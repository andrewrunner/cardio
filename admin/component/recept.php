<?php
if ($_POST['sort_group']) $_SESSION['recept_spisock'] = $_POST['recept_spisock'];
DeleteBs($_GET);
UpdateBs($_POST, $_GET);
SaveNewBs($_POST);
NewReceptSave($_POST);

echo '<div class="south">' . Recept('icon4') . '</div>
<h1 style="text-align: center;">РЕЦЕПТЫ</h1>';

if ($rev == NULL) {
	$rev = '+';
}

if ($rex == NULL) {
	$rex = '+';
}

if ($reu == NULL) {
	$reu = '+';
}

if ($rey == NULL) {
	$rey = '+';
}

if ($rem == NULL) {
	$rem = '+';
}

if ($zakl == NULL) {
	$zakl = '+';
}

if ($_SESSION['bio'] == NULL) {
	$_SESSION['bio'] = 'of';
}

if ($_SESSION['rec'] == NULL) {
	$_SESSION['rec'] = 'of';
}

if ($_SESSION['ancc'] == NULL) {
	$_SESSION['ancc'] = 'of';
}

if ($_SESSION['ecg'] == NULL) {
	$_SESSION['ecg'] = 'of';
}

if ($_SESSION['crv'] == NULL) {
	$_SESSION['crv'] = 'of';
}

if ($_SESSION['zakl'] == NULL) {
	$_SESSION['zakl'] = 'of';
}

// 1 редактирование биостимулятора
SaveBsEdit($_POST, $_GET);

if ($_GET['bio'] == 'on') {
	$_SESSION['bio'] = 'of';
}

if ($_GET['bio'] == 'of') {
	$_SESSION['bio'] = 'on';
}

if ($_SESSION['bio'] == 'of') {
	$rem = '+';
}

if ($_SESSION['bio'] == 'on') {
	$rem = '-';
}

echo '<h2><a class="dot" href="index.php?name=recept&bio=' . $_SESSION['bio'] . '">' . $rem . '</a>Редактировать биостимулятор</h2>';

if ($_SESSION['bio'] == 'on') {
	$_bs = EditBs($_GET, $_POST);
	include 'view/biostimulator.tpl';
}

// 2 редактирование  рецептов

if ($_GET['rec'] == 'on') {
	$_SESSION['rec'] = 'of';
}

if ($_GET['rec'] == 'of') {
	$_SESSION['rec'] = 'on';
}

if ($_SESSION['rec'] == 'of') {
	$rey = '+';
}

if ($_SESSION['rec'] == 'on') {
	$rey = '-';
}

echo '<h2><a class="dot" href="index.php?name=recept&rec=' . $_SESSION['rec'] . '">' . $rey . '</a>Редактировать рецепты</h2>';

EditReceprt($_POST, $_GET);

if ($_SESSION['rec'] == 'on') {
	$tablet = StacTableBS($_SESSION);
	if ($_POST['import_data']) ImpotrTabletRecept($_POST);
	include 'view/algoritm_recept.tpl';
}

// 3 расчет по анкете

if ($_GET['ancc'] == 'on') {
	$_SESSION['ancc'] = 'of';
}

if ($_GET['ancc'] == 'of') {
	$_SESSION['ancc'] = 'on';
}

if ($_SESSION['ancc'] == 'of') {
	$reu = '+';
}

if ($_SESSION['ancc'] == 'on') {
	$reu = '-';
}

AncetaEdid($_POST);

echo '<h2><a class="dot" href="index.php?name=recept&ancc=' . $_SESSION['ancc'] . '">' . $reu . '</a>Алгоритм анкеты</h2>';

if ($_SESSION['ancc'] == 'on') {
	include 'view/algoritm_anceta.tpl';
}

// 4 расчет по ЭКГ

if ($_GET['ecg'] == 'on') {
	$_SESSION['ecg'] = 'of';
}

if ($_GET['ecg'] == 'of') {
	$_SESSION['ecg'] = 'on';
}

if ($_SESSION['ecg'] == 'of') {
	$rex = '+';
}

if ($_SESSION['ecg'] == 'on') {
	$rex = '-';
}

echo '<h2><a class="dot" href="index.php?name=recept&ecg=' . $_SESSION['ecg'] . '">' . $rex . '</a>Алгоритм ЭКГ</h2>';

Ekg($_POST);

if ($_SESSION['ecg'] == 'on') {
	include 'view/algoritm_ecg.tpl';
}

// 5 Расчет по формуле крови
//Проблема вывода на страницу

if ($_GET['crv'] == 'on') {
	$_SESSION['crv'] = 'of';
}

if ($_GET['crv'] == 'of') {
	$_SESSION['crv'] = 'on';
}

if ($_SESSION['crv'] == 'of') {
	$rev = '+';
}

if ($_SESSION['crv'] == 'on') {
	$rev = '-';
}

echo '<h2><a class="dot" href="index.php?name=recept&crv=' . $_SESSION['crv'] . '">' . $rev . '</a>Алгоритм расчета по формуле крови</h2>';

if ($_SESSION['crv'] == 'on') {
	DiapasonLiEdit($_POST);
	DiapasonSignalEdit($_POST);
	include 'view/algoritm_po_krovi.tpl'; // 
}

// 6 Алгоритм заключения

if ($_GET['zakl'] == 'on') {
	$_SESSION['zakl'] = 'of';
}

if ($_GET['zakl'] == 'of') {
	$_SESSION['zakl'] = 'on';
}

if ($_SESSION['zakl'] == 'of') {
	$zakl = '+';
}

if ($_SESSION['zakl'] == 'on') {
	$zakl = '-';
}

echo '<h2><a class="dot" href="index.php?name=recept&zakl=' . $_SESSION['zakl'] . '">' . $zakl . '</a>Алгоритм заключения</h2>';

if ($_SESSION['zakl'] == 'on') {
	UpdateZacluchenie($_POST, $_GET);
	include 'view/algoritm_zaklucheniya.tpl';
}
