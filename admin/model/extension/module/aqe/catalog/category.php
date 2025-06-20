<?php
class ModelExtensionModuleAqeCatalogCategory extends Model {
	protected static $count = 0;

	public function getCategories($data = array()) {
		if (isset($data['columns'])) {
			$columns = $data['columns'];
		} else {
			$columns = array('name', 'sort_order');
		}

		if (isset($data['actions'])) {
			$actions = $data['actions'];
		} else {
			$actions = array();
		}

		// $sql = "SELECT SQL_CALC_FOUND_ROWS c.*, cd.*, cp.category_id AS category_id, GROUP_CONCAT(cd.name ORDER BY cp.level SEPARATOR '  &gt;  ') AS name";
		$sql = "SELECT SQL_CALC_FOUND_ROWS c.*, cd2.name AS short_name, cp.category_id AS category_id, GROUP_CONCAT(c2.category_id ORDER BY cp.level SEPARATOR '_') AS category_path, GROUP_CONCAT(cd.name ORDER BY cp.level SEPARATOR ' &gt; ') AS name";

		if (in_array("seo", $columns)) {
			$sql .= ", (SELECT keyword FROM " . DB_PREFIX . "seo_url WHERE query = CONCAT('category_id=', cp.category_id) AND store_id = '0' AND (language_id IS NULL OR language_id = '" . (int)$this->config->get('config_language_id') . "') ORDER BY language_id DESC LIMIT 1) AS seo";
		}

		if (in_array("parent", $columns)) {
			// $sql .= ", cd3.name AS parent_name";
			$sql .= ", (SELECT GROUP_CONCAT(cd1.name ORDER BY level SEPARATOR ' &gt; ') FROM " . DB_PREFIX . "category_path cp1 LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (cp1.path_id = cd1.category_id AND cp1.category_id != cp1.path_id) WHERE cp1.category_id = cp.category_id AND cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY cp1.category_id) AS path";
		}

		if ((int)$this->config->get('module_admin_quick_edit_highlight_actions')) {
			if (in_array("filters", $actions)) {
				$sql .= ", (SELECT 1 FROM " . DB_PREFIX . "category_filter WHERE category_id = cp.category_id LIMIT 1) AS filters_exist";
			}

			if (in_array("descriptions", $actions)) {
				$sql .= ", (SELECT 1 FROM " . DB_PREFIX . "category_description WHERE category_id = cp.category_id LIMIT 1) AS descriptions_exist";
			}

			if (in_array("keywords", $actions)) {
				$sql .= ", (SELECT 1 FROM " . DB_PREFIX . "seo_url WHERE query = CONCAT('category_id=', cp.category_id) LIMIT 1) AS keywords_exist";
			}
		}

		$sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "category c ON (cp.category_id = c.category_id) LEFT JOIN " . DB_PREFIX . "category c2 ON (cp.path_id = c2.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd ON (cp.path_id = cd.category_id AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "') LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (cp.category_id = cd2.category_id AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "')";

