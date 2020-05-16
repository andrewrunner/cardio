<div style="color: red; width: 100%; padding: 10px 5px; font-weight: 800; overflow: hidden;">Будте внимательны!<br>При
    заполнении формы первая ячейка меньшее число, вторая большее число (во избежании инвертации или збоя
    программы).<br>Там где значение имеет одно число, ставим в первое поле, второе оставляем пустым.<br>Если поле не
    принемает никагого значения, оставляем обе ячейки пустыми.<br>Вторая пара ячеек указывает на отклонение за пределами
    нормы.</div>
<p class="db">Таблица DB: car_dzcrov</p>
<h3>Количество не сигнальных показателей</h3>
<form action="index.php?name=recept&anketa=anket" method="post" enctype="multipart/form-data" name="myform">
    <?php echo DzCrovEdit(); ?>
    <input name="diapason_li" class="wf_blanck2 jk right_" type="submit" value="Изменить">
</form>
<div style="color: red; width: 100%; padding: 10px 5px; font-weight: 800; overflow: hidden;">Будте внимательны!<br>
    При заполнении формы первая ячейка меньшее число, вторая большее число (во избежании инвертации или збоя
    программы).<br>
    Значения заполняются оба поля из пары.<br>
    Первая пара ячеек — указывает на возрастной диапазон.<br>
    Вторая пара ячеек указывает на придел нормы.</div>
<p class="db">Таблица DB: car_dzcrovsignal</p>
<h3>Критерии опредиления не сигнальных показателей</h3>
<form action="index.php?name=recept&anketa=anket" method="post" enctype="multipart/form-data" name="myform">
    <?php echo DzSignalEdit(); ?>
    <input name="god_norm" class="wf_blanck2 jk right_" type="submit" value="Изменить">
</form>
