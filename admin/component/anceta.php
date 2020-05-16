<?php
//	Вывод таблицы и расчет первой дозы, выбор с таблицы, анкета, кардиограмма, кров
if ($_GET['tablet'] == 'table') {
	if ($_POST['opros']) {

		// Обработка данных анкеты
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

			foreach (Data(DZ) as $item) { //ghjdthrf
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
/**
 * переподключение к внешнему
 * обработчику по счетам
 */
		// Вывод таблицы
		if ($procent[0][0] >= $procent_ukasatel) { // Таблица
			$datestart = 11; // количество дней

			// Получение таблицы оздоровления
			$zrt = TableReceptOsdorovlenia([
				'polnuh' => $_POST['dni'], // десятидневки
				'datestart' => $datestart,
				'biostemulyator' => $_POST['type_of_treatment'],
				'colors' => $colors,
				'preduprejdenie' => $preduprejdenie,
				'categoris' => $categoris,
				'opisanie_urovnya_zdorovia' => $opisanie_urovnya_zdorovia,
				'reakciya_aktivacii' => $reakciya_aktivacii,
				'opisanie_primenenie' => $opisanie_primenenie,
				'sostoyanie' => $sostoyanie,
				'rec' => $rec,
				'mnojitel' => $_POST['mnojitel']
			]);

			// записываем результат в базу данных
			$save_test->data_test = [
				'id' => $_SESSION['data_personal']['id'],
				'categories' => $categoris,
				'groups' => 'anketa',
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
				'name_usluga' => 'anketa',
				'name' => 'Расчет по анкете', // проверить
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
		} else {
			echo '<br><div class="block_ancetu"><p style="color: red; font-size: 25px;">Введены противоречивые данные. Пожалуйста, заполните анкету с новыми данными!</p></div><br>';
		}
	}
}
unset($_SESSION['data_personal']);
