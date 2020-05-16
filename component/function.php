<?php
/* 
    Набор функций для работы с клиентом 
*/
function Data($db)
{
	include CONECT;
	$result = mysqli_query($mysqli, "SELECT * FROM " . $db) or die("Ошибка " . mysqli_error($mysqli));
	while ($row = mysqli_fetch_array($result)) {
		$public[] = $row;
	}
	mysqli_free_result($result);
	return $public;
}

function get_ip()
{
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}

function ValutaCof()
{
	foreach (Data(VALUTA) as $item) {
		if ($item['valuta'] == 'грн') {
			$grn = $item['coeficient'];
		}

		if ($item['valuta'] == 'руб') {
			$rub = $item['coeficient'];
		}

		if ($item['valuta'] == 'cor') {
			$cor = $item['coeficient'];
		}

		if ($item['valuta'] == 'eur') {
			$eur = $item['coeficient'];
		}
	}
	return [
		"grn" => $grn,
		"rub" => $rub,
		"cor" => $cor,
		"eur" => $eur
	];
}

class Calculator
{
	private $valuta;
	private $summa;
	private $out_valute;

	public function __construct($valuta, $summa, $out_valuta)
	{
		$this->valuta = $valuta;
		$this->summa = $summa;
		$this->out_valute = $out_valuta;
	}

	public function Calk()
	{
		foreach (Data(VALUTA) as $item) {
			if ($item['valuta'] == $this->valuta) {
				$result = ConverterValut($this->valuta, $this->summa, $this->out_valute);
				break;
			}
		}

		return $result;
	}
}

class Calendar
{
	public $mount;
	public $text;
	public $year;

	public function CalendarOz()
	{
		foreach (Data(POLSOVATEL) as $item) {
			if ($_SESSION['login'] == $item['login'] && $_SESSION['password'] == $item['password']) {
				$userid = $item['id'];
			}
		}

		// получаем данные календаря
		foreach (Data(CALENDAR) as $item) {

			if ($userid == $item['iduser'] && $this->mount == date('m', strtotime($item['data'])) && $this->year == date('Y', strtotime($item['data'])) || ($item['d'] != '' && $item['m'] == '')) {
				// повторения к шаблону накаждый месяц на день
				$primer[] = $item['primeth'];

				// назначаем цвет для шаблонных и персональных данных
				if ($item['formulaic'] == 'on' || $item['d'] != '') {
					$colors[] = ' style="background: green;"';
				} else {
					$colors[] = ' style="background: red;"';
				}

				if ($item['data']) {
					$dataprimera[] = date('d', strtotime($item['data']));
				} elseif ($item['data'] == '' && ($item['n'] != '' || $item['d'] != '')) {
					if ($item['d']) {
						$dataprimera[] = $item['d'];
					}
				}
			} elseif ($item['n'] != '' && $item['m'] == '') {
				// если на неделю
				$nedela[] = $item['primeth'];
				$n[] = $item['n'];
			} elseif ($userid == $item['iduser'] && $item['m'] != '' && $item['n'] != '') {
				// на день недели
				$data_m = explode(',', $item['m']);

				$rows = count($data_m);
				for ($w = 0; $w < $rows; $w++) {
					if ($data_m[$w] == $this->mount) {
						$variable_month[] = $item['primeth'];
						$m[] = $data_m[$w];
						$ned_m[] = $item['n'];
					}
				}
			} elseif ($userid == $item['iduser'] && $item['m'] != '' && $item['d'] != '') {
				// на день месяца
				$data_dm = explode(',', $item['m']);

				$rows = count($data_dm);
				for ($s = 0; $s < $rows; $s++) {
					if ($data_dm[$s] == $this->mount) {
						$variable_dm[] = $item['primeth'];
						$dm[] = $data_dm[$s];
						$d[] = $item['d'];
					}
				}
			}
		}

		$dayofmonth = date('t');
		$day_count = 1;
		$num = 0;
		// заносим данные в массив
		for ($i = 0; $i < 7; $i++) {
			$dayofweek = date('w', mktime(0, 0, 0, date($this->mount), $day_count, $this->year));
			$dayofweek = $dayofweek - 1;
			if ($dayofweek == -1) $dayofweek = 6;
			if ($dayofweek == $i) {
				$week[$num][$i] = $day_count;
				$day_count++;
			} else {
				$week[$num][$i] = "";
			}
		}

		// получаем данные из массива
		while (true) {
			$num++;
			for ($i = 0; $i < 7; $i++) {
				$week[$num][$i] = $day_count;
				$day_count++;
				if ($day_count > $dayofmonth) break;
			}
			if ($day_count > $dayofmonth) break;
		}

		$rows = count($week);
		$f = '';
		$ned = '';
		$month_m = '';
		$month_dm = '';
		$f .= '<h1>' . $this->text . '</h1>';

		for ($i = 0; $i < $rows; $i++) {
			$f .= '<div class="cal_bord">';
			for ($j = 0; $j < 7; $j++) {
				if (!empty($week[$i][$j])) {
					$ww = $week[$i][$j];

					// обрабатываем данные на число указанные
					$rowss = count($dataprimera);
					for ($rd = 0; $rd < $rowss; $rd++) {
						if ($ww == $dataprimera[$rd]) {
							$xc = $dataprimera[$rd];
							$el[] = '<div class="primeth"' . $colors[$rd] . '>' . $primer[$rd] . '</div>';
						}
					}

					// собараем из массива
					if ($ww == $xc) {
						$ssd = implode('', $el);
					} else {
						$ssd = '';
					}

					// на каждую неделю
					$rowsd = count($n);
					for ($u = 0; $u < $rowsd; $u++) {
						if ($n[$u] == $j) {
							$ned .= '<div class="primeth"' . $colors[$rd] . '>' . $nedela[$u] . '</div>';
						} else {
							$ned .= '';
						}
					}

					// выводим на неделю персонально
					$rowsm = count($m);
					for ($s = 0; $s < $rowsm; $s++) {
						if ($ned_m[$s] == $j) {
							$month_m .= '<div class="primeth" style="background: red;">' . $variable_month[$s] . '</div>';
							unset($ned_m[$s], $m[$s], $variable_month[$s]);
						} else {
							$month_m .= '';
						}
					}

					// выводим на день месяца персонально
					$rowsm = count($d);
					for ($s = 0; $s < $rowsm; $s++) {
						if ($d[$s] == $ww && $dm[$s] == $this->mount) {
							$month_dm .= '<div class="primeth" style="background: red;">' . $variable_dm[$s] . '</div>';
						} else {
							$month_dm .= '';
						}
					}

					// выводим результат
					if ($j == 5 || $j == 6) {
						$f .= '<div class="kaly"><font color=red>' . $week[$i][$j] . '</font>' . $ssd . $ned . $month_m . $month_dm . '</div>';
					} else {
						$f .= '<div class="kaly">' . $week[$i][$j] . '' . $ssd . $ned . $month_m . $month_dm . '</div>';
					}
				} else {
					$f .= '<div class="kaly">&nbsp;</div>';
				}
				unset($el, $ned, $month_m, $month_dm);
			}
			$f .= '</div>';
		}
		return $f;
	}
}

class Diagramma
{
	public $data; // подставляем месяц
	public $year;
	public $name;

	// получаем данные с базы диаграммы
	public function Diagrams($groups) //
	{
		$id = IdClient();
		$mounth_start = '01.' . $this->data;
		$rows = date('t', strtotime($mounth_start));

		for ($i = 0; $i < $rows; $i++) {
			$massiv_res_diagn[$i] = '';
			$data_month = date('d.m.Y', strtotime($mounth_start . '+' . $i . 'days'));

			foreach (Data(DIAGRAMMA) as $item) {
				if ($id == $item['id_client']) {
					if ($data_month == $item['data'] && $groups == $item['groups']) {
						$massiv_res_diagn[$i] = [
							'categories' => $item['categories'],
							'pocasatel' => $item['pocasatel'],
							'color' => $item['color']
						];
					}
				}
			}
		}

		return $massiv_res_diagn;
	}

	public function DiagRes($groups)
	{
		$id = IdClient($_SESSION);
		$mounth_start = date('01.01.' . $this->year);

		for ($i = 0; $i < 12; $i++) {
			$massiv_res_diagn[$i] = '';
			$mounth = date('m', strtotime($mounth_start . '+' . $i . 'month'));

			foreach (Data(DIAGRAMMA) as $item) {
				if ($id == $item['id_client']) {
					if ($mounth == date('m', strtotime($item['data'])) && $this->year == date('Y', strtotime($item['data'])) && $groups == $item['groups']) {
						$massiv_res_diagn[$i] = [
							'categories' => $item['categories'],
							'pocasatel' => $item['pocasatel'],
							'color' => $item['color']
						];
					}
				}
			}
		}
		return $massiv_res_diagn;
	}
}

function Nameclient()
{
	foreach (Data(POLSOVATEL) as $item) {
		if ($_SESSION['login'] == $item['login'] && $_SESSION['password'] == $item['password']) {
			$name = $item['lastname'] . ' ' . $item['firstname'] . ' ' . $item['middlename'];
			break;
		}
	}
	return $name;
}

function IdClient()
{
	foreach (Data(POLSOVATEL) as $item) {
		if ($_SESSION['login'] == $item['login'] && $_SESSION['password'] == $item['password']) {
			$id = $item['id'];
			break;
		}
	}
	return $id;
}

function Basis($new_post, $limm, $file_set, $dann, $new_session)
{
	$text = '';
	if ($new_post['basis']) {
		$text .= '<div class="form_table2"><div style="width: 350px; float: left;">';

		if ($new_post['lastname'] == "" || $new_post['lastname'] == " ") {
			$text .= '<div class="part"><b>Фамилия: </b> <span style="color: red;">Вы не ввели фамилию</span></div>';
		} elseif ($new_post['lastname'] != "" || $new_post['lastname'] != " ") {
			$text .= '<div class="part"><b>Фамилия: </b> ' . $new_post["lastname"] . '</div>';
		}

		if ($new_post['firstname'] == "" || $new_post['firstname'] == " ") {
			$text .= '<div class="part"><b>Имя: </b> <span style="color: red;">Вы не ввели имя</span></div>';
		} elseif ($new_post['firstname'] != "" || $new_post['firstname'] != " ") {
			$text .= '<div class="part"><b>Имя: </b> ' . $new_post["firstname"] . '</div>';
		}

		if ($new_post['middlename'] == "" || $new_post['middlename'] == " ") {
			$text .= '<div class="part"><b>Отчество: </b> <span style="color: red;">Вы не ввели отчество</span></div>';
		} elseif ($new_post['middlename'] != "" || $new_post['middlename'] != " ") {
			$text .= '<div class="part"><b>Имя: </b> ' . $new_post["middlename"] . '</div>';
		}

		if ($new_post['dat'] == "" || $new_post['dat'] == " ") {
			$text .= '<div class="part"><b>Дата: </b> <span style="color: red;">Вы не ввели дату</span></div>';
		} elseif ($new_post['dat'] != "" || $new_post['dat'] != " ") {
			$text .= '<div class="part"><b>Дата рождения: </b> ' . $new_post['dat'] . '</div>';
		}

		if ($new_post['email'] == "" || $new_post['email'] == " ") {
			$text .= '<div class="part"><b>E-mail:</b> <span style="color: red;">Вы не ввели E-mail</span></div>';
		} elseif ($new_post['email'] != "" || $new_post['email'] != " ") {
			$text .= '<div class="part"><b>E-mail:</b> ' . $new_post['email'] . '</div>';
		}

		if ($new_post['email'] == "" || $new_post['email'] == " ") {
			$text .= '<div class="part"><b>Страна проживания:</b> <span style="color: red;">Вы не ввели страну проживания</span></div>';
		} elseif ($new_post['email'] != "" || $new_post['email'] != " ") {
			$text .= '<div class="part"><b>Страна проживания:</b> ' . $new_post['strana'] . '</div>';
		}

		if ($new_post['number_personal'] == "" || $new_post['number_personal'] == " ") {
			$text .= '<div class="part"><b>Ваш персональный номер:</b></div>';
		} elseif ($new_post['email'] != "" || $new_post['email'] != " ") {
			$text .= '<div class="part"><b>Ваш персональный номер:</b> ' . $new_post['number_personal'] . '</div>';
		}

		if ($new_post['number_personal']) {
			$text .= '<div class="part"><b>Ваш лимит: </b><span style="color: blue;">' . $limm . '</span></div>';
		}

		if ($new_post['group'] == "" || $new_post['group'] == " ") {
			$text .= '<div class="part"><b>Ваша группа: </b></div>';
		} elseif ($new_post['email'] != "" || $new_post['email'] != " ") {
			$text .= '<div class="part"><b>Ваша группа: </b> ' . $new_post['group'] . '</div>';
		}

		$text .= '</div><div style="width: 825px; float: left;">';

		if ($new_post['state'] == "" || $new_post['state'] == " ") {
			$text .= '<div class="part"><b>Ваш пол:</b> <span style="color: red;">Вы не указали пол</span></div>';
		} elseif ($new_post['state'] != "" || $new_post['state'] != " ") {
			$text .= '<div class="part"><b>Ваш пол:</b> ' . $new_post['state'] . '</div>';
		}

		$text .= '<div class="part"><b>Жалобы: </b>' . $new_post["complaint"] . '</div>
        <div class="part"><b>Коментарии: </b>' . $new_post["comentari"] . '</div>';

		if ($new_post['position'] == "" || $new_post['position'] == " ") {
			$text .= '<div class="part"><b>Запись произведина:</b> <span style="color: red;">Вы не указали в каком положении произведена запись</span></div>';
		} elseif ($new_post['position'] != "" || $new_post['position'] != " ") {
			$text .= '<div class="part"><b>Положение:</b> ' . $new_post['position'] . '</div>';
		}

		if ($new_post['type_of_treatment'] == "" || $new_post['type_of_treatment'] == " ") {
			$text .= '<div class="part"><b>Вид обработки:</b> <span style="color: red;">Вы не указали вид обработки</span></div>';
		} elseif ($new_post['type_of_treatment'] != "" || $new_post['type_of_treatment'] != " ") {
			$new_type_of_treatment = explode(' * ', $new_post['type_of_treatment']);
			$text .= '<div class="part"><b>Тип обработки:</b> ' .  $new_type_of_treatment[0] . '</div>';
		}

		if (is_uploaded_file($_FILES["filename"]["tmp_name"])) {
			$text .= '<div class="part"><b>Данные:</b> <span style="color: red;">Вы не выбрали файл для обработки</span></div>';
		} elseif ($file_set) {
			$text .= '<div class="part"><b>Данные:</b> ' . $file_set . '</div>';
			$filename = $file_set;
		}

		if ($new_post['check'] == "" || $new_post['check'] == " ") {
			$text .= '<div class="part"><b>Подтверждение на обрадотку данных:</b> <span style="color: red;">Вы не подтвердили согласие на обработку данных</span></div>';
		} elseif ($new_post['check'] != "" || $new_post['check'] != " ") {
			$text .= '<div class="part"><b>Подтверждение на обрадотку:</b> Вы подтвердили обработку данных</div>';
		}

		$text .= '</div>';

		if ($new_post['type_of_treatment'] != "" || $new_post['type_of_treatment'] != " ") {
			foreach (Data(OBRABOTKA) as $item) {
				if ($item['name'] == $new_post['type_of_treatment']) {
					$new_session['summaopl'] = $item['price'];
					$text .= '<br><div style="width: 100%; float: left; font-size: 20px; color: #429eff; margin: 20px 0 10px;">Вы выбрали вид обработки: "' . $item['name'] . '", стоимость обработки файла ' . $item['price'] . ' cor.</div><br>';
					$_SESSION['vide_obr'] = $item['name'] . '-' . $item['price'];
				}
			}
			$text .= $dann;
		}
	}

	return $text;
}

