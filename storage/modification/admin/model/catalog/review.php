<?php
class ModelCatalogReview extends Model {
	public function addReview($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "review SET author = '" . $this->db->escape($data['author']) . "', product_id = '" . (int)$data['product_id'] . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "', reply = '" . $this->db->escape(strip_tags($data['reply'])) . "', rating = '" . (int)$data['rating'] . "', status = '" . (int)$data['status'] . "', date_added = '" . $this->db->escape($data['date_added']) . "'");

		$review_id = $this->db->getLastId();

		$this->cache->delete('product');

		return $review_id;
	}

	public function editReview($review_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "review SET author = '" . $this->db->escape($data['author']) . "', product_id = '" . (int)$data['product_id'] . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "', reply = '" . $this->db->escape(strip_tags($data['reply'])) . "', rating = '" . (int)$data['rating'] . "', status = '" . (int)$data['status'] . "', date_added = '" . $this->db->escape($data['date_added']) . "', date_modified = NOW() WHERE review_id = '" . (int)$review_id . "'");

		$this->cache->delete('product');
	}

	public function deleteReview($review_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "review WHERE review_id = '" . (int)$review_id . "'");

		$this->cache->delete('product');
	}

	public function getReview($review_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT pd.name FROM " . DB_PREFIX . "product_description pd WHERE pd.product_id = r.product_id AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS product FROM " . DB_PREFIX . "review r WHERE r.review_id = '" . (int)$review_id . "'");

		return $query->row;
	}

	public function getReviews($data = array()) {
		$sql = "SELECT r.review_id, pd.name, r.author, r.rating, r.status, r.date_added FROM " . DB_PREFIX . "review r LEFT JOIN " . DB_PREFIX . "product_description pd ON (r.product_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_product'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_product']) . "%'";
		}

		if (!empty($data['filter_author'])) {
			$sql .= " AND r.author LIKE '" . $this->db->escape($data['filter_author']) . "%'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND r.status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(r.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		$sort_data = array(
			'pd.name',
			'r.author',
			'r.rating',
			'r.status',
			'r.date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY r.date_added";
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

	public function getTotalReviews($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review r LEFT JOIN " . DB_PREFIX . "product_description pd ON (r.product_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_product'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_product']) . "%'";
		}

		if (!empty($data['filter_author'])) {
			$sql .= " AND r.author LIKE '" . $this->db->escape($data['filter_author']) . "%'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND r.status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(r.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getTotalReviewsAwaitingApproval() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review WHERE status = '0'");

		return $query->row['total'];
	}

    public function set_review_attachment($review_id, $attach_type, $attach_value) {
        if ($attach_type == 'video') {
            // Логіка для типу 'video'
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "review_attachment WHERE review_id = '" . (int)$review_id . "' AND type = '" . $this->db->escape($attach_type) . "'");

            if ($query->num_rows) {
                // Якщо запис існує, оновлюємо його
                $this->db->query("UPDATE " . DB_PREFIX . "review_attachment SET link = '" . $this->db->escape($attach_value) . "' WHERE attachment_id = '" . (int)$query->row['attachment_id'] . "'");
            } else {
                // Якщо запису немає, створюємо новий
                $this->db->query("INSERT INTO " . DB_PREFIX . "review_attachment SET review_id = '" . (int)$review_id . "', type = '" . $this->db->escape($attach_type) . "', link = '" . $this->db->escape($attach_value) . "'");
            }
        } elseif ($attach_type == 'image') {
            // Логіка для типу 'image' (створюємо нові записи для кожного зображення)
            $this->db->query("INSERT INTO " . DB_PREFIX . "review_attachment SET review_id = '" . (int)$review_id . "', type = '" . $this->db->escape($attach_type) . "', link = '" . $this->db->escape($attach_value) . "'");
        }
    }


    public function get_review_attachments($review_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "review_attachment WHERE review_id = '" . (int)$review_id . "'");

        return $query->rows;
    }

    public function delete_review_attachment($attachment_id) {
        // Отримуємо інформацію про файл, який видаляємо
        $query = $this->db->query("SELECT link FROM " . DB_PREFIX . "review_attachment WHERE attachment_id = '" . (int)$attachment_id . "'");

        if ($query->num_rows) {
            $file_path = DIR_IMAGE . $query->row['link']; // Повний шлях до файлу

            // Видаляємо запис з бази даних
            $this->db->query("DELETE FROM " . DB_PREFIX . "review_attachment WHERE attachment_id = '" . (int)$attachment_id . "'");

            // Перевіряємо, чи існує файл, і видаляємо його з файлової системи
            if (is_file($file_path)) {
                unlink($file_path); // Видаляємо файл
            }
        }
    }
}