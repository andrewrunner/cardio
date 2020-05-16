<?php
// require_once('component/errors.php'); // Для определеня ошибки Charcoal Oceanic Next

session_start();
require_once 'component/conect.php';
require_once _LOG_;
require_once _FUNCTION_;
require_once _CONTROLER_;
require_once _CROV_;
require_once _DOP_CATEGORI_;

// Заносим в базу продажи
$fin_ = new OperationFin;
$space = new Spacecraft;

// сохранение данных в сессию
SetSession($_POST, $_GET);

// сброс сесии
Resets($_GET);

// открытие и сохранение продукта с оплатой
OpenSakasProduct($_GET, $_POST);

$new_mas = EditECGClient($_POST); // card_fio
$fio_card = $new_mas['fio_card'];
$summa = $new_mas['summa'];
$startcart =$new_mas['startcart'];
$sort_group = Sortirovka($_POST);
$val = ValutaPolsovatela($_POST);
$kar = Kar($_POST, $_GET, $startcart);

// Загрузка страницы
require_once _HEADER_;
require_once CONTENTS;
require_once FOOTER;
