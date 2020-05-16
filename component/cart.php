<?php

if ($_GET['mas'] >= 0) {
	$mas = $_GET['mas'];
	unset($_SESSION['cart'][$mas], $_SESSION['colltov'][$mas]);
}

$cabinet = SaveIp($_SESSION);

// сохранение корзины
if ($cabinet) {
	$save = '<a class="wf_blanck2 jk right_" href="index.php?name=cart&save=save">Сохранить</a>';
}

// сохранение корзины
if ($_GET['save']) {
    
    // сохранение в корзину пользователя
	$iduser = Savecart($valuta, $_SESSION);

	if ($iduser) {
		unset($_SESSION['cart'], $_SESSION['colltov'], $_SESSION['summa_'], $_SESSION['valuta']);
		$stt = '<a class="wf_blanck2 jk right_" href="index.php?name=cartpersonal">Перейти к сохраненым заказам</a>';
	}

	header('Location: http://iridoc.com/cardio/index.php?name=cart');
} else {
	$stt = '';
}


if ($_SESSION['cart']) {
	echo Polsovatel($_SESSION) . '
	<div class="icon_print">
		<a href="#" onClick="javascript:CallPrintSac(\'print-content\');" title="Распечатать проект">' . Printer('icon') . '</a>
	</div>
	<div id="print-content">
	<div class="cart3 no_visibiliti"><b>
		<div class="imges"></div>
		<div class="tov_block">Наименование</div>
		<div class="tov_block2">Единиц</div>
		<div class="tov_block2">Цена</div>
		<div class="tov_block2">Всего</div>
		<div class="tov_block2 vis"></div>
	</b></div>';
		
	$array = CartProduct($_SESSION);
	echo $array['block'];
	
	if ($array['itog'] > 0) {
		echo '<div style="width: 100%; overflow: hidden; box-sizing: border-box;">
				<div class="itog_"><b>И того:</b> ' . $array['itog'] . ' ' . $valuta . '</div>
			</div>
		</div>';
	} else {
		echo '</div>';
	}
	
	echo '
		<br><div style="width: 100%; box-sizing: border-box;">
			' . $save . '
			<a class="wf_blanck2 jk right_" href="index.php?name=cart&page=dell">Очистить</a>
			<a class="wf_blanck2 jk right_" href="index.php?name=metodic">Продолжить выбор</a>
		</div>
		<br>';
} else {
	if ($_GET['name'] != 'cartpersonal') {
		echo '<div id="print-content">
			<a class="wf_blanck2 jk right_" href="index.php?name=cartpersonal">Перейти к сохраненым заказам</a>
			<a class="wf_blanck2 jk right_" href="index.php?name=metodic">Перейти к выбору</a>
		</div> ';
	}
}