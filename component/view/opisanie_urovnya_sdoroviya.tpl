<div class="content">
	<a href="#" onclick="javascript:CallPrintTablet('print-content');" title="Распечатать проект">
		<svg class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512">
			<title>Печать</title>
			<g>
			</g>
			<path d="M128 32h256v64h-256v-64z"></path>
			<path d="M480 128h-448c-17.6 0-32 14.4-32 32v160c0 17.6 14.397 32 32 32h96v128h256v-128h96c17.6 0 32-14.4 32-32v-160c0-17.6-14.4-32-32-32zM64 224c-17.673 0-32-14.327-32-32s14.327-32 32-32 32 14.327 32 32-14.326 32-32 32zM352 448h-192v-160h192v160z"></path>
		</svg>
	</a>
</div>
<div id="print-content">
<div style="background: <?php echo $colors; ?>; color: #fff; text-align: left; padding: 10px;">
	<?php echo $preduprejdenie; ?>
	<h3>Уровень здоровья: <?php echo $categoris; ?></h3>
	<p><b>Описание уровня здоровья: </b><?php echo $opisanie_urovnya_zdorovia; ?></p>
	<p><b>Реакция активации: </b><?php echo $reakciya_aktivacii; ?></p>
	<p><b>Описание и применение: </b><?php echo $opisanie_primenenie; ?></p>
</div>