function Autorisation($new_post)
{
	include CONECT;
	$lastname = 	$new_post['lastname'];
	$firstname = 	$new_post['firstname'];
	$middlename = 	$new_post['middlename'];
	$email = 		$new_post['email'];
	$strana = 		$new_post['strana'];
	$state =		$new_post['state'];
	$data =			$new_post['dat'];
	$phone = 		$new_post['phone'];
	$login = 		$new_post['login'];
	$password = 	md5($new_post['passwr']);
	$ip = 			get_ip();

	foreach (Data(POLSOVATEL) as $item) {
		if (($lastname == $item['lastname'] && $firstname == $item['firstname'] && $middlename == $item['middlename']) || $login == $item['login']) {
			$dann = '<div style="color: red; width: 100%; margin: 10px auto; float: left;"><b>Пользователь с такими данными уже существует! Попробуйте ввести другие значения!</b></div>';
			$blocer = 1;
		}
	}

	if ($blocer != 1) {
		$mysqli->query("INSERT INTO " . POLSOVATEL . " (`lastname`, `firstname`, `middlename`, `email`, `strana`, `state`, `data`, `phone`, `login`, `password`, `ip`, `group`) VALUES ('$lastname', '$firstname', '$middlename', '$email', '$strana', '$state', '$data', '$phone', '$login', '$password', '$ip', 'Инфогруппа')");
		foreach (Data(POLSOVATEL) as $item) {
			if ($lastname == $item['lastname'] && $firstname == $item['firstname'] && $middlename == $item['middlename']) {
				$id = $item['id'];
				$dann = '<div style="color: green; width: 100%; margin: 10px auto; float: left;"><b>Вы зарегистрированы с такими данными:</b><div>' . $lastname . ' ' . $firstname . ' ' . $middlename . '! Можите авторизоватся!</div></div>';
			}
		}
	}
	return $dann;
}

function EmailOplata()
{
	foreach (Data(EMAIL_OPLATA) as $item) {
		$emailotvet = $item['name'];
	}
	return $emailotvet;
}

function ObrabotcaVid()
{
	$vo = '';
	$vo .= '<option></option>';
	foreach (Data(OBRABOTKA) as $item) {
		$vo .= '<option>' . $item['name'] . ' * ' . $item['price'] . ' cor</option>';
	}
	return $vo;
}

function AutoComplitData($new_session)
{
	if ($new_session['lastname']) {
		$lastname = $new_session['lastname'];
	}

	if ($new_session['firstname']) {
		$firstname = $new_session['firstname'];
	}

	if ($new_session['middlename']) {
		$middlename = $new_session['middlename'];
	}

	if ($new_session['dat']) {
		$dat = $new_session['dat'];
	}

	if ($new_session['email']) {
		$email = $new_session['email'];
	}

	if ($new_session['number_personal']) {
		$number_personal = $new_session['number_personal'];
	}

	if ($new_session['group']) {
		$group = $new_session['group'];
	}

	if ($new_session['strana']) {
		$strana = $new_session['strana'];
	}

	if ($new_session['state']) {
		$state = $new_session['state'];
	}

	if ($new_session['complaint']) {
		$complaint = $new_session['complaint'];
	}

	if ($new_session['comentari']) {
		$comentari = $new_session['comentari'];
	}

	if ($new_session['position']) {
		$position = $new_session['position'];
	}

	if ($new_session['type_of_treatment']) {
		$type_of_treatment = $new_session['type_of_treatment'];
	}

	if ($new_session['filename']) {
		$filename = $new_session['filename'];
	}

	if ($new_session['check']) {
		$check = $new_session['check'];
	}

	foreach (Data(POLSOVATEL) as $item) {
		if ($new_session['login'] == $item['login'] && $new_session['password'] == $item['password']) {

			if ($item['limite'] > 0 || $item['summ'] > 0) {
				$limite = '<div class="limit">Ваш лимит по обработке ЭКГ: ' . $item['limite'] . '&emsp;&emsp;Сумма на вашем счету: ' . $item['summ'] . ' ' . $item['valuta'] . '</div>';
			} else {
				$limite = '<div class="nolimit">Ваш лимит по обработке ЭКГ: ' . $item['limite'] . '&emsp;&emsp;Сумма на вашем счету: ' . $item['summ'] . ' ' . $item['valuta'] . '</div>';
			}

			if ($item['number'] != '') {
				$number = '<input type="text" name="number_personal" value="' . $item['number'] . '" placeholder="index" id="number_personal" class="block_strock_2">';
			} else {
				$number = '<input type="text" name="number_personal" style="color: red;" value="У Вас нет персонального номера" placeholder="index" id="number_personal" class="block_strock_2">';
			}

			if ($item['group'] != '') {
				$new_group_ = '<input type="text" name="group" value="' . $item['group'] . '" placeholder="index" id="number_personal" class="block_strock_2">';
			} else {
				$new_group_ = '<input type="text" name="group" style="color: red;" value="Группа пока не назначена!" placeholder="index" id="number_personal" class="block_strock_2">';
			}

			if ($item['strana'] != '') {
				$strana = '<input type="text" name="strana" value="' . $item['strana'] . '" placeholder="index" id="number_personal" class="block_strock_2">';
			} else {
				$strana = '<input type="text" name="strana" style="color: red;" value="Вы не указали страну!" placeholder="index" id="number_personal" class="block_strock_2">';
			}

			$personal_date = '
				<div class="block_f2">
					<label class="wf_text" for="lastname">Фамилия:</label>
					<input type="text" name="lastname" value="' . $item['lastname'] . '" placeholder="" id="lastname" class="block_strock_2" readonly>
				</div>
				<div class="block_f2">
					<label class="wf_text" for="firstname">Имя:</label>
					<input type="text" name="firstname" value="' . $item['firstname'] . '" placeholder="" id="firstname"  class="block_strock_2" readonly>
				</div>
				<div class="block_f2">
					<label class="wf_text" for="middlename">Отчество:</label>
					<input type="text" name="middlename" value="' . $item['middlename'] . '" placeholder="" id="middlename"  class="block_strock_2" readonly>
				</div>
				<div class="block_f2">
					<label class="wf_text" for="dat">Дата рождения:</label>
					<input class="block_strock_2" name="dat" dateformat="d.M.y" list="dateList" type="date" placeholder="дд.мм.гггг" value="' . $item['data'] . '" readonly>
				</div>
				<div class="block_f2">
					<label class="wf_text"  for="email">Email:</label>
					<input type="email" name="email" value="' . $item['email'] . '" placeholder="E-Mail" id="email" class="block_strock_2" readonly>
				</div>
			';
			$pol_ = '
				<label class="wf_text">Ваш пол:</label>
				<input class="block_strock_2" type="" name="state" id="state" value="' . $item['state'] . '" readonly>
			';
			break;
		} else {
			$number = '<input type="text" name="number_personal" style="color: red;" value="У Вас нет персонального номера" placeholder="index" id="number_personal" class="block_strock_2">';
			$personal_date = '
				<div class="block_f2">
					<label class="wf_text" for="lastname"><span style="color: red;">*</span>Фамилия:</label>
					<input type="text" name="lastname" value="' . $lastname . '" placeholder="Фамилия" id="lastname" class="block_strock" required>
				</div>
				<div class="block_f2">
					<label class="wf_text" for="firstname"><span style="color: red;">*</span>Имя:</label>
					<input type="text" name="firstname" value="' . $firstname . '" placeholder="Имя" id="firstname"  class="block_strock" required>
				</div>
				<div class="block_f2">
					<label class="wf_text" for="middlename"><span style="color: red;">*</span>Отчество:</label>
					<input type="text" class="block_strock" name="middlename" value="' . $middlename . '" placeholder="Отчество" id="middlename" required>
				</div>
				<div class="block_f2">
					<label class="wf_text" for="dat"><span style="color: red;">*</span>Дата рождения:</label>
					<input class="block_strock" name="dat" dateformat="d.M.y" list="dateList" type="date" placeholder="дд.мм.гггг" value="' . $dat . '" required>
				</div>
				<div class="block_f2">
					<label class="wf_text"  for="email"><span style="color: red;">*</span>Email:</label>
					<input type="email" name="email" value="' . $email . '" placeholder="E-Mail" id="email" class="block_strock" required>
				</div>
			';
			$pol_ = '
				<fieldset class="block_f2">
					<label class="wf_text"><span style="color: red;">*</span>Ваш пол:</label>
					<input type="radio" name="state" id="state" value="Мужской" required>
					<label class="radio-inline" for="state">Мужской</label>
					<input type="radio" name="state" id="state2" value="Женский" required>
					<label class="radio-inline" for="state2">Женский</label>
				</fieldset>
			';
		}
	}
	return [$personal_date, $pol_, $number, $new_group_, $strana, $limite];
}

function Savecart($valuta, $new_session)
{
	include CONECT;
	$coll = $_SESSION['colltov'];
	$id = $_SESSION['cart'];
	$username = Nameclient($new_session);

	mysqli_query($mysqli, "INSERT INTO " . CARTUSER . " (`name`) VALUES ('$username')") or die("Ошибка " . mysqli_error($mysqli));

	foreach (Data(CARTUSER) as $item) {
		if ($username == $item['name']) {
			$iduser = $item['id'];
		}
	}

	$rows = count($coll);
	for ($i = 0; $i < $rows; $i++) {
		mysqli_query($mysqli, "INSERT INTO " . CARTCLIENT . " (`user_id`, `product_id`, `quantity`, `valuta`) VALUES ('$iduser', '$id[$i]', '$coll[$i]', '$valuta[0]')") or die("Ошибка " . mysqli_error($mysqli));
	}
	return $iduser;
}

function Datapolnuy($data)
{
	$date_a = new DateTime($data);
	$date_b = new DateTime();
	$interval = $date_b->diff($date_a);
	$datapol = $interval->format("%Y");
	return $datapol;
}

function Preparat()
{
	$preparat = '';
	$preparat .= '<option></option>';
	foreach (Data(NAME_BS) as $item) {
		if ($item['vide'] == 'on') {
			$preparat .= '<option value="' . $item['name'] . '">' . $item['name'] . '</option>';
		}
	}
	return $preparat;
}

function Ctegories($sort_group)
{
	$categoris = '';
	$categoris .= '<option>Все</option>';
	foreach (Data(CATEGORIS) as $item) {
		$select = ($item['namegroup'] == $sort_group) ? ' selected' : '';
		$categoris .= '<option value="' . $item['namegroup'] . '" ' . $select . '>' . $item['namegroup'] . '</option>';
	}
	return $categoris;
}

function Val($new_post)
{
	if ($new_post['valute']) {
		$val = $new_post['valut'];
		$_SESSION['valute'] = $new_post['valut'];
	} elseif ($_SESSION['valute']) {
		$val = $_SESSION['valute'];
	} else {
		$val = 'cor';
	}
	return $val;
}

function Valuta($new_post)
{
	$valuta = '';
	foreach (Data(VALUTA) as $item) {
		if ($_SESSION['va'])
			$select = ($item['valuta'] == Val($new_post)) ? ' selected' : '';
		$valuta .= '<option value="' . $item['valuta'] . '" ' . $select . '>' . $item['valuta'] . '</option>';
	}
	return $valuta;
}

function CofValuta($val)
{
	foreach (Data(VALUTA) as $item) {
		if ($val == $item['valuta']) {
			$cof = $item['coeficient'];
		}
	}
	return $cof;
}

function MasTrue($item, $string)
{
	$rows = count($string) + 1;
	for ($i = 0; $i < $rows; $i++) {
		if ($item == $string[$i]) $istina = true;
	}
	return $istina;
}

function Product($sort_group, $new_post, $new_get)
{
	$val = Val($new_post);
	$product = '';
	$product .= '<div class="content pad">';
	$theslo = 1;
	$u = 1;
	$i = 0;

	foreach (Data(PRODUCT) as $item) {
		if ($sort_group == '' || $sort_group == 'Все') {
			$page[$u][++$i] = $item['id'];
			if ($i == 12) {
				$i = 0;
				++$u;
			}
		}
	}

	foreach (Data(PRODUCT) as $item) {
		if ($item['product_group'] == $sort_group) {
			$page[$u][++$i] = $item['id'];
			if ($i == 12) {
				$i = 0;
				++$u;
			}
		}
	}

	if (!$new_get['pages_off']) $new_get['pages_off'] = 1;

	$pag = '';
	$rows = count($page) + 1;

	for ($sf = 1; $sf < $rows; $sf++) {
		if ($new_get['pages_off'] == $sf) {
			$class_page = 'pages_on';
			$string = $page[$sf];
		} else {
			$class_page = 'pages_off';
		}
		$pag .= '<a class="' . $class_page . '" href="index.php?name=metodic&pages_off=' . $sf . '">' . $sf . '</a>';
	}

	$product .= '<div class="content"><div class="pages">' . $pag . '</div></div>';

	foreach (Data(PRODUCT) as $item) {
		$rm = ($theslo == 4) ? '' : ' rm2';

		if ($item['product_group'] == $sort_group && MasTrue($item['id'], $string)) {
			$rt = $item['price'];
			$summa = round($rt * CofValuta($val), 2);
			$product .= '<div class="product' . $rm . '">
				<form name="basis_" action="index.php?name=metodic&id=' . $item['id'] . '&par=tov" method="post" enctype="multipart/form-data">
					<img class="img_product" src="admin/images/' . $item['foto'] . '">
					<div class="comentari2">' . $item['name'] . '</div>
					<div class="comentari">' . $item['comentari'] . '</div>
					<div class="blokcena">
						<input class="inputstyle" type="text" name="summa_" value="' . $summa . '" readonly>
						<input class="inputstyle" type="text" name="vall" value="' . $val . '" readonly>
					</div>
					<div class="vubor">
						<input type="submit" name="carss" class="wf_blanck2 jk right_" value="      В корзину      "> 
						<input name="colltov" class="block_sp2" type="number" step="1" min="1" value="1">
					</div>
				</form> 
			</div>';
			$theslo++;
		}

		if (($sort_group == '' || $sort_group == 'Все') && MasTrue($item['id'], $string)) {
			$rt = $item['price'];
			$summa = round($rt * CofValuta($val), 2);
			$product .= '<div class="product' . $rm . '">
				<form name="basis_" action="index.php?name=metodic&id=' . $item['id'] . '&par=tov" method="post" enctype="multipart/form-data">
					<img class="img_product" src="admin/images/' . $item['foto'] . '">
					<div class="comentari2">' . $item['name'] . '</div>
					<div class="comentari">' . $item['comentari'] . '</div>
					<div class="blokcena">
						<input class="inputstyle" type="text" name="summa_" value="' . $summa . '" readonly>
						<input class="inputstyle" type="text" name="vall" value="' . $val . '" readonly>
					</div>
					<div class="vubor">
						<input type="submit" name="carss" class="wf_blanck2 jk right_" value="      В корзину      "> 
						<input name="colltov" class="block_sp2" type="number" step="1" min="1" value="1">
					</div>
				</form>
			</div>';
			$theslo++;
		}

		if ($theslo > 4) {
			$theslo = 1;
		}
	}

	$product .= '<div class="content"><div class="pages">' . $pag . '</div></div></div>';
	return $product;
}

