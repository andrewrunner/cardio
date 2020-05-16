<div class="south">
    <?php echo PDF('icon4'); ?>
</div>
<h1>Расчет АО</h1>

<p class="redd">Результат сохраняется в файл, можно распечатать в PDF.<br>У клиента, после входа в кабинет,
    автоматически спишутся средства, если есть на счету.<br>Если средств нет будет выведено сообщение что просмотр не
    доступен!</p>

<h2><a class="dot" href="index.php?name=ao&anceta=<?php echo $_SESSION['anceta']; ?>">
        <?php echo $anceta; ?></a>Расчет по Анкете</h2>
<?php if($_SESSION['anceta'] == 'on'){
    if ($_GET['tablet'] == 'table') { 
        include 'component/anceta.php'; 
    } else { ?>
<div class="block_string">
    <form action="index.php?name=ao&tablet=table&id_oprosnic=<?php echo $id_oprosnic; ?>" method="post"
        enctype="multipart/form-data">
        <?php include 'component/view/ao_block.tpl'; ?>
        <?php echo Anceta() ?>
        <input name="opros" class="wf_blanck2 jk right_" type="submit" value="Далее">
    </form>
</div>
<?php }
    } ?>

<h2><a class="dot" href="index.php?name=ao&crov=<?php echo $_SESSION['crov']; ?>">
        <?php echo $crov; ?></a>Расчет по формуле крови</h2>
<?php if($_SESSION['crov'] == 'on'){ 
    if ($_GET['tablet'] == 'krov') { 
        include 'component/crov.php';
    } else { ?>
<div class="block_string">
    <form action="index.php?name=ao&tablet=krov&id_oprosnic=<?php echo $id_oprosnic; ?>" method="post"
        enctype="multipart/form-data">
        <?php include 'component/view/ao_block.tpl'; ?>
        <?php echo CrovTpl(); ?>
        <input name="krov" class="wf_blanck2 jk right_" type="submit" value="Далее">
    </form>
</div>
<?php }
    } ?>

<h2><a class="dot" href="index.php?name=ao&ekg=<?php echo $_SESSION['ekg']; ?>">
        <?php echo $ekg; ?></a>Расчет по ЭКГ</h2>
<?php if($_SESSION['ekg'] == 'on') {
    if ($_GET['tablet'] == 'ecg') { 
        include 'component/ecg.php';
    } else { ?>
<form action="index.php?name=ao&tablet=ecg&id_oprosnic=<?php echo $id_oprosnic; ?>" method="post"
    enctype="multipart/form-data">
    <?php include 'component/view/ao_block.tpl'; ?>
    <div class="content pad">
        <img class="image1" src="../images/diagrams.svg" width="400">
        <div class="block_sf">Определите графическую метку обработки ЭКГ в одном из полей обозначенных одним из цветов.
            Метка должна находиться внутри поля или в непосредственной близости от него. Укажите в какой зоне находится
            Ваша
            метка ЭКГ:</div>
        <fieldset class="block_sf">
            <input type="radio" name="fg" id="sost" value="green" required>
            <label class="radio-inline">Зеленый</label>
            <input type="radio" name="fg" id="sost" value="yellow" required>
            <label class="radio-inline">Желтый</label>
            <input type="radio" name="fg" id="sost" value="red" required>
            <label class="radio-inline">Красный</label>
            <input type="radio" name="fg" id="sost" value="blue" required>
            <label class="radio-inline">Голубой</label>
        </fieldset><br>
        <div class="block_sf">Из таблицы основных показателей сердечного ритма из колонки "Знач" укажите, количество
            показателей с одним знаком «*» и количество показателей с двумя знаками «**».</div>
        <div class="block_sf">
            <div class="block_string">
                <label for="lastname" class="left_">Количество показателей с одним знаком"*" :</label>
                <input class="block_sp2" type="number" size="10" name="num1" min="0" max="10" value="0">
            </div>
            <div class="block_string">
                <label for="lastname" class="left_">Количество показателей с двумя знаками"**" :</label>
                <input class="block_sp2" type="number" size="10" name="num2" min="0" max="10" value="0">
            </div>
        </div>
        <div class="block_string hr">
            <input name="ress" class="bottom_" type="submit" value="Очистка формы">
            <input class="bottom_" name="ekgres" type="submit" value="Ок">
        </div>
    </div>
</form>
<?php }
    } ?>

