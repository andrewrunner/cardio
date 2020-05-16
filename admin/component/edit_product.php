<?php

if ($_POST['product_group']) {
	$_SESSION['categori_product'] = $_POST['product_group'];
}

ProductUpdateEdit($_POST, $_FILES);
$new_array = Product($_GET['id']);
include'view/product.tpl';
