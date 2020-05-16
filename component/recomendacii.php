<?php
$histori = new Histori;

// Удаление записи
if ($_GET['delhist'] == 'del') {
    $histori->file = $_GET['histori'];
    $histori->DelHictori();
}

// Получаем список удаленных файлов
$histori->personal = [
    'id' => IdClient($_SESSION) //
];
$del_hist = $histori->StecDel(); //

// Получаем список файлов в папке histori
$test_anket = ResultatAnket($_SESSION);


// Вывод на показ файлов
include'view/recomendacii.tpl';

// Защита от повтора
$_SESSION['errors'] = $_POST;