		if (in_array("parent", $columns) || isset($data['filter_parent'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "category_description cd3 ON (c.parent_id = cd3.category_id AND cd3.language_id = '" . (int)$this->config->get('config_language_id') . "')";
		}

		if (in_array("filter", $columns) || isset($data['filter_filter'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "category_filter c2f ON (cp.category_id = c2f.category_id) LEFT JOIN " . DB_PREFIX . "filter_description fd ON (fd.filter_id = c2f.filter_id AND fd.language_id = '" . (int)$this->config->get('config_language_id') . "')";
		}

		if (isset($data['filter_store'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (cp.category_id = c2s.category_id)";
		}

		$where = array();

		$int_filters = array(
			'id'                => 'cp.category_id',
			'parent'            => 'c.parent_id',
			'top'               => 'c.top',
			'status'            => 'c.status',
		);

		foreach ($int_filters as $key => $value) {
			if (isset($data["filter_$key"]) && !is_null($data["filter_$key"])) {
				$where[] = "$value = '" . (int)$data["filter_$key"] . "'";
			}
		}

		$int_interval_filters = array(
			'column'        => 'c.column',
			'sort_order'    => 'c.sort_order',
		);

		foreach ($int_interval_filters as $key => $value) {
			if (isset($data["filter_$key"]) && !is_null($data["filter_$key"])) {
				if ($this->config->get('module_admin_quick_edit_interval_filter')) {
					$where[] = $this->filterInterval($data["filter_$key"], $value);
				} else {
					$where[] = "$value = '" . (int)$data["filter_$key"] . "'";
				}
			}
		}

		$anywhere_filters = array(
			'name'      => "cd2.name",
			// 'filter'    => 'fd.name',
		);

		foreach ($anywhere_filters as $key => $value) {
			if (!empty($data["filter_$key"])) {
				if ($this->config->get('module_admin_quick_edit_match_anywhere')) {
					$tokens = preg_split("/\s+/", trim($data["filter_$key"]));

					foreach ($tokens as $token) {
						$where[] = "$value LIKE '%" . $this->db->escape($token) . "%'";
					}
				} else {
					$where[] = "$value LIKE '" . $this->db->escape($data["filter_$key"]) . "%'";
				}
			}
		}

		if (isset($data['filter_image']) && !is_null($data['filter_image'])) {
			if ($data['filter_image'] == 1) {
				$where[] = "(c.image IS NOT NULL AND c.image <> '' AND c.image <> 'no_image.png')";
			} else {
				$where[] = "(c.image IS NULL OR c.image = '' OR c.image = 'no_image.png')";
			}
		}

		if (!empty($data['filter_seo'])) {
			if ($this->config->get('module_admin_quick_edit_match_anywhere')) {
				$tokens = preg_split("/\s+/", trim($data['filter_seo']));

				foreach ($tokens as $token) {
					$where[] = "(SELECT keyword FROM " . DB_PREFIX . "seo_url WHERE query = CONCAT('category_id=', cp.category_id) LIMIT 1) LIKE '%" . $this->db->escape($token) . "%'";
				}
			} else {
				$where[] = "(SELECT keyword FROM " . DB_PREFIX . "seo_url WHERE query = CONCAT('category_id=', cp.category_id) LIMIT 1) LIKE '" . $this->db->escape($data['filter_seo']) . "%'";
			}
		}

		if (isset($data['filter_filter'])) {
			if ($data['filter_filter'] == '*')
				$where[] = "c2f.filter_id IS NULL";
			else
				$where[] = "c2f.filter_id = '" . (int)$data['filter_filter'] . "'";
		}

		if (isset($data['filter_store'])) {
			if ($data['filter_store'] == '*')
				$where[] = "c2s.store_id IS NULL";
			else
				$where[] = "c2s.store_id = '" . (int)$data['filter_store'] . "'";
		}

		if ($where) {
			$sql .= " WHERE " . implode($where, " AND ");
		}

		$sql .= " GROUP BY cp.category_id";

		$sort_data = array(
			'cp.category_id',
			'c.top',
			'c.top',
			'c.column',
			'cd.name',
			'path',
			'short_name',
			'seo',
			'c.status',
			'c.sort_order',
			'name',
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		$count = $this->db->query("SELECT FOUND_ROWS() AS count");
		$this->count = ($count->num_rows) ? (int)$count->row['count'] : 0;

		return $query->rows;
	}

	public function getTotalCategories() {
		return $this->count;
	}

	public function quickEditCategory($category_id, $column, $value, $lang_id=null, $data=null) {
		$editable = array('image', 'column', 'top', 'status', 'sort_order');
		$result = false;
		if (in_array($column, $editable)) {
			if (in_array($column, array('column', 'top', 'sort_order', 'status')))
				$result = $this->db->query("UPDATE " . DB_PREFIX . "category SET `" . $column . "` = '" . (int)$value . "', date_modified = NOW() WHERE category_id = '" . (int)$category_id . "'");
			else if ($column == "image")
				$result = $this->db->query("UPDATE " . DB_PREFIX . "category SET `" . $column . "` = '" . $this->db->escape($value) . "', date_modified = NOW() WHERE category_id = '" . (int)$category_id . "'");
		} else if ($column == 'parent') {
			$result = $this->db->query("UPDATE " . DB_PREFIX . "category SET `" . $column . "_id` = '" . (int)$value . "', date_modified = NOW() WHERE category_id = '" . (int)$category_id . "'");

			// MySQL Hierarchical Data Closure Table Pattern
			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE path_id = '" . (int)$category_id . "' ORDER BY level ASC");

			if ($query->rows) {
				foreach ($query->rows as $category_path) {
					// Delete the path below the current one
					$this->db->query("DELETE FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$category_path['category_id'] . "' AND level < '" . (int)$category_path['level'] . "'");

					$path = array();

					// Get the nodes new parents
					$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$value . "' ORDER BY level ASC");

					foreach ($query->rows as $result) {
						$path[] = $result['path_id'];
					}

					// Get whats left of the nodes current path
					$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$category_path['category_id'] . "' ORDER BY level ASC");

					foreach ($query->rows as $result) {
						$path[] = $result['path_id'];
					}

					// Combine the paths with a new level
					$level = 0;

					foreach ($path as $path_id) {
						$this->db->query("REPLACE INTO `" . DB_PREFIX . "category_path` SET category_id = '" . (int)$category_path['category_id'] . "', `path_id` = '" . (int)$path_id . "', level = '" . (int)$level . "'");

						$level++;
					}
				}
			} else {
				// Delete the path below the current one
				$this->db->query("DELETE FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$category_id . "'");

				// Fix for records with no paths
				$level = 0;

				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$value . "' ORDER BY level ASC");

				foreach ($query->rows as $result) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET category_id = '" . (int)$category_id . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");

					$level++;
				}

				$this->db->query("REPLACE INTO `" . DB_PREFIX . "category_path` SET category_id = '" . (int)$category_id . "', `path_id` = '" . (int)$category_id . "', level = '" . (int)$level . "'");
			}
		} else if ($column == 'seo' || $column == 'keywords') {
			$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = 'category_id=" . (int)$category_id. "'");

			if (isset($data['value']) && is_array($data['value'])) {
				foreach ((array)$data['value'] as $store_id => $language) {
					foreach ($language as $language_id => $keyword) {
						if (!empty($keyword)) {
							$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id = '" . (int)$store_id . "', language_id = '" . (int)$language_id . "', query = 'category_id=" . (int)$category_id . "', keyword = '" . $this->db->escape($keyword) . "'");
						}
					}
				}
				$result = 1;
			} else {
				$result = 1;
			}
		} else if (in_array($column, array('name'))) {
			if (isset($data['value']) && is_array($data['value'])) {
				foreach ((array)$data['value'] as $language_id => $value) {
					$this->db->query("UPDATE " . DB_PREFIX . "category_description SET " . $column . " = '" . $this->db->escape($value) . "' WHERE category_id = '" . (int)$category_id . "' AND language_id = '" . (int)$language_id . "'");
				}
				$result = 1;
			} else if ($value) {
				$result = $this->db->query("UPDATE " . DB_PREFIX . "category_description SET " . $column . " = '" . $this->db->escape($value) . "' WHERE category_id = '" . (int)$category_id . "' AND language_id = '" . (int)$lang_id . "'");
				$result = 1;
			} else {
				$result = 0;
			}
		} else if ($column == 'store') {
			$this->db->query("DELETE FROM " . DB_PREFIX . "category_to_store WHERE category_id = '" . (int)$category_id . "'");

			if (isset($data['i_s'])) {
				foreach ((array)$data['i_s'] as $store_id) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "category_to_store SET category_id = '" . (int)$category_id . "', store_id = '" . (int)$store_id . "'");
				}
			}
			$result = 1;
		} else if ($column == 'filter' || $column == 'filters' ) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "category_filter WHERE category_id = '" . (int)$category_id . "'");

			if (isset($data['i_f'])) {
				foreach ((array)$data['i_f'] as $filter_id) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "category_filter SET category_id = '" . (int)$category_id . "', filter_id = '" . (int)$filter_id . "'");
				}
			}
			$result = 1;
		} else if ($column == 'descriptions') {
			foreach ((array)$data['description'] as $language_id => $value) {
				$this->db->query("UPDATE " . DB_PREFIX . "category_description SET description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "' WHERE category_id = '" . (int)$category_id . "' AND language_id = '" . (int)$language_id . "'");
			}
			$result = 1;
		}

		$this->cache->delete('category');

		return $result;
	}

	public function filterInterval($filter, $field, $date=false) {
		if ($date) {
			if (preg_match('/^(!=|<>)\s*(\d{2,4}-\d{1,2}-\d{1,2})$/', html_entity_decode(trim($filter)), $matches) && count($matches) == 3) {
				return "DATE($field) <> DATE('" . $matches[2] . "')";
			} else if (preg_match('/^(\d{2,4}-\d{1,2}-\d{1,2})\s*(<|<=)\s*(\d{2,4}-\d{1,2}-\d{1,2})$/', html_entity_decode(trim($filter)), $matches) && count($matches) == 4 && strtotime($matches[1]) <= strtotime($matches[3])) {
				return "DATE('" . $matches[1] . "') ${matches[2]} DATE($field) AND DATE($field) ${matches[2]} DATE('" . $matches[3] . "')";
			} else if (preg_match('/^(\d{2,4}-\d{1,2}-\d{1,2})\s*(>|>=)\s*(\d{2,4}-\d{1,2}-\d{1,2})$/', html_entity_decode(trim($filter)), $matches) && count($matches) == 4 && strtotime($matches[1]) >= strtotime($matches[3])) {
				return "DATE('" . $matches[1] . "') ${matches[2]} DATE($field) AND DATE($field) ${matches[2]} DATE('" . $matches[3] . "')";
			} else if (preg_match('/^(<|<=|>|>=)\s*(\d{2,4}-\d{1,2}-\d{1,2})$/', html_entity_decode(trim($filter)), $matches) && count($matches) == 3) {
				return "DATE($field) ${matches[1]} DATE('" . $matches[2] . "')";
			} else if (preg_match('/^(\d{2,4}-\d{1,2}-\d{1,2})\s*(>|>=|<|<=)$/', html_entity_decode(trim($filter)), $matches) && count($matches) == 3) {
				return "DATE('" . $matches[1] . "') ${matches[2]} DATE($field)";
			} else {
				return "DATE(${field}) = DATE('${filter}')";
			}
		} else {
			if (preg_match('/^(!=|<>)\s*(-?\d+\.?\d*)$/', html_entity_decode(trim(str_replace(",", ".", $filter))), $matches) && count($matches) == 3) {
				return "$field <> '" . (float)$matches[2] . "'";
			} else if (preg_match('/^(-?\d+\.?\d*)\s*(<|<=)\s*(-?\d+\.?\d*)$/', html_entity_decode(trim(str_replace(",", ".", $filter))), $matches) && count($matches) == 4 && (float)$matches[1] <= (float)$matches[3]) {
				return "'" . (float)$matches[1] . "' ${matches[2]} $field AND $field ${matches[2]} '" . (float)$matches[3] . "'";
			} else if (preg_match('/^(-?\d+\.?\d*)\s*(>|>=)\s*(-?\d+\.?\d*)$/', html_entity_decode(trim(str_replace(",", ".", $filter))), $matches) && count($matches) == 4 && (float)$matches[1] >= (float)$matches[3]) {
				return "'" . (float)$matches[1] . "' ${matches[2]} $field AND $field ${matches[2]} '" . (float)$matches[3] . "'";
			} else if (preg_match('/^(<|<=|>|>=)\s*(-?\d+\.?\d*)$/', html_entity_decode(trim(str_replace(",", ".", $filter))), $matches) && count($matches) == 3) {
				return "$field ${matches[1]} '" . (float)$matches[2] . "'";
			} else if (preg_match('/^(-?\d+\.?\d*)\s*(>|>=|<|<=)$/', html_entity_decode(trim(str_replace(",", ".", $filter))), $matches) && count($matches) == 3) {
				return "'" . (float)$matches[1] . "' ${matches[2]} $field";
			} else {
				return $field . " = '" . $this->db->escape($filter) . "'";
			}
		}
	}

	public function getSubCategories($category_id) {
		$sql = "SELECT DISTINCT category_id FROM " . DB_PREFIX . "category_path WHERE path_id = '" . (int)$category_id . "'";

		$query = $this->db->query($sql);

		return $query->rows;
	}
}
