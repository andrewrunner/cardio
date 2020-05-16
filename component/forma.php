<?php
$save_test = new SaveDiagrams;

if ($_POST['ichemiya'] == 'on' || $_POST['gipertoniya'] == 'on' || $_POST['infarkt'] == 'on') {
    $_SESSION['perenesenue_sabolevaniya'] = 'on';
}

if ($_POST['forma']) {
    $id = RegistrationClient($_POST);
}

$ao = 'Повторите расчёт рецепта АО';
$init = Initialisacia($_SESSION);
$_SESSION['polnuh_let'] = $init[1]; // Вывод полных лет
$_SESSION['data_personal']['polnuh_let'] = $init[1]; // Вывод дополнительно полных лет
$_SESSION['pol'] = $init[2]; // Вывод полных лет

//	Вывод таблицы и расчет первой дозы, выбор с таблицы, анкета, кардиограмма, кров
if ($_GET['tablet'] == 'table') {
    if ($_POST['opros']) {

        // Обработка данных анкеты
        require_once OBRANCET; // component/obr_ancet.php

        // Вывод таблицы
        if ($procent[0][0] >= $procent_ukasatel) { // Таблица
            $polnuh = 3; // циклы, вывод количества 10-дневок
            $datestart = 11; // количество дней

            // Получение таблицы оздоровления
            $zrt = TableReceptOsdorovlenia([
                'polnuh' => $polnuh,
                'datestart' => $datestart,
                'biostemulyator' => $_POST['type_of_treatment'],
                'colors' => $colors,
                'preduprejdenie' => $preduprejdenie,
                'categoris' => $categoris,
                'opisanie_urovnya_zdorovia' => $opisanie_urovnya_zdorovia,
                'reakciya_aktivacii' => $reakciya_aktivacii,
                'opisanie_primenenie' => $opisanie_primenenie,
                'sostoyanie' => $sostoyanie,
                'rec' => $rec
            ]);

            // записываем результат в базу данных диаграммы
            $save_test->data_test = [
                'id' => IdClient($_SESSION),
                'categories' => $categoris,
                'groups' => 'anketa',
                'data' => date('d.m.Y')
            ];
            $save_test->SaveResultTest();

            // Определяем показ файла пользователю
            if (SredstvaChet('Анкетирование')) {
                echo $zrt[0];
                $no_visibiliti = 'on';
                $reserv_summa = '0-' . $_SESSION['price']['valuta'];
            } else {
                echo '<br><div class="block_ancetu"><p style="color: red; font-size: 25px;">Недостаточно средств на счету!<br>Пополните счет для просмотра сохраненного файла!</p></div>';
                $no_visibiliti = 'off';
                $reserv_summa = $_SESSION['price']['price'] . '-' . $_SESSION['price']['valuta'];
            }

            // если  результат, то записываем его в файл
            if ($zrt[0]) {

                if ($zrt[2]) {
                    $id_user = IdClient($_SESSION);
                    $primeth = $ao;

                    for ($i = 0; $i < 3; $i++) {
                        $data_prohod = $zrt[2][$i];
                        $mysqli->query("INSERT INTO " . CALENDAR . " (`iduser`, `primeth`, `data`) VALUES ('$id_user', '$primeth', '$data_prohod')");
                    }
                }

                file_put_contents('histori/' . IdClient($_SESSION) . '.' . date('d-m-Y') . '.' . $no_visibiliti . '.' . 'anketa.' . $reserv_summa . '.tpl', $zrt[0]); // занести в базу данных результат
            }
        } else {
            echo '<br><div class="block_ancetu"><p style="color: red; font-size: 25px;">Введены противоречивые данные. Пожалуйста, заполните анкету с новыми данными!</p></div><br>';
        }

        // Запись в реестр результатов
        $fio = $_SESSION['lastname'] . ' ' . $_SESSION['firstname'] . ' ' . $_SESSION['middlename'];

        $result = $mysqli->query("INSERT INTO " . RESULT_ANCET . " (`fio`, `1`, `2`, `3`, `4`, `5`, `6`, `7`, `8`, `9`, `10`, `reacktivnost`, `recept`) VALUES ('$fio', '$sostoyanie1', '$sostoyanie2', '$sostoyanie3', '$sostoyanie4', '$sostoyanie5', '$sostoyanie6', '$sostoyanie7', '$sostoyanie8', '$sostoyanie9', '$sostoyanie10', '$reactivnost', '')");
    }
}

