<?php
if($_GET['name'] == 'group_pro'){
	$id_group = $_GET['id'];
	$result = mysqli_query($mysqli, "DELETE FROM ".CATEGORIS." WHERE ".CATEGORIS.".`id` = $id_group") or die("Ошибка " . mysqli_error($mysqli));
}
if($_POST['ngpa']){
	$name_group_product = $_POST['ngp'];
	$result = mysqli_query($mysqli, "INSERT INTO ".CATEGORIS." (`namegroup`) VALUES ('$name_group_product')") or die("Ошибка " . mysqli_error($mysqli));
}

if($new_tov == NULL){$new_tov = '+';}
if($edit_tov == NULL){$edit_tov = '+';}
if($stec_tov == NULL){$stec_tov = '+';}

if($_SESSION['new_tov'] == NULL){$_SESSION['new_tov'] = 'of';}
if($_SESSION['edit_tov'] == NULL){$_SESSION['edit_tov'] = 'of';}
if($_SESSION['stec_tov'] == NULL){$_SESSION['stec_tov'] = 'of';}

if($_GET['new_tov'] == 'on'){$_SESSION['new_tov'] = 'of';}
if($_GET['new_tov'] == 'of'){$_SESSION['new_tov'] = 'on';}
if($_SESSION['new_tov'] == 'of'){$new_tov = '+';}
if($_SESSION['new_tov'] == 'on'){$new_tov = '-';}

if($_GET['edit_tov'] == 'on'){$_SESSION['edit_tov'] = 'of';}
if($_GET['edit_tov'] == 'of'){$_SESSION['edit_tov'] = 'on';}
if($_SESSION['edit_tov'] == 'of'){$edit_tov = '+';}
if($_SESSION['edit_tov'] == 'on'){$edit_tov = '-';}

if($_GET['stec_tov'] == 'on'){$_SESSION['stec_tov'] = 'of';}
if($_GET['stec_tov'] == 'of'){$_SESSION['stec_tov'] = 'on';}
if($_SESSION['stec_tov'] == 'of'){$stec_tov = '+';}
if($_SESSION['stec_tov'] == 'on'){$stec_tov = '-';}

include'view/edit_product.tpl';