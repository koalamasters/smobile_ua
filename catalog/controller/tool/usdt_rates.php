<?
class ControllerToolUsdtRates extends Controller
{
    public function index()
    {

        // Ваш токен
        $token = "cwKfMlSH4dsyP1ZIRXfC4ZKItLo7jzPFbsAnXyrI";

        // Адреса, куди буде відправлятися запит
        $url = "https://api.whitepay.com/rates";

        // Заголовки запиту
        $headers = array(
            "Accept: application/json",
            "Content-Type: application/json",
            "Authorization: Bearer $token"
        );

        // Ініціалізуємо об'єкт CURL
        $ch = curl_init();

        // Встановлюємо опції CURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Виконуємо запит
        $response = curl_exec($ch);

        // Перевіряємо на наявність помилок
        if ($response === false) {
            echo "Помилка: " . curl_error($ch);
            die();
        }
        // Закриваємо CURL з'єднання
        curl_close($ch);

        $uah_usdt = json_decode($response)->USDT_UAH;

        file_put_contents(DIR_ROOT.'usdt_rates.txt', $uah_usdt);

    }
}