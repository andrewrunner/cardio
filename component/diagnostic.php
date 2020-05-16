<?php
$data = date("d.m.y");
if($_POST['diagnostic']){
	if(!Blocc($_POST, $_SESSION, $data) || Blocc($_POST, $_SESSION, $data) < 1){
		for($i = 0; $i < 8; $i++){
			unset($vopr);
			for($a = 0; $a < 10; $a++){
				$t = $i + 1;
				$vopr += $_POST['sost'.$t.$a];
			}
			$res[] += ($vopr/10);
		}

		$po = $_POST;
		unset($po['diagnostic']);
		$po = implode(',', $po);
		Diagrama($_SESSION, $res, $po);
		
		echo '<h1>Диаграмма оценки  систем организма:</h1>
		<div class="icon_print">
			<a class="blockprint" href="#" onClick="javascript:CallPrint(\'print-content\', \''.Nameclient($_SESSION).'\', \''.$data.'\');" title="Распечатать проект">'.Printer('icon').'</a>
		</div>
		<div id="print-content">
			<div class="diagnostic">
				<div class="diagrama">'.Diagram($res).'</div>
				<div class="comentdiagramm">
					<div class="shifr a" style="background: #71BF44;">Эндокринная система</div>
					<div class="shifr b" style="background: #F0DFAC;">Система очистки и выведения токсинов</div>
					<div class="shifr c" style="background: #00AEEF;">Система пищеварения</div>
					<div class="shifr d" style="background: #FBB040;">Мочеполовая система</div>
					<div class="shifr e" style="background: #B88BBF;">Опорнодвигательная система</div>
					<div class="shifr j" style="background: #F6A8CA;">Сердечно-сосудистая система</div>
					<div class="shifr z" style="background: #1C75BC;">Дыхательная система</div>
				</div>
			</div>
			<div style="font-size: 20px;">Чем ближе выделенный сектор находится к периферии круга, тем более выражены нарушения в секторе соответствующей системы организма</div><br><br>
		</div>';
		unset($_POST);
	}
	if(Blocc($_POST, $_SESSION, $data) == 1){
		echo '<div>Вы заполнили не все поля!</div>
			<div><a class="wf_blanck2 jk right_" href="index.php?name=diagnostic">Вернутся к анкете</a></div>';
	}
	if(Blocc($_POST, $_SESSION, $data) == 2){
		echo '<div>Вы уже проходили сегодня оценку здоровья! Попробуйте в другой день!</div>';
	}
}else{
	echo '<div style="text-align: justify;"><b><span style="color: red;">Внимание!</span> Пожалуйста, внимательно ответьте на вопросы. Учитывайте, что полученный результат будет записан, и на его основе будут производиться дальнейшие расчеты. Не отвечайте наугад, иначе это потянет за собой целый ряд несоответствий по оценке вашего здоровья.</b></div>
	<form name="basis_" action="index.php?name=diagnostic" method="post" enctype="multipart/form-data">
	'.DiagnosticVopros($_SESSION).'
	<input name="diagnostic" class="wf_blanck2 jk right_" type="submit" value="Далее">
	</form>';
}

