<form name="basis_" action="index.php" method="post" enctype="multipart/form-data">
	<div class="fm_3">
		<?php echo $personal_date['personal']; ?>
		<div class="block_f2" style="color: red; font-size: 14px;">Если Вы получили персональный номер или номер группы, то введите его в соответствующее поле.</div>
		<div class="block_f2">
			<label class="wf_text"  for="number_personal">Персональный номер:</label>
			<input type="number" name="number_personal" value="'.$number_personal.'" placeholder="index" id="number_personal" class="block_strock">
		</div>
		<div class="block_f2">
			<label class="wf_text"  for="group">Ваша группа:</label>
			<input type="text" name="group" value="'.$group.'" placeholder="group" id="group" class="block_strock">
		</div>
		<div class="block_f2">
			<label class="wf_text" for="complaint">Страна проживания:</label>
			<select name="strana" class="wid block_strock" value="Страна проживания" required>
				<option></option>
				<option>Россия</option>
				<option>Украина</option>
				<option>Другая</option>
			</select>
		</div>
		<?php echo $personal_date['pol']; ?>
		<div class="block_f2">
			<label class="wf_text" for="complaint">Жалобы:</label>
			<textarea name="complaint" class="block_strock" rows="3" placeholder="Опишите Ваши жалобы" value=""><?php echo $complaint; ?></textarea>
		</div>
	</div> 
	<div class="fm_3">
		<div class="block_f2">
			<label class="wf_text" for="comentari">Коментарии:</label>
			<textarea name="comentari" class="block_strock" rows="3" placeholder="Вы можете добавить коментарии"><?php echo $comentari; ?></textarea>
		</div>
		<div class="block_f2">
			<label class="wf_text" for="position"><span style="color: red;">*</span>Запись произведена:</label>
			<select name="position" class="wid block_strock" value="Выбирите положение при записи" required>
				<option></option>
				<option>Сидя</option>
				<option>Лежа</option>
				<option>Стоя</option>
			</select>
		</div>
		<div class="block_f2">
			<label class="wf_text" for="type_of_treatment"><span style="color: red;">*</span>Вид обработки:</label>
			<select name="type_of_treatment" class="wid block_strock" value="Выбирите тип обработки" keydown="" required>
			<?php echo Obrabotca(); ?>
			</select>
		</div>
		<div class="block_f2" style="color: red; font-size: 14px;">Все данные перед отправкой должны быть заархивированы в формате rar или zip!</div>
		<div class="block_f2">
			<label class="wf_text"><span style="color: red;">*</span>Выбор файла:</label>
			<input class="block_strock" type="file" name="filename" multiple="multiple" value="'.$filename.'" required><br>
		</div>
		<div class="block_f2">
			<a href="https://iridoc.com/files/Terms_of_use.pdf" target="_blank" style="margin: 5px 0 0 0; font-size: 15px;"><b>Ознакомиться с предупреждением о персональных данных</b></a><br>
			<label class="td"><span style="color: red;" for="check">*</span>Я согласен на обработку моих данных:</label>
			<input name="check" type="checkbox" style="float: left; margin: 4px 8px 0 0;" required>
		</div>
		<div class="block_f2">
			<label class="td"><span style="color: blue;" for="check2">*</span>Не своя кардиограмма:</label>
			<input name="check2" type="checkbox" style="float: left; margin: 4px 8px 0 0;">
		</div>
		<div class="block_f2">
			<input name="basis" class="wf_blanck2 jk right_" type="submit" value="Далее">
		</div>
	</div>
</form>
<form action="index.php?name=card" method="post" enctype="multipart/form-data">
	<input name="ress" class="wf_blanck2 jk right_" type="submit" value="Очистка формы">
</form>
	</div>
	<?php echo $ustav; ?>
