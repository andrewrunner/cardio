<h1>Регистрация</h1>
<form action="index.php" method="post" enctype="multipart/form-data">
	<div class="fm_3">
		<div class="block_f2">
			<label class="wf_text" for="lastname"><span style="color: red;">*</span>Фамилия:</label>
			<input type="text" name="lastname" value="" placeholder="Фамилия" id="lastname" class="block_strock"
				required>
		</div>
		<div class="block_f2">
			<label class="wf_text" for="firstname"><span style="color: red;">*</span>Имя:</label>
			<input type="text" name="firstname" value="" placeholder="Имя" id="firstname" class="block_strock" required>
		</div>
		<div class="block_f2">
			<label class="wf_text" for="middlename"><span style="color: red;">*</span>Отчество:</label>
			<input type="text" class="block_strock" name="middlename" value="" placeholder="Отчество" id="middlename"
				required>
		</div>
		<div class="block_f2">
			<label class="wf_text" for="email"><span style="color: red;">*</span>Email:</label>
			<input type="email" name="email" value="" placeholder="E-Mail" id="email" class="block_strock" required>
		</div>
		<div class="block_f2">
			<label class="wf_text" for="strana"><span style="color: red;">*</span>Страна постоянного прибывания:</label>
			<input type="text" name="strana" value="" placeholder="" id="strana" class="block_strock" required>
		</div>
		<fieldset class="block_f2">
			<label class="wf_text"><span style="color: red;">*</span>Ваш пол:</label>
			<input type="radio" name="state" id="state" value="Мужской" required><label class="radio-inline"
				for="state">Мужской</label>
			<input type="radio" name="state" id="state2" value="Женский" required><label class="radio-inline"
				for="state2">Женский</label>
		</fieldset>
		<div class="block_f2">
			<label class="wf_text" for="dat"><span style="color: red;">*</span>Дата рождения:</label>
			<input class="block_strock" name="dat" dateformat="d.M.y" list="dateList" type="date"
				placeholder="дд.мм.гггг" value="" required>
		</div>
	</div>
	<div class="fm_3">
		<div class="block_f2">
			<label class="wf_text" for="phone"><span style="color: red;">*</span>Номер мобильного:</label>
			<input class="block_strock" name="phone" type="text" value="" required>
		</div>
		<div class="block_f2">
			Придумайте логин и пароль для авторизации!
		</div>
		<div class="block_f2">
			<label class="wf_text" for="lastname"><span style="color: red;">*</span>Логин:</label>
			<input type="text" name="login" value="" placeholder="Логин" id="lastname" class="block_strock" required>
		</div>
		<div class="block_f2">
			<label class="wf_text" for="firstname"><span style="color: red;">*</span>Пароль:</label>
			<input type="password" name="passwr" value="" placeholder="Пароль" id="firstname" class="block_strock"
				required>
		</div>
		<div class="block_f2">
			<a href="https://iridoc.com/files/Privacy_policy.pdf" target="_blank"
				style="margin: 5px 0 0 0; font-size: 15px;"><b>Ознакомиться с Политикой конфиденциальности</b></a><br>
			
			<label class="wf_text" for="firstname"><span style="color: red;">*</span>Я согласен на обработку моих
				данных:</label>
			<input type="checkbox" value="" placeholder="Пароль" id="firstname" class="block_strock"
				required>
		</div>
		<div class="block_f2">

			<a href="https://iridoc.com/files/Charter_Associations_Language_Hearts_Russian.pdf" target="_blank"
				style="margin: 5px 0 0 0; font-size: 15px;"><b>Устав;</b></a><br>
			
			<a href="https://iridoc.com/files/Position_of_Activities_Associations_Language_Heart.pdf" target="_blank"
				style="margin: 5px 0 0 0; font-size: 15px;"><b>Положение;</b></a><br>
			
			<a href="https://iridoc.com/files/Terms_of_use.pdf" target="_blank"
				style="margin: 5px 0 0 0; font-size: 15px;"><b>Пользовательское соглашение</b></a><br>
			
			<label class="wf_text" for="firstname"><span style="color: red;">*</span>Я согласен с  Уставом, Положением, Пользовательским соглашением:</label>
			<input type="checkbox" value="" placeholder="Пароль" id="firstname" class="block_strock"
				required>
		</div>
		<div class="block_f2">
			<input name="autorisation" class="wf_blanck2 jk right_" type="submit" value="Далее">
		</div>
	</div>
</form>
<form action="index.php?name=registration" method="post" enctype="multipart/form-data">
	<input name="resset" class="wf_blanck2 jk right_" type="submit" value="Очистка формы">
</form>
<?php echo $dann; ?>