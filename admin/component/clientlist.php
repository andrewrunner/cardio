<?php
if($_POST['obr_form']){
	$form_obr = FormaObrabotci($_FILES, $_POST, $_GET);
}
$chec = ($form_obr[3] == 'on') ? '<span style="color: red;">Не своя кардиограмма</span>' : '<span style="color: green;">Собственная обработка</span>';
include'view/client.tpl';