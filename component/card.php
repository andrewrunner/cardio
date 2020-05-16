<?php

/*
	В vid_obr.tpl -> хранится структура
	В good.tpl -> хранится структура второй страницы
	В good.php -> обработка данных с первой страницы
	В index.php -> str 160 $_POST['card_fio'] обработка запроса с второй страницы
	Связан с good.php переход с первой страницы
	После нажатия на кнопку на второй странице попадаем в обработчек на index.php
	По выбору идем на оплату картой или списываем лимит, тамже фиксируем в chet
*/

if ($_POST['ress']) {
	session_destroy();
	header("Refresh:0");
}

$rrt = $_GET['name'];
$arr = AutoComplitData($_SESSION); // при необходимости убрать
$personal_date = $arr[0];
$pol_ = $arr[1];

include 'view/vid_obr.tpl'; // на файл

// свести страницы в едино

