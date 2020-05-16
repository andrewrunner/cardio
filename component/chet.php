<?php 
// выводим валюты для счетов
if ($_POST['val_chet']) {
    $_SESSION['global_valuta'] = $_POST['valut'];
    $curs = $_POST['valut'];
    $uslovnuy_limit = ConverterValut('грн', LimitDogovorChet($_SESSION), $_POST['valut']);
} else {
    $curs = 'грн';
    $uslovnuy_limit = LimitDogovorChet($_SESSION);
}

// загрузка страницы
include'view/chet.tpl';