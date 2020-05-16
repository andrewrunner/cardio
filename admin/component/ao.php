<?php

if ($_SESSION['errors'] == $_POST && $_GET['tablet']) {
    echo '<p class="red">Вы пытаетесь осуществить повторный запрос! Это может привести к повторному съёму денежных средств!</p><br>
    <a class="wf_blanck2 jk" href="index.php?name=ao">Вернутся к списку "АО"</a>';
} else {
    $pol_pdf = new PolsovatelPDF;
    $valuta_polsovatela = new Polsovatel;
    $reakciya = new Reakciya;
    $save_test = new SaveDiagrams;


    $prest = $pol_pdf->PolPDF($_POST['personal_anceta']);
    $valuta_polsovatela->id = $prest['id'];

    // определяем полных лет
    if (Datapolnuy($prest['data']) != '') {
        $pl = Datapolnuy($prest['data']);
    } elseif ($_POST['personal_data']) {
        $pl = $_POST['personal_data'];
    }

    if ($prest['data'] != '') {
        $_data_ = ': ' . $prest['data'] . ',';
    } else {
        $_data_ = ',';
    }

    if ($prest['id'] != '') {
        $_id_ = $prest['id'];
    } else {
        $_id_ = 0;
    }

    if ($prest['state'] != '') {
        $_pol_ = $prest['state'];
    } else {
        $_plo_ = $_POST['pol'];
    }

    if ($prest['lastname'] != '') {
        $_name_ = $prest['lastname'] . ' ' . $prest['firstname'] . ' ' . $prest['middlename'];
    } else {
        $_name_ = $_POST['personal_anceta'];
    }

    if ($prest['valuta'] != '') {
        $_valuta_ = $prest['valuta'];
    } else {
        $_valuta_ = $_POST['price_usluga'];
    }

    // Внесение в изменение файла
    $_SESSION['data_personal'] = [
        'polnuh_let' => $pl,
        'pol' => $_pol_,
        'id' => $_id_,
        'price_usluge' => $_POST['price_usluga'],
        'valuta_usluga' => $_POST['valuta_uslugi'],
        'valuta_pol' => $_valuta_,
        'name_personal' => '<b>' . $_name_ . '</b>' . $_data_ . ' <b>Цена за услугу</b>: ' . $_POST['price_usluga'] . ' ' . $_POST['valuta_uslugi']
    ];

    if ($_POST['ichemiya'] || $_POST['gipertoniya'] || $_POST['infarkt']) {
        $_SESSION['data_personal']['perenesenue_sabolevaniya'] = 'on';
    }

    if ($anceta == NULL) {
        $anceta = '+';
    }

    if ($crov == NULL) {
        $crov = '+';
    }

    if ($ekg == NULL) {
        $ekg = '+';
    }

    if ($ad == NULL) {
        $ad = '+';
    }

    if ($_SESSION['anceta'] == NULL) {
        $_SESSION['anceta'] = 'of';
    }

    if ($_SESSION['crov'] == NULL) {
        $_SESSION['crov'] = 'of';
    }

    if ($_SESSION['ekg'] == NULL) {
        $_SESSION['ekg'] = 'of';
    }

    if ($_SESSION['ad'] == NULL) {
        $_SESSION['ad'] = 'of';
    }

    if ($_GET['anceta'] == 'on') {
        $_SESSION['anceta'] = 'of';
    }

    if ($_GET['anceta'] == 'of') {
        $_SESSION['anceta'] = 'on';
    }

    if ($_SESSION['anceta'] == 'of') {
        $anceta = '+';
    }

    if ($_SESSION['anceta'] == 'on') {
        $anceta = '-';
    }

    if ($_GET['crov'] == 'on') {
        $_SESSION['crov'] = 'of';
    }

    if ($_GET['crov'] == 'of') {
        $_SESSION['crov'] = 'on';
    }

    if ($_SESSION['crov'] == 'of') {
        $crov = '+';
    }

    if ($_SESSION['crov'] == 'on') {
        $crov = '-';
    }

    if ($_GET['ekg'] == 'on') {
        $_SESSION['ekg'] = 'of';
    }

    if ($_GET['ekg'] == 'of') {
        $_SESSION['ekg'] = 'on';
    }

    if ($_SESSION['ekg'] == 'of') {
        $ekg = '+';
    }

    if ($_SESSION['ekg'] == 'on') {
        $ekg = '-';
    }
    
    if ($_GET['ad'] == 'on') {
        $_SESSION['ad'] = 'of';
    }

    if ($_GET['ad'] == 'of') {
        $_SESSION['ad'] = 'on';
    }

    if ($_SESSION['ad'] == 'of') {
        $ad = '+';
    }

    if ($_SESSION['ad'] == 'on') {
        $ad = '-';
    }

    // Вывод в админпанель обработки по анкете, крови и экг 
    include 'view/ao.tpl'; 
}

$_SESSION['errors'] = $_POST;
