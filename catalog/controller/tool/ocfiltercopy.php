<?
class ControllerToolOcfiltercopy extends Controller
{
    public function index()
    {
        $res = $this->load->controller('extension/module/ocfilter/copy', [
            'copy_attribute' => 1, // Копіювати атрибути
            'copy_group_as_attribute' => 0, // Групи атрибутів як фільтри
            'copy_attribute_id_exclude' => 1, // Дані для копіювання
            'copy_attribute_group_id_exclude' => 1, // Дані для копіювання
            'copy_attribute_category_id_exclude' => 1, // Дані для копіювання
            'copy_filter' => 0, // Копіювати стандартні фільтри
            'copy_option' => 0, // Копіювати опції товарів
            'copy_option_in_stock' => 1, // Тільки в наявності
            'copy_type' => 'checkbox', // Тип скопійованих фільтрів
            'copy_dropdown' => 0, // Помістити в список, що випадає
            'copy_status' => 1, // Статус скопійованих фільтрів
            'copy_truncate' => 0, // Очистити існуючі фільтри OCFilter
            'copy_category' => 0, // Прив'язати фільтри до категорій
            'copy_cron_wget' => 0, // Команда для виклику по cron (планувальник)
            'copy_value_separator' => [','], //
            'copy_attribute_id' => [], //
            'copy_attribute_group_id' => [], //
            'copy_attribute_category_id' => [], //
        ]);

        var_dump($res);

    }
}