function CoefValuta($new_session)
{
	foreach (Data(VALUTA) as $item) {
		if ($new_session['valute'] == $item['valuta']) {
			$coeficient = $item['coeficient'];
		}

		if (!$new_session['valute']) {
			$coeficient = 1;
		}
	}
	return $coeficient;
}

function Polsovatel($new_session)
{
	foreach (Data(POLSOVATEL) as $item) {
		if ($new_session['login'] == $item['login'] && $new_session['password'] == $item['password']) {
			$wer = '<br><span style="color: red;">Для оформления заказа, сохраните заказ в личном кабинете, после нажмите кнопку «Оформить заказ»!</span>';
			break;
		} else {
			$wer = '<br><span style="color: red;">Для оформления заказа, авторизуйтесь и сохраните заказ в личном кабинете, после нажмите кнопку «Оформить заказ»!</span>';
		}
	}
	return $wer;
}

function CartProduct($new_session)
{
	$block = '';
	$itog = 0;
	for ($u = 0; $u < count($new_session['cart']); ++$u) {
		$idtov = $new_session['cart'][$u];
		$colltov = $new_session['colltov'][$u];
		$valuta = ($new_session['valute']) ? $new_session['valute'] : 'cor';
		if ($idtov != 0) {
			foreach (Data(PRODUCT) as $item) {
				if ($item['id'] == $idtov) {
					$summa = $item['price'] * CoefValuta($new_session);
					$resultat = $colltov * $summa;
					$block .= '
					<div class="cart3">
						<img class="imges" src="admin/images/' . $item['foto'] . '">
						<div class="tov_block">' . $item['name'] . '</div>
						<div class="tov_block2">' . $colltov . '</div>
						<div class="tov_block2">' . $summa . ' ' . $valuta . '</div>
						<div class="tov_block2">' . $resultat . ' ' . $valuta . '</div>
						<div class="tov_block2 vis"><a href="index.php?name=cart&mas=' . $u . '">Удалить</a></div>
					</div>';
					$itog += $resultat;
				}
			}
		}
	}
	return [
		"block" => $block,
		"itog" => $itog
	];
}

function SaveIp()
{
	include CONECT;
	foreach (Data(POLSOVATEL) as $item) {
		if ($_SESSION['login'] == $item['login'] && $_SESSION['password'] == $item['password']) {
			$ip = get_ip();

			// сохранение ip последнего вхождения
			$mysqli->query("UPDATE " . POLSOVATEL . " SET `ip` = '$ip' WHERE " . POLSOVATEL . ".`id` = " . $item['id']);

			$cabinet = '<a href="index.php?name=personal_area"><span class="menu_reg">ЛИЧНЫЙ КАБИНЕТ</span></a>';
			$ex = '<a href="index.php?name=resset"><span class="menu_reg">ВЫХОД</span></a>';
			break;
		} else {
			$cabinet = '';
			$ex = '<a href="index.php?name=entrance"><span class="menu_reg">ВХОД</span></a>
				<a href="index.php?name=registration"><span class="menu_reg">РЕГИСТРАЦИЯ</span></a>';
		}
	}

	return [
		"ex" => $ex,
		"cabinet" => $cabinet
	];
}

function DeletCartUser($new_get)
{
	include CONECT;
	$id = $new_get['mas'];
	mysqli_query($mysqli, "DELETE FROM " . CARTCLIENT . " WHERE  " . CARTCLIENT . ".`id` = $id") or die("Ошибка " . mysqli_error($mysqli));
	return true;
}

function DataCartUser($new_post)
{
	foreach (Data(CARTUSER) as $item) {
		if (Nameclient($new_post) == $item['name']) {
			$idclient[] = 	$item['id'];
			$loginclien[] = 	$item['name'];
			$sakas[] =		$item['sakas'];
		}
	}
	return [
		'idclient' => $idclient,
		'loginclien' => $loginclien,
		'sakas' => $sakas
	];
}

function DeletPositionTov($id)
{
	include CONECT;
	if ($id != NULL) {
		mysqli_query($mysqli, "DELETE FROM " . CARTUSER . " WHERE  " . CARTUSER . ".`id` = $id") or die("Ошибка " . mysqli_error($mysqli));
	}
	return true;
}

function Sakas()
{
	$data_cart_user = DataCartUser($_SESSION);
	$block = '';

	if (!$_SESSION['valute']) {
		$_SESSION['valute'] = 'cor';
	}

	$uuuu = $print = '';
	for ($e = 0; $e < count($data_cart_user['idclient']) + 1; $e++) {
		$itogresut{
			$e} = '';
		$srt = $data_cart_user['idclient'][$e];

		foreach (Data(CARTCLIENT) as $item) {
			if ($srt == $item['user_id']) {
				$idhhm[] = $item['user_id'];
				$idtovara[] = $item['product_id'];
				$col[] = $item['quantity'];
				$valute[] = $item['valuta'];
				$idtovrsacas[] = $item['id']; // для удаления продукта из записи
				$uuuu++;
			}
		}

		if ($data_cart_user['sakas'][$e] == 'sak') {
			$sakk = '<b>Статус заказа:</b> <span style="color: #246ad6;">заказан, ожидает обработку</span>';
		} elseif ($data_cart_user['sakas'][$e] == 'obr') {
			$sakk = '<b>Статус заказа:</b> <span style="color: #0bbd12;">обработан, отправлен</span>';
		} else {
			$sakk = '';
		}

		if (!$uuuu) {
			DeletPositionTov($srt);
		}

		if ($uuuu) {
			$print++;
			$block .= '<div class="icon_print">' . $sakk . '
				<a class="blockprint" href="#" onClick="javascript:CallPrintSac(\'print-content' . $print . '\');" title="Распечатать">' . Printer('icon') . '</a>
			</div>
			<div id="print-content' . $print . '">
				<div class="cart3 no_visibiliti"><b>
					<div class="imges"></div>
					<div class="tov_block">Наименование</div>
					<div class="tov_block2">Единиц</div>
					<div class="tov_block2">Цена</div>
					<div class="tov_block2">Всего</div>
					<div class="tov_block2 vis"></div></b>
				</div>';

			for ($a = 0; $a < count($idtovara); $a++) {
				if ($data_cart_user['idclient'][$e] == $idhhm[$a]) {
					$newid = $idtovara[$a];

					foreach (Data(PRODUCT) as $item) {
						if ($item['id'] == $newid) {
							$nameproduct = 	$item['name'];
							$foto = 		$item['foto'];
							$price2 = 		$item['price'];
						}
					}

					foreach (Data(VALUTA) as $item) {
						if ($_SESSION['valute'] == $item['valuta']) {
							$coeficient = $item['coeficient'];
						}

						if (!$_SESSION['valute']) {
							$coeficient = $item['coeficient'];
						}
					}

					$vall = ($_SESSION['valute'] != NULL) ? $_SESSION['valute'] : $valute[0];
					$price = $price2 * $coeficient;
					$suma = $col[$a] * $price;
					$block .= '<div class="cart3">
						<img class="imges" src="admin/images/' . $foto . '">
						<div class="tov_block">' . $nameproduct . '</div>
						<div class="tov_block2">' . $col[$a] . '</div>
						<div class="tov_block2">' . $price . ' ' . $vall . '</div>
						<div class="tov_block2">' . $suma . ' ' . $vall . '</div>
						<div class="tov_block2 vis"><a href="index.php?name=cartpersonal&delprod=delprod&mas=' . $idtovrsacas[$a] . '">Удалить</a></div>
					</div>';
					$itogresut{
						$e} += $suma;
				}
			}

			if (!$data_cart_user['sakas'][$e]) {
				$ty = '<div style="width: 100%; overflow: hidden; border-bottom: 1px solid #ddd; padding: 10px 0;">
					<a href="index.php?name=cartpersonal&ret=' . $data_cart_user['idclient'][$e] . '&ssm=' . $itogresut[$e] . '&vt=' . $vall . '" class="wf_blanck2 jk right_" value="">Оформить заказ</a>
				</div>';
			}

			$block .= '<div style="width: 100$; overflow: hidden;">
					<div class="itog_"><b>И того:</b> ' . $itogresut[$e] . ' ' . $vall . '</div>
				</div>
				' . $ty . '
			</div>';
		}

		if ($uuuu) {
			$resultat = '<h1>Сохраненная корзина</h1>' . $block;
		}

		unset($data_cart_user['idclient'][0], $uuuu, $idhhm, $idtovara, $col, $valute, $idtovrsacas);
	}

	return $resultat;
}

function ConverterValut($vt, $G, $valutaoplatu) // $vt - валюта в какой товар, $G - сумма к оплате, $valutaoplatu - в какую конвертируем
{
	$new_cof_valuta = ValutaCof();
	if ($vt == 'cor') {
		if ($valutaoplatu == 'cor') {
			$summaofsak = $G;
		} elseif ($valutaoplatu == 'грн') {
			$summaofsak = $G * $new_cof_valuta['grn'];
		} elseif ($valutaoplatu == 'руб') {
			$summaofsak = $G * $new_cof_valuta['rub'];
		} elseif ($valutaoplatu == 'eur') {
			$summaofsak = $G * $new_cof_valuta['eur'];
		}
	} elseif ($vt == 'грн') {
		if ($valutaoplatu == 'cor') {
			$summaofsak = $G / $new_cof_valuta['grn'];
		} elseif ($valutaoplatu == 'грн') {
			$summaofsak = $G;
		} elseif ($valutaoplatu == 'руб') {
			$summaofsak = $G * ($new_cof_valuta['rub'] / $new_cof_valuta['grn']);
		} elseif ($valutaoplatu == 'eur') {
			$summaofsak = $G / $new_cof_valuta['grn'] * $new_cof_valuta['eur'];
		}
	} elseif ($vt == 'руб') {
		if ($valutaoplatu == 'cor') {
			$summaofsak = $G / $new_cof_valuta['rub'];
		} elseif ($valutaoplatu == 'грн') {
			$summaofsak = $G * ($new_cof_valuta['grn'] / $new_cof_valuta['rub']);
		} elseif ($valutaoplatu == 'руб') {
			$summaofsak = $G;
		} elseif ($valutaoplatu == 'eur') {
			$summaofsak = $G / $new_cof_valuta['rub'] * $new_cof_valuta['eur'];
		}
	} elseif ($vt == 'eur') {
		if ($valutaoplatu == 'eur') {
			$summaofsak = $G;
		} elseif ($valutaoplatu == 'cor') {
			$summaofsak = $G / $new_cof_valuta['eur'];
		} elseif ($valutaoplatu == 'грн') {
			$summaofsak = $G / $new_cof_valuta['eur'] * $new_cof_valuta['grn'];
		} elseif ($valutaoplatu == 'руб') {
			$summaofsak = $G / $new_cof_valuta['eur'] * $new_cof_valuta['rub'];
		}
	}
	return $summaofsak;
}

function OpenSakasProduct($new_get, $new_post)
{
	include CONECT;

	$space = new Spacecraft;

	if ($new_get['ret'] != '') {
		$idsak = $new_get['ret'];
		$datazakaza = date('d.m.y');

		foreach (Data(POLSOVATEL) as $item) {
			if ($_SESSION['login'] == $item['login'] && $_SESSION['password'] == $item['password']) {
				$userid = $item['id']; // id пользователя
				$summacthot = $item['summ'];
				$valutaoplatu = $item['valuta'];
				$otricanie = $item['otricatelno'];
			}
		}

		$G = $new_get['ssm']; // сумма товара
		$vt = $new_get['vt']; // валюта в какой товар

		$summaofsak = ConverterValut($vt, $G, $valutaoplatu);
		$r = 0;

		if ($item['product_group'] == 'ФРИЛАНСЕРЫ' && $summacthot < $summaofsak) {
			//
		} elseif ($summacthot > $summaofsak) {
			foreach (Data(CARTCLIENT) as $item) {
				if ($new_get['ret'] == $item['user_id']) {
					$id_product[$r] = $item['product_id'];
					$col_product[$r] = $item['quantity'];
					$r++;
				}
			}

			$rows = count($id_product);
			for ($i = 0; $i < $rows; $i++) {
				foreach (Data(PRODUCT) as $item) {
					if ($item['id'] == $id_product[$i]) {

						if ($item['product_group'] == 'ФРИЛАНСЕРЫ') {
							$frilanc = explode(' ', $item['comentari'])[4];

							mysqli_query($mysqli, "UPDATE " . CARTUSER . " SET `sakas` = 'sak', `date` = '$datazakaza' WHERE " . CARTUSER . ".`id` = $idsak") or die("Ошибка " . mysqli_error($mysqli));
						} else {
							$frilanc = '';

							// отправляем на оплату
							$space->Fixed([
								'id' => $userid,
								'price' => ($item['price'] * $col_product[$i]),
								'valuta' => 'cor',
								'name' => $item['name'],
								'usluga' => 'Оплачено',
								'frilanc' => $frilanc
							]);

							mysqli_query($mysqli, "UPDATE " . CARTUSER . " SET `sakas` = 'sak', `oplata` = '<div style=\"color: green;\">Оплачен</div>', `date` = '$datazakaza' WHERE " . CARTUSER . ".`id` = $idsak") or die("Ошибка " . mysqli_error($mysqli));
						}
					}
				}
			}
		} elseif ($summacthot < $summaofsak && $otricanie == 'on') {
			foreach (Data(CARTCLIENT) as $item) {
				if ($new_get['ret'] == $item['user_id']) {
					$id_product[$r] = $item['product_id'];
					$col_product[$r] = $item['quantity'];
					$r++;
				}
			}

			$rows = count($id_product);
			for ($i = 0; $i < $rows; $i++) {
				foreach (Data(PRODUCT) as $item) {
					if ($item['id'] == $id_product[$i]) {

						if ($item['product_group'] == 'ФРИЛАНСЕРЫ') {
							$frilanc = explode(' ', $item['comentari'])[4];

							mysqli_query($mysqli, "UPDATE " . CARTUSER . " SET `sakas` = 'sak', `date` = '$datazakaza' WHERE " . CARTUSER . ".`id` = $idsak") or die("Ошибка " . mysqli_error($mysqli));
						} else {
							$frilanc = '';

							// отправляем на оплату
							$space->Fixed([
								'id' => $userid,
								'price' => ($item['price'] * $col_product[$i]),
								'valuta' => 'cor',
								'name' => $item['name'],
								'usluga' => 'Долг',
								'frilanc' => $frilanc
							]);

							mysqli_query($mysqli, "UPDATE " . CARTUSER . " SET `sakas` = 'sak', `oplata` = '<div style=\"color: green;\">Оплачен</div>', `date` = '$datazakaza' WHERE " . CARTUSER . ".`id` = $idsak") or die("Ошибка " . mysqli_error($mysqli));
						}
					}
				}
			}
		} elseif ($summacthot < $summaofsak && $otricanie == '') {

			foreach (Data(CARTCLIENT) as $item) {
				if ($new_get['ret'] == $item['user_id']) {
					$id_product[$r] = $item['product_id'];
					$col_product[$r] = $item['quantity'];
					$r++;
				}
			}

			$rows = count($id_product);
			for ($i = 0; $i < $rows; $i++) {
				foreach (Data(PRODUCT) as $item) {
					if ($item['id'] == $id_product[$i]) {

						if ($item['product_group'] == 'ФРИЛАНСЕРЫ') {
							$frilanc = explode(' ', $item['comentari'])[4];

							mysqli_query($mysqli, "UPDATE " . CARTUSER . " SET `sakas` = 'sak', `date` = '$datazakaza' WHERE " . CARTUSER . ".`id` = $idsak") or die("Ошибка " . mysqli_error($mysqli));
						} else {
							$frilanc = '';

							mysqli_query($mysqli, "UPDATE " . CARTUSER . " SET `sakas` = 'sak', `oplata` = '<div style=\"color: red;\">Не оплачен</div>', `date` = '$datazakaza' WHERE " . CARTUSER . ".`id` = $idsak") or die("Ошибка " . mysqli_error($mysqli));
						}
					}
				}
			}

			// если нет на счету отправляем на карту
			header('Location: ' . URLPartner($new_post));
		}
	}
	return true;
}

