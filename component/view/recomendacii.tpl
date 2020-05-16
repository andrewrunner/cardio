<?php if ($_SESSION['errors'] == $_POST && $_GET['delhist'] == 'del') {
	header("Location: http://iridoc.com/cardio/index.php?name=recomendacii", true); ?>
	<div class="block_string etr">
		<p class="goou">Файл был успешно удален</p>
		<a class="rmt" href="index.php?name=recomendacii">Назад</a>
		<?php  ?>
	</div>
<?php } else { ?>
	<h3 class="h3text">По анкете</h3>
	<div class="content">
		<?php
			echo $del_hist[0];
			echo $test_anket['anketa'];
			if($_GET['bloc'] == 'anketa'){
				include $_GET['histori'];
			} 
		?>
	</div>

	<h3 class="h3text">По крови</h3> 
	<div class="content">
		<?php
			echo $del_hist[1];
			echo $test_anket['krov'];
			if($_GET['bloc'] == 'krov'){
				include $_GET['histori'];
			} 
		?>
	</div>

	<h3 class="h3text">По ЭКГ</h3>
	<div class="content">
		<?php
			echo $del_hist[2];
			echo $test_anket['ecg'];
			if($_GET['bloc'] == 'ecg'){
				include $_GET['histori'];
			} 
		?>
	</div>
	
	<h3 class="h3text">По АД</h3>
	<div class="content">
		<?php
			echo $del_hist[3];
			echo $test_anket['ad'];
			if($_GET['bloc'] == 'ad'){
				include $_GET['histori'];
			}
		?>
	</div>
<!--
	<h3 class="h3text">Субстраты</h3>
	<div class="content">
		<?php
			echo $test_anket['sub'];
			if($_GET['bloc'] == 'sub'){
				include $_GET['histori'];
			} 
		?>
	</div>
-->
<?php } ?>