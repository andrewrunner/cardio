<?php
// опредиляем корек
$corection = new CorectSumma;

// записываем в базу результат
if ($_POST['corect']) {
	$corection->sum_val = [
		'individual' => [
			'price' => $_POST['individual'],
			'valuta' => $_POST['individual_valuta']
		],
		'minus' => [
			'price' => $_POST['minus'],
			'valuta' => $_POST['minus_valuta']
		],
		'vne' => [
			'price' => $_POST['vne'],
			'valuta' => $_POST['vne_valuta']
		]
	];
	$corection->SaveCorect();
}

$_c_ = $corection->Corect();

// удаление всех записей
if ($_GET['del_valuta'] == 'del') {
	$fin = new Finotchet;
	$fin->DelFinOtchet();
}

// коректировка суммы CORECT
if ($_POST['corect']) {
	// написать функцию
}

if($_GET['deldat'] == 'dell'){
	DeletFinOtchot($_GET);
}

if($_GET['sav'] == 'savings'){
	UpdateFinOtchot($_GET, $_POST);
}

if($_POST['vall']){
	UpdateValuta($_GET, $_POST);
}

if($_POST['datasut']){
	$datasortir = date('d.m.y', strtotime($_POST['datapost']));
}

if($_valut_ == NULL){$_valut_ = '+';}
if($_summa_ == NULL){$_summa_ = '+';}
if($_corect_ == NULL){$_corect_ = '+';}

if($_SESSION['_valut_'] == NULL){$_SESSION['_valut_'] = 'of';}
if($_SESSION['_summa_'] == NULL){$_SESSION['_summa_'] = 'of';}
if($_SESSION['_corect_'] == NULL){$_SESSION['_corect_'] = 'of';}
if($_SESSION['_calculator_'] == NULL){$_SESSION['_calculator_'] = 'of';}

if($_GET['_valut_'] == 'on'){$_SESSION['_valut_'] = 'of';}
if($_GET['_valut_'] == 'of'){$_SESSION['_valut_'] = 'on';}
if($_SESSION['_valut_'] == 'of'){$_valut_ = '+';}
if($_SESSION['_valut_'] == 'on'){$_valut_ = '-';}

if($_GET['_summa_'] == 'on'){$_SESSION['_summa_'] = 'of';}
if($_GET['_summa_'] == 'of'){$_SESSION['_summa_'] = 'on';}
if($_SESSION['_summa_'] == 'of'){$_summa_ = '+';}
if($_SESSION['_summa_'] == 'on'){$_summa_ = '-';}

if($_GET['_corect_'] == 'on'){$_SESSION['_corect_'] = 'of';}
if($_GET['_corect_'] == 'of'){$_SESSION['_corect_'] = 'on';}
if($_SESSION['_corect_'] == 'of'){$_corect_ = '+';}
if($_SESSION['_corect_'] == 'on'){$_corect_ = '-';}

if($_GET['_calculator_'] == 'on'){$_SESSION['_calculator_'] = 'of';}
if($_GET['_calculator_'] == 'of'){$_SESSION['_calculator_'] = 'on';}
if($_SESSION['_calculator_'] == 'of'){$_calculator_ = '+';}
if($_SESSION['_calculator_'] == 'on'){$_calculator_ = '-';}

if ($_POST['calculator_valut']) {
	$calculator_valut = new Calculator($_POST['valuta'], $_POST['summa_convertacii']);
	$summa_convertacii = '<div class="result"><b>Результат расчета:</b>  ' . round($calculator_valut->Calk(), 2) . ' грн.</div>';
}

include'view/forma_valuta.tpl';
