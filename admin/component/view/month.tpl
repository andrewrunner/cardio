<div class="content">
    <a href="index.php?name=edit_polsovateli&id=<?php echo $_GET['id'] ?>&data=mount" class="wf_blanck2 jk">Месяц</a>
    <a href="index.php?name=edit_polsovateli&id=<?php echo $_GET['id'] ?>&data=year" class="wf_blanck2 jk">Год</a>
    <a href="index.php?name=edit_polsovateli&id=<?php echo $_GET['id'] ?>&data=base" class="wf_blanck2 jk">База</a>
    <a href="index.php?name=edit_polsovateli&id=<?php echo $_GET['id'] ?>&data=dop_data" class="wf_blanck2 jk">Дополнительные данные</a>
</div>
<?php if ($_GET['data'] == 'mount') { ?>
<div class="content">
    <form action="index.php?name=edit_polsovateli&id=<?php echo $_GET['id'] ?>&data=mount" method="post" enctype="multipart/form-data">
        <input type="month" name="data" class="wid block_strock margin_right" value="<?php echo date('Y-m') ?>">
        <select class="wid block_strock margin_right" name="group_categories">
            <option value="anketa">По анкета</option>
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
    <form action="index.php?name=edit_polsovateli&id=<?php echo $_GET['id'] ?>&data=year" method="post" enctype="multipart/form-data">
        <select class="wid block_strock margin_right" name="data_Y">
            <?php echo $year->Yaer_10(); ?>
        </select>
        <select class="wid block_strock margin_right" name="group_categories">
            <option value="anketa">По анкета</option>
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
if ($_GET['data'] == 'base') { ?>
<h3 class="center">Редактирование результатов диаграммы</h3>
<p class="db">Таблица DB: car_diagramma_resultat</p>
<p class="red">Список групп: anketa, crov, ecg, ad</p>
<div class="content">
    <form action="index.php?name=edit_polsovateli&id=<?php echo $_GET['id'] ?>&data=base" method="post" enctype="multipart/form-data">
        <?php echo $base_diagrams; ?>
        <div class="content">
            <a class="wf_blanck2 jk" href="index.php?name=edit_polsovateli&id=<?php echo $_GET['id'] ?>&data=base&new_diagram_reg=<?php echo $_GET['id'] ?>">Добавить новую запись запись</a>
            <input name="save_d" class="wf_blanck2 jk" type="submit" value="Сохранить">
        </div>
    </form>
</div>
<?php }
if ($_GET['data'] == 'dop_data') { ?>
    <div class="content">
        <form action="index.php?name=edit_polsovateli&id=<?php echo $_GET['id']; ?>&data=dop_data" method="post" enctype="multipart/form-data">
            <label class="wf_text lable_width">Удалить индивидуальную диаграмму:</label>
            <select  name="name_graficks_del" class="wid block_strock margin_right" placeholder="" required>
                <option></option>
                <?php echo $steck_categori_del; ?>
            </select>
            <input name="data_new_result_del" class="wf_blanck2 jk" type="submit" value="Удалить">
        </form>
    </div>
    <div class="content">
        <form action="index.php?name=edit_polsovateli&id=<?php echo $_GET['id']; ?>&data=dop_data" method="post" enctype="multipart/form-data">
            <label class="wf_text lable_width">Добавить индивидуальную диаграмму:</label>
            <input name="new_personal_grafick" type="text" class="wid block_strock margin_right" placeholder="Название индивидуального график" required>
            <input name="data_new_result" class="wf_blanck2 jk" type="submit" value="Добавить">
        </form>
    </div>
    <div class="content">
        <form action="index.php?name=edit_polsovateli&id=<?php echo $_GET['id']; ?>&data=dop_data" method="post" enctype="multipart/form-data">
            <label class="wf_text lable_width">Внести данные в диаграмму:</label>
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