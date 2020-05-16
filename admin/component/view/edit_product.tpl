<div class="south"><?php echo Prod('icon4'); ?></div>
<h1 style="text-align: center;">ТОВАРЫ</h1>
<!-- добавление товаров -->
<h2><a class="dot" href="index.php?name=product&new_tov=<?php echo $_SESSION['new_tov']; ?>"><?php echo $new_tov; ?></a>Добавить в список товаров</h2>
<?php if($_SESSION['new_tov'] == 'on'){ ?>
<p class="db">Таблица DB: car_product</p>
<form action="index.php?name=product" method="post" enctype="multipart/form-data">
	<div class="punckt">
		<label class="ogl">Название продукта:</label>
		<input name="name" class="box_vvoda" type="text">
	</div>
	<div class="punckt">
		<label class="ogl">Фото продукта 279x279px:</label>
		<input name="filename" class="box_vvoda" type="file" placeholder="Выбирите фото 289ч289px">
	</div>
	<div class="punckt">
		<label class="ogl">Описание:</label>
		<textarea class="box_vvoda" class="block_coment" name="comentari" rows="6"></textarea>
	</div>
	<div class="punckt">
		<label class="ogl">Цена:</label>
		<input name="price" class="box_vvoda" type="text">
	</div>
	<div class="punckt">
		<div class="block_f2">
			<label class="ogl" for="type_of_treatment">Группа товара: </label>
			<select name="product_group" class="box_vvoda" keydown=""><?php echo CategorisProduct(); ?></select>
		</div>
	</div>
	<input class="wf_blanck2 jk right_" name="dob" type="submit" value="Добавить">
</form>
<?php } ?>
<!-- Группа товаров -->
<h2><a class="dot" href="index.php?name=product&edit_tov=<?php echo $_SESSION['edit_tov']; ?>"><?php echo $edit_tov; ?></a>Редактировать группы</h2>
<?php if($_SESSION['edit_tov'] == 'on'){ ?>
<div class="punckt">
	<p class="db">Таблица DB: car_group_product</p>
	<div class="block_f2"><?php echo DeletCategories(); ?>
	</div>
	<form action="index.php?name=product" method="post" enctype="multipart/form-data">
		<div class="punckt">
			<label class="ogl">Название группы продукта:</label>
			<input name="ngp" class="box_vvoda" type="text">
		</div>
		<input class="wf_blanck2 jk right_" name="ngpa" type="submit" value="Добавить">
	</form>
</div>
<?php } ?>
<!-- Список продуктов -->
<h2><a class="dot" href="index.php?name=product&stec_tov=<?php echo $_SESSION['stec_tov']; ?>"><?php echo $stec_tov; ?></a>Список товаров</h2>
<?php if($_SESSION['stec_tov'] == 'on'){ ?>
<div class="width100">
	<p class="db">Таблица DB: car_product</p>
	<form action="index.php?name=product" method="post" enctype="multipart/form-data">	
		<div style="width: 735px; padding: 10px; overflow: hidden;">
			<div class="block_f2">
				<label class="wf_text" for="group_prodd">Группа товара: </label>
				<select name="group_prodd" class="box_vvoda" keydown=""><?php echo CategorisProduct(); ?></select>
				<input class="wf_blanck2 jk" name="sort_group" type="submit" value="Выбрать группу">
			</div>
		</div>
	</form>	
</div>
<div class="tovaru_"><?php echo SteckProduct($_POST['group_prodd']); ?></div>
<?php } ?>
