<div class="table_client">
	<div class="south"><?php echo Vide('icon4'); ?></div>
	<h1 style="text-align: center;">Виды обработки</h1>
	<p class="db">Таблица DB: cardio_vid</p>
	<p class="redd">Всевиды обработки сохраняются в валюте 'cor'.</p>
	<div class="form_table">
		<div class="table_contents">
			<div class="namber">№</div>
			<div class="table_width2_2">Вид обработки</div>
			<div class="table_width2">Цена</div>
		</div><?php echo VideObrabotci(); ?></div>
	</div>
	<form name="vd" action="" method="post" enctype="multipart/form-data">
		<div class="form_table2">
			<div class="fm_">
				<div class="block_f">
					<label class="td">Новый вид обработки: </label>
					<input class="pole_vvoda" name="vide" type="text">
					<label class="td">Цена: </label>
					<input class="pole_vvoda" name="price" type="text">
					<div class="block_f">
						<input name="" class="wf_blanck2 jk right_" type="reset" value="Отмена">
						<input name="save_vide" class="wf_blanck2 jk right_" type="submit" value="Добавить">
					</div>
				</div>
			</div>
		</div>
    </form>
</div>