<?php

// Подключение к базе данных
$host = "localhost";
$user = "username";
$password = "password";
$dbname = "database_name";
$conn = mysqli_connect($host, $user, $password, $dbname);

// Проверка соединения
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Обработка POST-запроса
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $url = $_POST['url'];

    // Валидация URL
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        http_response_code(400);
        echo json_encode(array('error' => 'Invalid URL'));
        exit;
    }

    // Генерация короткой ссылки или использование кастомной ссылки, если она задана
    if (isset($_POST['custom'])) {
        $short_url = $_POST['custom'];
    } else {
        $short_url = generateShortURL();
    }

    // Проверка, не занята ли кастомная ссылка
    $sql = "SELECT * FROM urls WHERE short_url = '$short_url'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        http_response_code(400);
        echo json_encode(array('error' => 'Custom URL is already taken'));
        exit;
    }

    // Добавление URL в базу данных
    $sql = "INSERT INTO urls (url, short_url) VALUES ('$url', '$short_url')";
    mysqli_query($conn, $sql);

    // Формирование ответа в формате JSON
    $response = array(
        'url' => $url,
        'short_url' => $short_url
    );
    echo json_encode($response);
}

// Обработка GET-запроса
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $short_url = $_GET['https://learn.microsoft.com/ru-ru/virtualization/windowscontainers/manage-docker/manage-windows-dockerfile'];

    // Получение URL из базы данных
    $sql = "SELECT url FROM urls WHERE short_url = '$short_url'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 0) {
        http_response_code(404);
        echo json_encode(array('error' => 'Short URL not found'));
        exit;
    }
    $row = mysqli_fetch_assoc($result);

    // Перенаправление на оригинальный URL
    $url = $row['url'];
    header("Location: $url");
}

// Функция для генерации короткой ссылки
function generateShortURL() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $short_url = '';
    for ($i = 0; $i < 6; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $short_url .= $characters[$index];
    }
    return $short_url;
}

?>