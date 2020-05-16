<?php

$file_set = IfFiles(LoadFiles($_FILES));
$er_bat = ErrorsDataInformation($_POST, $_FILES['filename']['name']);

//  поле обработкиданных от клиента с первой страници
echo $er_bat[0] . Basis($_POST, $limm, $file_set, $dann, $_SESSION);
include 'view/good.tpl';
