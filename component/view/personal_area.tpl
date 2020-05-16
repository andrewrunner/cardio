<b>Вы вошли как:</b>
<?php echo Nameclient($_SESSION); ?>
<div class="calculator-valut">
    <form name="vd" action="index.php?name=personal_area" method="post" enctype="multipart/form-data">
        <select name="valuta" class="block_strock" style="width: 70px; margin-right: 10px;" keydown="">
            <?php echo Valuta(''); ?>
        </select>
        <span class="turen">-></span>
        <select name="out_valuta" class="block_strock" style="width: 70px; margin-right: 10px;" keydown="">
            <?php echo Valuta(''); ?>
        </select>
        <input class="block_strock" name="summa_convertacii" style="width: 100px; margin-right: 10px;" type="text" placeholder="Введите сумму">
        <?php echo $summa_convertacii; ?>
        <input name="calculator_valut" class="wf_blanck2 jk" type="submit" value="Конвертировать">
    </form>
</div>
<h1>Личный кабинет</h1>
<div class="block_pers">
    <a class="pers" href="index.php?name=personal">Персональные данные</a><br>
    <a class="pers" href="index.php?name=chet">Движение средств, баланс</a><br>
    <a class="pers" href="index.php?name=recomendacii">Рекомендации</a><br>
    <a class="pers" href="index.php?name=diagrams">Диаграмма здоровья</a><br>
</div>
<div class="block_pers">
    <a class="pers" href="index.php?name=diagnostic">Построить диаграмму по системам</a><br>
    <a class="pers" href="index.php?name=crov">Рассчитать рецепт активационного оздоровления</a><br>
    <a class="pers" href="index.php?name=card">Отослать ЭКГ и др. данные на обработку</a><br>
</div>
<div class="block_pers">
    <!-- <a class="pers" href="index.php?name=kalendar">Календарь здоровья</a><br> -->
    <a class="pers" href="index.php?name=cartpersonal">Корзина</a><br>
    <a class="pers" href="index.php?name=metodic">Подобрать средства оздоровления</a><br>
    <a class="pers" href="<?php echo URLPartner(['group' => '914']); ?>">Оплатить или сделать пожертвование</a><br>
</div>