function Osdorovlenie($new_session)
{
	foreach (Data(POLSOVATEL) as $item) {
		if ($new_session['login'] == $item['login'] && $new_session['password'] == $item['password']) {
			$blockauto = '<div class="content pad">
				<form action="index.php" method="post" enctype="multipart/form-data">
				<div class="block_left">
					<div class="block_string">
						<label class="text_menu" for="lastname"><span style="color: red;">*</span>Фамилия:</label>
						<input type="text" name="lastname" class="block_strock_2" value="' . $item['lastname'] . '" readonly>
					</div>
					<div class="block_string">
						<label class="text_menu" for="firstname"><span style="color: red;">*</span>Имя:</label>
						<input type="text" name="firstname" class="block_strock_2" value="' . $item['firstname'] . '" readonly>
					</div>
					<div class="block_string">
						<label class="text_menu" for="middlename"><span style="color: red;">*</span>Отчество:</label>
						<input type="text" name="middlename" class="block_strock_2" value="' . $item['middlename'] . '" readonly>
					</div>
					<div class="block_string">
						<label class="text_menu" for="dat"><span style="color: red;">*</span>Дата рождения:</label>
						<input class="block_strock_2" name="dat" dateformat="d.M.y" list="dateList" type="date" placeholder="дд.мм.гггг" value="' . $item['data'] . '" readonly>
					</div>
				</div>
				<div class="block_right">
					<div class="block_string">
						<label class="text_menu" for="dat"><span style="color: red;">*</span>Email:</label>
						<input type="email" name="email" value="' . $item['email'] . '" placeholder="E-Mail" id="email" class="block_strock_2" readonly>
					</div>
					<div class="block_string">
						<label class="text_menu"><span style="color: red;">*</span>Ваш пол:</label>
						<input class="block_strock_2" type="" name="state" id="state" value="' . $item['state'] . '" readonly>
					</div>
					<div class="block_string">
						<label class="text_menu" for="comentari">Коментарии:</label>
						<textarea class="block_coment" name="comentari" rows="3" placeholder="Вы можете добавить коментарии"></textarea>
					</div>
					
				<div class="">
					<input class="bottom_" name="forma" type="submit" value="Далее">
				</div>
				</div>
				</form>
				<form class="resett" action="index.php?name=crov" method="post" enctype="multipart/form-data">
					<input name="ress" class="bottom_" type="submit" value="Очистка формы">
				</form>
			</div>';
			break;
		} else {
			$blockauto = '<div class="content pad">
				<p class="errors">Для дальнейшего прохождения, войдите под логином или зарегистрируйтесь!</p>
				<div class="block_string etr">
					<a class="rmt" href="index.php?name=registration">Регистрация</a>
				</div>
				<div class="block_string etr">
					<a class="rmt" href="index.php?name=entrance">Войти</a>
				</div>
			</div>';
		}
	}
	return $blockauto;
}

function PersonalData($new_session)
{
	$personal = '';
	$personal .= '<div style="color: red;">Будте внимательны к изменению персональных данных! После смены пароля перезагрузите страницу!</div>';
	foreach (Data(POLSOVATEL) as $item) {
		if ($new_session['login'] == $item['login'] && $new_session['password'] == $item['password']) {
			$personal .= '<form action="index.php?name=personal&id=' . $item['id'] . '" method="post" enctype="multipart/form-data">
				<div class="block_f2">
					<div><b>Имя пользователя</b>: ' . $item['lastname'] . ' ' . $item['firstname'] . ' ' . $item['middlename'] . '</div>
				</div>
				<div class="block_f2">
					<lable class="wf_text2" >Ваш Email: </lable>
					<input class="block_strock" type="text" name="mailpol" placeholder="' . $item['email'] . '" autocomplete="new-password">
				</div>
				<div class="block_f2">
					<lable class="wf_text2" >Персональный номер: </lable>
					<input class="block_strock_2" readonly value="' . $item['number'] . '">
				</div>
				<div class="block_f2">
					<lable class="wf_text2" >Ваш лимит: </lable>
					<input class="block_strock_2" readonly value="' . $item['limite'] . '">
				</div>
				<div class="block_f2">
					<lable class="wf_text2" >Сумма на счету: </lable>
					<input class="block_strock_2" readonly value="' . $item['summ'] . ' ' . $item['valuta'] . '">
				</div>
				<div class="block_f2">
					<lable class="wf_text2" >Ваша страна проживания: </lable>
					<input class="block_strock" type="text" name="strananame" placeholder="' . $item['strana'] . '">
				</div>';
			if ($item['state'] == '') {
				$personal .= '<fieldset class="block_f2">
						<label class="wf_text2"><span style="color: red;">*</span>Ваш пол:</label>
						<input type="radio" name="state" id="state" value="Мужской" required><label class="radio-inline" for="state">Мужской</label>
						<input type="radio" name="state" id="state2" value="Женский" required><label class="radio-inline" for="state2">Женский</label>
					</fieldset>';
			} else {
				$personal .= '<div class="block_f2">
						<lable class="wf_text2" >Ваш пол: </lable>
						<input class="block_strock_2" readonly value="' . $item['state'] . '">
					</div>';
			}
			$personal .= '<div class="block_f2">
					<lable class="wf_text2" >Дата рождения: </lable>
					<input class="block_strock_2" readonly value="' . $item['data'] . '">
				</div>
				<div class="block_f2">
					<lable class="wf_text2" >Дата рождения: </lable>
					<input name="data" class="block_strock" type="date">
				</div>
				<div class="block_f2">
					<lable class="wf_text2" >Номер вашего телефона: </lable>
					<input class="block_strock" type="text" name="phone" placeholder="' . $item['phone'] . '">
				</div>
				<div class="block_f2">
					<lable class="wf_text2" >Пароль: </lable>
					<input class="block_strock" type="password" name="passwordpolsovatel" autocomplete="new-password">
				</div>
				<input name="editpersonal" class="wf_blanck2 jk right_" type="submit" value="Изменить">
			</form>';
		}
	}
	return $personal;
}

function Diagrama($new_session, $res, $po)
{
	include CONECT;
	$nameus = Nameclient($new_session);
	$data = date('d.m.y');
	mysqli_query($mysqli, "INSERT INTO " . DIAGRAMA . " (`name`, `res1`, `res2`, `res3`, `res4`, `res5`, `res6`, `res7`, `data`, `result`) VALUES ('$nameus', '$res[0]', '$res[1]', '$res[2]', '$res[3]', '$res[4]', '$res[5]', '$res[6]', '$data','$po')") or die("Ошибка " . mysqli_error($mysqli));
	return true;
}

class SaveDiagrams
{
	public $data_test;

	public function SaveResultTest()
	{
		include CONECT;
		$id = $this->data_test['id'];
		$categories = $this->data_test['categories'];
		$groups = $this->data_test['groups'];
		$data = $this->data_test['data'];
		mysqli_query($mysqli, "INSERT INTO " . DIAGRAMMA . " (`id_client`, `categories`, `groups`, `data`) VALUES ('$id', '$categories', '$groups', '$data')") or die("Ошибка " . mysqli_error($mysqli));
		return true;
	}
}

function Pol($new_session)
{
	foreach (Data(POLSOVATEL) as $item) {
		if (Nameclient($new_session) == $item['lastname'] . ' ' . $item['firstname'] . ' ' . $item['middlename']) {
			$pol = $item['state'];
		}
	}
	return $pol;
}

function Blocc($new_post, $new_session, $data)
{
	$po = '';
	for ($i = 10; $i < 80; $i++) {
		if (!isset($new_post['sost' . $i])) {
			$blocc = 1;
		}
		$po .= $new_post['sost' . $i] . ',';
	}
	foreach (Data(DIAGRAMA) as $item) {
		if (Nameclient($new_session) == $item['name'] && $data == $item['data']) {
			$blocc = 2;
		}
	}
	return $blocc;
}

function DiagnosticVopros($new_session)
{
	$d = 0;
	$o = 1;
	$diagnostic = '';
	foreach (Data(DIAGNISTIC) as $item) {
		$d++;

		if (Pol($new_session) == 'Мужской') {
			if ($d == 4) continue;
		}

		if (Pol($new_session) == 'Женский') {
			if ($d == 5) continue;
		}

		$diagnostic .= '<br>
				<div class="type_sostoyaniya">' . $o . '. ' . $item['name'] . '</div>
				<div class="block_f2"><b>
					<div class="vopros">Признаки по органам и системам</div>
					<div class="otvet">нет<br><span style="color: red; font-size: 15px;">стало значительно лучше</span></div>
					<div class="otvet">редко<br><span style="color: red; font-size: 15px;">улучшилось</span></div>
					<div class="otvet">бывает<br><span style="color: red; font-size: 15px;">немного ухудшилось</span></div>
					<div class="otvet">часто<br><span style="color: red; font-size: 15px;">значительно ухудшилось</span></div>
				</b></div>';

		for ($k = 0; $k < 10; $k++) {
			$diagnostic .= ' 
				<fieldset class="block_f2">
					<div class="block_f2">
						<div class="vopros"><label class="radio-inline">' . $item[$k + 2] . '</label></div>
						<div class="otvet"><input type="radio" name="sost' . $o . $k . '" id="sost" value="0" required></div>
						<div class="otvet"><input type="radio" name="sost' . $o . $k . '" id="sost" value="1" required></div>
						<div class="otvet"><input type="radio" name="sost' . $o . $k . '" id="sost" value="2" required></div>
						<div class="otvet"><input type="radio" name="sost' . $o . $k . '" id="sost" value="3" required></div>
					</div> 
				</fieldset>
			<br><br>';
		}

		$o++;
	}
	return $diagnostic;
}

function RegistrationClient($new_post)
{
	include CONECT;
	$lastname = $new_post['lastname'];
	$firstname = $new_post['firstname'];
	$middlename = $new_post['middlename'];
	$dat = $new_post['dat'];
	$state = $new_post['state'];
	$comentari = $new_post['comentari'];
	$mysqli->query("INSERT INTO " . REGISTRATION_CLIENT . " (`lastname`, `firstname`, `middlename`, `dat`, `state`, `comentari`) VALUES ('$lastname', '$firstname', '$middlename', '$dat', '$state', '$comentari')");
	foreach (Data(REGISTRATION_CLIENT) as $item) {
		if ($lastname == $item['lastname'] && $firstname == $item['firstname'] && $middlename == $item['middlename']) {
			$id = $item['id'];
			break;
		}
	}
	return $id;
}

function Initialisacia($new_session)
{
	foreach (Data(POLSOVATEL) as $item) {
		if ($new_session['login'] == $item['login'] && $new_session['password'] == $item['password']) {
			$datarojdeniya = $item['data'];
			$_SESSION['data_personal']['id'] = $item['id'];
			$polnayadata = (int) Datapolnuy($datarojdeniya);
			$vvpol = $item['state'];
			$init = '
			<div class="content pad">
				<div>
					<div class="nameblock">
						<i><b>ФИО</b></i>: ' . $item['lastname'] . ' ' . $item['firstname'] . ' ' . $item['middlename'] . '<br>
						<i><b>Дата рождения</b></i>: ' . $datarojdeniya . '  (Полных лет: ' . $polnayadata . ')
					</div>
					<div class="nameblock">
						<i><b>Пол</b></i>: ' . $vvpol . '<br>
						<i><b>Коментарий</b></i>: ' . $item['comentari'] . '
					</div>
				</div>';
		}
	}
	return [$init, $polnayadata, $vvpol];
}

class ECG
{
	public $post;

	public function ProcentOtclECG()
	{
		$dual = '';

		if ($this->post['bolesni'] == 'on') {
			$dual = 1;
		} else {
			$dual = 0;
		}

		$num1 = (int) $this->post['num1'];
		$num2 = (int) $this->post['num2'] + $dual;

		foreach (Data(DS) as $item) {
			if ($item['zona'] == $this->post['zona']) {

				if ($num1 == 0 && $num2 == 0) {
					$ress = $num1 == $item['sn1'] && $num2 == $item['sn3'];
				} else {
					if ($item['sn1'] > $item['sn2'] && $item['sn3'] == 0 && $item['sn4'] == 0) {
						$ress = $num1 == $item['sn1'] && $num2 == $item['sn3'];
					} elseif ($item['sn1'] < $item['sn2'] && $item['sn3'] == 0 && $item['sn4'] == 0) {
						$ress = $num1 >= $item['sn1'] && $num1 <= $item['sn2'] && $num2 == $item['sn3'];
					} elseif ($item['sn1'] < $item['sn2'] && $item['sn3'] > $item['sn4']) {
						$ress = ($num1 >= $item['sn1'] && $num1 <= $item['sn2'] && $num2 == $item['sn3']) || ($num2 == $item['sn3']);
					} elseif ($item['sn1'] < $item['sn2'] && $item['sn3'] < $item['sn4']) {
						$ress = ($num1 >= $item['sn1'] && $num1 <= $item['sn2'] && $num2 >= $item['sn3'] && $num2 <= $item['sn4']) || ($num2 >= $item['sn3'] && $num2 <= $item['sn4']);
					}
				}

				if ($ress) {
					$_group = $item['categiries'];

					// Опрас базы данных car_ds
					$ds = [
						'name' => $item['name'],
						'categories' => $_group,
						'status' => $item['status'],
						'color' => $item['color'],
						'sostoyanie' => explode(',', $item['sostoyanie'])
					];
				}
			}
		}

		// Опредиление заключения
		foreach (Data(ZACLUCHENIE) as $item) {
			if ($item['categori'] == $_group) {
				$opisanie_urovnya_zdorovia = $item['status'];
				$reakciya_aktivacii = $item['uroven_riakciy'];
				$opisanie_primenenie = $item['comentari'];
			}
		}

		return [$opisanie_urovnya_zdorovia, $reakciya_aktivacii, $opisanie_primenenie, $ds];
	}
}

function Saboliv()
{
	return file_get_contents(SABOLEVANIYA, true);
}

