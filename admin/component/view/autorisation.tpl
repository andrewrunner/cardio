<div class="south">
	<?php echo Polsovateli('icon4'); ?>
</div>
<h1>КАБИНЕТ</h1>
<h2><a class="dot" href="index.php?name=avtorisovanue&_email_poluch_=<?php echo $_SESSION['_email_poluch_']; ?>">
		<?php echo $_email_poluch_; ?></a>E-mail для получения тематических писем</h2>
<?php if($_SESSION['_email_poluch_'] == 'on'){ ?>
<div style="width: 100%; padding: 10px 0; overflow: overlay;">
	<p class="db">Таблица DB: car_email_opl</p>
	<form name="vd" action="index.php?name=avtorisovanue" method="post" enctype="multipart/form-data">
		<label class="wf_text" for="type_of_treatment">Введите e-mail: </label>
		<input class="box_vvoda" name="emailotvet" type="text" placeholder="<?php echo EmailOplata(); ?>">
		<input class="wf_blanck2 jk right_" style="margin: 0 0 0 10px; float: left;" name="emotv" type="submit"
			value="Изменить">
	</form>
</div>
<?php } ?>

<h2><a class="dot" href="index.php?name=avtorisovanue&_steck_polsov_=<?php echo $_SESSION['_steck_polsov_']; ?>">
		<?php echo $_steck_polsov_; ?></a>Список зарегестрированных пользоватилей</h2>
<?php if($_SESSION['_steck_polsov_'] == 'on'){ ?>
<div style="height: 200px; overflow: auto;">
	<?php echo SteckPolsovateley(); ?>
</div>
<?php } ?>

<h2><a class="dot" href="index.php?name=avtorisovanue&_diagrams_=<?php echo $_SESSION['_diagrams_']; ?>">
		<?php echo $_diagrams_; ?></a>Диаграмма оценки систем организма:</h2>
<?php if($_SESSION['_diagrams_'] == 'on'){ ?>
<div style="width: 100%; padding: 10px 0; overflow: hidden;">
	<form name="vd" action="index.php?name=avtorisovanue" method="post" enctype="multipart/form-data">
		<label class="wf_text" for="type_of_treatment">Выберите дату: </label>
		<input class="box_vvoda" name="datastart" type="date">
		<input name="datasort" class="wf_blanck2 jk" type="submit" value="Сортировать по дате">
	</form>
</div>
<div class="block_f2" style="overflow: hidden;">
	<form action="index.php?name=avtorisovanue" method="post" enctype="multipart/form-data">
		<label class="wf_text" for="type_of_treatment">Пользователи: </label>
		<select name="nameusers" class="box_vvoda" keydown="">
			<?php echo MenuDiagram($datareg, $usersname, $nn); ?></select>
		<input class="wf_blanck2 jk right_" style="margin: 0 0 0 10px; float: left;" name="diagrampol" type="submit"
			value="Выбрать">
	</form>
</div>
<?php } ?>


<h2><a class="dot" href="index.php?name=avtorisovanue&_file_del_=<?php echo $_SESSION['_file_del_']; ?>">
		<?php echo $_file_del_; ?></a>Удаление отправляемых файлов:</h2>
<?php if($_SESSION['_file_del_'] == 'on'){ 
	echo $down_;
} ?>