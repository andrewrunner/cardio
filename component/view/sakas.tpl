<b>Вы вошли как:</b><?php echo Nameclient($_SESSION); ?>

<div style="width: 100%; padding: 5px; overflow: hidden; box-sizing: border-box;">
	<form action="index.php?name=cartpersonal" method="post" enctype="multipart/form-data">	
		<div style="float: left; padding: 5px 0;">
			<label style="width: 85px; float: left;" for="valut">Валюта: </label>
			<select style="width: 90px;" name="valut" class="block_strock" keydown=""><?php echo Valuta($_POST); ?></select>
			<input class="wf_blanck2 jk" name="valute2" type="submit" value="Сменить">
		</div>
	</form>
	<div id="print-content">
		<a class="wf_blanck2 jk right_" href="index.php?name=metodic">Перейти к выбору</a>
	</div>
</div>

<?php if ($_SESSION['cart']) { ?>
<h1>Текущая корзина</h1>
<?php } ?>
