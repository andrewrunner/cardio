<?php if (!$_POST['ekgres']) { ?>
	<form action="index.php?name=forma&vuboranket=kardio" method="post" enctype="multipart/form-data">
		<div class="block_string hr">
			<h1>Расчет по ЭКГ</h1>
		</div>
		<?php echo Saboliv(); ?>
		<?php echo $boli; ?>
		<div class="block_string">
			<label class="text_menu2" for="type_of_treatment">Выбор препарата:</label>
			<select class="block_sp" name="type_of_treatment" value="" keydown="" required>
				<?php echo Preparat(); ?>
			</select>
		</div>
		</div>
		<div class="content pad">
			<img class="image1" src="images/diagrams.svg" width="400">
			<div class="block_sf">Определите графическую метку обработки ЭКГ в одном из полей обозначенных одним из цветов.
				Метка должна находиться внутри поля или в непосредственной близости от него. Укажите в какой зоне находится Ваша
				метка ЭКГ:</div>
			<fieldset class="block_sf">
				<input type="radio" name="fg" id="sost" value="green" required>
				<label class="radio-inline">Зеленый</label>
				<input type="radio" name="fg" id="sost" value="yellow" required>
				<label class="radio-inline">Желтый</label>
				<input type="radio" name="fg" id="sost" value="red" required>
				<label class="radio-inline">Красный</label>
				<input type="radio" name="fg" id="sost" value="blue" required>
				<label class="radio-inline">Голубой</label>
			</fieldset><br>
			<div class="block_sf">Из таблицы основных показателей сердечного ритма из колонки "Знач" укажите, количество
				показателей с одним знаком «*» и количество показателей с двумя знаками «**».</div>
			<div class="block_sf">
				<div class="block_string">
					<label for="lastname" class="left_">Количество показателей с одним знаком"*" :</label>
					<input class="block_sp2" type="number" size="10" name="num1" min="0" max="10" value="0">
				</div>
				<div class="block_string">
					<label for="lastname" class="left_">Количество показателей с двумя знаками"**" :</label>
					<input class="block_sp2" type="number" size="10" name="num2" min="0" max="10" value="0">
				</div>
			</div>
			<div class="block_string hr">
				<input name="ress" class="bottom_" type="submit" value="Очистка формы">
				<input class="bottom_" name="ekgres" type="submit" value="Ок">
			</div>
		</div>
	</form>
<?php } ?>
