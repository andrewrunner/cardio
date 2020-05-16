<h1 style="text-align: center;">Операции со счетом</h1>

<div class="content">
	<form action="index.php?name=chet" method="post" enctype="multipart/form-data">	
		<label style="width: 85px; float: left;" for="valut">Валюта: </label>
		<select style="width: 90px;" name="valut" class="block_strock" keydown=""><?php echo Valuta($_POST); ?></select>
		<input class="wf_blanck2 jk" name="val_chet" type="submit" value="Сменить">
	</form>
</div>

<div class="content">
	<a href="#" onclick="javascript:ChetPrintTablet('print-content');" title="Распечатать проект"><?php echo Printer('icon'); ?></a>
</div>

<div id="print-content">
	<p>Ваш лимит по договору: <b><?php echo $uslovnuy_limit . ' ' . $curs; ?></b></p>
	<div class="tblet_chet no_visibiliti">
		<div class="chet_pp chet1 chet">№<br>пп</div>
		<div class="chet_data chet">Услуга из перечня клуба</div>
		<div class="chet_operation chet">Дата осущ. операции</div>
		<div class="chet_dolg chet">Использование лимита, <?php echo $curs; ?></div>
		<div class="chet_bes chet">Сумма на текущем счету, <?php echo $curs; ?></div>
		<div class="chet_data1_ chet">Стоимость клубная</div>
		<div class="chet_oplata chet">Расчета за услугу</div>
		<div class="chet_limit1_ chet">Дата погашения</div>
		<div class="chet_limit chet">Купленых обработок ЭКГ</div>
		<div class="chet_ostatoc chet">Использовано обработок ЭКГ</div>
	</div>
	<?php echo ChetClient(); ?>
	<!-- конец печати -->
</div>