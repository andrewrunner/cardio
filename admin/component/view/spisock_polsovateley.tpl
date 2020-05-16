<div class="south"><?php echo Polsovateli('icon4'); ?></div>
<h1 style="text-align: center;">Список пользователей</h1>
<!-- Вывод сортировка по дате -->
<h2><a class="dot" href="index.php?name=polsovateli&_kalendar_=<?php echo $_SESSION['_kalendar_']; ?>"><?php echo $_kalendar_; ?></a>Сортировка по дате</h2>
<?php if($_SESSION['_kalendar_'] == 'on'){ ?>
	<div class="fm_2">
		<div class="form_table2">
			<p class="db">Таблица DB: cardio_number</p>
			<form name="vd" action="" method="post" enctype="multipart/form-data">
				<div>Выберите дату начала и дату окончания, не включая последней даты</div>
				<input class="pole_vvoda" name="datastart" type="date">
				<input class="pole_vvoda" name="datastop" type="date">
				<input name="datasort" class="wf_blanck2 jk right_" type="submit" value="Вывести результат">
			</form>
		</div>
		<?php if ($_POST['datasort']) { ?>
		<div class="form_table2">
			<?php echo PoiskPoData($_POST); ?>
		</div>
		<?php } ?>
	</div>
<?php } ?>
<!-- Выод таблицы с поиском -->
<h2><a class="dot" href="index.php?name=polsovateli&_tablet_client_=<?php echo $_SESSION['_tablet_client_']; ?>"><?php echo $_tablet_client_; ?></a>Таблица пользователей</h2>
<?php if($_SESSION['_tablet_client_'] == 'on') { ?>
	<div class="form_table2">
		<div class="block_f2" style="overflow: hidden;">
			<fieldset class="ram5">
				<legend class="legenda">На личных счетах пользователей:</legend>
				<div class="sumu" style="color: green;"><b>Сумма на счетах:</b> <?php echo $u['plus']; ?> грн</div>
				<div class="sumu" style="color: red;"><b>Задолженность по счетам:</b> <?php echo $u['minus']; ?> грн</div>
				<div class="sumu"><b>Разница по счетам:</b> <?php echo $u['raznica']; ?> грн</div>
			</fieldset>
			<fieldset class="ram5">
				<legend class="legenda">Лимиты:</legend>
				<div class="sumu" style="color: green;"><b>Лимит по договору:</b> <?php echo $limit['limit']; ?> грн</div>
				<div class="sumu" style="color: red;"><b>Расход по лимиту:</b> <?php echo $limit['rshod']; ?> грн</div>
			</fieldset>
			<fieldset class="ram5">
				<legend class="legenda">Заработано за день:</legend>
				<div class="sumu" style="color: #4ea0dc;"><b>За текущий день:</b> <?php echo $data_summa; ?> грн</div>
			</fieldset>
		</div>
		<div class="block_f2" style="overflow: hidden;">	
			<form action="index.php?name=polsovateli" method="post" enctype="multipart/form-data">
				<input class="pole_vvoda" name="sortpol" type="text">
				<input class="wf_blanck2 jk right_" style="margin: 5px 0 0 10px; float: left;" name="diagrampol" type="submit" value="Найти" />
			</form>
		</div>
		<div class="form_table">
			<div class="table_contents">
				<div class="namber"> </div>
				<div class="table_width">
					<a class="<?php echo $style[0]; ?>" href="index.php?name=polsovateli&reles=fio_o">ФИО</a>
				</div>
				<div class="table_width2">
					<a class="<?php echo $style[1]; ?>" href="index.php?name=polsovateli&reles=data_r">E-mail</a>
				</div>
				<div class="table_width2a">
					<a class="<?php echo $style[2]; ?>" href="index.php?name=polsovateli&reles=ok">№ Пол.</a>
				</div>
				<div class="table_width2a">
					<a class="<?php echo $style[3]; ?>" href="index.php?name=polsovateli&reles=time_load">Группа</a>
				</div>
				<div class="table_width2a">
					<a class="<?php echo $style[4]; ?>" href="index.php?name=polsovateli&reles=personal_number">Лимит</a>
				</div>
				<div class="table_width">
					<a class="<?php echo $style[5]; ?>" href="index.php?name=polsovateli&reles=group_number">На кого карта</a>
				</div>
				<div class="table_width2a">
					<a class="<?php echo $style[7]; ?>" href="index.php?name=polsovateli&reles=card_ras">Оплачено</a>
				</div>
				<div class="table_width2a">
					<a class="<?php echo $style[8]; ?>" href="index.php?name=polsovateli&reles=oplashen">Сумма</a>
				</div>
				<div class="table_width2a">
					<a class="<?php echo $style[9]; ?>" href="index.php?name=polsovateli&reles=sum_opl">Валюта</a>
				</div>
			</div>
		</div>
		<div class="table_contents">			
			<div class="namber">№</div>
			<?php echo SteckPolsovateli($_POST, $style); ?>
			</div>
	</div>
<?php } ?>
<!-- Вывод регистрации нового пользователя -->
<h2><a class="dot" href="index.php?name=polsovateli&_new_pol_=<?php echo $_SESSION['_new_pol_']; ?>"><?php echo $_new_pol_; ?></a>Регистрация новых пользователей</h2>
<?php if($_SESSION['_new_pol_'] == 'on'){ ?>
	<p class="db">Таблица DB: cardio_number</p>
	<div class="form_table2">
		<form name="vd" action="" method="post" enctype="multipart/form-data">
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
					<label class="wf_text">E-mail: </label>
					<input class="pole_vvoda" name="email_" type="text"><br>
				</div>
				<div class="block_f">
					<label class="wf_text">Номер пользователя: </label>
					<input class="pole_vvoda" name="num" type="text"><br>
				</div>
				<div class="block_f">
					<label class="wf_text">Номер группы: </label>
					<input class="pole_vvoda" name="numgrup" type="text"><br>
				</div>
				<div class="block_f">
					<label class="wf_text">Лимит: </label>
					<input class="pole_vvoda" name="limite" type="text"><br>
				</div>
				<div class="block_f">
					<label class="wf_text">Сумма: </label>
					<input class="pole_vvoda" name="summa" type="text"><br>
				</div>
				<div style="float: left; padding: 5px 0;">
					<label class="wf_text" for="valut">Валюта: </label>
					<select name="valut" class="pole_vvoda" keydown=""><?php echo Valuta($val); ?></select>
				</div>
			</div>
			<div class="pol_str">
				<div class="block_f">
					<label class="wf_text">Страна проживания: </label>
					<input class="pole_vvoda" name="strana" type="text">
				</div>
				<div class="block_f">
					<label class="wf_text">Пол: </label>
					<input class="pole_vvoda" name="pol" type="text">
				</div>
				<div class="block_f">
					<label class="wf_text">Дата рождения: </label>
					<input class="pole_vvoda" name="dataname" type="date">
				</div>
				<div class="block_f">
					<label class="wf_text">Номер телифона: </label>
					<input class="pole_vvoda" name="phone" type="text">
				</div>
				<div class="block_f">
					<label class="wf_text">Логин: </label>
					<input class="pole_vvoda" name="login" type="text">
				</div>
				<div class="block_f">
					<label class="wf_text">Пароль: </label>
					<input class="pole_vvoda" name="passwordname" type="text">
				</div>
				<div class="block_f">
					<label class="wf_text">На кого карта: </label>
					<input class="pole_vvoda" name="card" type="text">
				</div>
			</div>
			<div  class="button_">
				<input class="wf_blanck2 jk right_" type="reset" value="Отмена">
				<input name="pars" class="wf_blanck2 jk right_" type="submit" value="Добавить">
			</div>
		</form>
	</div>
<?php } ?>

<h2><a class="dot" href="index.php?name=polsovateli&del_chet=<?php echo $_SESSION['del_chet']; ?>"><?php echo $del_chet; ?></a>Глобальное удаление счетов</h2>
<?php if($_SESSION['del_chet'] == 'on'){ ?>
	<div class="form_table2">
		<p class="red">Будте осторожны! Данная кнопка удаляет все записи счетов!</p>
		<p class="db">Таблица DB: cart_chet</p>
		<a href="index.php?name=polsovateli&print_rejim=edit&delite=del_globel" class="wf_blanck2 jk">Удалить все записи из базы пользователя</a>
	</div>
<?php } ?>
