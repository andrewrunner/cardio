<div style="padding: 10px; overflow: hidden;">
	<form action="index.php" method="post" enctype="multipart/form-data">
		<div class="block_f2" style="width: 800px;">
			<label style="width: 260px; float: left;" for="group_prodd">Однотипная группировка: </label>
			<select name="group_prodd" class="block_strock" keydown="">
				<?php echo Ctegories($sort_group); ?></select>
			<input class="wf_blanck2 jk" name="sort_group" type="submit" value="Выбрать группу">
		</div>
	</form>
	<form action="index.php" method="post" enctype="multipart/form-data">
		<div style="float: left; padding: 5px 0;">
			<label style="width: 85px; float: left;" for="valut">Валюта: </label>
			<select style="width: 90px;" name="valut" class="block_strock" keydown="">
				<?php echo Valuta($_POST); ?></select>
			<input class="wf_blanck2 jk" name="valute" type="submit" value="Сменить">
		</div>
	</form>
</div>
<h2><?php echo $sort_group; ?></h2>
<?php echo Product($sort_group, $_POST, $_GET); ?>
