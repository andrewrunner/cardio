<?php
for ($i = 0; $i < 11; $i++) {
    foreach (Data(OPROS) as $item) {
        $proverka = $_POST['sost' . $i];

        if ($proverka == $item['-3']) {
            $ttr = -3;
        } elseif ($proverka == $item['-2']) {
            $ttr = -2;
        } elseif ($proverka == $item['-1']) {
            $ttr = -1;
        } elseif ($proverka == $item['0']) {
            $ttr = 0;
        } elseif ($proverka == $item['+1']) {
            $ttr = 1;
        } elseif ($proverka == $item['+2']) {
            $ttr = 2;
        } elseif ($proverka == $item['+3']) {
            $ttr = 3;
        }

        if ($i > 0) {
            ${'s' . $i} = $ttr;
        }
    }
}

$result = mysqli_query($mysqli, "SELECT * FROM " . OPROS_ANCETA) or die("Ошибка " . mysqli_error($mysqli));
$rows = mysqli_num_rows($result);

for ($t = 0; $t < $rows; $t++) {
    $row = mysqli_fetch_row($result);

    for ($luo = 1; $luo < 11; $luo++) {
        ${'oprosnick' . $luo} = explode(',', $row[$luo + 1]);

        if (${'oprosnick' . $luo}) {
            ${'group_ravinstva' . $luo} = (${'s' . $luo} == ${'oprosnick' . $luo}[0]);
        }

        if (${'group_ravinstva' . $luo}) {
            $procent[$t][0] += 10;
            $procent[$t][1] = $row[0];
        }
    }

    if ($group_ravinstva1 && $group_ravinstva2 && $group_ravinstva3 && $group_ravinstva4 && $group_ravinstva5 && $group_ravinstva6 && $group_ravinstva7 && $group_ravinstva8 && $group_ravinstva9 && $group_ravinstva10) {
        $idpro = $row[0];
    }

    unset($group_ravinstva1, $group_ravinstva2, $group_ravinstva3, $group_ravinstva4, $group_ravinstva5, $group_ravinstva6, $group_ravinstva7, $group_ravinstva8, $group_ravinstva9, $group_ravinstva10);
}

// Выбор найбольшего значения
rsort($procent);
$kl = $procent[0][0];
$rows = count($procent);

for ($u = 0; $u < $rows; $u++) {
    if ($procent[$u][0] == $kl) {
        $df++;
        $procent_new[$df] = $procent[$u];
    }
}

sort($procent_new);
$procent = $procent_new;
$procent_ukasatel = 10; // 30

if ($procent[0][0] <= ($procent_ukasatel + 10)) {
    $preduprejdenie = '<p>Ваш результат меньше допустимого <a href="#">отправить оператору</a> на проверку.</p>';
}

$srednie = ceil(($procent[count($procent) - 1][1] + $procent[0][1]) / 2);

//	Вывести проценты достоверности оператору
if ($idpro != NULL) {
    foreach (Data(ZACLUCHENIE) as $item) {
        for ($luo = 1; $luo < 11; $luo++) {
            if ($item['id'] == $idpro) {
                $opisanie_urovnya_zdorovia = $item['status'];
                $reakciya_aktivacii = $item['uroven_riakciy'];
                $opisanie_primenenie = $item['comentari'];
            }
        }
    }

    foreach (Data(DZ) as $item) {
        if ($item['id'] == $idpro) {
            $categoris = $item['categori'];
            $ress = $item['tegi'];
            $colors = $item['color'];
            $id_out = $item['id'];
            $sostoyanie = $item['sostoyanie'];
        }
    }

    $id_18sost_3 = $idpro * 3;
}

if ($procent[0][0] >= $procent_ukasatel) {
    foreach (Data(ZACLUCHENIE) as $item) {
        for ($luo = 1; $luo < 11; $luo++) {
            if ($item['id'] == $srednie) {
                $opisanie_urovnya_zdorovia = $item['status'];
                $reakciya_aktivacii = $item['uroven_riakciy'];
                $opisanie_primenenie = $item['comentari'];
            }
        }
    }

    foreach (Data(DZ) as $item) {
        if ($item['id'] == $srednie) {
            $categoris = $item['categori'];
            $ress = $item['tegi'];
            $colors = $item['color'];
            $id_out = $item['id'];
            $sostoyanie = explode(',', $item['sostoyanie']);
        }
    }

    $id_18sost_3 = $procent[0][1] * 3;
}