<div class="content">
    <a href="index.php?name=diagrams&data=mount" class="wf_blanck2 jk">Месяц</a>
    <a href="index.php?name=diagrams&data=year" class="wf_blanck2 jk">Год</a>
    <a href="index.php?name=diagrams&data=new_result" class="wf_blanck2 jk">Дополнительные данные</a>
</div>
<?php if ($_GET['data'] == 'mount') { ?>
<div class="content">
    <form action="index.php?name=diagrams&data=mount" method="post" enctype="multipart/form-data">
        <input type="month" name="data" class="wid block_strock margin_right" value="<?php echo date('Y-m') ?>">
        <select class="wid block_strock margin_right" name="group_categories">
            <option value="anketa">По анкете</option>
            <option value="crov">По крови</option>
            <option value="ecg">По ЭКГ</option>
            <option value="ad">По АД</option>
            <?php echo $steck_categori; ?>
        </select>
        <input name="mount_diagrams" class="wf_blanck2 jk" type="submit" value="Выбрать">
    </form>
</div>
<h1><?php echo $s[$mount]; ?></h1>
<h2 class="center"><?php echo $_groups_[$_POST['group_categories']]; ?></h2>
<?php }
if ($_GET['data'] == 'year') { ?>
<div class="content">
    <form action="index.php?name=diagrams&data=year" method="post" enctype="multipart/form-data">
        <select class="wid block_strock margin_right" name="data_Y">
            <?php echo $year->Yaer_10(); ?>
        </select>
        <select class="wid block_strock margin_right" name="group_categories">
            <option value="anketa">По анкете</option>
            <option value="crov">По крови</option>
            <option value="ecg">По ЭКГ</option>
            <option value="ad">По АД</option>
            <?php echo $steck_categori; ?>
        </select>
        <input name="data_year" class="wf_blanck2 jk" type="submit" value="Выбрать">
    </form>
</div>
<h1><?php echo $_POST['data_Y']; ?></h1>
<h2 class="center"><?php echo $_groups_[$_POST['group_categories']]; ?></h2>
<?php } 
if ($_GET['data'] == 'new_result') { ?>
    <div class="content">
        <form action="index.php?name=diagrams&data=new_result" method="post" enctype="multipart/form-data">
            <label class="wf_text2">Удалить индивидуальную диаграмму:</label>
            <select  name="name_graficks_del" class="wid block_strock margin_right" placeholder="" required>
                <option></option>
                <?php echo $steck_categori_del; ?>
            </select>
            <input name="data_new_result_del" class="wf_blanck2 jk" type="submit" value="Удалить">
        </form>
    </div>
    <div class="content">
        <form action="index.php?name=diagrams&data=new_result" method="post" enctype="multipart/form-data">
            <label class="wf_text2">Добавить индивидуальную диаграмму:</label>
            <input name="new_personal_grafick" type="text" class="wid block_strock margin_right" placeholder="Название индивидуального график" required>
            <input name="data_new_result" class="wf_blanck2 jk" type="submit" value="Добавить">
        </form>
    </div>
    <div class="content">
        <form action="index.php?name=diagrams&data=new_result" method="post" enctype="multipart/form-data">
            <label class="wf_text2">Внести данные в диаграмму:</label>
            <input name="data_graficks" type="date" class="wid block_strock margin_right" style="width: 140px;" required>
            <select  name="name_graficks" class="wid block_strock margin_right" placeholder="" required>
                <option></option>
                <?php echo $steck_categori; ?>
            </select>
            <input name="resultat_graficks" type="number" step="0.01" class="wid block_strock" style="width: 90px;" placeholder="Показания" required>
            <input name="data_new_result" class="wf_blanck2 jk" type="submit" value="Добавить">
        </form>
    </div>
<?php } ?>
