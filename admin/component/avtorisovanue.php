<?php
$download = new DownloadDel;

if ($_GET['delet'] == 'del' && $_GET['file_name'] != '') {
	$download->DownloadDelet($_GET['file_name']);
}

$down_ = $download->DownloadHistori();

if ($_POST['emotv']) {
	EmailOplataAuto($_POST);
}

$nameuse = $_POST['nameusers'];
$nn = explode('|', $nameuse, 10);
$usersname = $nn[1];

if ($_POST['diagrampol']) {
	$array_diagram = Diagrama($usersname, $nn);
	$res = $array_diagram[0];
	$data = $array_diagram[1];
	$ress = $array_diagram[2];
}

$voprosu = explode(',', $ress, 80);

if ($_POST['datasort']) {
	$datareg = date('d.m.y', strtotime($_POST['datastart']));
} else {
	$datareg = '01.01.70';
}

if ($_email_poluch_ == NULL) {
	$_email_poluch_ = '+';
}

if ($_steck_polsov_ == NULL) {
	$_steck_polsov_ = '+';
}

if ($_diagrams_ == NULL) {
	$_diagrams_ = '+';
}


if ($_file_del_ == NULL) {
	$_file_del_ = '+';
}

if ($_SESSION['_email_poluch_'] == NULL) {
	$_SESSION['_email_poluch_'] = 'of';
}

if ($_SESSION['_steck_polsov_'] == NULL) {
	$_SESSION['_steck_polsov_'] = 'of';
}

if ($_SESSION['_diagrams_'] == NULL) {
	$_SESSION['_diagrams_'] = 'of';
}

if ($_SESSION['_file_del_'] == NULL) {
	$_SESSION['_file_del_'] = 'of';
}

if ($_GET['_email_poluch_'] == 'on') {
	$_SESSION['_email_poluch_'] = 'of';
}

if ($_GET['_email_poluch_'] == 'of') {
	$_SESSION['_email_poluch_'] = 'on';
}

if ($_SESSION['_email_poluch_'] == 'of') {
	$_email_poluch_ = '+';
}

if ($_SESSION['_email_poluch_'] == 'on') {
	$_email_poluch_ = '-';
}

if ($_GET['_steck_polsov_'] == 'on') {
	$_SESSION['_steck_polsov_'] = 'of';
}

if ($_GET['_steck_polsov_'] == 'of') {
	$_SESSION['_steck_polsov_'] = 'on';
}

if ($_SESSION['_steck_polsov_'] == 'of') {
	$_steck_polsov_ = '+';
}

if ($_SESSION['_steck_polsov_'] == 'on') {
	$_steck_polsov_ = '-';
}

if ($_GET['_diagrams_'] == 'on') {
	$_SESSION['_diagrams_'] = 'of';
}

if ($_GET['_diagrams_'] == 'of') {
	$_SESSION['_diagrams_'] = 'on';
}

if ($_SESSION['_diagrams_'] == 'of') {
	$_diagrams_ = '+';
}

if ($_SESSION['_diagrams_'] == 'on') {
	$_diagrams_ = '-';
}

if ($_GET['_file_del_'] == 'on') {
	$_SESSION['_file_del_'] = 'of';
}

if ($_GET['_file_del_'] == 'of') {
	$_SESSION['_file_del_'] = 'on';
}

if ($_SESSION['_file_del_'] == 'of') {
	$_file_del_ = '+';
}

if ($_SESSION['_file_del_'] == 'on') {
	$_file_del_ = '-';
}

include 'view/autorisation.tpl';

if ($_POST['nameusers'] != '') {
	include 'view/diagramma.tpl';
}
