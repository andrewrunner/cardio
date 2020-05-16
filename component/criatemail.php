<?php
if($_POST['savemail']){
	mail (EmailOplata(), '«'.$_POST['tema'].'»', $_POST['mess'].'
	'.$_POST['emailotvet']);
	echo '<div class="container">Благодарим за обращение! Мы скоро Вам ответим!</div>
	<a class="wf_blanck2 jk right_ fg" href="http://iridoc.com/cardio/index.php?name=card">Назад</a>';
}else{
	include'view/mail.tpl';
}