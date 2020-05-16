<?php

// Удаление всех записей счетов
if ($_GET['delite'] == 'del_globel') {
    $del_globel = new DeliteChet; // проверка удаления по записям счетов
    $del_globel->GlobalDel();
}

$statistic = new Statistic;
$u = $statistic->StaticSumma(); // Вывод по суммам пользователей
$limit = $statistic->Limite(); // Вывод по лимиту 
$data_summa = $statistic->DataFinans();

if ($_GET['reles']) {
    ColumEdit($_GET);
}

if ($_GET['newdel'] == 'del') {
    unset($_SESSION['dfh'], $_SESSION['dgr']);
}

$ar = ResultatSumma();
RegistrationNewPolsovatel($_POST);
$style = StyleColumDuo();

// Группа опредиления старта
if ($_kalendar_ == NULL) {
    $_kalendar_ = '+';
}

if ($_tablet_client_ == NULL) {
    $_tablet_client_ = '+';
}

if ($_new_pol_ == NULL) {
    $_new_pol_ = '+';
}

if ($del_chet == NULL) {
    $del_chet = '+';
}

// Группа сессии если нет
if ($_SESSION['_kalendar_'] == NULL) {
    $_SESSION['_kalendar_'] = 'of';
}

if ($_SESSION['_tablet_client_'] == NULL) {
    $_SESSION['_tablet_client_'] = 'of';
}

if ($_SESSION['_new_pol_'] == NULL) {
    $_SESSION['_new_pol_'] = 'of';
}

if ($_SESSION['del_chet'] == NULL) {
    $_SESSION['del_chet'] = 'of';
}

// Группа 1
if ($_GET['_kalendar_'] == 'on') {
    $_SESSION['_kalendar_'] = 'of';
}

if ($_GET['_kalendar_'] == 'of') {
    $_SESSION['_kalendar_'] = 'on';
}

if ($_SESSION['_kalendar_'] == 'of') {
    $_kalendar_ = '+';
}

if ($_SESSION['_kalendar_'] == 'on') {
    $_kalendar_ = '-';
}

// Группа 2
if ($_GET['_tablet_client_'] == 'on') {
    $_SESSION['_tablet_client_'] = 'of';
}

if ($_GET['_tablet_client_'] == 'of') {
    $_SESSION['_tablet_client_'] = 'on';
}

if ($_SESSION['_tablet_client_'] == 'of') {
    $_tablet_client_ = '+';
}

if ($_SESSION['_tablet_client_'] == 'on') {
    $_tablet_client_ = '-';
}

// Группа 3
if ($_GET['_new_pol_'] == 'on') {
    $_SESSION['_new_pol_'] = 'of';
}

if ($_GET['_new_pol_'] == 'of') {
    $_SESSION['_new_pol_'] = 'on';
}

if ($_SESSION['_new_pol_'] == 'of') {
    $_new_pol_ = '+';
}

if ($_SESSION['_new_pol_'] == 'on') {
    $_new_pol_ = '-';
}

// Группа 4
if ($_GET['del_chet'] == 'on') {
    $_SESSION['del_chet'] = 'of';
}

if ($_GET['del_chet'] == 'of') {
    $_SESSION['del_chet'] = 'on';
}

if ($_SESSION['del_chet'] == 'of') {
    $del_chet = '+';
}

if ($_SESSION['del_chet'] == 'on') {
    $del_chet = '-';
}

// Вывод на экран
include 'view/spisock_polsovateley.tpl';
