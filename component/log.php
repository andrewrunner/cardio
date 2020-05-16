<?php

// массив информации
$info = [];

// добавление значений $_SERVER
$info[] = date('Y-m-d H:i:s');
$info[] = $_SERVER['PHP_AUTH_USER']; // имя пользователя
$info[] = $_SERVER['PHP_AUTH_PW']; // пароль предоставленный пользователем
$info[] = $_SERVER['REMOTE_ADDR']; // ip адрес пользователя
$info[] = $_SERVER['REMOTE_USER']; // пользователь
$info[] = $_SERVER['HTTP_USER_AGENT']; // браузер
$info[] = $_SERVER['PHP_SELF']; // исполняемый скрипт
$info[] = $_SERVER['SCRIPT_FILENAME']; // абсолютный путь к используемому скрипту
$info[] = $_SERVER['REQUEST_METHOD']; // метод запроса к серверу

if ($_POST) {
    $info[] = implode(' p--- ', $_POST);
}

if ($_GET) {
    $info[] = implode(' g--- ', $_GET);
}

if ($_HEAD) {
    $info[] = implode(' h--- ', $_HEAD);
}

if ($_PUT) {
    $info[] = implode(' pu-- ', $_PUT);
}

$info[] = $_SERVER['QUERY_STRING']; // строка запроса
$info[] = $_SERVER['HTTP_ACCEPT']; // содержимое заголовка
$info[] = $_SERVER['HTTP_REFERER']; // адрес строки с которой перешол пользователь
$info[] = $_SERVER['PATH_INFO']; // путь
$info[] = $_SERVER['REQUEST_URL']; // предоставленный адрес для доступа к этой странице

// записываем данные в файл
$data = implode(" || ", $info);
file_put_contents('logs/log.log', $data . "\n\n", FILE_APPEND);
