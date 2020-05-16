<h2>
	<a class="dot" href="index.php?name=edit_polsovateli&id=<?php echo $_GET['id'] ?>&personal_dan=<?php echo $_SESSION['personal_dan']; ?>"><?php echo $personal_dan; ?></a>Персональные данные</h2>
<?php if($_SESSION['personal_dan'] == 'on') { ?>
<div class="table_client">
	<p class="db">Таблица DB: cardio_number</p>
	<p class="redd">Для отправки изменений пользователю на почту, нужно ввести все нужные поля, после нажать кнопку «Изменить», а потом «Отправить изменения»</p>
	<div class="form_table2">
		<form action="" method="post" enctype="multipart/form-data" name="myform">
			<div style="float: left; width: 550px;">
				<div class="block_f">
					<label class="wf_text" for="lastname">Фамилия: </label>
					<input type="text" name="lastname" value="" placeholder="<?php echo $polsovatel[5]; ?>" id="lastname"
						class="pole_vvoda">
				</div>
				<div class="block_f">
					<label class="wf_text" for="firstname">Имя: </label>
					<input type="text" name="firstname" value="" placeholder="<?php echo $polsovatel[6]; ?>" id="firstname"
						class="pole_vvoda">
				</div>
				<div class="block_f">
					<label class="wf_text" for="middlename">Отчество: </label>
					<input type="text" class="pole_vvoda" name="middlename" value=""
						placeholder="<?php echo $polsovatel[7]; ?>" id="middlename">
				</div>
				<div class="block_f">
					<label class="wf_text" for="email">Email: </label>
					<input type="email" name="email" value="" placeholder="<?php echo $polsovatel[1]; ?>" id="email"
						class="pole_vvoda">
				</div>
				<div class="block_f">
					<label class="wf_text" for="numpol">№ пользователя: </label>
					<input type="text" name="numpol" value="" placeholder="<?php echo $polsovatel[2]; ?>" id="numpol"
						class="pole_vvoda">
				</div>
				<div class="block_f">
					<label class="wf_text" for="group">Группа: </label>
					<input type="text" name="group" value="" placeholder="<?php echo $polsovatel[3]; ?>" id="group"
						class="pole_vvoda">
				</div>
				<div class="block_f">
					<label class="wf_text" for="limite">Обработок ЭКГ: </label>
					<input type="text" name="limite" value="" placeholder="<?php echo $polsovatel[4]; ?>" id="limite"
						class="pole_vvoda">
				</div>
				<div class="block_f">
					<label class="wf_text" for="summa">Сумма: </label>
					<input type="text" name="summa" value="" placeholder="<?php echo $polsovatel[10]; ?>" id="summa"
						class="pole_vvoda">
				</div>
				<div class="block_f">
					<label class="wf_text" for="summa_plus">Добавить к сумме: </label>
					<input type="text" name="summa_plus" value="" id="summa_plus" class="pole_vvoda">
				</div>
				<div class="block_f">
					<label class="wf_text" for="valuta">Валюта: </label>
					<input type="text" name="valuta" value="" placeholder="<?php echo $polsovatel[11]; ?>" id="valuta"
						class="pole_vvoda">
				</div>
			</div>
			<div style="float: right; width: 550px;">
				<div style="float: right;">
					<div class="block_f">
						<label class="wf_text">Страна проживания: </label>
						<input class="pole_vvoda" name="strana" type="text" value=""
							placeholder="<?php echo $polsovatel[13]; ?>">
					</div>
					<div class="block_f">
						<label class="wf_text">Пол: </label>
						<input class="pole_vvoda" name="pol" type="text" value=""
							placeholder="<?php echo $polsovatel[14]; ?>">
					</div>
					<div class="block_f">
						<label class="wf_text">Дата рождения: </label>
						<input class="pole_vvoda" type="text" placeholder="<?php echo $polsovatel[15]; ?>">
						<label class="wf_text"></label>
						<input class="pole_vvoda" name="dataname" type="date">
					</div>
					<div class="block_f">
						<label class="wf_text">Номер телифона: </label>
						<input class="pole_vvoda" name="phone" type="text" value=""
							placeholder="<?php echo $polsovatel[16]; ?>">
					</div>
					<div class="block_f">
						<label class="wf_text">Логин: </label>
						<input class="pole_vvoda" name="login" type="text" value=""
							placeholder="<?php echo $polsovatel[17]; ?>">
					</div>
					<div class="block_f">
						<label class="wf_text">Пароль: </label>
						<input class="pole_vvoda" name="passwordname" type="text" value="">
					</div>
					<div class="block_f">
						<label class="wf_text">На кого карта: </label>
						<input class="pole_vvoda" name="card" type="text" value="<?php echo $polsovatel[8]; ?>">
					</div>
					<div class="block_f"><b>Статус оплаты</b>:
						<?php echo $polsovatel[9]; ?>
					</div><br>
					<div class="block_f"><b>Допускается отрицательное значение</b>: <input name="otricatilno" type="checkbox" style="float: right; margin: 8px 200px 8px 8px;" <?php echo OnOffPolsovatel($_GET['id']); ?> /></div>
					<div class="block_f">
						<input class="wf_blanck2 jk right_" type="reset" value="Отмена">
						<input name="ren" class="wf_blanck2 jk right_" type="submit" value="Изменить">
						<a class="wf_blanck2 jk right_"
							href="index.php?name=edit_polsovateli&id=<?php echo $id; ?>&optses=startses">Отправить
							изменения</a>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="form_table2">
		<form action="" method="post" enctype="multipart/form-data" name="opl">
			<input name="opl" class="wf_blanck2 jk right_" type="submit" value="Оплачен">
		</form>
		<form action="" method="post" enctype="multipart/form-data" name="noopl">
			<input name="noopl" class="wf_blanck2 jk right_" type="submit" value="Не оплачен">
		</form>
	</div>
</div>
<?php } ?>
<h2><a class="dot" href="index.php?name=edit_polsovateli&id=<?php echo $_GET['id'] ?>&personal_chet=<?php echo $_SESSION['personal_chet']; ?>"><?php echo $personal_chet; ?></a>Управление персональным счетом</h2>
<?php if($_SESSION['personal_chet'] == 'on'){ ?>
<div class="content">
	<p class="db">Таблица DB: cart_chet</p>
	<?php if($_GET['print_rejim'] == 'edit'){ ?>
		<a href="index.php?name=edit_polsovateli&print_rejim=print&id=<?php echo $_GET['id']; ?>" class="wf_blanck2 jk">Печать</a>
		<a href="index.php?name=edit_polsovateli&print_rejim=edit&id=<?php echo $_GET['id']; ?>&delite=del" class="wf_blanck2 jk">Удалить все записи из базы пользователя</a>
	<?php }
		if($_GET['print_rejim'] == 'print' || $_SESSION['print_rejim'] == 'print'){ ?>
		<a href="index.php?name=edit_polsovateli&print_rejim=edit&id=<?php echo $_GET['id']; ?>" class="wf_blanck2 jk">Редактировать таблицу</a>
		<a href="#" onclick="javascript:ChetPrintTablet('print-content');" title="Распечатать проект"><?php echo Printer('icon'); ?></a>
		<p class="redd">Для внесения суммы по договору, нужно перейти в "Редактировать таблицу" и в последней строке таблицы добавить сумму,<br> она будет дублироватся из ячейки в ячейку, а у пользователя в кабинете отбиватся с верху таблицы!</p>
	<?php } ?>
</div>
<?php if($_GET['print_rejim'] == 'edit'){ ?>
<div id="print-content">
	<div class="tblet_chet">
		<div class="chet_pp chet1 chet">№<br>пп</div>
		<div class="chet_data chet">Услуга из перечня клуба</div>
		<div class="chet_operation chet">Дата осущ. операции</div>
		<div class="chet_data2_ chet">Лимит по договору грн</div>
		<div class="chet_dolg chet">Использование лимита грн</div>
		<div class="chet_bes chet">Сумма на текущем счету, грн</div>
		<div class="chet_data1_ chet">Стоимость клубная грн</div>
		<div class="chet_oplata chet">Расчет за услугу</div>
		<div class="chet_limit1_ chet">Дата погашения</div>
		<div class="chet_limit chet">Купленых обработок ЭКГ</div>
		<div class="chet_ostatoc chet">Использовано обработок ЭКГ</div>
		<div class="chet_delete chet">изменение и удаление</div>
	</div><!--  -->
	<?php echo TabletChetClient($_GET); ?>
	<!-- конец печати -->
</div>
<?php }
	if($_GET['print_rejim'] == 'print' || $_SESSION['print_rejim'] == 'print'){ ?>
<div id="print-content">
	<div class="tblet_chet_print">
		<div class="chet_pp chet1 chet">№<br>пп</div>
		<div class="chet_data chet">Услуга из перечня клуба</div>
		<div class="chet_operation chet">Дата осущ. операции</div>
		<div class="chet_data2_ chet">Лимит по договору грн</div>
		<div class="chet_dolg chet">Использование лимита грн</div>
		<div class="chet_bes chet">Сумма на текущем счету, грн</div>
		<div class="chet_data1_ chet">Стоимость клубная грн</div>
		<div class="chet_oplata chet">Расчет за услугу</div>
		<div class="chet_limit1_ chet">Дата погашения</div>
		<div class="chet_limit chet">Купленых обработок ЭКГ</div>
		<div class="chet_ostatoc_print chet">Использовано обработок ЭКГ</div>
	</div>
	<?php echo TabletChetClientPint($_GET); ?>
	<!-- конец печати -->
</div>
<?php }
} ?>
<h2><a class="dot" href="index.php?name=edit_polsovateli&id=<?php echo $_GET['id'] ?>&calendar_personal=<?php echo $_SESSION['calendar_personal']; ?>"><?php echo $calendar_personal; ?></a>Календарь</h2>
<?php if($_SESSION['calendar_personal'] == 'on'){ ?>
<p class="db">Таблица DB: car_calendar</p>

<p class="redd"><span class="red_h">1. Персонально на одну дату:</span>	1. Написать примечание;	2. Поставить дату назначения;	3. Нажать кнопку "Добавить";<br>
<span class="red_h">2. Персонально с повторениями дней недели:</span>	1. Написать примечание;	2. Отметить месяца для повторения;	3. Отметить повторение на день недели;	4. Нажать кнопку "Добавить";<br>
<span class="red_h">3. Персонально с повторением числа в месяце:</span>	1. Написать примечание;	2. Отметить месяца для повторения;	3. Отметить повторение на день месяца;	4. Нажать кнопку "Добавить";<br>
<span class="red_h">4. Шалон для всех:</span>	1. Написать примечание;	2. Отметить "Добавить к шаблону";	3. Отметить повторение на день недели или на день месяца;	4. Нажать кнопку "Добавить";</p>

<form name="vd" action="" method="post" enctype="multipart/form-data">
	<div class="block_f">
		<label class="wf_text">Примечание: </label>
		<input class="pole_vvoda" name="textprim" type="text">
	</div>
	<div class="block_f">
		<label class="wf_text">На дату: </label>
		<input class="pole_vvoda" name="dataprim" type="date">
	</div>
	<div class="block_f">
		<label class="wf_text">Добавить к шаблону: </label>
		<input name="formulaic" type="checkbox">
	</div>
	<!-- выбор месяца -->
	<div class="block_f">
		<label class="wf_text">Январь: </label>
		<input name="jan" type="checkbox" value="01">
	</div>
	<div class="block_f">
		<label class="wf_text">Февраль: </label>
		<input name="fiv" type="checkbox" value="02">
	</div>
	<div class="block_f">
		<label class="wf_text">Март: </label>
		<input name="mar" type="checkbox" value="03">
	</div>
	<div class="block_f">
		<label class="wf_text">Апрель: </label>
		<input name="apr" type="checkbox" value="04">
	</div>
	<div class="block_f">
		<label class="wf_text">Май: </label>
		<input name="may" type="checkbox" value="05">
	</div>
	<div class="block_f">
		<label class="wf_text">Июнь: </label>
		<input name="iun" type="checkbox" value="06">
	</div>
	<div class="block_f">
		<label class="wf_text">Июль: </label>
		<input name="iul" type="checkbox" value="07">
	</div>
	<div class="block_f">
		<label class="wf_text">Август: </label>
		<input name="avg" type="checkbox" value="08">
	</div>
	<div class="block_f">
		<label class="wf_text">Сентябрь: </label>
		<input name="sen" type="checkbox" value="09">
	</div>
	<div class="block_f">
		<label class="wf_text">Октябрь: </label>
		<input name="oct" type="checkbox" value="10">
	</div>
	<div class="block_f">
		<label class="wf_text">Ноябрь: </label>
		<input name="nov" type="checkbox" value="11">
	</div>
	<div class="block_f">
		<label class="wf_text">Декабрь: </label>
		<input name="dec" type="checkbox" value="12">
	</div>
	<!-- регулярные -->
	<div class="block_f">
		<label class="wf_text">Повторения на день недели: </label>
		<select class="pole_vvoda" name="nedelya">
			<?php echo $regular->RegularNedela(); ?>
		</select>
	</div>
	<div class="block_f">
		<label class="wf_text">повторения на день месяца: </label>
		<select class="pole_vvoda" name="data_month">
			<?php echo $regular->RegularData(); ?>
		</select>
	</div>

	<div class="button_">
		<input class="wf_blanck2 jk right_" type="reset" value="Отмена">
		<input name="xxx" class="wf_blanck2 jk right_" type="submit" value="Добавить">
	</div>
</form>
<div class="table_client">
	<fieldset class="ram6 bac_1">
		<legend class="legenda"><b class="chust">Персонально</b></legend>
		<?php echo $calendar->Calendar($_GET['id'])[0]; ?>
	</fieldset>
	<fieldset class="ram6 bac_2">
		<legend class="legenda"><b class="chust">Шаблон</b></legend>
		<?php echo $calendar->Calendar($_GET['id'])[1]; ?>
	</fieldset>
</div>
<?php } ?>
<!-- не правильно выдает записи -->
<h2><a class="dot" href="index.php?name=edit_polsovateli&id=<?php echo $_GET['id'] ?>&pdf_del=<?php echo $_SESSION['pdf_del']; ?>"><?php echo $pdf_del; ?></a>Удаление старых записей из истории о файлах PDF</h2>
<?php if($_SESSION['pdf_del'] == 'on'){ ?>
	<p class="db">Таблица DB: car_delit_histori</p>
	<p class="redd">Если при выводе на печать не отображается фон шапки, нужно в «Дополнительные настройки» печати поставить галочку фон.<br>
	Если в имени файла стоит имя с "off", то нет средств на счету, после пополнения, пользователь войдет и все автоматически снимется.<br>
	Если средства даны на руки и есть данные для ввода, то нужно провести операцию, с обязательным параметром сумма = 0, тоесть не пустое значение.</p>
	<div>
		<h3>Анкета</h3>
		<?php echo $steck_print[0];
			echo $test_anket['anketa'];
			if($_GET['bloc'] == 'anketa'){
				include $_GET['histori'];
			} 
		?>
		<h3>Кров</h3>
		<?php echo $steck_print[1];
			echo $test_anket['krov'];
			if($_GET['bloc'] == 'krov'){
				include $_GET['histori'];
			} 
		?>
		<h3>ЭКГ</h3>
		<?php echo $steck_print[2];
			echo $test_anket['ecg'];
			if($_GET['bloc'] == 'ecg'){
				include $_GET['histori'];
			} 
		?>
        <h3>АД</h3>
		<?php echo $steck_print[3];
			echo $test_anket['ad'];
			if($_GET['bloc'] == 'ad'){
				include $_GET['histori'];
			}
		?>
	</div>
<?php } ?>

<h2><a class="dot" href="index.php?name=edit_polsovateli&id=<?php echo $_GET['id'] ?>&diagram=<?php echo $_SESSION['diagram']; ?>"><?php echo $diagram; ?></a>Диаграмма</h2>
<?php if($_SESSION['diagram'] == 'on') { 
    // Подключение диаграммы обработки 
    include DIAGRAMS;
} ?>

<div class="block_f">
	<hr>
    <a class="wf_blanck2 jk" href="index.php?name=polsovateli&newdel=del#l<?php echo $_GET['id'] ?>">Назад</a>
</div>