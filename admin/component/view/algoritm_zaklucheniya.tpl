<div class="block_f2">
	<form action="index.php?name=recept" method="post" enctype="multipart/form-data" name="myform">
		<label class="wf_text" for="zakl_categori">Уровень здоровья: </label>
		<select name="zakl_categori" class="box_vvoda1" keydown=""><?php echo Zakluchenie($_POST); ?></select>
		<input class="wf_blanck2 jk" name="categoris_zakl" type="submit" value="Выбрать группу">
	</form></div>
		<div style="color: red; width: 100%; padding: 10px 5px; font-weight: 800; overflow: hidden;">Будте внимательны при заполнении формы!</div>
		<p class="db">Таблица DB: car_algoritm_zaklutheniya</p>
		<?php echo ZakluchenieEdit($_POST); ?>