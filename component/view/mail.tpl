<div class="container">
	<div class="pull-left">
		<h1><span class="glyphicon glyphicon-envelope"></span> Написать письмо<span class="hidden-xs">. Задать вопрос</span></h1>
	</div>
	<form action="index.php?name=criatemail" method="post" enctype="multipart/form-data">
		<div class="block_f2">
			<label class="wf_text">Тема:</label>
			<select name="tema" class="block_strock" required>
				<?php echo EditMail(); ?>
			</select>
		</div>
		<div class="block_f2">
			<label class="wf_text">Ваш е-mail:</label>
			<input class="block_strock" name="emailotvet" type="email" value="" required>
		</div>
		<div class="block_f2">
			<label class="wf_text"><font color="red">*</font>Сообщение:</label>
			<textarea class="block_strock" name="mess" rows="10" required></textarea>
		</div>
		<div class="block_f2">
			<hr>
			<input class="wf_blanck2 jk right_" type="submit" name="savemail" value="Отправить">
		</div>
	</form>
</div>