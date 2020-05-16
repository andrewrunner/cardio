<div class="content">
    <hr>
    <form action="index.php?name=personal_area" method="post" enctype="multipart/form-data">
        <select name="cal_mes" class="wid block_strock" value="Выбирите месяц" keydown="" required="">
            <?php echo $year->Mount(); ?>
        </select>
        <select class="wid block_strock" name="_year_" style="width: 90px; margin: 0 10px;">
            <?php echo $year->Yaer_10(); ?>
        </select>
        <input name="kalendar" class="wf_blanck2 jk" type="submit" value="Выбрать">
        <div class="coment" style="background: green;">Общеклубное мероприятие</div>
        <div class="coment" style="background: red;">Индивидуальное назначение</div>
    </form>
</div>
<div border=1><?php echo $cal_oz->CalendarOz(); ?></div>
