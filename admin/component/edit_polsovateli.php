<?php
$_SESSION['personal_id'] = $_GET['id'];

if ($_GET['delite'] == 'del') {
    $del_client = new DeliteChet;
    $del_client->id = $_GET['id'];
    $del_client->DelChetPersonal();
}

$histori = new Histori;
$steck = new DelHistoriPDF;
$calendar = new Kalendar;
$regular = new DataRegular;
$mail = new Mail; // письмо персональные, с календаря 

if ($_GET['del_calendar'] == 'del') {
    $calendar->DelCalendar($_GET['id_reg']);
}

$steck->id = $_GET['id'];

$histori->personal = [
    'id' => $_GET['id']
];

if ($_GET['del_hist'] == 'del') {
    $steck->del_id = $_GET['id_del_'];
    $steck->DelHistori();
}

if ($_GET['delhist'] == 'del') {
    $histori->file = $_GET['histori'];
    $histori->DelHictori();
}

$steck_print = $steck->StecDel(); // сменит id

// удаляем запись
$del_hist = $histori->StecDel(); 

// Получаем список файлов в папке histori
$test_anket = $histori->ResultatAnket(); // назначить ссылку для открития

if (!$_GET['print_rejim']) {
    $_SESSION['print_rejim'] = 'print';
}

if ($_GET['print_rejim']) {
    unset($_SESSION['print_rejim']);
}

if ($_POST['save_chet']) {
    SaveEditChet($_POST, $_GET);
}

if ($_GET['chets'] == 'dell') {
    DeleteChetTable($_GET);
}

if ($personal_dan == NULL) {
    $personal_dan = '+';
}

if ($pdf_del == NULL) {
    $pdf_del = '+';
}

if ($personal_chet == NULL) {
    $personal_chet = '+';
}

if ($calendar_personal == NULL) {
    $calendar_personal = '+';
}

if ($diagram == NULL) {
    $diagram = '+';
}

if ($_SESSION['personal_dan'] == NULL) {
    $_SESSION['personal_dan'] = 'of';
}

if ($_SESSION['pdf_del'] == NULL) {
    $_SESSION['pdf_del'] = 'of';
}

if ($_SESSION['personal_chet'] == NULL) {
    $_SESSION['personal_chet'] = 'of';
}

if ($_SESSION['calendar_personal'] == NULL) {
    $_SESSION['calendar_personal'] = 'of';
}

if ($_SESSION['diagram'] == NULL) {
    $_SESSION['diagram'] = 'of';
}

if ($_GET['personal_dan'] == 'on') {
    $_SESSION['personal_dan'] = 'of';
}

if ($_GET['personal_dan'] == 'of') {
    $_SESSION['personal_dan'] = 'on';
}

if ($_SESSION['personal_dan'] == 'of') {
    $personal_dan = '+';
}

if ($_SESSION['personal_dan'] == 'on') {
    $personal_dan = '-';
}

if ($_GET['pdf_del'] == 'on') {
    $_SESSION['pdf_del'] = 'of';
}

if ($_GET['pdf_del'] == 'of') {
    $_SESSION['pdf_del'] = 'on';
}

if ($_SESSION['pdf_del'] == 'of') {
    $pdf_del = '+';
}

if ($_SESSION['pdf_del'] == 'on') {
    $pdf_del = '-';
}

if ($_GET['personal_chet'] == 'on') {
    $_SESSION['personal_chet'] = 'of';
}

if ($_GET['personal_chet'] == 'of') {
    $_SESSION['personal_chet'] = 'on';
}

if ($_SESSION['personal_chet'] == 'of') {
    $personal_chet = '+';
}

if ($_SESSION['personal_chet'] == 'on') {
    $personal_chet = '-';
}

if ($_GET['calendar_personal'] == 'on') {
    $_SESSION['calendar_personal'] = 'of';
}

if ($_GET['calendar_personal'] == 'of') {
    $_SESSION['calendar_personal'] = 'on';
}

if ($_SESSION['calendar_personal'] == 'of') {
    $calendar_personal = '+';
}

if ($_SESSION['calendar_personal'] == 'on') {
    $calendar_personal = '-';
}
    
if ($_GET['diagram'] == 'on') {
    $_SESSION['diagram'] = 'of';
}

if ($_GET['diagram'] == 'of') {
    $_SESSION['diagram'] = 'on';
}

if ($_SESSION['diagram'] == 'of') {
    $diagram = '+';
}

if ($_SESSION['diagram'] == 'on') {
    $diagram = '-';
}

UpdatePersonalDataPolsovatel($_POST, $_GET); 

if ($_POST['podnam']) {
    $new_email_operator = NewEmailOperator();
    $new_email_system_admin = NewEmailSystemAdmin();
    mail($_SESSION['dfh']['email'], $_SESSION['dfh']['lastname'] . ' ' . $_SESSION['dfh']['firstname'] . ' ' . $_SESSION['dfh']['middlename'] . '. Изминения в персональных данных', $_POST['mailtext'], $_SESSION['dfh']['email']);
   
    if ($new_email_operator) {
        mail($new_email_operator, $_SESSION['dfh']['lastname'] . ' ' . $_SESSION['dfh']['firstname'] . ' ' . $_SESSION['dfh']['middlename'], $_POST['mailtext'], $new_email_operator);
    } elseif (!$new_email_operator) {
        mail($new_email_system_admin[1], $_SESSION['dfh']['lastname'] . ' ' . $_SESSION['dfh']['firstname'] . ' ' . $_SESSION['dfh']['middlename'], $_POST['mailtext'], $new_email_system_admin[1]);
    }

    $data_email = '<p style="color: green; font-size: 16px; text-align: left;">Данные успешно отправлены!</p>';
} else {
    $data_email = '';
}

$polsovatel = SesssionInterpritation($_GET['id']);
$rmt = (OnOffPolsovatel($_GET['id']) != '') ? 'да' : 'нет';
$_SESSION['dfh']['otricatilno'] = $rmt;

if (!$_SESSION['dgr']) {
    $_SESSION['dgr'] = $_SESSION['dfh'];
}

echo '<div class="table_client">
	<div class="south">' . Edit('icon4') . '</div>
<h1 style="text-align: center;">Поле для редактирования данных пользователя</h1>';

if ($_GET['optses'] == 'startses') {
    echo IsmenenieData($_GET['id'], $_SESSION);
    echo $data_email;
} else {
    include 'view/personal_data.tpl'; 
}
