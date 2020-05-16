<div class="punckt">
	<p class="db">Таблица DB: car_biostemulyator</p>
	<div class="block_f2 bio_dop">
		<div class="blokvidname"><?php echo $_bs[0]; ?></div>
		<form action="index.php?name=recept" method="post" enctype="multipart/form-data">
			<div class="punckt" style="width: 693px; padding: 10px 0; overflow: hidden;">
				<label class="wf_text">Название:</label>
				<input name="biostimulyator" class="box_vvoda" type="text">
				<input class="wf_blanck2 jk" name="biostim" type="submit" value="Добавить">
			</div>
		</form>
	</div>
	<?php echo $_bs[1]; ?>
</div>