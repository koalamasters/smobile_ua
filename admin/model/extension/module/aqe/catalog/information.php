<?php
class ModelExtensionModuleAqeCatalogInformation extends Model {
	protected static $count = 0;

	public function getInformations($data = array()) {
		if (isset($data['columns'])) {
			$columns = $data['columns'];
		} else {
			$columns = array('title', 'sort_order');
		}

		if (isset($data['actions'])) {
			$actions = $data['actions'];
		} else {
			$actions = array();
		}

		$sql = "SELECT SQL_CALC_FOUND_ROWS i.*, id.*";

		if (in_array("seo", $columns)) {
			$sql .= ", (SELECT keyword FROM " . DB_PREFIX . "seo_url WHERE query = CONCAT('information_id=', i.information_id) AND store_id = '0' AND (language_id IS NULL OR language_id = '" . (int)$this->config->get('config_language_id') . "') ORDER BY language_id DESC LIMIT 1) AS seo";
		}

		if ((int)$this->config->get('module_admin_quick_edit_highlight_actions')) {
			if (in_array("descriptions", $actions)) {
				$sql .= ", (SELECT 1 FROM " . DB_PREFIX . "information_description WHERE information_id = i.information_id LIMIT 1) AS descriptions_exist";
			}

			if (in_array("keywords", $actions)) {
				$sql .= ", (SELECT 1 FROM " . DB_PREFIX . "seo_url WHERE query = CONCAT('information_id=', i.information_id) LIMIT 1) AS keywords_exist";
			}
		}

		$sql .= " FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id AND id.language_id = '" . (int)$this->config->get('config_language_id') . "')";

		if (isset($data['filter_store'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "information_to_store i2s ON (i.information_id = i2s.information_id)";
		}

		$where = array();

		$int_filters = array(
			'id'                => 'i.information_id',
			'bottom'            => 'i.bottom',
			'status'            => 'i.status',
		);

		foreach ($int_filters as $key => $value) {
			if (isset($data["filter_$key"]) && !is_null($data["filter_$key"])) {
				$where[] = "$value = '" . (int)$data["filter_$key"] . "'";
			}
		}

		$int_interval_filters = array(
			'sort_order'    => 'i.sort_order',
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
			'title'     => "id.title",
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

		if (!empty($data['filter_seo'])) {
			if ($this->config->get('module_admin_quick_edit_match_anywhere')) {
				$tokens = preg_split("/\s+/", trim($data['filter_seo']));

				foreach ($tokens as $token) {
					$where[] = "(SELECT keyword FROM " . DB_PREFIX . "seo_url WHERE query = CONCAT('information_id=', i.information_id) LIMIT 1) LIKE '%" . $this->db->escape($token) . "%'";
				}
			} else {
				$where[] = "(SELECT keyword FROM " . DB_PREFIX . "seo_url WHERE query = CONCAT('information_id=', i.information_id) LIMIT 1) LIKE '" . $this->db->escape($data['filter_seo']) . "%'";
			}
		}

		if (isset($data['filter_store'])) {
			if ($data['filter_store'] == '*')
				$where[] = "i2s.store_id IS NULL";
			else
				$where[] = "i2s.store_id = '" . (int)$data['filter_store'] . "'";
		}

		if ($where) {
			$sql .= " WHERE " . implode($where, " AND ");
		}

		$sql .= " GROUP BY i.information_id";

		$sort_data = array(
			'i.information_id',
			'i.bottom',
			'id.title',
			'seo',
			'i.status',
			'i.sort_order',
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY id.title";
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

	public function getTotalInformations() {
		return $this->count;
	}

	public function quickEditInformation($information_id, $column, $value, $lang_id=null, $data=null) {
		$editable = array('bottom', 'status', 'sort_order');
		$result = false;
		if (in_array($column, $editable)) {
			$result = $this->db->query("UPDATE " . DB_PREFIX . "information SET `" . $column . "` = '" . (int)$value . "' WHERE information_id = '" . (int)$information_id . "'");
		} else if ($column == 'seo' || $column == 'keywords') {
			$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = 'information_id=" . (int)$information_id. "'");

			if (isset($data['value']) && is_array($data['value'])) {
				foreach ((array)$data['value'] as $store_id => $language) {
					foreach ($language as $language_id => $keyword) {
						if (!empty($keyword)) {
							$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id = '" . (int)$store_id . "', language_id = '" . (int)$language_id . "', query = 'information_id=" . (int)$information_id . "', keyword = '" . $this->db->escape($keyword) . "'");
						}
					}
				}
				$result = 1;
			} else {
				$result = 1;
			}
		} else if (in_array($column, array('title'))) {
			if (isset($data['value']) && is_array($data['value'])) {
				foreach ((array)$data['value'] as $language_id => $value) {
					$this->db->query("UPDATE " . DB_PREFIX . "information_description SET " . $column . " = '" . $this->db->escape($value) . "' WHERE information_id = '" . (int)$information_id . "' AND language_id = '" . (int)$language_id . "'");
				}
				$result = 1;
			} else if ($value) {
				$result = $this->db->query("UPDATE " . DB_PREFIX . "information_description SET " . $column . " = '" . $this->db->escape($value) . "' WHERE information_id = '" . (int)$information_id . "' AND language_id = '" . (int)$lang_id . "'");
				$result = 1;
			} else {
				$result = 0;
			}
		} else if ($column == 'store') {
			$this->db->query("DELETE FROM " . DB_PREFIX . "information_to_store WHERE information_id = '" . (int)$information_id . "'");

			if (isset($data['i_s'])) {
				foreach ((array)$data['i_s'] as $store_id) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "information_to_store SET information_id = '" . (int)$information_id . "', store_id = '" . (int)$store_id . "'");
				}
			}
			$result = 1;
		} else if ($column == 'descriptions') {
			foreach ((array)$data['description'] as $language_id => $value) {
				$this->db->query("UPDATE " . DB_PREFIX . "information_description SET description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "' WHERE information_id = '" . (int)$information_id . "' AND language_id = '" . (int)$language_id . "'");
			}
			$result = 1;
		}

		$this->cache->delete('information');

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
}
