<div class="south">
	<?php echo ClientDel('icon4'); ?>
</div>
<h1 style="text-align: center;">Форма управления клиентами</h1>
<p class="db">Таблица DB: cardio_clientu</p>
<div class="form_table">
	<div class="table_contents">
		<div class="namber"> </div>
		<div class="table_width">
			<a class="<?php echo $style_colum[0]; ?>" href="index.php?name=client_del&reles=fio_o">ФИО</a>
		</div>
		<div class="table_width3">
			<a class="<?php echo $style_colum[1]; ?>" href="index.php?name=client_del&reles=data_r">Рождение</a>
		</div>
		<div class="table_width2">
			<a class="<?php echo $style_colum[2]; ?>" href="index.php?name=client_del&reles=ok">Обработано</a>
		</div>
		<div class="table_width2">
			<a class="<?php echo $style_colum[3]; ?>" href="index.php?name=client_del&reles=time_load">Прислано</a>
		</div>
		<div class="table_width2a">
			<a class="<?php echo $style_colum[4]; ?>" href="index.php?name=client_del&reles=personal_number">Перс. №</a>
		</div>
		<div class="table_width2a">
			<a class="<?php echo $style_colum[5]; ?>" href="index.php?name=client_del&reles=group_number">Группа</a>
		</div>
		<div class="table_width">
			<a class="<?php echo $style_colum[6]; ?>" href="index.php?name=client_del&reles=card_ras">На кого карта</a>
		</div>
		<div class="table_width2a">
			<a class="<?php echo $style_colum[7]; ?>" href="index.php?name=client_del&reles=oplashen">Оплачен</a>
		</div>
		<div class="table_width2a">
			<a class="<?php echo $style_colum[8]; ?>" href="index.php?name=client_del&reles=sum_opl">Сумма</a>
		</div>
	</div>
</div>
<?php echo SteckClientu($style_colum); ?>