<?php
if ($_POST['ekgres']) {

    if ($_POST['ichemiya'] == 'on' || $_POST['gipertoniya'] == 'on' || $_POST['infarkt'] == 'on') {
        $bolesni = 'on';
    } else {
        $bolesni = 'off';
    }

    $ecg_obr = new ECG;
    $ecg_obr->post = [
        'bolesni' => $bolesni,
        'type_of_treatment' => $_POST['type_of_treatment'],
        'zona' => $_POST['fg'],
        'num1' => $_POST['num1'],
        'num2' => $_POST['num2']
    ];
    $_ds = $ecg_obr->ProcentOtclECG(); // обработка

    $datestart = 11; // количество дней

    // Получение таблицы оздоровления
    $zrt = TableReceptOsdorovlenia([
        'polnuh' => $_POST['dni'], // десятидневки
        'datestart' => $datestart,
        'biostemulyator' => $_POST['type_of_treatment'], 
        'colors' => $_ds[3]['color'],
        'preduprejdenie' => $preduprejdenie,
        'categoris' =>  $_ds[3]['categories'],
        'opisanie_urovnya_zdorovia' => $_ds[0],
        'reakciya_aktivacii' => $_ds[1],
        'opisanie_primenenie' => $_ds[2],
        'sostoyanie' => $_ds[3]['sostoyanie'],
        'rec' => $rec,
        'mnojitel' => $_POST['mnojitel']
    ]);

    // записываем результат в базу данных
    $save_test->data_test = [
        'id' => $_SESSION['data_personal']['id'],
        'categories' => $_ds[3]['categories'],
        'groups' => 'ecg',
        'data' => date('d.m.Y'),
        'mnojitel' => $_POST['mnojitel'] //нетлимита
    ];
    $save_test->SaveResultTest();

    // Списание со счета суммы за услугу  
    ValutAncetReserv([
        'price' => $_POST['price_usluga'],
        'valuta' => $_POST['valuta_uslugi'],
        'val_pol' => $valuta_polsovatela->ValutaPolsovatela(),
        'summa' => $valuta_polsovatela->SummaPolsovatela(),
        'otr' => $valuta_polsovatela->OtricatelnoPolsovatela(),
        'name_usluga' => 'ecg',
        'name' => 'Расчет по ЭКГ',
        'table' => $zrt[0]
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