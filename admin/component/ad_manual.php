<?php
// Обработка ad_base
if ($_POST['ad_man']) {
    $TRO = new TableReceptOs;
    $ad_base = new ECG;
    
    if ($_POST['ichemiya'] == 'on' || $_POST['gipertoniya'] == 'on' || $_POST['infarkt'] == 'on') {
        $bolesni = 'on';
    } else {
        $bolesni = 'off';
    }
    
    // Получение таблицы оздоровления  
    $zrt = $TRO->TableRecept([
        'polnuh' => $_POST['dni'], // десятидневки
        'datestart' => 11,
        'name' => $_POST['personal_anceta'],
        'price' => $_POST['price_usluga'],
        'valuta' => $_POST['valuta_uslugi'],
        'biostemulyator' => $_POST['type_of_treatment'],
        'bolesni' =>  $bolesni,
        'preduprejdenie' => $preduprejdenie,
        'rec' => $rec,
        'mnojitel' => $_POST['mnojitel'],
        'recept_spisock' => $_POST['recept_spisock']
    ]);
    		
    // внесение результата в примечание
    if ($zrt) {
        $id_user = $_SESSION['data_personal']['id'];
        $primeth = 'Повторите расчёт рецепта АО';

        for ($i = 0; $i < 3; $i++) {
            $data_prohod = $zrt[2][$i];
            $mysqli->query("INSERT INTO " . CALENDAR . " (`iduser`, `primeth`, `data`) VALUES ('$id_user', '$primeth', '$data_prohod')");
        }
    }

    // Определяем показ файла пользователю
    echo $zrt[0];
}