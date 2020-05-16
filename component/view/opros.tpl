<div class="block_string hr">
	<h1>Расчет по Анкете</h1>
</div>
<div class="block_string">
	<form action="index.php?name=forma&tablet=table&id_oprosnic=<?php echo $id_oprosnic; ?>" method="post"
		enctype="multipart/form-data">
		<?php echo Saboliv(); ?>
		<?php echo $boli; ?>
		<div class="block_string">
			<label class="text_menu2" for="type_of_treatment">Выбор препарата:</label>
			<select class="block_sp" name="type_of_treatment" value="" keydown="" required>
				<?php echo Preparat(); ?></select>
		</div>
		<?php echo Anceta(); ?>
		<input name="opros" class="wf_blanck2 jk right_" type="submit" value="Далее">
	</form>
</div>

<!-- Для переноса на админ -->