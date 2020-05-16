<div class="f_admin">
<div class="content">
	<div class="table_client"><?php echo ClientDataPersonal($_GET).$form_obr[0]; ?></div>
	<div class="diagnostic2">
		<div class="dat">
			<p class="bn klent"><b><?php echo $form_obr[1]; ?></b></p>
		</div>
		<div class="dat">
			<div class="bl_6">
				<div class="bn dat"><?php echo $form_obr[4]; ?> г.</div>
				<div class="bn dat"><b>Email</b>: <?php echo $form_obr[2]; ?></div>
				<div class="bn dat"><b>Пол</b>: <?php echo $form_obr[5]; ?></div>
			</div>
			<div class="bl_6">
				<div class="bn"><b>Запись произведена</b>: <?php echo $form_obr[6]; ?></div>
				<div class="bn"><b>Вид обработки</b>: <?php echo $form_obr[7]; ?></div>
			</div>
			<div class="bl_7">
				<div class="bn"><b>С чией карты оплачено</b>: <?php echo $form_obr[8]; ?></div><br>
				<div class="bn"><b>Оплата проведена</b>: <?php echo $form_obr[9]; ?></div>
			</div>
		</div>
	</div>
<fieldset class="ram2">
	<legend>Данные клиента:</legend>
	<div class="bn dat mg block_a">
		<div class="block_a">
			<h3>Не своя кардиограмма:</h3>
			<div class="text_client"><?php echo $chec; ?></div>
		</div>
		<div class="block_a">
			<h3>Жалобы:</h3>
			<div class="text_client"><?php echo $form_obr[10]; ?></div>
		</div>
		<div class="block_a">
			<h3>Коментарии:</h3>
			<div class="text_client"><?php echo $form_obr[11]; ?></div>
		</div>
		<div class="block_a mg">
			<label class="wf_text">Данные клиента:</label>
			<a class="wf_blanck2 jk right_ fg" href="http://iridoc.com/cardio/download/<?php echo $form_obr[12]; ?>" download>Скачать</a>
		</div>
	</div>
</fieldset>
<form name="form" action="" method="post" id="form" enctype="multipart/form-data">
	<fieldset class="ram2">
		<legend>Данные обработки:</legend>
		<label class="wf_text">Краткий коментарий:</label>
		<textarea name="coment_" class="text_client" rows="5" placeholder="Поле для внесения коментария"></textarea>
		<div class="block_f">
			<label name="comentari_vrath" class="wf_text" for="uploadfile"><span style="color: red;">*</span>Загрузить данные:</label>
			<input class="wf_blanck" type="file" name="filename" multiple="multiple">
		</div>		
		<div class="dat" style="padding-top: 10px;">
			<input class="wf_blanck2 jk right_" type="reset" value="Отмена">
			<input name="obr_form" type="submit" class="wf_blanck2 jk right_ fg" id="" value="Отправить">
			<a class="wf_blanck2 jk right_ fg" href="index.php">К списку клиентов</a>
		</div>
	</fieldset>
</form>
</div>
</div>