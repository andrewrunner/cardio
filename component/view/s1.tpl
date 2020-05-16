<div class="content pad">
	<form action="index.php" method="post" enctype="multipart/form-data">
	<div class="block_left">
		<div class="block_string">
			<label class="text_menu" for="lastname"><span style="color: red;">*</span>Фамилия:</label>
			<input class="block_strock" type="text" name="lastname" value="" placeholder="Фамилия" id="lastname" required>
		</div>
		<div class="block_string">
			<label class="text_menu" for="firstname"><span style="color: red;">*</span>Имя:</label>
			<input class="block_strock" type="text" name="firstname" value="" placeholder="Имя" id="firstname" required>
		</div>
		<div class="block_string">
			<label class="text_menu" for="middlename"><span style="color: red;">*</span>Отчество:</label>
			<input class="block_strock" type="text" class="" name="middlename" value="" placeholder="Отчество" id="middlename" required>
		</div>
		<div class="block_string">
			<label class="text_menu" for="dat"><span style="color: red;">*</span>Дата рождения:</label>
			<input class="block_strock" name="dat" dateformat="d.M.y" list="dateList" type="date" placeholder="дд.мм.гггг" value="" required>
		</div>
	</div>
	<div class="block_right">
		<div class="block_string">
			<label class="text_menu" for="dat"><span style="color: red;">*</span>Email:</label>
			<input class="block_strock" name="email" type="email" placeholder="Email" value="" required>
		</div>
		<div class="block_string">
			<label class="text_menu"><span style="color: red;">*</span>Ваш пол:</label>
			<input type="radio" name="state" id="state" value="Мужской" required><label class="" for="state">Мужской</label>
			<input type="radio" name="state" id="state2" value="Женский" required><label class="" for="state2">Женский</label>
		</div>
		<div class="block_string">
			<label class="text_menu" for="comentari">Коментарии:</label>
			<textarea class="block_coment" name="comentari" rows="3" placeholder="Вы можете добавить коментарии"></textarea>
		</div>
		
	<div class="">
		<input class="bottom_" name="forma" type="submit" value="Далее">
	</div>
	</div>
	</form>
	<form class="resett" action="index.php?name=crov" method="post" enctype="multipart/form-data">
		<input name="ress" class="bottom_" type="submit" value="Очистка формы">
	</form>
</div>