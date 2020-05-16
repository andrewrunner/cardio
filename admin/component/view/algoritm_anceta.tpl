<div style="color: red; width: 100%; padding: 10px 5px; font-weight: 800; overflow: hidden;">Будте внимательны!<br>При
	заполнении формы первая ячейка меньшее число, вторая большее число (во избежании инвертации или збоя
	программы).<br>Там где значение имеет одно число, ставим в первое поле, второе оставляем пустым.<br>Если поле
	принемает весь диапазон оставляем обе ячейки пустыми.</div>
<p class="db">Таблица DB: car_opr18sost</p>
<form action="index.php?name=recept&anketa=anket" method="post" enctype="multipart/form-data" name="myform">
	<div class="blokked">
		<label class="receptblockform4"></label>
		<div class="receptblockform1" style="overflow: hidden; height: 160px;">
			<div class="olr">тревожность</div>
			<div class="olr">раздражительность</div>
			<div class="olr">утомляемость</div>
			<div class="olr">угнетенность</div>
			<div class="olr">активность</div>
			<div class="olr">оптимизм</div>
			<div class="olr">сон</div>
			<div class="olr">аппетит</div>
			<div class="olr">работа скорость</div>
			<div class="olr">работа время </div>
		</div>
	</div>
	<?php echo OprosAncetaEdit(); ?>
	<input name="anketres" class="wf_blanck2 jk right_" type="submit" value="Изменить">
	<input name="id" style="visibility: hidden;" value="<?php echo $id[0].'.'.$id[1].'.'.$id[2]; ?>">
</form>