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
}

// по году
if ($_POST['data_year']) {
	$d->year = $_POST['data_Y'];
}

$name_polsovatel = Nameclient();

// получаем дополнительный список категорий анкетирования
$dop_categori->id = IdClient();
$_groups_ = $_groups_ + $dop_categori->DopCategoriSpisok();
$new_mod = $dop_categori->DopCategoriMod();

if ( $_POST['data_new_result'] && $_POST['new_personal_grafick'] != ' ' && $_POST['new_personal_grafick'] != '' ) {
	$trans->text = $_POST['new_personal_grafick'];
	$dop_categori->groups = $trans->Transliterator();
	$dop_categori->id = IdClient();
	$dop_categori->name_dop = $_POST['new_personal_grafick'];
	$dop_categori->NewDopCategori();
}

$steck_categori = $dop_categori->DopCategori();
$steck_categori_del = $dop_categori->DopCategoriDelet($_POST['name_graficks_del']);

if ($_POST['data_new_result_del']) {	
	$dop_categori->DopCatDelet($_POST['name_graficks_del']);
}

// записываем результат в базу
if ($_POST['data_new_result']) {
	$dop_categori->data_dop = [
		'data' => date('d.m.Y', strtotime($_POST['data_graficks'])),
		'psevdonim' => $_POST['name_graficks'],
		'pokasanie' => $_POST['resultat_graficks']
	];
	$dop_categori->SaveResultDop();
}

// втсавляем шапку 
include DIAGRAM;

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

$admin = false;

if ($_GET['data'] == 'mount') {
	require_once MONTH;
	echo $svg;
} elseif ($_GET['data'] == 'year') {
	require_once YEAR;
	echo $svg;
}
