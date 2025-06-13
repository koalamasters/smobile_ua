<?php
class ModelKmMenueditor extends Model {

    // Метод для отримання всього меню
    public function getMenu() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "km_megamenu ORDER BY id ASC");
        return $query->rows; // Повертаємо всі записи
    }

    // Метод для отримання меню по ID
    public function getMenuById($id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "km_megamenu WHERE id = '" . (int)$id . "'");
        return $query->row; // Повертаємо один запис
    }

    // Метод для обробки або перетворення JSON меню
    public function processMenuJson($menu) {
        $menu_data = json_decode($menu['data_json'], true); // Декодуємо JSON


        return $menu_data; // Повертаємо меню з декодованим JSON
    }

    public function getActiveMenu() {
        // Виконуємо запит на отримання ID меню, де статус = 1
        $query = $this->db->query("SELECT id FROM " . DB_PREFIX . "km_megamenu WHERE status = 1 LIMIT 1");

        // Перевіряємо, чи є результат
        if ($query->num_rows) {
            return $query->row['id']; // Повертаємо ID
        }

        return false; // Повертаємо false, якщо не знайдено записів зі статусом 1
    }
}