function ResultatTable($sir1, $sir2, $coloris)
{
	foreach (Data(DS) as $item) {
		$pks1 = $item['sn1'];
		$pks2 = $item['sn2'];
		$pks3 = $item['sn3'];
		$pks4 = $item['sn4'];
		if ($coloris != 'black') {
			if ($sir1 != '' && $sir2 == '') {
				if ($coloris == $item['color']) {
					if ($pks1 != '' && $pks2 == '' && $pks3 == '' && $pks4 == '') {
						$qrt = ($pks1 == $sir1);
						if ($pks1 == $sir1) {
							$colort = $item['color'];
							$uy = $item['status'] . ' ' . $item['categiries'];
						}
					} elseif ($pks1 != '' && $pks2 != '' && $pks3 == '' && $pks4 == '') {
						$qrt = (($pks1 <= $sir1) && ($pks2 >= $sir1));
						$colort = $item['color'];
						$uy = $item['status'] . ' ' . $item['categiries'];
					}
				}
			} elseif ($sir1 != '' && $sir2 != '') {
				if ($coloris == $item['color']) {
					if ($pks1 != '' && $pks2 == '' && $pks3 != '' && $pks4 == '') {
						$qrt = (($pks1 == $sir1) && ($pks3 == $sir2));
						if (($pks1 == $sir1) && ($pks3 == $sir2)) {
							$colort = $item['color'];
							$uy = $item['status'] . ' ' . $item['categiries'];
						}
					} elseif ($pks1 != '' && $pks2 != '' && $pks3 != '' && $pks4 != '') {
						$qrt = (($sir1 >= $pks1 && $sir1 <= $pks2) && ($sir2 >= $pks3 && $sir2 <= $pks4));
						if (($sir1 >= $pks1 && $sir1 <= $pks2) && ($sir2 >= $pks3 && $sir2 <= $pks4)) {
							$colort = $item['color'];
							$uy = $item['status'] . ' ' . $item['categiries'];
						}
					} elseif ($pks1 != '' && $pks2 != '' && $pks3 != '' && $pks4 == '') {
						$qrt = (($pks1 <= $sir1) && ($pks2 >= $sir1)) && ($pks3 == $sir2);
						if (($pks1 <= $sir1 && $pks2 >= $sir1) && ($pks3 == $sir2)) {
							$colort = $item['color'];
							$uy = $item['status'] . ' ' . $item['categiries'];
						}
					} elseif ($pks1 != '' && $pks2 == '' && $pks3 != '' && $pks4 != '') {
						$qrt = ($pks1 == $sir1) && (($pks3 >= $sir2) && ($pks4 <= $sir2));
						$colort = $item['color'];
						$uy = $item['status'] . ' ' . $item['categiries'];
					}
				}
			} elseif ($sir1 == '' && $sir2 != '') {
				if ($coloris == $item['color']) {
					if ($pks3 != '' && $pks4 == '') {
						$qrt = $pks3 == $sir2;
						$colort = $item['color'];
						$uy = $item['status'] . ' ' . $item['categiries'];
					} elseif ($pks3 != '' && $pks4 != '') {
						$qrt = (($pks3 <= $sir2) && ($pks4 >= $sir2));
						$colort = $item['color'];
						$uy = $item['status'] . ' ' . $item['categiries'];
					}
				}
			} elseif ($sir1 == '' && $sir2 == '') {
				if ($coloris == $item['color']) {
					if ($pks1 == '' && $pks2 == '' && $pks3 == '' && $pks4 == '') {
						$qrt = ($pks1 == $sir1) && ($pks3 == $sir2);
						$colort = $item['color'];
						$uy = $item['status'] . ' ' . $item['categiries'];
					}
				}
			}
		} else {
			$colort = '#000';
			$uy = '<b>За пределами диапазона!</b>';
			$qrt = true;
		}
		unset($pks1, $pks2, $pks3, $pks4);
	}
	return $array = [$colort, $uy, $qrt];
}

function Anceta()
{
	$anceta = '';
	$m = 0;
	foreach (Data(OPROS) as $item) {
		$anceta .= '
			<br>
				<div class="type_sostoyaniya">' . ++$m . '. ' . $item['sostoyanie'] . '</div>
				<fieldset class="block_f2">
					<div class="vopros">
						<input type="radio" name="sost' . $m . '" id="sost" value="' . $item['-3'] . '" required>
						<label class="radio-inline">' . $item['-3'] . '</label>
					</div>
					<div class="vopros">
						<input type="radio" name="sost' . $m . '" id="sost" value="' . $item['-2'] . '" required>
						<label class="radio-inline">' . $item['-2'] . '</label>
					</div>
					<div class="vopros">
						<input type="radio" name="sost' . $m . '" id="sost" value="' . $item['-1'] . '" required>
						<label class="radio-inline">' . $item['-1'] . '</label>
					</div>
					<div class="vopros">
						<input type="radio" name="sost' . $m . '" id="sost" value="' . $item['0'] . '" required>
						<label class="radio-inline">' . $item['0'] . '</label>
					</div>
					<div class="vopros">
						<input type="radio" name="sost' . $m . '" id="sost" value="' . $item['+1'] . '" required>
						<label class="radio-inline">' . $item['+1'] . '</label>
					</div>
					<div class="vopros">
						<input type="radio" name="sost' . $m . '" id="sost" value="' . $item['+2'] . '" required>
						<label class="radio-inline">' . $item['+2'] . '</label>
					</div>
					<div class="vopros">
						<input type="radio" name="sost' . $m . '" id="sost" value="' . $item['+3'] . '" required>
						<label class="radio-inline">' . $item['+3'] . '</label>
					</div>
				</fieldset>
			<br><br>';
	}
	return $anceta;
}

function ReceptRecomendacii()
{
	foreach (Data(RECEPT) as $item) {
		$rec = $item['recomendacii'];
	}
	return $rec;
}

function Chuvstvitelnost()
{
	if ($_SESSION['polnuh_let'] >= 23 && $_SESSION['polnuh_let'] <= 63 && $_SESSION['pol'] >= 'Мужской' && $_SESSION['perenesenue_sabolevaniya'] != 'on') {
		$chuvst = 1;
	} elseif ((($_SESSION['polnuh_let'] >= 19 && $_SESSION['polnuh_let'] <= 22 && $_SESSION['pol'] >= 'Мужской') || ($_SESSION['polnuh_let'] > 63 && $_SESSION['pol'] >= 'Мужской') || ($_SESSION['pol'] >= 'Женский') || $_SESSION['perenesenue_sabolevaniya'] == 'on') && $_SESSION['polnuh_let'] >= 19) {
		$chuvst = 2;
	} elseif ($_SESSION['polnuh_let'] < 19) {
		$chuvst = 3;
	}
	return $chuvst;
}

function Tabu()
{
	$scdir = scandir('histori/', 1);
	$rows = count($scdir);

	for ($sd = 0; $sd < $rows; $sd++) {
		$new_scdir[$sd] = explode('.', $scdir[$sd]);
	}

	sort($new_scdir);
	$tabu = '';

	for ($wr = 0; $wr < $rows; $wr++) {
		if ($new_scdir[$wr][0] == IdClient($_SESSION)) {
			$data = $new_scdir[$wr][1];
			$data_prohod = strtotime(date('d-m-Y', strtotime($data . '+ 26 days')));
			$data_tecuchyaya = strtotime(date('d-m-Y'));

			if ($new_scdir[$wr][3] == 'krov') {
				if ($data_prohod < $data_tecuchyaya) {
					$tabu['krov'] = false;
				} elseif ($data_prohod > $data_tecuchyaya) {
					$tabu['krov'] = true;
				}

				$data_pr['krov'] = date('d.m.Y', $data_prohod);
			} elseif ($new_scdir[$wr][3] == 'anketa') {
				if ($data_prohod < $data_tecuchyaya) {
					$tabu['anceta'] = false;
				} elseif ($data_prohod > $data_tecuchyaya) {
					$tabu['anketa'] = true;
				}

				$data_pr['anketa'] = date('d.m.Y', $data_prohod);
			} elseif ($new_scdir[$wr][3] == 'ecg') {
				if ($data_prohod < $data_tecuchyaya) {
					$tabu['ecg'] = false;
				} elseif ($data_prohod > $data_tecuchyaya) {
					$tabu['ecg'] = true;
				}

				$data_pr['ecg'] = date('d.m.Y', $data_prohod);
			}
		}
	}

	return [$tabu, $data_pr];
}

function TableReceptOsdorovlenia($array)
{
	include CONECT;
	$aray = Tabu();
	$tabu = $aray[0];
	$tablet .= '<div class="content">
		<a href="#" onclick="javascript:CallPrintTablet(\'print-content\');" title="Распечатать проект">
			<svg class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512">
				<title>Печать</title>
				<g>
				</g>
				<path d="M128 32h256v64h-256v-64z"></path>
				<path d="M480 128h-448c-17.6 0-32 14.4-32 32v160c0 17.6 14.397 32 32 32h96v128h256v-128h96c17.6 0 32-14.4 32-32v-160c0-17.6-14.4-32-32-32zM64 224c-17.673 0-32-14.327-32-32s14.327-32 32-32 32 14.327 32 32-14.326 32-32 32zM352 448h-192v-160h192v160z"></path>
			</svg>
		</a>
	</div>
	<div id="print-content">
	<div style="background: ' . $array['colors'] . '; color: #fff; text-align: left; padding: 10px;">
		' . $array['preduprejdenie'] . '
		<h3>Уровень здоровья: ' . $array['categoris'] . '</h3>
		<p><b>Описание уровня здоровья: </b>' . $array['opisanie_urovnya_zdorovia'] . '</p>
		<p><b>Реакция активации: </b>' . $array['reakciya_aktivacii'] . '</p>
		<p><b>Описание и применение: </b>' . $array['opisanie_primenenie'] . '</p>
	</div>';

	$colum1 = $colum2 = $colum3 = $colum4 = '';
	$new_j = 0;
	for ($zm = 0; $zm < $array['polnuh']; $zm++) {
		foreach (Data(TABLE_BS) as $item) {

			if ($item['reakciya'] == $array['sostoyanie'][0] && $item['uroven'] == $array['sostoyanie'][1] && $item['biostimulyator'] == $array['biostemulyator'] && $item['cickl'] == ($zm + 1) && $item['chust'] == Chuvstvitelnost()) {
				$colum1 = $item['dosa1'];
				$colum2 = $item['rasvedenie1'];
				$colum3 = $item['dosa2'];
				$colum4 = $item['rasvedenie2'];
				$reakciya = $item['reakciya'];
				$uroven = $item['uroven'];
			}
		}

		if ($zm == 0 || $zm == 1 && $array['polnuh'] > 1) $bort = 'table_block2';

		if ($zm == 2 || $array['polnuh'] == 1) $bort = 'table_block';

		if ($zm == 1 && $array['polnuh'] == 2) $bort = 'table_block';

		$tablet .= '<div class="' . $bort . '">';

		if ($zm == 0) {
			$tablet .= '<div><div class="recept_ogl1"><b>Назначенный биостимулятор: </b>' . $array['biostemulyator'] . '</div>
					<div class="recept_ogl2">
						<div class="date_table"><b class="bb">Дата</b></div>
						<div class="date_table"><b class="bb">Доза (капли)</b></div>
						<div class="date_table"><b class="bb">Разведение</b></div>
						<div class="date_table"><b class="bb">Вторая доза (капли)</b></div>
						<div class="date_table"><b class="bb">Разведение</b></div>
					</div>
				</div>';
		}

		if ($zm == 0) {
			$f = date('Y-m-d', time());
			$fm = date('Y-m-d', strtotime($f . '+1days'));
		} elseif ($zm == 1) {
			$fm = date('Y-m-d', strtotime($f . '+11days'));
		} elseif ($zm == 2) {
			$fm = date('Y-m-d', strtotime($f . '+21days'));
		}

		$jf = 0;

		for ($i = 0; $i < $array['datestart']; $i++) {
			$nt = date('Y-m-d', strtotime($fm . '+' . $i . 'days'));

			if ($zm == 2 && $i >= 7) {
				$ntm[$jf++] = $nt;
			}
		}

		// $ntm последние три дня
		unset($ntm[3]);

		$from = new DateTime($fm);
		$to = new DateTime($nt);
		$period = new DatePeriod($from, new DateInterval('P1D'), $to);

		$arrayOfDates = array_map(function ($item) {
			return $item->format('d.m.Y');
		}, iterator_to_array($period, true));

		$diff = $to->diff($from);
		$tablet .= '<div class="date_table">';

		for ($i = 0; $i < $diff->days; $i++) {
			$tablet .= '<div class="date_table">' . $arrayOfDates[$i] . '</div>';
		}

		$tablet .= '</div>';

		for ($colon = 1; $colon < 5; $colon++) {
			$coln = explode(',', ${'colum' . $colon}, 10);
			$tablet .= '<div class="date_table">';

			for ($j = 0; $j < 10; $j++) {
				$tablet .= '<div class="date_table">' . $coln[$j] . '</div>';
			}

			$tablet .= '</div>';
		}

		$tablet .= '</div>';
	}

	$tablet .= ReceptRecomendacii() . '<br><div class="block_ancetu">' . $array['rec'] . '</div><br></div>'; // Описание под таблицей
	return [$tablet, $tabu, $ntm];
}

function ResultatAnket()
{
	include CONECT;

	$space = new Spacecraft;

	$scdir = scandir('histori', 1);
	$rows = count($scdir);

	for ($i = 0; $i < $rows; $i++) {
		$array = explode('.', $scdir[$i]);

		if ($array[2] == 'off' && $array[0] == IdClient($_SESSION)) {
			$admin_price = explode('-', $array[4]);
			$summa_uslugi = ConverterValut($admin_price[1], $admin_price[0], ValutaPolsovatela(IdClient($_SESSION)));

			foreach (Data(POLSOVATEL) as $item) {
				if ($item['id'] == IdClient($_SESSION)) {
					if ($item['summ'] >= $summa_uslugi) {

						// отправляем на оплату
						$space->Fixed([
							'id' => $item['id'],
							'price' => $admin_price[0],
							'valuta' => $admin_price[1],
							'name' => 'Списано долг за обработку',
							'usluga' => 'Оплачено'
						]);

						foreach ($scdir as $fil) {
							$doc_id = explode('.', $fil);
							if ($item['id'] == $doc_id[0]) {
								$doc_id[2] = 'on';
								$new_name = implode('.', $doc_id);
								rename('histori/' . $fil, 'histori/' . $new_name);
							}
						}

						$array[2] = 'on';
					}
				}
			}
		}

		if ($array[0] == IdClient($_SESSION)) {
			if ($array[2] == 'on') {
				if ($array[3] == 'anketa') {
					$data['anketa'] = '<p><a href="index.php?name=recomendacii&bloc=anketa&histori=histori/' . $scdir[$i] . '"><b>Результат анкетирования: </b>' . $array[1] . '</a><a href="index.php?name=recomendacii&bloc=anketa&histori=histori/' . $scdir[$i] . '&delhist=del">' . Del('icon3red') . '</a></p>';
				}

				if ($array[3] == 'krov') {
					$data['krov'] = '<p><a href="index.php?name=recomendacii&bloc=krov&histori=histori/' . $scdir[$i] . '"><b>Результат по крови: </b>' . $array[1] . '</a><a href="index.php?name=recomendacii&bloc=krov&histori=histori/' . $scdir[$i] . '&delhist=del">' . Del('icon3red') . '</a></p>';
				}

				if ($array[3] == 'ecg') {
					$data['ecg'] = '<p><a href="index.php?name=recomendacii&bloc=ecg&histori=histori/' . $scdir[$i] . '"><b>Результат по ЭКГ: </b>' . $array[1] . '</a><a href="index.php?name=recomendacii&bloc=ecg&histori=histori/' . $scdir[$i] . '&delhist=del">' . Del('icon3red') . '</a></p>';
				}

				if ($array[3] == 'ad') {
					$data['ad'] = '<p><a href="index.php?name=recomendacii&bloc=ad&histori=histori/' . $scdir[$i] . '"><b>Результат по АД: </b>' . $array[1] . '</a><a href="index.php?name=recomendacii&bloc=ad&histori=histori/' . $scdir[$i] . '&delhist=del">' . Del('icon3red') . '</a></p>';
				}
			} elseif ($array[2] == 'off') {
				if ($array[3] == 'anketa') {
					$data['anketa'] = '<p class="redd">Не достаточно средств на счету для просмотра этого файла!</p>';
				}

				if ($array[3] == 'krov') {
					$data['krov'] = '<p class="redd">Не достаточно средств на счету для просмотра этого файла!</p>';
				}

				if ($array[3] == 'ecg') {
					$data['ecg'] = '<p class="redd">Не достаточно средств на счету для просмотра этого файла!</p>';
				}

				if ($array[3] == 'ad') {
					$data['ad'] = '<p class="redd">Не достаточно средств на счету для просмотра этого файла!</p>';
				}
			}
		}
	}
	return $data;
}

