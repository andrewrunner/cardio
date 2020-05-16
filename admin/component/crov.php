<?php
// Обработка крови
if ($_POST['krov']) {

    $res_crov = new Crov;

    // Обработка по крови
    $res_crov->post = $_POST;
    $procent_otcloneniya = $res_crov->PrcentOtcloneniya();

    $datestart = 11; // количество дней
    $biostemulyator = $_POST['type_of_treatment'];

    // Получение таблицы оздоровления
    $zrt = TableReceptOsdorovlenia([
        'polnuh' => $_POST['dni'], // десятидневки
        'datestart' => $datestart,
        'biostemulyator' => $biostemulyator,
        'colors' => $procent_otcloneniya[2],
        'preduprejdenie' => $preduprejdenie,
        'categoris' =>  $procent_otcloneniya[3],
        'opisanie_urovnya_zdorovia' => $procent_otcloneniya[5],
        'reakciya_aktivacii' => $procent_otcloneniya[6],
        'opisanie_primenenie' => $procent_otcloneniya[7],
        'sostoyanie' => $procent_otcloneniya[8],
        'rec' => $rec,
        'mnojitel' => $_POST['mnojitel']
    ]);

    // записываем результат в базу данных
    $save_test->data_test = [
        'id' => $_SESSION['data_personal']['id'],
        'categories' => $procent_otcloneniya[3],
        'groups' => 'crov',
        'data' => date('d.m.Y'),
        'mnojitel' => $_POST['mnojitel']
    ];
    $save_test->SaveResultTest();

    // Списание со счета суммы за услугу
    ValutAncetReserv([
        'price' => $_POST['price_usluga'],
        'valuta' => $_POST['valuta_uslugi'],
        'val_pol' => $valuta_polsovatela->ValutaPolsovatela(),
        'summa' => $valuta_polsovatela->SummaPolsovatela(),
        'otr' => $valuta_polsovatela->OtricatelnoPolsovatela(),
        'name_usluga' => 'krov',
        'name' => 'Расчет по крови',
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
