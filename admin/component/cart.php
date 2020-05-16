<?php
if ($_GET == $_SESSION['storag']) {
	echo '<p class="redd">Вы пытаетесь отправить повторно запрос!</p>
	<a class="wf_blanck2 jk" href="index.php?name=cart">Назад</>';
} else {
		
	// Оформление заказа, проведение платежа
	if ($_GET['otp'] == 'opt') {
		UpdateCartUserSakas($_GET);
	}

	// Подтверждение оплаченого заказа
	if ($_GET['oplata'] == 'opl') {
		UpdateCartUserOplataGreen($_GET);
	}

	// Подтверждение что заказ не оплачен
	if ($_GET['oplata'] == 'noopl') {
		UpdateCartUserOplataRed($_GET);
	}

	// Удаление заказа
	if ($_GET['deltov'] == 'delt') {
		DeleteCartUser($_GET);
	}

	// вывод заказов
	echo SteacSakas($tt);

	// блокируем повторный запрос
	if ($_GET['otp'] == 'opt') {
		$_SESSION['storag'] = $_GET;	
	}
}
