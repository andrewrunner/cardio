<?php
// удаление продукта из корзины
if ($_GET['delprod']) {
    DeletCartUser($_GET);
}

// загрузка на страницу
include 'view/sakas.tpl';
require_once 'cart.php';

// вывод на страницу
echo Sakas();
