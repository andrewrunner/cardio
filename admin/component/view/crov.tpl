<div class="block_string">
    <label class="text_menu2" for="lastname">Общие число лейкоцитов:</label>
    <input class="block_sp2" type="number" size="10" step="0.1" name="obthee_chislo_leycocitov" min="0"
        max="100" value="0" pattern="\d+(\,\d{2})?">
    <label class="text_menu2" style="width: 61px; padding: 0 0 0 20px;">(*10<sup>9</sup>)</label>
</div>
<fieldset class="crov100">
    <legend class="crov100legeng">Сумма должна быть равна 100 %</legend>
    <div class="nameblock">
        <div class="block_string">
            <label class="text_menu2" for="lastname">Лимфоциты:</label>
            <input class="block_sp2" type="number" size="10" step="0.5" name="limficitu" min="0" max="100" value="0"
                pattern="\d+(\,\d{2})?">
        </div>
        <div class="block_string">
            <label class="text_menu2" for="lastname">Эозинофилы:</label>
            <input class="block_sp2" type="number" size="10" step="0.5" name="eosinofilu" min="0" max="100" value="0"
                pattern="\d+(\,\d{2})?">
        </div>
        <div class="block_string">
            <label class="text_menu2" for="lastname">Моноциты:</label>
            <input class="block_sp2" type="number" size="10" step="0.5" name="monocitu" min="0" max="100" value="0"
                pattern="\d+(\,\d{2})?">
        </div>
    </div>
    <div class="nameblock">
        <div class="block_string">
            <label class="text_menu2" for="lastname">Базофилы:</label>
            <input class="block_sp2" type="number" size="10" step="0.5" name="basofilu" min="0" max="100" value="0"
                pattern="\d+(\,\d{2})?">
        </div>
        <div class="block_string">
            <label class="text_menu2" for="lastname">Палочкоядерные нейтрофилы:</label>
            <input class="block_sp2" type="number" size="10" step="0.5" name="paloch_neytrofilu" min="0" max="100"
                value="0" pattern="\d+(\,\d{2})?">
        </div>
        <div class="block_string">
            <label class="text_menu2" for="lastname">Сегментоядерные нейтрофилы:</label>
            <input class="block_sp2" type="number" size="10" step="0.5" name="segmento_neytrofilu" min="0" max="100"
                value="0" pattern="\d+(\,\d{2})?">
        </div>
    </div>
</fieldset>
<div class="block_string">
    <fieldset class="fiel">
        <legend>Токсическая зернистость</legend>
        <input type="radio" name="sernistost" id="cletka1" value="on"><label class="radio-inline"
            for="cletka">Есть</label>
        <input type="radio" name="sernistost" id="cletka2" value="off" checked><label class="radio-inline"
            for="cletka">Нет</label>
    </fieldset>
    <fieldset class="fiel">
        <legend>Плазматические клетки</legend>
        <input type="radio" name="cletka" id="cletka1" value="on"><label class="radio-inline"
            for="cletka">Есть</label>
        <input type="radio" name="cletka" id="cletka2" value="off" checked><label class="radio-inline"
            for="cletka">Нет</label>
    </fieldset>
</div>
<?php echo $procent_otcloneniya[1]; ?>
