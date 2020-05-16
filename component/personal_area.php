<?php
// получаем калькулятор
if ($_POST['calculator_valut']) {
	$calculator_valut = new Calculator($_POST['valuta'], $_POST['summa_convertacii'], $_POST['out_valuta']);
	$summa_convertacii = '<div class="result">' . round($calculator_valut->Calk(), 2) . ' ' . $_POST['out_valuta'] . '</div>';
}

// Персональный кабинет
include 'view/personal_area.tpl';

// календарь здоровья
$cal_oz = new Calendar;
$year = new Year;

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

// опредиление года
$_year_ = date('Y') - 3;
for ($i = 0; $i < 10; $i++) {
	if (($_year_ + $i) == date('Y')) {
		$select = ' selected';
	} else {
		$select = '';
	}
	$_plr_ .= '<option' . $select . '>' . ($_year_ + $i) . '</option>';
}

if ($_POST['kalendar']) {
	$cal_oz->mount = $_POST['cal_mes'];
	$cal_oz->year = $_POST['_year_'];
	$cal_oz->text = $s[$_POST['cal_mes']];
} else {
	$cal_oz->mount = date('m');
	$cal_oz->year = date('Y');
	$cal_oz->text = $s[date('m')];
}

$url = URLPartner(['group' => '914']);

// формирование ячеек календаря
include CALENDAROZ;
