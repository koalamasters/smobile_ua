<?php
class ModelExtensionModuleAttributeCategory extends Model {
	public function addAttributeCategory($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "attribute_category SET name = '" . $this->db->escape($data['name']) . "'");

		$attr_cat_id = $this->db->getLastId();
		$this->addAttributes($attr_cat_id, $data);
		return $attr_cat_id;
	}

	public function editAttributeCategory($attr_cat_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "attribute_category SET 
			name = '" . $this->db->escape($data['name']) . "'
			WHERE attr_cat_id = '" . (int)$attr_cat_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "attribute_category_value
			WHERE attr_cat_id = '" . (int)$attr_cat_id . "'");
		$this->addAttributes($attr_cat_id, $data);

	}

	private function addAttributes($attr_cat_id, $data) {
		if (isset($data['attributes'])) {
			foreach ($data['attributes'] as $row=>$values) {
				foreach ($values as $attribute_id => $values_languages) {
					foreach ($values_languages as $language_id => $value) {

                        if(!is_int($language_id)){
                            continue;
                        }
                        $is_base = 0;
                        $is_base = ($data['attributes_base'][$attribute_id]['is_base'] == 'on') ? 1 : 0;
						$this->db->query("INSERT INTO " . DB_PREFIX . "attribute_category_value SET 
							`attr_cat_id`  = '" . (int)$attr_cat_id . "',
							`language_id`  = '" . (int)$language_id . "',
							`attribute_id` = '" . (int)$attribute_id . "',
							`base_attr` = '" . (int)$is_base . "',
							`text`         = '" . $this->db->escape($value) . "'");
					}
				}
			}
		}
	}
	
	public function deleteAttributeCategory($attr_cat_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "attribute_category WHERE attr_cat_id = '" . (int)$attr_cat_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "attribute_category_value WHERE attr_cat_id = '" . (int)$attr_cat_id . "'");
	}


	public function getAttribute($attribute_id,$language_id) {
		$sql = "SELECT *, (SELECT agd.name FROM " . DB_PREFIX . "attribute_group_description agd WHERE agd.attribute_group_id = a.attribute_group_id AND agd.language_id = '" . (int)$language_id . "') AS group_name
		    FROM " . DB_PREFIX . "attribute a
			LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) 
			WHERE a.attribute_id = '" . (int)$attribute_id . "' 
			AND ad.language_id = '" . (int)$language_id . "'";

		$query = $this->db->query($sql);
		return $query->row;
	}

	public function getAttributeCategoryValue($attr_cat_id) {
		$result = $this->db->query("SELECT * FROM " . DB_PREFIX . "attribute_category_value a 
		WHERE a.attr_cat_id = '" . (int)$attr_cat_id . "'");
		return $result->rows;
	}

	public function getAttributeCategory($attr_cat_id) {
		$result = $this->db->query("SELECT * FROM " . DB_PREFIX . "attribute_category a 
		WHERE a.attr_cat_id = '" . (int)$attr_cat_id . "'");
		return $result->row;
	}

	public function getAttributeCategories($data = array()) {
		$sql = "SELECT attr_cat_id, name FROM " . DB_PREFIX . "attribute_category WHERE 1 ";

		if (!empty($data['filter_name'])) {
			$sql .= " AND ad.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sort_data = array(
			'name',
			'sort_order'
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

		return $query->rows;
	}

	public function getTotalAttrubuteCategories($data) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "attribute_category WHERE 1";
		if (!empty($data['filter_name'])) {
			$sql .= " AND ad.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$query = $this->db->query($sql);
		return $query->row['total'];
	}

}
