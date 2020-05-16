<div class="table_client">
	<div class="south"><?php echo Edit('icon4'); ?></div>
</div>
<h1 style="text-align: center;">Поле для редактирования данных партнера</h1>
<div class="table_client">
	<div class="form_table2">
		<form action="" method="post" enctype="multipart/form-data" name="myform">	
			<div style="float: left; width: 550px;">
				<div class="block_f">
					<label class="wf_text" for="lastname">Фамилия: </label>
					<input type="text" name="lastname" value="" placeholder="<?php echo $ress[1]; ?>" id="lastname" class="pole_vvoda">
				</div>
				<div class="block_f">
					<label class="wf_text" for="firstname">Имя: </label>
					<input type="text" name="firstname" value="" placeholder="<?php echo $ress[2]; ?>" id="firstname"  class="pole_vvoda">
				</div>
				<div class="block_f">
					<label class="wf_text" for="middlename">Отчество: </label>
					<input type="text" class="pole_vvoda" name="middlename" value="" placeholder="<?php echo $ress[3]; ?>" id="middlename">
				</div>
				<div class="block_f">
					<label class="wf_text"  for="email">Email: </label>
					<input type="email" name="email" value="" placeholder="<?php echo $ress[4]; ?>" id="email" class="pole_vvoda">
				</div>
				<div class="block_f">
					<label class="wf_text"  for="group">Группа: </label>
					<input type="text" name="group" value="" placeholder="<?php echo $ress[8]; ?>" id="group" class="pole_vvoda">
				</div>
					<div class="block_f">
						<label class="wf_text"  for="cardcode">Ссылка на карту: </label>
						<input type="text" name="cardcode" value="" placeholder="<?php echo $ress[6]; ?>" id="cardcode" class="pole_vvoda">
					</div>
			</div>
			<div style="float: left; width: 550px;">
				<div style="float: left;">
					<div class="block_f">
						<label class="wf_text"  for="limite">Лимит: </label>
						<input type="text" name="limite" value="" placeholder="<?php echo $ress[7]; ?>" id="limite" class="pole_vvoda">
					</div>
					<div class="block_f">
						<label class="wf_text"  for="tefone">Номер моб.: </label>
						<input type="text" name="tefone" value="" placeholder="<?php echo $ress[9]; ?>" id="tefone" class="pole_vvoda">
					</div>
					<div class="block_f">
						<label class="wf_text"  for="tefone">Статус оплаты: </label>
						<div class="pole_vvoda" ><?php echo $ress[10]; ?></div>
					</div>
					<div class="block_f">
						<label class="wf_text"  for="tefone">Сумма: </label>
						<input type="text" name="summa" value="" placeholder="<?php echo $ress[11]; ?>" id="tefone" class="pole_vvoda">
					</div>
					<div class="block_f">
						<label class="wf_text"  for="tefone">Валюта: </label>
						<input type="text" name="valut" value="" placeholder="<?php echo $ress[12]; ?>" id="tefone" class="pole_vvoda">
					</div>
					<div class="block_f">
					<label class="wf_text"  for="messenger">Месенжер для связи: </label>
					<select name="messenger" class="pole_vvoda" value="Выбирите тип обработки" keydown=""><?php echo Messenger(); ?></select>
					</div>
					<div class="block_f">
						<input class="wf_blanck2 jk right_" type="reset" value="Отмена">
						<input name="ren" class="wf_blanck2 jk right_" type="submit" value="Изменить">
					</div>
				</div>
			</div>
		</form>
		<div style="float: left; width: 560px;">
			<form style="float: left; margin: 5px 0px 5px;"  action="" method="post" enctype="multipart/form-data" name="myform">
				<input name="back" class="wf_blanck2 jk right_" type="submit" value="Назад">
			</form>
			<form style="float: left; margin: 5px 0px 5px;"  action="" method="post" enctype="multipart/form-data" name="myform">
				<input name="globals" class="wf_blanck2 jk right_" type="submit" value="Использовать карту по умочанию">
			</form>
			<form style="float: left; margin: 5px 0px 5px;"  action="" method="post" enctype="multipart/form-data" name="myform">
				<input name="opl" class="wf_blanck2 jk right_" type="submit" value="Оплачено">
			</form>
			<form style="float: left; margin: 5px 0px 5px;"  action="" method="post" enctype="multipart/form-data" name="myform">
				<input name="noopl" class="wf_blanck2 jk right_" type="submit" value="Не оплачено">
			</form>
		</div>
	</div>
</div>