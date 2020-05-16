</div>
<div class="form_table2" style="margin : 20px auto;">
	<form name="card_fio" action="index.php?name=card" method="post" enctype="multipart/form-data">
		<p>Если Вы воспользовались для оплаты не своей картой, то введите <b>ФИО</b> владельца карты. Данная информация
			нужна для проверки оплаты и дальнейшей обработки Ваших данных.<br>Если же карта пренадлежит Вам и <b>ФИО</b>
			соответствует ранее записаному, то вводить ничего не надо.</p>
		<label style="font-weight: 700; font-family: tahoma;">ФИО: </label>
		<?php echo $er_bat[1]; ?>
		<a class="wf_blanck2 jk right_ fg" href="http://iridoc.com/cardio/index.php?name=card">Назад</a>
		<input name="fio" type="text" placeholder="Фамилия Имя Отчество" style="padding: 5px; border: 1px solid #ddd; width: 300px; border-radius: 2px;">
		<p>Для продолжения нажмите кнопку <b>«Далее»</b>. Если у Вас есть оплаченый лимит, то спишится с лемита одна
			единица , после чего вы увидите начальную страницу. Если лимит исчерпан, Вы перейдете к форме оплаты.</p>
	</form>
</div>