<h2><a class="dot" href="index.php?name=ao&ad=<?php echo $_SESSION['ad']; ?>"><?php echo $ad; ?></a>Выбор Рецепта</h2>
<?php if($_SESSION['ad'] == 'on') { ?>
<div class="content pad">
    <a href="index.php?name=ao&structura=base" class="wf_blanck2 jk">Из базы</a>
    <a href="index.php?name=ao&structura=manual" class="wf_blanck2 jk">Ручной ввод</a>
</div>
<?php if ($_GET['structura'] == 'base') { ?>
<h3 class="h3_ad">Из базы</h3>
<form action="index.php?name=ao&structura=base_res&tablet=ad&id_oprosnic=<?php echo $id_oprosnic; ?>" method="post"
    enctype="multipart/form-data">
    <?php include 'component/view/ao_block.tpl'; ?>
    <div class="blockk">
        <label class="text_menu3" for="recept_spisock">Реакция и уровень: </label>
        <select name="recept_spisock" class="block_sp_2" keydown="" required><?php echo $reakciya->ReUr(); ?></select>
    </div>
    <div class="block_string hr">
        <input name="ress" class="bottom_" type="submit" value="Очистка формы">
        <input class="bottom_" name="ad_bas" type="submit" value="Ок">
    </div>
    </div>
</form>
<?php } else {
    include 'component/ad_base.php';
}
 if ($_GET['structura'] == 'manual') { ?>
<h3 class="h3_ad">Ручной режим</h3>
<form action="index.php?name=ao&tablet=ad&id_oprosnic=<?php echo $id_oprosnic; ?>" method="post"
    enctype="multipart/form-data">
    <div class="block">
        <div class="blockk">
            <?php echo Saboliv(); ?>
        </div>    
        <div class="blockk">
            <label class="text_menu3" for="personal_anceta">ФИО пользователя:</label>
            <input class="block_sp" type="text" name="personal_anceta" required>
        </div>
        <div class="blockk">
            <label class="text_menu3" for="pol">Пол:</label>
            <select class="block_sp_2" name="pol" required>
                <option>Мужской</option>
                <option>Женский</option>
            </select>
        </div>    
        <div class="blockk">
            <label class="text_menu3" for="personal_data">Полных лет:</label>
            <input class="block_sp" type="number" name="personal_data" step="1" min="1" required>
        </div>
        <div class="blockk">
            <label class="text_menu3" for="price_usluga">Цена:</label>
            <input name="price_usluga" type="text" class="block_sp" required>
        </div>
        <div class="blockk">
            <label class="text_menu3" for="valuta_uslugi">Валюта:</label>
            <select class="block_sp_2" name="valuta_uslugi" required>
                <?php echo Valuta($val); ?>
            </select>
        </div>
        <div class="blockk">
            <label class="text_menu3" for="dni">Количество десятидневок:</label>
            <input name="dni" class="block_sp" required value="3" step="1" min="1" type="number">
        </div>
        <div class="blockk">
            <label class="text_menu3" for="mnojitel">ИК:</label>
            <input name="mnojitel" class="block_sp" required value="1" step="0.1" min="0.1" type="number">
        </div>
        <div class="blockk">
            <label class="text_menu3" for="type_of_treatment">Выбор препарата:</label>
            <select class="block_sp_2" name="type_of_treatment" value="" keydown="" required><?php echo Preparat() ?></select>
        </div>
    </div>
    <div class="blockk">
        <label class="text_menu3" for="recept_spisock">Реакция и уровень: </label>
        <select name="recept_spisock" class="block_sp_2" keydown="" required><?php echo $reakciya->ReUr(); ?></select>
    </div>
    <div class="block_string hr">
        <input name="ress" class="bottom_" type="submit" value="Очистка формы">
        <input class="bottom_" name="ad_man" type="submit" value="Ок">
    </div>
    </div>
</form>
<?php } else {
    include 'component/ad_manual.php';
}
} ?>
