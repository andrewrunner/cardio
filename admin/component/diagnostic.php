<?php
$d = new Diagramma;
$year = new Year;
$dop_categori = new DopCategoriDiagrams;
$trans = new Translit;

$g_cat = $_POST['group_categories'];


$s = [
    '01' => 'Январь',
    '02' => 'Февраль',
    '03' => 'Март',
    '04' => 'Апрель',
    '05' => 'Май',
    '06' => 'Июнь',
    '07' => 'Июль',
    '08' => 'Август',
    '09' => 'Сентябрь',
    '10' => 'Октябрь',
    '11' => 'Ноябрь',
    '12' => 'Декабрь'
];

$_groups_ = [
    'anketa' => 'По анкете',
    'crov' => 'По крови',
    'ecg' => 'По ЭКГ',
    'ad' => 'По АД'
];

// по месяцу
if ($_POST['mount_diagrams']) {
	$d->data = date('m.Y', strtotime($_POST['data']));
	$col_data = date('t', strtotime($_POST['data'] . '-01'));
	$mount = date('m', strtotime($_POST['data']));
} else {
    $d->data = date('m.Y');
    $mount = date('m');
}

// по году
if ($_POST['data_year']) {
	$d->year = $_POST['data_Y'];
} else {
    $d->year = date('Y');
}

// удаление записи из базы
if ($_GET['del_id_diagrams']) {
    $d->DelRegDiagram($_GET['del_id_diagrams']);
}

// создать новую запись
if ($_GET['new_diagram_reg']) {
    $d->NewRegDiagram($_GET['new_diagram_reg']);
}

// сохраняем изменения
if ($_POST['save_d']) {
    $d->array = $_POST;
    $d->UpdateRegDiagram();
}

// редактирование базы
if ($_GET['data'] == 'base') {
    $d->id = $_GET['id'];
    $base_diagrams = $d->SteckResultDiagram();
}

// получаем дополнительный список категорий анкетирования
$dop_categori->id = $_GET['id'];
$_groups_ = $_groups_ + $dop_categori->DopCategoriSpisok();
$new_mod = $dop_categori->DopCategoriMod();

if ( $_POST['data_new_result'] && $_POST['new_personal_grafick'] != ' ' && $_POST['new_personal_grafick'] != '' ) {
	$trans->text = $_POST['new_personal_grafick'];
	$dop_categori->groups = $trans->Transliterator();
	$dop_categori->id = $_GET['id'];
	$dop_categori->name_dop = $_POST['new_personal_grafick'];
	$dop_categori->NewDopCategori();
}

if ($_POST['data_new_result_del']) {	
	$dop_categori->DopCatDelet($_POST['name_graficks_del']);
}

$steck_categori = $dop_categori->DopCategori();
$steck_categori_del = $dop_categori->DopCategoriDelet($_POST['name_graficks_del']);

// записываем результат в базу
if ($_POST['data_new_result']) {
	$dop_categori->data_dop = [
		'data' => date('d.m.Y', strtotime($_POST['data_graficks'])),
		'psevdonim' => $_POST['name_graficks'],
		'pokasanie' => $_POST['resultat_graficks']
	];
	$dop_categori->SaveResultDop();
}

include MONTH; // оснастка

/*
	Начало обработки диаграммы
*/				
$_cat_ = ['1А', '1Б', '2А', '2Б', '3А', '3Б', '4А', '4Б', '5А', '5Б', '6А', '6Б', '7А', '7Б', '8А', '8Б', '9А', '9Б'];
$_number_ = [18, 17, 16, 15, 14, 13, 12, 11, 10, 9, 8, 7, 6, 5, 4, 3, 2, 1];

// массив проверяемых методик
$mod = ['anketa', 'crov', 'ecg', 'ad']; 
$new_mod = $dop_categori->DopCategoriMod();
$mod = $mod + $new_mod;

// массив цветов для кривой
$color = ['#3FA9F5', 'red', 'green', '#f5bc20'];
$color2 = '#666'; // цвет рамки

// выравниваем массивы
$rows = 4 + count($new_mod);
for ($wt = 4; $wt < $rows; $wt++) {
	$color[$wt] = '#4d6a88';
}

$admin = true;

// на месяц
if ($_GET['data'] == 'mount') {
	require_once _MONTH_;
	echo $svg;
} elseif ($_GET['data'] == 'year') { // на год
	require_once _YEAR_;
	echo $svg;
}
