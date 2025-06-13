<?php
class ModelKmMenueditor extends Model {
    public function checkAndCreateTable() {
        // Назва таблиці
        $tableName = DB_PREFIX . 'km_megamenu';

        // Перевіряємо, чи існує таблиця
        $query = $this->db->query("SHOW TABLES LIKE '" . $this->db->escape($tableName) . "'");

        if ($query->num_rows == 0) {
            // Якщо таблиці немає, створюємо її
            $this->db->query("
                CREATE TABLE `" . $this->db->escape($tableName) . "` (
                    `id` INT(11) NOT NULL AUTO_INCREMENT,
                    `name` VARCHAR(255) NOT NULL,
                    `date_edit` DATETIME NOT NULL,
                    `date_create` DATETIME NOT NULL,
                    `data_json` TEXT NOT NULL,
                    PRIMARY KEY (`id`)
                ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
            ");
        }
    }

    public function getMenuById($id) {
        // Перевіряємо, чи id переданий правильно
        $id = (int)$id;

        // Виконуємо запит до БД для отримання запису по ID
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "km_megamenu` WHERE `id` = '" . $id . "'");

        // Повертаємо результат запиту
        return $query->row;
    }

    public function getMenuList() {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "km_megamenu` ORDER BY id ASC");

        // Повертаємо результат запиту
        return $query->rows;
    }

    public function updateMenu($id, $name, $date_edit, $data_json) {
        // Перевіряємо, чи ID переданий коректно
        $id = (int)$id;

        // Екрануємо та готуємо дані для безпечного запису в базу
        $name = $this->db->escape($name);
        $date_edit = $this->db->escape($date_edit);
        $data_json = $this->db->escape($data_json);


        // Оновлення запису в базі даних по ID
        $query = "
            UPDATE `" . DB_PREFIX . "km_megamenu`
            SET
                `name` = '" . $name . "',
                `date_edit` = '" . $date_edit . "',
                `data_json` = '" . $data_json . "'
            WHERE `id` = '" . $id . "'
        ";

        $this->db->query($query);
        return 1;
    }

    public function copyMenuItem($id = 0) {
        // Перевіряємо, чи існує запис з даним ID
        $sql = "SELECT * FROM " . DB_PREFIX . "km_megamenu WHERE id = '" . (int)$id . "'";
        $query = $this->db->query($sql);

        if ($query->num_rows) {
            $original = $query->row;

            // Формуємо новий name
            $new_name = $original['name'] . ' (копія)';

            $sql = "INSERT INTO " . DB_PREFIX . "km_megamenu (name, date_edit, date_create, data_json, status)
                          VALUES ('" . $this->db->escape($new_name) . "', NOW(), NOW(), '" . $this->db->escape($original['data_json']) . "', 0)";

            // Вставляємо новий запис
            $this->db->query($sql);

            return true; // Повертаємо true, якщо успішно скопійовано
        }

        return false; // Повертаємо false, якщо запис не знайдено
    }

    public function delete_item($menu_id) {
        // Перевіряємо, чи передано ID
        if ((int)$menu_id) {
            // Перевіряємо статус запису
            $query = $this->db->query("SELECT status FROM " . DB_PREFIX . "km_megamenu WHERE id = '" . (int)$menu_id . "'");

            if ($query->num_rows && $query->row['status'] != 1) {
                // Виконуємо запит на видалення, якщо статус не дорівнює 1
                $this->db->query("DELETE FROM " . DB_PREFIX . "km_megamenu WHERE id = '" . (int)$menu_id . "'");
                return true; // Повертаємо true, якщо успішно видалено
            }
        }

        return false; // Повертаємо false, якщо ID не коректний або статус дорівнює 1
    }

    public function update_status($id) {
        // Перевіряємо, чи передано ID
        if ((int)$id) {
            // Встановлюємо статус 0 для всіх інших записів
            $this->db->query("UPDATE " . DB_PREFIX . "km_megamenu SET status = 0");

            // Встановлюємо статус 1 для вказаного запису
            $this->db->query("UPDATE " . DB_PREFIX . "km_megamenu SET status = 1 WHERE id = '" . (int)$id . "'");

            return true; // Повертаємо true, якщо статуси успішно змінено
        }

        return false; // Повертаємо false, якщо ID не коректний
    }

}