<div class="f_admin">
	<div class="content"><?php echo ClientDataPersonal($_GET).$form_obr[0]; ?>
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
					<div class="bn"><b>Оплата проведена</b>: <?php echo $newmassiv[0]; ?></div>
				</div>
			</div>
		</div>
	<div class="block_men">
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
					<a class="wf_blanck2 jk right_ fg" href="../download/<?php echo $form_obr[12]; ?>" download>скачать</a>
				</div>
			</div>
		</fieldset>	
	</div>
	<fieldset class="ram2">
			<legend>Форма обработки:</legend>		
			<div class="bn dat mg block_a">
				<form name="form" action="" method="post" id="form" enctype="multipart/form-data">
					<div class="block_a pag">
						<label class="wf_text">Краткий коментарий:</label>
						<textarea name="coment_" class="text_client2" rows="5" placeholder="Поле для внесения коментария"></textarea>
						<div class="block_f">
							<label name="comentari_vrath" class="wf_text" for="uploadfile"><span style="color: red;">*</span>Загрузить данные:</label>
							<input class="wf_blanck" type="file" name="filename" multiple="multiple">
						</div>
					</div>
					<div class="dat" style="padding-top: 10px;">
						<input class="wf_blanck2 jk right_" type="reset" value="Отмена">
						<input name="forma_otpravki" type="submit" class="wf_blanck2 jk right_ fg" id="" value="Отправить">
					</div>
				</form>
			</div>
		</fieldset>
	<fieldset class="ram2">
		<legend>Список пользователей:</legend>	
		<form name="sps" action="index.php?name=clientlisting&id=<?php echo $_GET['id'] ?>" method="post" id="form" enctype="multipart/form-data">
			<input class="wf_blanck2 jk right_" type="reset" value="Отмена">
			<input name="number_client" class="wf_blanck2 jk right_" type="submit" value="Добавить получателя">
		</form>
	</fieldset>	
<div class="dock">
	<fieldset class="ram2">
		<legend>Список партнеров:</legend>
		<form name="part" action="" method="post" id="form" enctype="multipart/form-data">
			<input class="wf_blanck2 jk right_" type="reset" value="Отмена">
				<input name="dath" class="wf_blanck2 jk right_" type="submit" value="Добавить партнера">
		</form>
	</fieldset>
	<fieldset class="ram2">
		<legend>Подтверждение оплаты:</legend>
		<form action="" method="post" enctype="multipart/form-data">
			<input name="opl" class="wf_blanck2 jk right_" type="submit" value="Оплачено">
		</form>
		<form action="" method="post" enctype="multipart/form-data">
			<input name="noopl" class="wf_blanck2 jk right_" type="submit" value="Не оплачено">
		</form>
		<a class="wf_blanck2 jk right_ fg" href="http://iridoc.com/cardio/admin/index.php?name=client_del">К списку клиентов</a>
	</fieldset>
</div></div>
<div style="width: 100%; float: left; margin: 10px 0 0 10px;"><?php echo $newmassiv[1]; ?></div>