// Обработка крови
if ($_POST['krov']) {
    $polnuh_let = $init[1];

    $res_crov = new Crov;

    // Обработка по крови
    $res_crov->post = $_POST;
    $procent_otcloneniya = $res_crov->PrcentOtcloneniya();

    // Получение таблицы оздоровления
    $zrt = TableReceptOsdorovlenia([ //  проблема когда 12 лимфоциты
        'polnuh' => 3, // циклы, вывод количества 10-дневок
        'datestart' => 11, // количество дней
        'biostemulyator' => $_POST['type_of_treatment'],
        'colors' => $procent_otcloneniya[2],
        'preduprejdenie' => $preduprejdenie,
        'categoris' =>  $procent_otcloneniya[3],
        'opisanie_urovnya_zdorovia' => $procent_otcloneniya[5],
        'reakciya_aktivacii' => $procent_otcloneniya[6],
        'opisanie_primenenie' => $procent_otcloneniya[7],
        'sostoyanie' => $procent_otcloneniya[8],
        'rec' => $rec
    ]);

    // записываем результат в базу данных
    $save_test->data_test = [
        'id' => IdClient($_SESSION),
        'categories' => $procent_otcloneniya[3],
        'groups' => 'crov',
        'data' => date('d.m.Y')
    ];
    $save_test->SaveResultTest();

    // Определяем показ файла пользователю
    if (SredstvaChet('Обработка по крови')) {
        echo $zrt[0];
        $no_visibiliti = 'on';
        $reserv_summa = '0-' . $_SESSION['price']['valuta'];
    } else {
        echo '<br><div class="block_ancetu"><p style="color: red; font-size: 25px;">Недостаточно средств на счету!<br>Пополните счет для просмотра сохраненного файла!</p></div>';
        $no_visibiliti = 'off';
        $reserv_summa = $_SESSION['price']['price'] . '-' . $_SESSION['price']['valuta'];
    }

    // если  результат, то записываем его в файл
    if ($zrt[0]) {

        if ($zrt[2]) {
            $id_user = IdClient($_SESSION);
            $primeth = $ao;

            for ($i = 0; $i < 3; $i++) {
                $data_prohod = $zrt[2][$i];
                $mysqli->query("INSERT INTO " . CALENDAR . " (`iduser`, `primeth`, `data`) VALUES ('$id_user', '$primeth', '$data_prohod')");
            }
        }

        file_put_contents('histori/' . IdClient($_SESSION) . '.' . date('d-m-Y') . '.' . $no_visibiliti . '.' . 'krov.' . $reserv_summa . '.tpl', $zrt[0]);
    }
}

// Обработка ЭКГ
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
    $_ds = $ecg_obr->ProcentOtclECG();

    // Переписать проверку
    $polnuh_let = $init[1];

    $polnuh = 3; // циклы, вывод количества 10-дневок
    $datestart = 11; // количество дней

    // Получение таблицы оздоровления
    $zrt = TableReceptOsdorovlenia([
        'polnuh' => $polnuh,
        'datestart' => $datestart,
        'biostemulyator' => $_POST['type_of_treatment'],
        'colors' => $_ds[3]['color'],
        'preduprejdenie' => $preduprejdenie,
        'categoris' =>  $_ds[3]['categories'],
        'opisanie_urovnya_zdorovia' => $_ds[0],
        'reakciya_aktivacii' => $_ds[1],
        'opisanie_primenenie' => $_ds[2],
        'sostoyanie' => $_ds[3]['sostoyanie'],
        'rec' => $rec
    ]);

    // записываем результат в базу данных
    $save_test->data_test = [
        'id' => IdClient($_SESSION),
        'categories' => $_ds[3]['categories'],
        'groups' => 'ecg',
        'data' => date('d.m.Y')
    ];
    $save_test->SaveResultTest();

    // Определяем показ файла пользователю
    if (SredstvaChet('Обработка по ЭКГ')) {
        echo $zrt[0];
        $no_visibiliti = 'on';
        $reserv_summa = '0-' . $_SESSION['price']['valuta'];
    } else {
        echo '<br><div class="block_ancetu"><p style="color: red; font-size: 25px;">Недостаточно средств на счету!<br>Пополните счет для просмотра сохраненного файла!</p></div>';
        $no_visibiliti = 'off';
        $reserv_summa = $_SESSION['price']['price'] . '-' . $_SESSION['price']['valuta'];
    }

    // если  результат, то записываем его в файл
    if ($zrt[0]) {

        if ($zrt[2]) {
            $id_user = IdClient($_SESSION);
            $primeth = $ao;

            for ($i = 0; $i < 3; $i++) {
                $data_prohod = $zrt[2][$i];
                $mysqli->query("INSERT INTO " . CALENDAR . " (`iduser`, `primeth`, `data`) VALUES ('$id_user', '$primeth', '$data_prohod')");
            }
        }

        file_put_contents('histori/' . IdClient($_SESSION) . '.' . date('d-m-Y') . '.' . $no_visibiliti . '.' . 'ecg.' . $reserv_summa . '.tpl', $zrt[0]);
    }
}

//	Вывод по анкетированию и другой диагностике
if ($_GET['vuboranket'] == 'anketa') { // Расчет по анкете 
    if ($id_oprosnic <= 0) {
        $id_oprosnic = 1;
    }

    $id_oprosnic = $_GET['id_oprosnic'] + 1;

    if (!$_POST['opros']) {
        $tabu = Tabu();

        if ($tabu[0]['anketa']) {
            echo '<p class="errors">Вы не можете больше пройти анкетирование! Следующая дата прохождения: ' . $tabu[1]['anketa'] . '</p>';
        } else {
            include OPROSS; // анкета
        }
    }
} elseif ($_GET['vuboranket'] == 'crow') { // Расчет по крови
    $tabu = Tabu();

    if ($tabu[0]['krov']) {
        echo '<p class="errors">Вы не можете больше пройти тестирование по крови! Следующая дата прохождения: ' . $tabu[1]['krov'] . '</p>';
    } else {
        include CROV; // вывод предупреждения
    }
} elseif ($_GET['vuboranket'] == 'kardio') { // Расчет по ЭКГ
    $tabu = Tabu();

    if ($tabu[0]['ecg']) {
        echo '<p class="errors">Вы не можете больше пройти тестирование по ЭКГ! Следующая дата прохождения: ' . $tabu[1]['ecg'] . '</p>';
    } else {
        include ECG; // доработать
    }
} else {
    if (!$_GET['tablet'] && !$_GET['krov'] && !$_GET['ecg']) {
        include MENU; // Меню выбора расчета
    }
}

unset($_SESSION['perenesenue_sabolevaniya']);
