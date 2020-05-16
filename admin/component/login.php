<?php
$text_ = '';
$text_2 = '';
if($_POST['operator_logi']){
	$text_ = LoginOperator($_POST);
}
if($_POST['email_operator']){
	$text_3 = EmailOperatop($_POST);
}
if($_POST['system_logi']){
	$text_array = LoginAdmin($_POST);
	$text_ = $text_array[0];
	$text_2 = $text_array[1];
}
if($_POST['new_email_system']){
	$text_3 = EmailSystem1($_POST);
}
if($_POST['new_email_system2']){
	$text_3 = EmailSystem2($_POST);
}
$array_email_system = NewEmailSystemAdmin();
if($text_ != ''){
	$text_gh1 = '<br><div>'.$text_.'</div>';
}else{
	$text_gh1 = '';
}
if($text_2 != ''){
	$text_gh2 = '<br><div>'.$text_2.'</div>';
}else{
	$text_gh2 = '';
}
if($text_3 != ''){
	$text_gh3 = '<br><div>'.$text_3.'</div>';
}else{
	$text_gh3 = '';
}

include'view/login_pass.tpl';