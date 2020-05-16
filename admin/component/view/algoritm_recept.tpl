<p class="db">Таблица DB: car_18sostoyaniy</p>
<form action="index.php?name=recept" method="post" enctype="multipart/form-data">
	<div style="width: 100%; padding: 10px; overflow: hidden;">
		<fieldset class="ram3">
			<legend><b class="chust">Импорт из другого рецепта всей группы</b></legend>
			<label class="wf_text2" for="recept_spisock_import">Из какого рецепта: </label>
			<select class="box_vvoda2" name="recept_spisock_import" keydown=""><?php echo StacTableBSDuo(); ?></select>
			<label class="wf_text2" for="new_recept">Название нового рецепта: </label>
			<select class="box_vvoda2" name="new_recept" keydown="" required><?php echo Biostemulator(); ?></select>
			<input class="wf_blanck2 jk" name="new_recept_save" type="submit" value="Создать рецепт">
		</fieldset>
	</div>
</form>
<form action="index.php?name=recept" method="post" enctype="multipart/form-data">
	<div style="width: 100%; padding: 10px; overflow: hidden;">
		<fieldset class="ram3">
			<legend><b class="chust">Выборочный импорт из другого рецепта </b></legend>
			<label class="wf_text2" for="export_biostimulator">Из какого рецепта: </label>
			<select class="box_vvoda2" name="export_biostimulator" keydown=""><?php echo $tablet[0]; ?></select>
			<label class="wf_text2" for="import_biostimulator">В какой рецепт: </label>
			<select class="box_vvoda2" name="import_biostimulator" keydown="" required><?php echo $tablet[0]; ?></select>
			<input class="wf_blanck2 jk" name="import_data" type="submit" value="Импортиравать">
		</fieldset>
	</div>
</form>
<form action="index.php?name=recept" method="post" enctype="multipart/form-data">	
	<div style="width: 735px; padding: 10px; overflow: hidden;">
		<div class="block_f2">
			<label class="wf_text" for="recept_spisock">Рецепт: </label>
			<select name="recept_spisock" class="box_vvoda2" keydown=""><?php echo $tablet[0]; ?></select>
			<input class="wf_blanck2 jk" name="sort_group" type="submit" value="Выбрать рецепт">
		</div>
	</div>
</form>
<form action="index.php?name=recept&id=<?php echo $tablet[1]; ?>" method="post" enctype="multipart/form-data" name="myform">
	<?php echo EditTableBS($_SESSION); ?>
	<input name="edit" class="wf_blanck2 jk right_" type="submit" value="Изменить">
</form>