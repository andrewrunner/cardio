<div style="color: red; width: 100%; padding: 10px 5px; font-weight: 800; overflow: hidden;">Будте внимательны!<br>При заполнении формы первая ячейка меньшее число, вторая большее число (во избежании инвертации или збоя программы).<br>Там где значение имеет одно число, ставим в первое поле, второе оставляем пустым.<br>Если поле не принемает никагого значения, оставляем обе ячейки пустыми.</div>
<p class="db">Таблица DB: car_ds</p>
<form action="index.php?name=recept&anketa=anket" method="post" enctype="multipart/form-data" name="myform">
	<div class="blokked">
		<label class="receptblockform6"></label>
		<div class="receptblockform1">
			<fieldset class="setfil2"><b>*</b></fieldset>
			<fieldset class="setfil2"><b>**</b></fieldset>
		</div>
	</div>
	<?php echo Ds(); ?>
	<input name="ekg" class="wf_blanck2 jk right_" type="submit" value="Изменить">
</form>