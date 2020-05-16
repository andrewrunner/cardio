<h1>Вход</h1>
<div class="fm_3">
	<form action="index.php" method="post" enctype="multipart/form-data">
		<div class="block_f2">Введите логин и пароль для авторизации!</div>
		<div class="block_f2">
			<label class="wf_text" for="lastname"><span style="color: red;">*</span>Логин:</label>
			<input type="text" name="login" value="" placeholder="Логин" id="lastname" class="block_strock"
				autocomplete="new-password" required>
		</div>
		<div class="block_f2">
			<label class="wf_text" for="firstname"><span style="color: red;">*</span>Пароль:</label>
			<input type="password" name="passwr" value="" placeholder="Пароль" id="firstname" class="block_strock"
				autocomplete="new-password" required>
		</div>
		<div class="block_f2">
			<a href="https://iridoc.ru/preduprezhdenie-o-personalnyx-dannyx/" target="_blank"
				style="margin: 5px 0 0 0; font-size: 15px;"><b>Ознакомиться с предупреждением о персональных
					данных</b></a><br>
			<label class="wf_text" for="firstname"><span style="color: red;">*</span>Я согласен на обработку моих
				данных:</label>
			<input type="checkbox" value="" placeholder="Пароль" id="firstname" class="block_strock" required>
		</div>
		<div class="block_f2">
			<a href="https://iridoc.ru/publichnaya-oferta/" target="_blank"
				style="margin: 5px 0 0 0; font-size: 15px;"><b>Ознакомиться с договором оферты</b></a><br>
			<label class="wf_text" for="firstname"><span style="color: red;">*</span>Я согласен с договором
				оферты:</label>
			<input type="checkbox" value="" placeholder="Пароль" id="firstname" class="block_strock" required>
		</div>
		<div class="block_f2">
			<input name="entrance_log" class="wf_blanck2 jk right_" type="submit" value="Далее">
		</div>
	</form>
</div>