class Histori // получение списка файлов
{
	public $file;
	public $personal;

	public function DelHictori() // Функция
	{
		include CONECT;
		// Удаляем файл
		unlink($this->file);

		$data_file = explode('.', explode('/', $this->file)[1]);
		$id_client = $data_file[0];
		$file_data = $data_file[1];
		$type_file = $data_file[3];
		$data_del = date('d.m.Y H:i');

		// записываем результат в реестр HISTORI
		$mysqli->query("INSERT INTO " . HISTORI . " (`id_client`, `name`, `data_del`, `type`) VALUES ('$id_client', '$file_data', '$data_del', '$type_file')");

		return true;
	}

	public function StecDel()
	{
		$anketa = $crov = $ecg = $ad = '';
		foreach (Data(HISTORI) as $item) {
			if ($item['id_client'] == $this->personal['id']) {
				if ($item['type'] == 'anketa') {
					$anketa .= '<div class="del_stec"><b>Файл</b> ' . $item['name'] . ', был удален ' . $item['data_del'] . '</div><br>';
				} elseif ($item['type'] == 'krov') {
					$crov .= '<div class="del_stec"><b>Файл</b> ' . $item['name'] . ', был удален ' . $item['data_del'] . '</div><br>';
				} elseif ($item['type'] == 'ecg') {
					$ecg .= '<div class="del_stec"><b>Файл</b> ' . $item['name'] . ', был удален ' . $item['data_del'] . '</div><br>';
				} elseif ($item['type'] == 'ad') {
					$ad .= '<div class="del_stec"><b>Файл</b> ' . $item['name'] . ', был удален ' . $item['data_del'] . '</div><br>';
				}
			}
		}
		return [$anketa, $crov, $ecg, $ad];
	}


	function ResultatAnket()
	{
		print_r("GH");
		include CONECT;

		$space = new Spacecraft;

		$scdir = scandir('histori', 1);
		$rows = count($scdir);

		for ($i = 0; $i < $rows; $i++) {
			$array = explode('.', $scdir[$i]);

			if ($array[2] == 'off' && $array[0] == IdClient($_SESSION)) {
				$admin_price = explode('-', $array[4]);
				$summa_uslugi = ConverterValut($admin_price[1], $admin_price[0], ValutaPolsovatela(IdClient($_SESSION)));

				foreach (Data(POLSOVATEL) as $item) {
					if ($item['id'] == IdClient($_SESSION)) {
						if ($item['summ'] >= $summa_uslugi) {

							// отправляем на оплату
							$space->Fixed([
								'id' => $item['id'],
								'price' => $admin_price[0],
								'valuta' => $admin_price[1],
								'name' => 'Списано долг за обработку',
								'usluga' => 'Оплачено'
							]);

							foreach ($scdir as $fil) {
								$doc_id = explode('.', $fil);
								if ($item['id'] == $doc_id[0]) {
									$doc_id[2] = 'on';
									$new_name = implode('.', $doc_id);
									rename('histori/' . $fil, 'histori/' . $new_name);
								}
							}

							$array[2] = 'on';
						}
					}
				}
			}

			if ($array[0] == IdClient($_SESSION)) {
				if ($array[2] == 'on') {
					if ($array[3] == 'anketa') {
						$data['anketa'] = '<p><a href="index.php?name=recomendacii&bloc=anketa&histori=histori/' . $scdir[$i] . '"><b>Результат анкетирования: </b>' . $array[1] . '</a><a href="index.php?name=recomendacii&bloc=anketa&histori=histori/' . $scdir[$i] . '&delhist=del">' . Del('icon3red') . '</a></p>';
					}

					if ($array[3] == 'krov') {
						$data['krov'] = '<p><a href="index.php?name=recomendacii&bloc=krov&histori=histori/' . $scdir[$i] . '"><b>Результат по крови: </b>' . $array[1] . '</a><a href="index.php?name=recomendacii&bloc=krov&histori=histori/' . $scdir[$i] . '&delhist=del">' . Del('icon3red') . '</a></p>';
					}

					if ($array[3] == 'ecg') {
						$data['ecg'] = '<p><a href="index.php?name=recomendacii&bloc=ecg&histori=histori/' . $scdir[$i] . '"><b>Результат по ЭКГ: </b>' . $array[1] . '</a><a href="index.php?name=recomendacii&bloc=ecg&histori=histori/' . $scdir[$i] . '&delhist=del">' . Del('icon3red') . '</a></p>';
					}

					if ($array[3] == 'ad') {
						$data['ad'] = '<p><a href="index.php?name=recomendacii&bloc=ad&histori=histori/' . $scdir[$i] . '"><b>Результат по АД: </b>' . $array[1] . '</a><a href="index.php?name=recomendacii&bloc=ad&histori=histori/' . $scdir[$i] . '&delhist=del">' . Del('icon3red') . '</a></p>';
					}
				} elseif ($array[2] == 'off') {
					if ($array[3] == 'anketa') {
						$data['anketa'] = '<p class="redd">Не достаточно средств на счету для просмотра этого файла!</p>';
					}

					if ($array[3] == 'krov') {
						$data['krov'] = '<p class="redd">Не достаточно средств на счету для просмотра этого файла!</p>';
					}

					if ($array[3] == 'ecg') {
						$data['ecg'] = '<p class="redd">Не достаточно средств на счету для просмотра этого файла!</p>';
					}

					if ($array[3] == 'ad') {
						$data['ad'] = '<p class="redd">Не достаточно средств на счету для просмотра этого файла!</p>';
					}
				}
			}
		}
		return $data;
	}
}

