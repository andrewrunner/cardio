<!-- Общая часть для анкеты, крови и экг -->
<div class="block">
    <div class="blockk">
        <?php echo Saboliv(); ?>
    </div>    
    <div class="blockk">
        <label class="text_menu3" for="personal_anceta">Выбрать пользователя:</label>
        <select class="block_sp_2" name="personal_anceta" required>
            <?php echo STRPolsovateli(); ?>
        </select>
    </div>
    <div class="blockk">
        <label class="text_menu3" for="price_usluga">Цена:</label>
        <input name="price_usluga" class="block_sp" required>
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