<div class="icon_print2">
	<a class="blockprint" href="#" onClick="javascript:CallPrint('print-content', '<?php echo $usersname; ?>', '<?php echo $data; ?>');" title="Распечатать проект"><?php echo Printer('icon'); ?></a>
</div>
<div id="print-content">
	<div class="diagnostic001">
		<div class="diagrama"><?php echo Diagram($res); ?></div>
		<div class="comentdiagramm">
			<div class="shifr" style="background: #71BF44;">Эндокринная система</div>
			<div class="shifr" style="background: #F0DFAC;">Система очистки и выведения токсинов</div>
			<div class="shifr" style="background: #00AEEF;">Система пищеварения</div>
			<div class="shifr" style="background: #FBB040;">Мочеполовая система</div>
			<div class="shifr" style="background: #B88BBF;">Опорнодвигательная система</div>
			<div class="shifr" style="background: #F6A8CA;">Сердечно-сосудистая система</div>
			<div class="shifr" style="background: #1C75BC;">Дыхательная система</div>
		</div>
	</div>
</div>
<?php echo Diagnostic($usersname, $voprosu); ?>