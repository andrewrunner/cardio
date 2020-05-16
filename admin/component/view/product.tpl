<h1>Редактирование товара</h1>
<p class="redd">Рекомендуется все товары ставить в валюте 'cor', во избежании ошибок при пересчете</p>
<?php echo $new_array[0]; ?>
<form action="index.php?name=edit_product&id=<?php echo $_GET['id'] ?>" method="post" enctype="multipart/form-data" name="<?php echo $new_array[1][0]; ?>">
	<div class="block_men">
		<div class="punckt">
			<label>ID: </label>
			<input name="identificator" style="border: none; width: 40px;" value="<?php echo $new_array[1][0]; ?>">
			<label>Группа товара: </label>
			<input name="" style="border: none; overflow: inherit; width: 297px;" value="<?php echo $new_array[1][5]; ?>">
		</div>
		<div class="punckt">
			<label class="ogl">Переместить на позицию:</label>
			<input name="new_name_prod" class="box_vvoda" type="text" value="<?php echo $new_array[1][0]; ?>">
		</div>
		<div class="punckt">
			<label class="ogl">Название продукта:</label>
			<input name="name_prod" class="box_vvoda" type="text" value="<?php echo $new_array[1][1]; ?>">
		</div>
		<div class="punckt">
			<label class="ogl">Фото продукта 289x289px:</label>
			<input name="filename" class="box_vvoda" type="file" placeholder="Выбирите фото 289ч289px">
		</div>
		<div class="punckt">
			<label class="ogl">Цена:</label>
			<input name="price" class="box_vvoda" type="text" placeholder="<?php echo $new_array[1][4]; ?> cor.">
		</div>
	</div>
	<div class="block_men">
		<div class="punckt">
			<label class="ogl">Описание:</label>
			<textarea class="box_vvoda" class="block_coment" name="comentari" rows="6" value=""><?php echo $new_array[1][3]; ?></textarea>
		</div>
		<div class="punckt">
			<div class="block_f2">
				<label class="wf_text" for="type_of_treatment">Группа товара: </label>
				<select name="product_group" class="box_vvoda" keydown=""><?php echo CategorisProduct(); ?></select>
			</div>
		</div>
		<div class="punckt">
			<input class="wf_blanck2 jk right_" name="prodd" type="submit" value="Изменить">
			<a class="wf_blanck2 jk right_" href="http://iridoc.com/cardio/admin/index.php?name=product">Назад</a>
		</div>
	</div>
</form>