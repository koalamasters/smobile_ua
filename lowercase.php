<?
$domain = 'https://smobile.ua/';

if (isset($_GET['address'])) {
    $url = $_GET['address'];

    // Список розширень файлів, для яких не потрібен редирект
    $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp', 'tiff', 'ico', 'avif'];

    // Отримуємо розширення файлу
    $pathInfo = pathinfo($url);
    $extension = isset($pathInfo['extension']) ? strtolower($pathInfo['extension']) : '';

 
    // Якщо розширення є у списку — пропускаємо редирект
    if (in_array($extension, $imageExtensions)) {
        header("HTTP/1.1 200 OK");
        exit;
    }

    unset($_GET['address']);
    $params = http_build_query($_GET);

    if (strlen($params)) {
        $params = '?' . $params;
    }

    header('Location: ' . $domain . strtolower($url) . $params, true, 301);
    exit;
}

header("HTTP/1.0 404 Not Found");
die('Unable to convert the URL to lowercase. You must supply a URL to work upon.');
?>