<div class="south"><?php echo Pass('icon4'); ?></div>
	<h1 style="text-align: center;">Смена логинов и паролей</h1>
	<div class="form_table2">
		<div>
			<fieldset class="ram2">
			<p class="db">Таблица DB: cardio_administrator</p>
			<legend>Оператор-обработчик:</legend>
				<form action="" method="post" enctype="multipart/form-data" name="myform">
					<div class="block_f">
						<label class="wf_login"  for="login_admin">Логин: </label>
						<input type="text" name="login_admin" value="" placeholder="" id="login_admin" class=" pole_vvoda" autocomplete="off">
					</div>
					<div class="block_f">
						<label class="wf_login"  for="pass_admin">Действующий пароль: </label>
						<input type="password" name="pass_admin" value="" placeholder="" id="pass_admin" class=" pole_vvoda" autocomplete="off">
					</div>
					<div class="block_f">
						<label class="wf_login"  for="new_login">Новый логин: </label>
						<input type="text" name="new_login" value="" placeholder="" id="new_login" class="pole_vvoda" autocomplete="off">
					</div>
					<div class="block_f">
						<label class="wf_login"  for="new_pass_admin">Новый пароль: </label>
						<input type="password" name="new_pass_admin" value="" placeholder="" id="new_pass_admin" class="pole_vvoda" autocomplete="off">
					</div>
					<input class="wf_blanck2 jk right_" type="reset" value="Отмена">
					<input name="operator_logi" class="wf_blanck2 jk right_" type="submit" value="Сменить">
				</form>
				<form action="" method="post" enctype="multipart/form-data" name="myform">
					<div class="block_f">
						<label class="wf_login"  for="new_pass_system">E-mail для уведомления: </label>
						<input type="email" name="new_email_operator" value="" placeholder="<?php echo NewEmailOperator(); ?>" id="new_email_operator" class="pole_vvoda">
					</div>
					<input class="wf_blanck2 jk right_" type="reset" value="Отмена">
					<input name="email_operator" class="wf_blanck2 jk right_" type="submit" value="Сменить">
				</form>
			</fieldset>
			<fieldset class="ram2">
				<p class="db">Таблица DB: cardio_system</p>
				<legend>Системный администратор:</legend>
				<form action="" method="post" enctype="multipart/form-data" name="system_form">
				<div class="block_f">
					<label class="wf_login"  for="login_system">Логин: </label>
					<input type="text" name="login_system" value="" placeholder="" id="login_system" class="pole_vvoda" autocomplete="off">
				</div>
				<div class="block_f">
					<label class="wf_login"  for="pass_system">Действующий пароль: </label>
					<input type="password" name="pass_system" value="" placeholder="" id="pass_system" class="pole_vvoda" autocomplete="off">
				</div>
				<div class="block_f">
					<label class="wf_login"  for="new_sys_login">Новый логин: </label>
					<input type="text" name="new_sys_login" value="" placeholder="" id="new_sys_login" class="pole_vvoda" autocomplete="off">
				</div>
				<div class="block_f">
					<label class="wf_login"  for="new_pass_system">Новый пароль: </label>
					<input type="password" name="new_pass_system" value="" placeholder="" id="new_pass_system" class="pole_vvoda" autocomplete="off">
				</div>
				<input class="wf_blanck2 jk right_" type="reset" value="Отмена">
				<input name="system_logi" class="wf_blanck2 jk right_" type="submit" value="Сменить">
				</form>
				<form action="" method="post" enctype="multipart/form-data" name="myform">
					<div class="block_f">
						<label class="wf_login"  for="new_pass_system">E-mail для востановления: </label>
						<input type="email" name="new_email_system_" value="" placeholder="<?php echo $array_email_system[0]; ?>" id="new_email_system_" class="pole_vvoda" autocomplete="off">
					</div>
					<input class="wf_blanck2 jk right_" type="reset" value="Отмена">
					<input name="new_email_system" class="wf_blanck2 jk right_" type="submit" value="Сменить">
				</form>
				<form action="" method="post" enctype="multipart/form-data" name="myform">
					<div class="block_f">
						<label class="wf_login"  for="new_pass_system">E-mail для уведомления: </label>
						<input type="email" name="new_email_system2_" value="" placeholder="<?php echo $array_email_system[1]; ?>" id="new_email_system2_" class="pole_vvoda" autocomplete="off">
					</div>
					<input class="wf_blanck2 jk right_" type="reset" value="Отмена">
					<input name="new_email_system2" class="wf_blanck2 jk right_" type="submit" value="Сменить">
				</form>
			</fieldset>	
		</div>
		<div style="width: 100%; overflow: hidden;">
		<?php echo $text_gh1;
		   echo $text_gh2;
		   echo $text_gh3; ?>
		</div>
	</div>