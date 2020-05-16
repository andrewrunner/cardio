<?php
// сохранение IP
$masiv = SaveIp();
$ex = $masiv['ex'];
$cabinet = $masiv['cabinet'];

if (isset($_SESSION['cart'])) {
	if (count($_SESSION['cart']) > 0) {
		$coo = '<div class="cart_prod">' . count($_SESSION['cart']) . '</div>';
	}
}


include 'view/header.tpl';