function SaveClient($new_session)
{
	include CONECT;
	$lastname = 	$mysqli->real_escape_string(htmlspecialchars($new_session["lastname"]));
	$firstname = 	$mysqli->real_escape_string(htmlspecialchars($new_session['firstname']));
	$middlename = 	$mysqli->real_escape_string(htmlspecialchars($new_session['middlename']));
	$rojdenie = 	$mysqli->real_escape_string(htmlspecialchars($new_session['dat']));
	$email = 		$mysqli->real_escape_string(htmlspecialchars($new_session['email']));
	$state = 		$mysqli->real_escape_string(htmlspecialchars($new_session['state']));
	$complaint = 	$mysqli->real_escape_string(htmlspecialchars($new_session['complaint']));
	$comentari = 	$mysqli->real_escape_string(htmlspecialchars($new_session['comentari']));
	$file = 		$mysqli->real_escape_string(htmlspecialchars($new_session['uploadfile']));
	$position = 	$mysqli->real_escape_string(htmlspecialchars($new_session['position']));
	$treatment = 	$mysqli->real_escape_string(htmlspecialchars($new_session['type_of_treatment']));
	$checks =		$mysqli->real_escape_string(htmlspecialchars($new_session['check']));
	$checks2 =		$mysqli->real_escape_string(htmlspecialchars($new_session['check2']));
	$personal_num = $mysqli->real_escape_string(htmlspecialchars($new_session['number_personal']));
	$group =		$mysqli->real_escape_string(htmlspecialchars($new_session['group']));
	$strana =		$mysqli->real_escape_string(htmlspecialchars($new_session['strana']));
	$summa = 		$mysqli->real_escape_string(htmlspecialchars($new_session['summa_uslugi_ecg']));
	$status = 		"0";
	$filename =		$new_session['filename'];

	$treatment = explode(' * ', $treatment);

	if (date('H', time()) >= '19') {
		$date = '<span style="color: red;">' . date('d.m.Y H:i') . '</span>';
	} else {
		$date = date('d.m.Y H:i');
	}

	$mysqli->query("INSERT INTO " . CLIENTU . " (`lastname`, `firstname`, `middlename`, `rojdenie`, `email`, `state`, `complaint`, `comentari`, `position`, `treatment`, `status`, `data_registr`, `file`, `personal_num`, `group`, `fio_card`, `summ`, `dop_card`, `strana`)
	VALUES ('$lastname', '$firstname', '$middlename', '$rojdenie', '$email', '$state', '$complaint', '$comentari', '$position', '$treatment[0]', '$status', '$date', '$filename', '$personal_num', '$group', '$fio_card', '$summa', '$checks2', '$strana')");

	return true;
}

function ChetClient()
{
	$id = IdClient($_SESSION);
	$valuta_clienta = $_SESSION['global_valuta'];
	$chet = $z = '';
	foreach (Data(CHETDB) as $item) {
		if ($valuta_clienta == '' || $valuta_clienta == NULL) {
			if ($item['id_client'] == $id) {
				$chet .= '<div class="tblet_chet1">
					<div class="chet_pp1 chet1">' . ++$z . '</div>
					<div class="chet_data1 chet1">' . $item['name'] . '</div>
					<div class="chet_operation1 chet1">' . $item['data'] . '</div>
					<div class="chet_dolg1 chet1">' . $item['rashod_limit'] . '</div>
					<div class="chet_bes1 chet1">' . $item['sama_tec'] . '</div>
					<div class="chet_data11_ chet1">' . $item['price_club'] . '</div>
					<div class="chet_oplata1 chet1">' . $item['raschet_usluga'] . '</div>
					<div class="chet_limit11_ chet1">' . $item['data_pogasheniya'] . '</div>
					<div class="chet_ostatoc1 chet1">' . $item['obrabotci'] . '</div>
					<div class="chet_ostatoc12 chet1">' . $item['octatoc_obrabotci'] . '</div>
				</div>';
			}
		} elseif ($valuta_clienta != '') {
			if ($item['id_client'] == $id) {
				$chet .= '<div class="tblet_chet1">
					<div class="chet_pp1 chet1">' . ++$z . '</div>
					<div class="chet_data1 chet1">' . $item['name'] . '</div>
					<div class="chet_operation1 chet1">' . $item['data'] . '</div>
					<div class="chet_dolg1 chet1">' . round(ConverterValut('грн', $item['rashod_limit'], $valuta_clienta), 2) . '</div>
					<div class="chet_bes1 chet1">' . round(ConverterValut('грн', $item['sama_tec'], $valuta_clienta), 2) . '</div>
					<div class="chet_data11_ chet1">' . round(ConverterValut('грн', $item['price_club'], $valuta_clienta), 2) . '</div>
					<div class="chet_oplata1 chet1">' . round(ConverterValut('грн', $item['raschet_usluga'], $valuta_clienta), 2) . '</div>
					<div class="chet_limit11_ chet1">' . $item['data_pogasheniya'] . '</div>
					<div class="chet_ostatoc1 chet1">' . $item['obrabotci'] . '</div>
					<div class="chet_ostatoc12 chet1">' . $item['octatoc_obrabotci'] . '</div>
				</div>';
			}
		}
	}
	return $chet;
}

function LimitDogovorChet($new_session)
{
	$id = IdClient($new_session);
	foreach (Data(CHETDB) as $item) {
		if ($item['id_client'] == $id) {
			$limit = $item['limite_uslovn'];
		}
	}
	return $limit;
}

function LoadFiles($new_files)
{
	$filename = $new_files['filename']['name'];
	$tmp = $new_files['filename']['tmp_name'];
	$file_date = date('YmdHis');
	$md = md5($filename) . '-' . $file_date . '.' . pathinfo($filename, PATHINFO_EXTENSION);
	return [$tmp, $md];
}

function ErrorsDataInformation($new_post, $filename)
{
	if (!empty($new_post["lastname"]) && !empty($new_post['firstname']) && !empty($new_post['middlename']) && !empty($new_post['dat']) && !empty($new_post['email']) && !empty($new_post['state']) && !empty($filename) && !empty($new_post['position']) && !empty($new_post['type_of_treatment']) && !empty($new_post['check'])) {
		$batt = '<input name="card_fio" class="wf_blanck2 jk right_" type="submit" value="Далее">'; // переход не index.php
		$control = true;
	} else {
		$control = false;
	}

	if ($control == true) {
		$errors = '<p style="color: #67d467; text-align: center; font-weight: 800;">Данные буду сохранены после оплаты или списания лимита!<br>Результат обработки будет направлен на указанный Вами E-mail.</p>';
	} else {
		$errors = '<p style="color: red; text-align: center;  font-weight: 800;">Ошибка при внесении данных!<br>Обратите внимание, возможно вы заполнили не все поля</p>';
	}

	return [$errors, $batt];
}

function IfFiles($m)
{
	$_SESSION['filename'] = $m[1];
	if (is_uploaded_file($m[0])) {
		move_uploaded_file($m[0], 'download/' . $m[1]);
		$file_set = $m[1];
	} else {
		$file_set = '<span style="color: red;">Файл не загружен</span>';
	}
	return $file_set;
}

function RegistrationSumNewUslug($price)
{
	return true;
}

function ValutaPolsovatel($new_post)
{
	if ($new_post['valute2'] && $new_post['val_chet']) {
		$val = $new_post['valut'];
		$_SESSION['global_valuta'] = $new_post['valut'];
	} elseif ($new_post['sort_group'] || $new_post['valute']) {
		$val = $new_post['valute'];
		$_SESSION['global_valuta'] = $new_post['valut'];
	}
	return $val;
}

function Resets($new_get)
{
	if ($new_get['name'] == 'resset') {
		session_destroy();
		unset($_SESSION);
		header('Location: http://iridoc.com/cardio/index.php');
		exit;
	}
	return true;
}

function PriceObrabotca($new_post)
{
	if ($new_post['type_of_treatment'] != '' || $new_post['type_of_treatment'] != ' ') {
		foreach (Data(OBRABOTKA) as $item) {
			if ($item['name'] == $new_post['type_of_treatment']) {
				$summa = $item['price'];
			}
		}
	}
	return $summa;
}

function NameCartPersonal($new_post)
{
	$fio_card = $new_post['fio'];
	if ($fio_card == '' || $fio_card == ' ') {
		$fio_card = $new_post["lastname"] . ' ' . $new_post['firstname'] . ' ' . $new_post['middlename'];
	}
	return $fio_card;
}

function ControlEmail()
{
	foreach (Data(SYSTEMADMIN) as $item) {
		mail($item['email2'], '«SUM_LINE»', 'Добавлен новый файл для обработки, админ');
	}
	return true;
}

function LimitPersonal($id)
{
	foreach (Data(POLSOVATEL) as $item) {
		if ($item['id'] == $id) {
			$limit = $item['limite'];
		}
	}
	return $limit;
}

function Sortirovka($new_post)
{
	if ($new_post['sort_group'] || $new_post['valute']) {
		$sort_group = $new_post['group_prodd'];
	}
	return $sort_group;
}

function Ustav($new_post, $startcart)
{
	if (($new_post['card_fio'] && $startcart == 'off') || ($startcart == 'on' && $_SESSION['cena'] == 0)) {
		$ustav = '<div class="preduprejdenie">Операция выполнена успешно!</div>';
	} else {
		$ustav = '';
	}
	return $ustav;
}

// Данна функция для проверки на прохождение
function Ok()
{
	return 'Проходит';
}

function SetSession($new_post, $new_get)
{
	foreach (Data(OBRABOTKA) as $item) {
		if ($item['name'] == $new_post['type_of_treatment']) {
			$_SESSION['cena'] = $item['price'];
		}
	}

	if ($new_post['carss']) {
		$_SESSION['colltov'][]			= $new_post['colltov'];
		$_SESSION['summa'][]			= $new_post['summa_'];
		$_SESSION['valuta'][]			= $new_post['vall'];
	}

	if ($new_post['personal_area']) {
		$_SESSION['personal_area']		= 'personal_area';
	}

	if ($new_get['par'] == 'tov') {
		$_SESSION['cart'][]				= $new_get['id'];
	}

	if ($new_post['basis']) {
		$_SESSION['lastname']			= $new_post['lastname'];
		$_SESSION['firstname']			= $new_post['firstname'];
		$_SESSION['middlename']			= $new_post['middlename'];
		$_SESSION['dat']				= $new_post['dat'];
		$_SESSION['email']				= $new_post['email'];
		$_SESSION['number_personal']	= $new_post['number_personal'];
		$_SESSION['group']				= $new_post['group'];
		$_SESSION['strana']				= $new_post['strana'];
		$_SESSION['state']				= $new_post['state'];
		$_SESSION['complaint']			= $new_post['complaint'];
		$_SESSION['comentari']			= $new_post['comentari'];
		$_SESSION['position']			= $new_post['position'];
		$_SESSION['type_of_treatment']	= $new_post['type_of_treatment'];
		$_SESSION['filename']			= $new_post['filename'];
		$_SESSION['check']				= $new_post['check'];
		$_SESSION['check2']				= $new_post['check2'];
	}

	if ($new_post['entrance_log']) {
		$_SESSION['login']				= $new_post['login'];
		$_SESSION['password']			= md5($new_post['passwr']);
	}

	if ($new_post['valute'] || $new_post['valute2']) {
		$_SESSION['valute']				= $new_post['valut'];
	}

	if ($new_post['group_prodd']) {
		$_SESSION['sell']				= $new_post['group_prodd'];
	}

	if ($new_get['page'] == 'dell') {
		unset($_SESSION['cart'], $_SESSION['colltov'], $_SESSION['summa_'], $_SESSION['valuta']);
	}
	return true;
}

function OpenDataClientChet($new_get)
{
	$z = 0;
	foreach (Data(CHETDB) as $item) {
		if ($new_get['id'] == $item['id_client']) {
			$array[++$z] = $item;
		}
	}
	return $array;
}

function URLPartner($new_post)
{
	// Определение URL партнера
	if ($new_post['group']) {
		foreach (Data(PARTNER) as $item) {
			if ($new_post['group'] == $item['group']) {
				$http = $item['checking'];
				break;
			}
		}
	}

	// Определение глобальной карты
	if ($new_post['group'] == '' || $new_post['group'] == ' ') {
		foreach (Data(CART) as $item) {
			$http = $item['name'];
		}
	}
	return $http;
}

function Kar($new_post, $new_get, $startcart)
{
	$kar = '';
	$kar = $_GET['name'];
	if ($new_post['card_fio'] && $startcart == 'off') {
		$kar = 'card_fio';
	} elseif ($new_post['sort_group'] || $new_post['valute']) {
		$kar = 'metodic';
	} elseif ($new_post['valute2']) {
		$kar = 'cartpersonal';
	} elseif ($new_post['opros']) {
		$kar = 'forma'; // anceta
	} elseif ($new_post['autorisation']) {
		$kar = 'registration';
	} elseif ($new_post['cart']) {
		$kar = 'cart';
	} elseif ($new_post['basis']) {
		$kar = 'basis';
	} elseif ($new_post['forma']) {
		$kar = 'forma';
	} elseif ($new_get['name'] == 'forma') {
		$kar = 'forma';
	} elseif ($new_get['name'] == 'diagnostic') {
		$kar = 'diagnostic';
	} elseif ($new_get['name'] == 'kalendar') {
		$kar = 'kalendar';
	} elseif ($new_get['name'] == 'metodic') {
		$kar = 'metodic';
	} elseif ($new_get['cartpersonal']) {
		$kar = 'cartpersonal';
	} elseif ($new_get['registration']) {
		$kar = 'registration';
	} elseif ($new_get['entrance']) {
		$kar = 'entrance';
	} elseif ($new_get['personal_area']) {
		$kar = 'personal_area';
	} elseif ($new_get['name'] == 'recomendacii') {
		$kar = 'recomendacii';
	} elseif ($new_get['name'] == 'anketa') {
		$kar = 'anketa';
	} elseif ($new_get['name'] == 'recept') {
		$kar = 'recept';
	} elseif ($new_get['name'] == 'personal') {
		$kar = 'personal';
	} elseif ($new_get['name'] == 'criatemail') {
		$kar = 'criatemail';
	} elseif ($new_get['name'] == 'diagrams') {
		$kar = 'diagrams';
	} elseif ($new_get['name'] == 'chet') {
		$kar = 'chet';
	}
	return $kar;
}

class OperationFin
{
	public function Operation($fin)
	{
		include CONECT;
		$data = date('y-m-d');
		$summa = ConverterValut($fin['valuta'], $fin['summa'], 'cor');
		$mysqli->query("INSERT INTO " . FINOTCHET . " (`summa`, `data`) VALUES ('$summa', '$data')");
		return true;
	}
}

function EditECGClient($new_post)
{
	include CONECT;

	$space = new Spacecraft;

	if ($new_post['card_fio']) {

		// Если нажата кнопка «Далие» на второй странице ЭКГ, для подтверждения на оплату
		if ($_SESSION['group'] != '') { // Если группа не пуста
			foreach (Data(POLSOVATEL) as $item) {
				if ($item['email'] == $_SESSION['email'] && $item['group'] == $_SESSION['group']) {
					$limite = $item['limite'];
					$type_price = explode(' * ', $_SESSION['type_of_treatment']);
					$price = explode(' ', $type_price[1]);
					$price_club = ConverterValut($price[1], $price[0], $item['valuta']); // вход, сумма, выход
					$otricatelno = $item['otricatelno'];
					$_SESSION['summa_uslugi_ecg'] = ConverterValut($price[1], $price[0], 'грн');

					if ($limite > 0 && $type_price[0] == 'Обработка файла ЭКГ') {

						if ($price_club != 0) {
							--$limite;
						}

						if ($limite <= 0) {
							$group = 'Члены Клуба'; // при пополнении счета менять на Фрилансеры
						} else {
							$group = 'Фрилансеры';
						}

						// отправляем на оплату
						$space->FixedLimit([
							'id' => $item['id'],
							'price' => $price[0],
							'valuta' => $price[1],
							'name' => $type_price[0],
							'usluga' => 'Оплачено',
							'frilanc' => 1,
							'groups' => $group
						]);

						// переброс на карту
						$startcart = 'off';
					} elseif ($limite <= 0 && $type_price[0] == 'Обработка файла ЭКГ') {


						if ($limite <= 0) {
							$group = 'Члены Клуба'; // при пополнении счета менять на Фрилансеры
						} else {
							$group = 'Фрилансеры';
						}

						// отправляем на оплату
						$space->Fixed([
							'id' => $item['id'],
							'price' => $price[0],
							'valuta' => $price[1],
							'name' => $type_price[0],
							'usluga' => 'Оплачено',
							'groups' => $group
						]);

						// переброс на карту
						$startcart = 'off';
					} elseif ($item['summ'] > $price_club && $type_price[0] != 'Обработка файла ЭКГ') {

						// отправляем на оплату
						$space->Fixed([
							'id' => $item['id'],
							'price' => $price[0],
							'valuta' => $price[1],
							'name' => $type_price[0],
							'usluga' => 'Оплачено'
						]);

						// переброс на карту
						$startcart = 'off';
					} elseif ($type_price[0] != 'Обработка файла ЭКГ' && $otricatelno == 'on') {

						// отправляем на оплату
						$space->Fixed([
							'id' => $item['id'],
							'price' => $price[0],
							'valuta' => $price[1],
							'name' => $type_price[0],
							'usluga' => 'Долг'
						]);

						// переброс на карту
						$startcart = 'off';
					} elseif ($_SESSION['strana'] == 'Россия' && $item['summ'] >= $price_club) {
						header('Location: http://iridoc.com/cardio/index.php?name=criatemail');
						exit;
					} elseif ($otricatelno != 'on' && $price_club != 0) {
						$startcart = 'on';
						header('Location:' . URLPartner($new_post));
					}
				}
			}
		} elseif ($_SESSION['group'] == '') {
			$type_price = explode(' * ', $_SESSION['type_of_treatment']);
			$price = explode(' ', $type_price[1]);

			// внести изменения если не зарегистрирован
			if ($_SESSION['strana'] == 'Россия' && $price[0] != 0) {
				header('Location: http://iridoc.com/cardio/index.php?name=criatemail');
			} elseif ($price[0] > 0) {
				$startcart = 'on';
				header('Location:' . URLPartner($new_post));
			} elseif ($price[0] == 0) {
				$startcart = 'off';
			}
		}

		// переписать лимит со стороны админки
		// Карта пользователя
		$fio_card = NameCartPersonal($new_post);
		$summa = PriceObrabotca($new_post);

		// Сохранение в базу клиента
		SaveClient($_SESSION);

		// Уведомление на почту
		ControlEmail();
	}
	return [
		"fio_card" => $fio_card,
		"summa" => $summa,
		"startcart" => $startcart
	];
}

function EditMail()
{
	$mail = '';
	$mail .= '<option value=""></option>';
	foreach (Data(EMAILCATEGORI) as $item) {
		$mail .= '<option value="' . $item['name'] . '">' . $item['name'] . '</option>';
	}
	return $mail;
}

function ValutaPolsovatela($id)
{
	foreach (Data(POLSOVATEL) as $item) {
		if ($item['id'] == $id) {
			$valuta = $item['valuta'];
		}
	}
	return $valuta;
}

function PriceAnceta($id)
{
	foreach (Data(PRODUCT) as $item) {
		if ($item['id'] == $id) {
			$price = $item['price'];
		}
	}
	return $price;
}

function SredstvaChet($usluga)
{
	include CONECT;

	$space = new Spacecraft;

	foreach (Data(CORECTION) as $item) {
		if ($item['name'] == 'individual') {
			$price = $item['price'];
			$valuta = $item['valuta'];
			$summa_uslugi = ConverterValut($item['valuta'], $item['price'], ValutaPolsovatela(IdClient($_SESSION)));
		}

		if ($item['name'] == 'minus') {
			$_SESSION['price'] = [
				'price' => $item['price'],
				'valuta' => $item['valuta']
			];
		}
	}

	foreach (Data(POLSOVATEL) as $item) {
		if ($item['id'] == IdClient($_SESSION)) {
			if ($item['summ'] >= $summa_uslugi) {
				$space->Fixed([
					'id' => $_SESSION['data_personal']['id'],
					'price' => $price,
					'valuta' => $valuta,
					'name' => $usluga
				]);

				$off = true;
			} else {
				$off = false;
			}
		}
	}
	return $off;
}

class Year
{
	public function Yaer_10()
	{
		$_plr_ = '';
		$_year_ = date('Y') - 3;
		for ($i = 0; $i < 10; $i++) {
			if (($_year_ + $i) == date('Y')) {
				$select = ' selected';
			} else {
				$select = '';
			}
			$_plr_ .= '<option value="' . ($_year_ + $i) . '" ' . $select . '>' . ($_year_ + $i) . '</option>';
		}
		return $_plr_;
	}

	public function Mount()
	{
		$data = date('01.01.' . date('Y'));
		$dat = '';
		$s = [
			'01' => 'Январь',
			'02' => 'Февраль',
			'03' => 'Март',
			'04' => 'Апрель',
			'05' => 'Май',
			'06' => 'Июнь',
			'07' => 'Июль',
			'08' => 'Август',
			'09' => 'Сентябрь',
			'10' => 'Октябрь',
			'11' => 'Ноябрь',
			'12' => 'Декабрь'
		];

		for ($i = 0; $i < 12; $i++) {
			$new_data = date('m', strtotime($data . '+' . $i . 'month'));

			if ($new_data == date('m')) {
				$select = ' selected';
			} else {
				$select = '';
			}

			$dat .= '<option value="' . $new_data . '"' . $select . '>' . $s[$new_data] . '</option>';
		}
		return $dat;
	}
}

function Cart($style_icon)
{
	$cart = '<svg class=' . $style_icon . ' version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1000 1000" enable-background="new 0 0 1000 1000" xml:space="preserve">
		<g><path d="M186.1,132.5H40.6c-16.9,0-30.6-13.7-30.6-30.6C10,85,23.7,71.3,40.6,71.3h145.5c16.9,0,30.6,13.7,30.6,30.6C216.7,118.8,203,132.5,186.1,132.5L186.1,132.5z M844.5,775.6H346.9c-16.9,0-30.6-13.7-30.6-30.6c0-16.9,13.7-30.6,30.6-30.6h497.7c16.9,0,30.6,13.7,30.6,30.6C875.2,761.9,861.4,775.6,844.5,775.6L844.5,775.6z M959.4,255H232c-16.9,0-30.6-13.7-30.6-30.6c0-16.9,13.7-30.6,30.6-30.6h727.3c16.9,0,30.6,13.7,30.6,30.6C990,241.3,976.3,255,959.4,255L959.4,255z M911.5,438.8H279.9c-16.9,0-30.6-13.7-30.6-30.6c0-16.9,13.7-30.6,30.6-30.6h631.6c16.9,0,30.6,13.7,30.6,30.6C942.1,425,928.4,438.8,911.5,438.8L911.5,438.8z M867.5,622.5H327.7c-16.9,0-30.6-13.7-30.6-30.6c0-16.9,13.7-30.6,30.6-30.6h539.8c16.9,0,30.6,13.7,30.6,30.6C898.1,608.8,884.4,622.5,867.5,622.5L867.5,622.5z M588,618.7c-16.9,0-30.6-13.7-30.6-30.6V258.8c0-16.9,13.7-30.6,30.6-30.6c16.9,0,30.6,13.7,30.6,30.6V588C618.7,605,605,618.7,588,618.7L588,618.7z M798.8,236.8l-39.2,326.9c-2,16.8-17.3,28.8-34.1,26.8c-16.8-2-28.8-17.3-26.8-34L738,229.6c2-16.8,17.3-28.8,34.1-26.8C788.9,204.8,800.8,220.1,798.8,236.8L798.8,236.8z M988.3,232.6l-88.3,356c-4,16.4-20.6,26.5-37.1,22.4c-16.4-4-26.5-20.6-22.4-37.1l88.3-356c4-16.4,20.6-26.5,37.1-22.4C982.3,199.6,992.3,216.2,988.3,232.6L988.3,232.6z M451.5,595.2c-16.8,2.2-32.1-9.7-34.3-26.5l-39.4-307.6c-2.2-16.8,9.7-32.1,26.5-34.3c16.8-2.2,32.1,9.7,34.3,26.5L478,560.9C480.1,577.7,468.3,593,451.5,595.2L451.5,595.2z M352.6,768.4c-16.5,4.1-33.1-5.9-37.2-22.3L158,115.5c-4.1-16.4,5.9-33,22.4-37.1c16.5-4.1,33.1,5.9,37.2,22.3l157.3,630.6C379,747.7,369,764.4,352.6,768.4L352.6,768.4z M400.5,928.7c-33.8,0-61.2-27.4-61.2-61.2c0-33.8,27.4-61.3,61.2-61.3c33.8,0,61.2,27.4,61.2,61.3C461.7,901.3,434.3,928.7,400.5,928.7L400.5,928.7z M775.6,928.7c-33.8,0-61.2-27.4-61.2-61.2c0-33.8,27.4-61.3,61.2-61.3c33.8,0,61.3,27.4,61.3,61.3C836.9,901.3,809.4,928.7,775.6,928.7L775.6,928.7z"/></g>
		</svg>';
	return $cart;
}

function Printer($style_icon)
{
	$printer = '<svg class=' . $style_icon . ' version="1.1" xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512">
		<title>Печать</title>
		<g>
		</g>
		<path d="M128 32h256v64h-256v-64z"></path>
		<path d="M480 128h-448c-17.6 0-32 14.4-32 32v160c0 17.6 14.397 32 32 32h96v128h256v-128h96c17.6 0 32-14.4 32-32v-160c0-17.6-14.4-32-32-32zM64 224c-17.673 0-32-14.327-32-32s14.327-32 32-32 32 14.327 32 32-14.326 32-32 32zM352 448h-192v-160h192v160z"></path>
		</svg>';
	return $printer;
}

function Diagram($snak)
{
	for ($u = 0; $u < 7; $u++) {
		if ($snak[$u] >= 0 && $snak[$u] <= 0.6) {
			$snakk = 0;
		} elseif ($snak[$u] >= 0.7 && $snak[$u] <= 1.5) {
			$snakk = 1;
		} elseif ($snak[$u] >= 1.6 && $snak[$u] <= 2.4) {
			$snakk = 2;
		} elseif ($snak[$u] >= 2.5) {
			$snakk = 3;
		}

		for ($i = 0; $i < 4; $i++) {
			if ($snakk == $i) {
				${'end' . $u . $i} = 1;
			} else {
				${'end' . $u . $i} = 0.2;
			}
		}
	}
	$diagramm = '<?xml version="1.0" encoding="utf-8"?>
		<svg version="1.2" baseProfile="tiny" id="Слой_1"
			 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1000 1000"
			 xml:space="preserve">
			 
		<path style="opacity: ' . $end03 . ';" fill="#71BF44" stroke="#000000" stroke-width="1" stroke-miterlimit="10" d="M296.4,76.4L346.8,181
			c47-22.8,99.8-35.5,155.6-35.5c54.1,0.1,105.2,12.1,151,33.6l50.4-104.6c-60.9-29-129-45.3-200.9-45.4C429.1,29,359,46,296.4,76.4z"/>
		<path style="opacity: ' . $end02 . ';" fill="#71BF44" stroke="#000000" stroke-width="1" stroke-miterlimit="10" d="M506.5,264.1c33.6,0.2,66,7.9,95.5,21.7
			l50.4-104.6c-44.3-21-93.6-33-145.5-33.7c-57.2-0.8-111.2,12.2-159.2,35.6l50.4,104.6C431,271.5,468,263,506.5,264.1z"/>
		<path style="opacity: ' . $end01 . ';" fill="#71BF44" stroke="#000000" stroke-width="1" stroke-miterlimit="10" d="M399,289.5l50.4,104.7c8.3-4.1,17.2-7.2,26.6-9.2
			c26.7-5.9,52.5-2.6,74.7,7.3l50.4-104.7c-29.5-13.8-62.4-21.6-96.9-21.9C466.4,265.3,430.7,273.9,399,289.5z"/>
		<path style="opacity: ' . $end00 . ';" fill="#71BF44" stroke="#000000" stroke-width="1" stroke-miterlimit="10" d="M549.9,394.1c-23-10.3-49.4-13.2-75.6-6.8
			c-8.4,2.1-16.5,5-24,8.7l49.3,102.5L549.9,394.1z"/>
			
		<path style="opacity: ' . $end13 . ';" fill="#F0DFAC" stroke="#000000" stroke-width="1" stroke-miterlimit="10" d="M848.3,419.6l113.4-25.9
			c-33-140.4-129-257.4-256.9-318.6l-50.4,104.6C751.1,225.5,823.4,313.5,848.3,419.6z"/>
		<path style="opacity: ' . $end12 . ';" fill="#F0DFAC" stroke="#000000" stroke-width="1" stroke-miterlimit="10" d="M733,445.9L846.3,420
			c-24.9-105.4-97.2-192.8-192.8-238.4l-50.4,104.6C666.4,316.1,715.9,373.9,733,445.9z"/>
		<path style="opacity: ' . $end11 . ';" fill="#F0DFAC" stroke="#000000" stroke-width="1" stroke-miterlimit="10" d="M616.8,469.6c0.2,0.9,0.5,1.8,0.7,2.7l113.6-25.9
			c-16.8-70.1-65.1-128.1-128.9-158.3l-50.4,104.7C583.3,407.2,607.5,435.2,616.8,469.6z"/>
		<path style="opacity: ' . $end10 . ';" fill="#F0DFAC" stroke="#000000" stroke-width="1" stroke-miterlimit="10" d="M615.8,472.7c-9.1-36.1-33.7-63.8-64.8-78.1
			l-50.3,104.4L615.8,472.7z"/>
			
		<path style="opacity: ' . $end23 . ';" fill="#00AEEF" stroke="#000000" stroke-width="1" stroke-miterlimit="10" d="M857.7,501.6c-0.1,83.8-29.1,160.6-77.4,221.3
			l90.7,72.3C935.5,714.2,974,612,974.1,501.5c0-36.6-4.2-72.3-12.1-106.6l-113.4,25.9C854.5,446.7,857.7,473.8,857.7,501.6z"/>
		<path style="opacity: ' . $end22 . ';" fill="#00AEEF" stroke="#000000" stroke-width="1" stroke-miterlimit="10" d="M739.4,502.3c-0.2,55.3-19.4,106.4-51.6,146.9
			l90.7,72.3c47.7-59.8,76.5-135.2,77.2-217c0.3-28.6-3-56.5-9.2-83.2l-113.3,25.9C737.3,464.7,739.5,483.1,739.4,502.3z"/>
		<path style="opacity: ' . $end21 . ';" fill="#00AEEF" stroke="#000000" stroke-width="1" stroke-miterlimit="10" d="M595.3,575.4l90.9,72.5
			c32-40.1,51.2-90.8,51.4-146c0-18.7-2.1-36.9-6.2-54.3l-113.6,25.9C626.9,511.5,617,548.2,595.3,575.4z"/>
		<path style="opacity: ' . $end20 . ';" fill="#00AEEF" stroke="#000000" stroke-width="1" stroke-miterlimit="10" d="M593.9,574.2c21.2-26.5,30.6-61.7,22.9-97.4
			c-0.2-1-0.4-2-0.7-3l-115.1,26.3L593.9,574.2z"/>
			
		<path style="opacity: ' . $end33 . ';" fill="#FBB040" stroke="#000000" stroke-width="1" stroke-miterlimit="10" d="M502.2,856.8c-0.7,0-1.3,0-2,0v116.4
			c0.5,0,1,0,1.5,0c149.3,0.1,282-69.4,368.5-177.2l-90.7-72.3C714.3,805,614.3,856.9,502.2,856.8z"/>
		<path style="opacity: ' . $end32 . ';" fill="#FBB040" stroke="#000000" stroke-width="1" stroke-miterlimit="10" d="M502.1,738.7c-0.6,0-1.3,0-1.9,0v116.2
			c0.5,0,1,0,1.5,0c111.3,0.4,211.1-51.5,276.1-132.5L687.1,650C643.8,703.9,577.3,738.6,502.1,738.7z"/>
		<path style="opacity: ' . $end31 . ';" fill="#FBB040" stroke="#000000" stroke-width="1" stroke-miterlimit="10" d="M531.5,616.5c-10.7,2.7-21.1,3.9-31.3,3.9v116.3
			c0.5,0,1.1,0,1.6,0c73.8,0.3,140.2-34.1,183.6-88l-90.9-72.5C578.7,595.8,556.8,610.2,531.5,616.5z"/>
		<path style="opacity: ' . $end30 . ';" fill="#FBB040" stroke="#000000" stroke-width="1" stroke-miterlimit="10" d="M500.2,618.5c18.2,0.3,35.8-3.5,52.4-11.5
			c16-7.7,29.7-18.7,40.5-31.9L500.2,501V618.5z"/>
			
		<path style="opacity: ' . $end43 . ';" fill="#B88BBF" stroke="#000000" stroke-width="1" stroke-miterlimit="10" d="M222.6,721.5l-90.8,72.4
			C218,902.6,351,972.4,499,973.2V856.8C387.4,856,287.3,803.5,222.6,721.5z"/>
		<path style="opacity: ' . $end42 . ';" fill="#B88BBF" stroke="#000000" stroke-width="1" stroke-miterlimit="10" d="M315.1,647.7L224.4,720
			c64.3,81.4,163.4,134.2,274.6,134.8V738.6C423.7,737.6,357.8,702,315.1,647.7z"/>
		<path style="opacity: ' . $end41 . ';" fill="#B88BBF" stroke="#000000" stroke-width="1" stroke-miterlimit="10" d="M429.7,595.8c-0.6-0.4-1.1-1-1.7-1.5
			c-0.9-0.7-1.8-1.3-2.7-2.1c-2.6-2.1-5.1-4.4-7.4-7l0,0c-3.8-3.6-7.2-7.4-10.3-11.4l-90.9,72.5c42.6,54.3,108.5,89.6,182.3,90.3
			V620.4C474.4,620,451.2,611.7,429.7,595.8z"/>
		<path style="opacity: ' . $end40 . ';" fill="#B88BBF" stroke="#000000" stroke-width="1" stroke-miterlimit="10" d="M409.1,572.7c2.2,2.8,4.4,5.5,6.8,8.1
			c1,1.1,1.9,2.3,2.9,3.5c3.4,3,6.8,6,10.2,9c1.6,1.1,3.1,2.1,4.7,3.2c17.8,12.7,37.7,20,59.4,21.7c2,0.2,3.9,0.2,5.9,0.3V501
			L409.1,572.7z"/>
			
		<path style="opacity: ' . $end53 . ';" fill="#F6A8CA" stroke="#000000" stroke-width="1" stroke-miterlimit="10" d="M146.4,500.8c0-27.2,3.1-53.6,8.9-79L41.8,395.9
			c-7.7,33.7-11.8,68.9-11.8,105c-0.1,110.5,37.8,211.8,101.1,292l90.8-72.4C174.6,660.2,146.3,584.1,146.4,500.8z"/>
		<path style="opacity: ' . $end52 . ';" fill="#F6A8CA" stroke="#000000" stroke-width="1" stroke-miterlimit="10" d="M264.6,501.3c0-18.3,2.1-36.1,6-53.2l-113.3-25.9
			c-5.8,25.3-8.9,51.7-9,78.6c-0.1,82,28.1,157.9,75.4,218.2l90.7-72.3C283.1,606.3,264.6,555.7,264.6,501.3z"/>
		<path style="opacity: ' . $end51 . ';" fill="#F6A8CA" stroke="#000000" stroke-width="1" stroke-miterlimit="10" d="M401.8,565.6c-3.5-5.5-6.6-11.4-9.3-17.5
			c-8.4-19.1-11.2-39.3-8.9-59.9c0.5-4.7,1.3-9.3,2.3-13.8l-113.5-25.9c-3.8,16.3-5.8,33.3-6,50.6c-0.5,55,18.1,105.8,49.6,146.3
			l90.9-72.5C405.1,570.6,403.4,568.1,401.8,565.6z"/>
		<path style="opacity: ' . $end50 . ';" fill="#F6A8CA" stroke="#000000" stroke-width="1" stroke-miterlimit="10" d="M386.1,519c3,19.7,10.5,37.3,22.3,52.8l89.9-71.7
			l-110.6-25.2C384.4,488.9,383.8,503.8,386.1,519z"/>
			
		<path style="opacity: ' . $end63 . ';" fill="#1C75BC" stroke="#000000" stroke-width="1" stroke-miterlimit="10" d="M345.7,181.5L295.3,76.9
			C169.5,138.5,74.5,254.4,42.1,394.7l113.4,25.9C179.8,315.2,250.8,227.9,345.7,181.5z"/>
		<path style="opacity: ' . $end62 . ';" fill="#1C75BC" stroke="#000000" stroke-width="1" stroke-miterlimit="10" d="M397,288.1l-50.4-104.6
			C252.4,230,181.8,317.1,157.5,421.1L270.8,447C287.3,376.6,334.9,318.9,397,288.1z"/>
		<path style="opacity: ' . $end61 . ';" fill="#1C75BC" stroke="#000000" stroke-width="1" stroke-miterlimit="10" d="M448.4,394.7L397.9,290
			c-62.4,30.9-109,88.6-125.2,157.4l113.5,25.9C394.5,438.8,417.3,410.3,448.4,394.7z"/>
		<path style="opacity: ' . $end60 . ';" fill="#1C75BC" stroke="#000000" stroke-width="1" stroke-miterlimit="10" d="M449.2,396.5C418.4,412,396,440.4,388,473.7
			l110.6,25.2L449.2,396.5z"/>
		</svg>';
	return $diagramm;
}

function Del($style_icon)
{
	return '<svg class=' . $style_icon . ' version="1.1" xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512">
		<title>Удалить</title>
		<path d="M256 0c-141.385 0-256 114.615-256 256s114.615 256 256 256 256-114.615 256-256-114.615-256-256-256zM256 464c-114.875 0-208-93.125-208-208s93.125-208 208-208 208 93.125 208 208-93.125 208-208 208z"></path>
		<path d="M336 128l-80 80-80-80-48 48 80 80-80 80 48 48 80-80 80 80 48-48-80-80 80-80z"></path>
	</svg>';
}

/**
 * Обвертка var_dump
 */
class V
{
	static public function vd($name)
	{
		echo '<div class="container"><pre>';
			var_dump($name);
		echo '</pre></div>';
	}
}
