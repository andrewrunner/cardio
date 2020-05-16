<div class="table_client">
	<div class="south"><?php echo Partneru('icon4'); ?></div>
	<h1 style="text-align: center;">Список партнеров</h1>
	<div class="form_table">
		<div class="table_client">
			<p class="db">Таблица DB: cardio_south</p>
			<div class="fm_2">
				<div class="form_table">
					<div class="table_contents">
						<div class="namber">№</div>
						<div class="table_width">ФИО</div>
						<div class="table_width2_1">E-Mail</div>
						<div class="t_width">Messenger</div>
						<div class="t_width">Номер моб.:</div>
						<div class="table_width2">Ссылка на карту</div>
						<div class="table_width2a">Группа</div>
						<div class="table_width2a">Лимит</div>
						<div class="table_width2a">Оплачено</div>
						<div class="table_width2a">Сумма</div>
						<div class="table_width2a">Валюта</div>
					</div>
					<?php echo StackPartneru(); ?>
				</div> 
			</div>
		</div>
	</div>
</div>
<div class="form_table2">
	<form action="" method="post" enctype="multipart/form-data" name="myform">	
	<div class="pol_str">
	<div class="block_f">
		<label class="wf_text" for="lastname">Фамилия: </label>
		<input type="text" name="lastname" value="" placeholder="Фамилия" id="lastname" class="pole_vvoda">
	</div>
	<div class="block_f">
		<label class="wf_text" for="firstname">Имя: </label>
		<input type="text" name="firstname" value="" placeholder="Имя" id="firstname"  class="pole_vvoda">
	</div>
	<div class="block_f">
		<label class="wf_text" for="middlename">Отчество: </label>
		<input type="text" class="pole_vvoda" name="middlename" value="" placeholder="Отчество" id="middlename">
	</div>
	<div class="block_f">
		<label class="wf_text"  for="email">Email: </label>
		<input type="email" name="email" value="" placeholder="E-Mail" id="email" class="pole_vvoda">
	</div>
	<div class="block_f">
		<label class="wf_text"  for="cardcode">Ссылка на карту: </label>
		<input type="text" name="cardcode" value="" placeholder="http://" id="cardcode" class="pole_vvoda">
	</div>
	</div>
	<div class="pol_str">
	<div style="float: right;">
<fieldset class="ram2">
   <legend>Контакты:</legend>
	
	<div class="block_f">
	<label class="wf_text"  for="messenger">Мессенжер для связи:</label>
	<select name="messenger" class="ram_t" value="Выбирите тип обработки" keydown=""><?php echo Messenger(); ?>
	</select>
	</div>
	<div class="block_f">
		<label class="wf_text"  for="tefone">Номер моб.: </label>
		<input type="text" name="tefone" value="" placeholder="Номер" id="tefone" class="ram_t">
	</div>
	<div class="block_f">
		<label class="wf_text"  for="messenger">Группа: </label>
		<input type="text" name="group" value="" placeholder="Группа" id="group" class="ram_t">
	</div>
</fieldset>
	<div class="block_f">
		<label class="wf_text"  for="messenger">Лимит: </label>
		<input type="text" name="limite" value="" placeholder="" id="limite" class="pole_vvoda">
	</div>
	<div class="block_f">
		<label class="wf_text"  for="messenger">Сумма: </label>
		<input type="text" name="summa" value="" placeholder="" id="limite" class="pole_vvoda">
	</div>
	<div class="block_f">
		<label class="wf_text" for="valut">Валюта: </label>
		<select name="valut" class="pole_vvoda" keydown=""><?php echo Valuta($val); ?></select>
	</div>
	<div class="block_f">
		<input class="wf_blanck2 jk right_" type="reset" value="Отмена">
		<input name="dath" class="wf_blanck2 jk right_" type="submit" value="Добавить">
	</div>
	</div>
	</div>
    </form>
</div>