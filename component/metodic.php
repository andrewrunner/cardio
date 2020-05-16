<?php
// определяет категории
if ($_SESSION['sell']) {
	$sort_group = $_SESSION['sell'];
}

// определяет валюту
if ($_SESSION['valute']) {
	$valute = $_SESSION['valute'];
}

// вывод на страницу
include 'view/metodic.tpl';
