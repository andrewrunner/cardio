<div class="south">
	<?php echo Libr('icon4'); ?>
</div>
<h1>ВАЛЮТА</h1>
<h2><a class="dot" href="index.php?name=valuta&_valut_=<?php echo $_SESSION['_valut_']; ?>">
		<?php echo $_valut_; ?></a>Валюта</h2>
<?php if($_SESSION['_valut_'] == 'on'){ ?>
<p class="db">Таблица DB: car_valute</p>
<p class="redd">Задает коэфициент конвертации фалюты (множитель)</p>
<?php echo FormaValuta(); 
} ?>

<h2><a class="dot" href="index.php?name=valuta&_summa_=<?php echo $_SESSION['_summa_']; ?>">
		<?php echo $_summa_; ?></a>Коректировка сумм за день</h2>
<?php if($_SESSION['_summa_'] == 'on'){ ?>
<form name="vd" action="index.php?name=valuta" method="post" enctype="multipart/form-data">
	<label class="wf_text" for="type_of_treatment">Выберите дату: </label>
	<input class="box_vvoda" name="datapost" type="date">
	<input name="datasut" class="wf_blanck2 jk" type="submit" value="Сортировать по дате">
</form>
<div style="color: red; width: 100%; padding: 10px 5px; font-weight: 800; overflow: hidden;">Будте осторожны во время
	коректировки записи!<br>Для изменения ошибочной записи введите значение в поле за нужное число, в валюте «cor», и
	нажмите «ок» для применения изменений.<br>Для удаления записи, нажмите на кразный круг с крестиком, обратите
	внимание что запись удаляется безвозвратно!</div>
<p class="db">Таблица DB: car_finoth</p>
<p class="cc"><a class="wf_blanck2 jk" href="index.php?name=valuta&del_valuta=del">Удаление всех записей из базы
		данных</a></p>
<div class="content">
	<?php echo FinOtchot($datasortir); ?>
</div>
<?php } ?>

<h2><a class="dot" href="index.php?name=valuta&_corect_=<?php echo $_SESSION['_corect_']; ?>">
		<?php echo $_corect_; ?></a>Коректировка суммы за услуги</h2>
<?php if($_SESSION['_corect_'] == 'on'){ ?>
<form name="vd" action="index.php?name=valuta" method="post" enctype="multipart/form-data">
	<div class="blockk">
		<label class="wf_text3" for="individual">Самостоятельная работа: </label>
		<input class="pole_vvoda2_2 pole_vvoda2" name="individual" type="text" value="<?php echo $_c_[0]['price']; ?>">
		<input class="pole_vvoda2_2 pole_vvoda2" name="individual_valuta" type="text"
			value="<?php echo $_c_[0]['valuta']; ?>">
	</div>
	<div class="blockk">
		<label class="wf_text3" for="minus">Работа при недостатке средств: </label>
		<input class="pole_vvoda2_2 pole_vvoda2" name="minus" type="text" value="<?php echo $_c_[1]['price']; ?>">
		<input class="pole_vvoda2_2 pole_vvoda2" name="minus_valuta" type="text" value="<?php echo $_c_[1]['valuta']; ?>">
	</div>
	<div class="blockk">
		<label class="wf_text3" for="vne">Работа вне рабочее время и вне средств коммуникации клуба: </label>
		<input class="pole_vvoda2_2 pole_vvoda2" name="vne" type="text" value="<?php echo $_c_[2]['price']; ?>">
		<input class="pole_vvoda2_2 pole_vvoda2" name="vne_valuta" type="text" value="<?php echo $_c_[2]['valuta']; ?>">
	</div>
	<input name="corect" class="wf_blanck2 jk" type="submit" value="Изменить">
</form>
<?php } ?>

<h2><a class="dot" href="index.php?name=valuta&_calculator_=<?php echo $_SESSION['_calculator_']; ?>">
		<?php echo $_calculator_; ?></a>Калькулятор валют</h2>
<?php if($_SESSION['_calculator_'] == 'on'){ ?>
<div style="color: red; width: 100%; padding: 10px 5px; font-weight: 800; overflow: hidden;">Калькулятор валют. Предназначен для конвертации суммы из выбраной валюты в гривны.</div>
<form name="vd" action="index.php?name=valuta" method="post" enctype="multipart/form-data">
	<div class="blockk">
		<label class="wf_text3" for="individual">Из какой валюты: </label>
		<select name="valuta" class="pole_vvoda2_2 pole_vvoda2" keydown=""><?php echo Valuta($val); ?></select>
	</div>
	<div class="blockk">
		<label class="wf_text3" for="individual">Сумма: </label>
		<input class="pole_vvoda2_2 pole_vvoda2" name="summa_convertacii" type="text" placeholder="Введите сумму">
	</div>
	<?php echo $summa_convertacii; ?>
	<input name="calculator_valut" class="wf_blanck2 jk" type="submit" value="Конвертировать волюту">
</form>
<?php } ?>
