<?php
/*
	Все функции для работы сайта
*/

function Data($db)
{
	include 'component/conect.php'; // ."ORDER BY id DESC"
	$result = mysqli_query($mysqli, "SELECT * FROM " . $db) or die("Ошибка " . mysqli_error($mysqli));
	while ($row = mysqli_fetch_array($result)) {
		$public[] = $row;
	}
	mysqli_free_result($result);
	return $public;
}

function Pol($usersname)
{
	foreach (Data(POLSOVATEL) as $item) {
		if ($usersname == trim($item['lastname']) . ' ' . trim($item['firstname']) . ' ' . trim($item['middlename'])) {
			$pol = $item['state'];
		}
	}
	return $pol;
}

function SteckPolsovateley()
{
	$m = 0;
	$polsovatel = '';
	foreach (Data(POLSOVATEL) as $item) {
		$polsovatel .= '<div><b>' . ++$m . '.</b> ' . $item['lastname'] . ' ' . $item['firstname'] . ' ' . $item['middlename'] . '</div>';
	}
	return $polsovatel;
}

function STRPolsovateli()
{
	$pols = '<option></option>';
	foreach (Data(POLSOVATEL) as $item) {
		$pols .= '<option>' . $item['lastname'] . ' ' . $item['firstname'] . ' ' . $item['middlename'] . '</option>';
	}
	return $pols;
}

class PolsovatelPDF
{
	public function PolPDF($name)
	{
		foreach (Data(POLSOVATEL) as $item) {
			if ($name == $item['lastname'] . ' ' . $item['firstname'] . ' ' . $item['middlename']) {
				$res = $item;
			}
		}
		return $res;
	}
}

function Saboliv()
{
	return file_get_contents(SABOLEVANIYA, true);
}

function Preparat()
{
	$preparat = '';
	$preparat .= '<option></option>';
	foreach (Data(NAME_BS) as $item) {
		if ($item['vide'] == 'on') {
			$preparat .= '<option>' . $item['name'] . '</option>';
		}
	}
	return $preparat;
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

function IdClient($new_session)
{
	foreach (Data(POLSOVATEL) as $item) {
		if ($new_session['login'] == $item['login'] && $new_session['password'] == $item['password']) {
			$id = $item['id'];
			break;
		}
	}
	return $id;
}

function Tabu()
{
	$scdir = scandir('../histori/', 1);
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

			if ($data_prohod < $data_tecuchyaya) {
				$tabu = false;
			} elseif ($data_prohod > $data_tecuchyaya) {
				$tabu = true;
			}
			break;
		}
	}

	return [$tabu, date('d.m.Y', $data_prohod)];
}

class DownloadDel
{
	public function DownloadHistori()
	{
		$scdir = scandir('../download/', 1);
		$dir = '';
		$i = 0;

		foreach ($scdir as $item) {
			if ($item != '.' && $item != '..') {
				$dir .= '<div class="block_file">
					<div class="numbers">' . ++$i . '</div>
					<a class="download_file" href="../download/' . $item . '" download>' . $item . '</a>
					<a class="download_file_delet" href="index.php?name=avtorisovanue&_file_del_=of&delet=del&file_name=' . $item . '">delet</a>
				</div>';
			}
		}
		return $dir;
	}

	public function DownloadDelet($name)
	{
		unlink('../download/' . $name);
		return true;
	}
}

class Calculator
{
	private $valuta;
	private $summa;

	public function __construct($valuta, $summa)
	{
		$this->valuta = $valuta;
		$this->summa = $summa;
	}

	public function Calk()
	{
		foreach (Data(VALUTA) as $item) {
			if ($item['valuta'] == $this->valuta) {
				$result = ConverterValut($this->valuta, $this->summa, 'грн');
				break;
			}
		}

		return $result;
	}
}

function Datapolnuy($data)
{
	$date_a = new DateTime($data);
	$date_b = new DateTime();
	$interval = $date_b->diff($date_a);
	$datapol = $interval->format("%Y");
	return $datapol;
}

function Chuvstvitelnost()
{
	if ($_SESSION['data_personal']['polnuh_let'] >= 23 && $_SESSION['data_personal']['polnuh_let'] <= 63 && $_SESSION['data_personal']['pol'] >= 'Мужской' && $_SESSION['data_personal']['perenesenue_sabolevaniya'] != 'on') {
		$chuvst = 1;
	} elseif ((($_SESSION['data_personal']['polnuh_let'] >= 19 && $_SESSION['data_personal']['polnuh_let'] <= 22 && $_SESSION['data_personal']['pol'] >= 'Мужской') || ($_SESSION['data_personal']['polnuh_let'] > 63 && $_SESSION['data_personal']['pol'] >= 'Мужской') || ($_SESSION['data_personal']['pol'] >= 'Женский') || $_SESSION['data_personal']['perenesenue_sabolevaniya'] == 'on') && $_SESSION['data_personal']['polnuh_let'] >= 19) {
		$chuvst = 2;
	} elseif ($_SESSION['data_personal']['polnuh_let'] < 19) {
		$chuvst = 3;
	}
	return $chuvst;
}

function ReceptRecomendacii()
{
	foreach (Data(RECEPT) as $item) {
		$rec = $item['recomendacii'];
	}
	return $rec;
}

function TableReceptOsdorovlenia($array)
{
	include CONECT;
	$aray = Tabu();
	$colum1 = $colum2 = $colum3 = $colum4 = '';
	$thuvstvitelnost = Chuvstvitelnost();
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
		<p>' . $_SESSION['data_personal']['name_personal'] . '</p>
		<h3>Уровень здоровья: ' . $array['categoris'] . '</h3>
		<p><b>Описание уровня здоровья: </b>' . $array['opisanie_urovnya_zdorovia'] . '</p>
		<p><b>Реакция активации: </b>' . $array['reakciya_aktivacii'] . '</p>
		<p><b>Описание и применение: </b>' . $array['opisanie_primenenie'] . '</p>
	</div>';

	for ($zm = 0; $zm < $array['polnuh']; $zm++) {
		foreach (Data(TABLE_BS) as $item) {
			if ($item['reakciya'] == $array['sostoyanie'][0] && $item['uroven'] == $array['sostoyanie'][1] && $item['biostimulyator'] == $array['biostemulyator'] && $item['cickl'] == ($zm + 1) && $item['chust'] == $thuvstvitelnost) {
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
			$tablet .= '<div>
					<div class="recept_ogl1"><b>Назначенный биостимулятор: </b>' . $array['biostemulyator'] . '</div>
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
		$dosa_mnojitel = '';

		for ($colon = 1; $colon < 5; $colon++) {
			$coln = explode(',', ${'colum' . $colon}, 10);
			$tablet .= '<div class="date_table">';

			for ($j = 0; $j < 10; $j++) {
				if ($colon == 1 || $colon == 3) {
					$itog = round($coln[$j] * $array['mnojitel']);
					if ($itog == 0) $itog = '';

					$tablet .= '<div class="date_table">' . $itog . '</div>';
				} else {
					$tablet .= '<div class="date_table">' . $coln[$j] . '</div>';
				}
			}

			$tablet .= '</div>';
		}

		$tablet .= '</div>';
	}

	$tablet .= ReceptRecomendacii() . '<br><div class="block_ancetu">' . $array['rec'] . '</div><br></div>'; // Описание под таблицей
	return [$tablet, $tabu, $ntm];
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
			$_plr_ .= '<option' . $select . '>' . ($_year_ + $i) . '</option>';
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
			'09' => 'Сеньтябрь',
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

class TableReceptOs
{
	public function TableRecept($array)
	{
		include CONECT;
		$aray = Tabu();
		$thuvstvitelnost = Chuvstvitelnost();
		if ($thuvstvitelnost > 2) {
			if ($array['bolesni'] == 'on') {
				$thuvstvitelnost = 2;
			} else {
				$thuvstvitelnost = 1;
			}
		}
		$tabu = $aray[0];

		foreach (Data(AD) as $item) { // проверить
			if ($item['sostoyanie'] == $array['recept_spisock']) {
				$colors = $item['color'];
				$categori = $item['categori'];
			}
		}

		foreach (Data(ZACLUCHENIE) as $item) {
			if ($item['categori'] == $categori) {
				$status = $item['status'];
				$uroven = $item['uroven_riakciy'];
				$comentari = $item['comentari'];
			}
		}

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
		<div style="background: ' . $colors . '; color: #fff; text-align: left; padding: 10px;">
			' . $array['preduprejdenie'] . '
			<p>' . $_SESSION['data_personal']['name_personal'] . '</p>
			<h3>Уровень здоровья: ' . $categori . '</h3>
			<p><b>Описание уровня здоровья: </b>' . $status . '</p>
			<p><b>Реакция активации: </b>' . $uroven . '</p>
			<p><b>Описание и применение: </b>' . $comentari . '</p>
		</div>';

		// формирование таблицы
		$reakciya_uroven = explode(',', $array['recept_spisock']);
		for ($zm = 0; $zm < $array['polnuh']; $zm++) {
			foreach (Data(TABLE_BS) as $item) {
				if ($item['reakciya'] == $reakciya_uroven[0] && $item['uroven'] == $reakciya_uroven[1] && $item['biostimulyator'] == $array['biostemulyator'] && $item['cickl'] == ($zm + 1) && $item['chust'] == $thuvstvitelnost) {
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
				$tablet .= '<div>
						<div class="recept_ogl1"><b>Назначенный биостимулятор: </b>' . $array['biostemulyator'] . '</div>
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

			for ($i = 0; $i < $array['datestart']; $i++) {
				$nt = date('Y-m-d', strtotime($fm . '+' . $i . 'days'));
			}

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
					if ($colon == 1 || $colon == 3) {
						$itog = round($coln[$j] * $array['mnojitel']);
						if ($itog == 0) $itog = '';
						$tablet .= '<div class="date_table">' . $itog . '</div>';
					} else {
						$tablet .= '<div class="date_table">' . $coln[$j] . '</div>';
					}
				}

				$tablet .= '</div>';
			}

			$tablet .= '</div>';
		}

		$tablet .= ReceptRecomendacii() . '<br><div class="block_ancetu">' . $array['rec'] . '</div><br></div>'; // Описание под таблицей
		return [$tablet, $tabu, $categori];
	}
}

class DataRegular
{
	public function RegularData()
	{
		$d = '<option></option>';
		for ($i = 1; $i < 32; $i++) {
			$d .= '<option>' . $i . '</option>';
		}
		return $d;
	}

	public function RegularNedela()
	{
		$n = '<option></option>';
		$array = ['Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота', 'Воскресенье'];
		for ($i = 0; $i < 7; $i++) {
			$n .= '<option value="' . $i . '">' . $array[$i] . '</option>';
		}
		return $n;
	}
}

class Polsovatel
{
	public $id;

	public function ValutaPolsovatela()
	{
		foreach (Data(POLSOVATEL) as $item) {
			if ($this->id == $item['id']) {
				$valuta = $item['valuta'];
			}
		}
		return $valuta;
	}

	public function SummaPolsovatela()
	{
		foreach (Data(POLSOVATEL) as $item) {
			if ($this->id == $item['id']) {
				$summa = $item['summ'];
			}
		}
		return $summa;
	}

	public function OtricatelnoPolsovatela()
	{
		foreach (Data(POLSOVATEL) as $item) {
			if ($this->id == $item['id']) {
				$otr = $item['otricatelno'];
			}
		}
		return $otr;
	}
}

// работа со счетом
function ValutAncetReserv($price)
{
	include CONECT;

	if ($price['summa'] >= ConverterValut($price['valuta'], $price['price'], $price['val_pol'])) {
		$space = new Spacecraft;
		$space->Fixed([
			'id' => $_SESSION['data_personal']['id'],
			'price' => $price['price'],
			'valuta' => $price['valuta'],
			'name' => $price['name']
		]);

		// если  результат, то записываем его в файл
		if ($price['table']) {
			file_put_contents('../histori/' . $_SESSION['data_personal']['id'] . '.' . date('d-m-Y') . '.on.' . $price['name_usluga'] . '.' . '0-' . $price['valuta'] . '.tpl', $price['table']);
		}
	} elseif ($price['otr'] == 'on') {
		// если  результат отрицательный, то записываем его в файл
		if ($price['table']) {
			file_put_contents('../histori/' . $_SESSION['data_personal']['id'] . '.' . date('d-m-Y') . '.off.' . $price['name_usluga'] . '.' . $price_uslug . '-' . $price['valuta'] . '.tpl', $price['table']);
		}
	}
	return true;
}

function EmailOplata()
{
	foreach (Data(EMAIL_OPLATA) as $item) {
		$emailotvet = $item['name'];
	}
	return $emailotvet;
}

function Diagrama($usersname, $nn)
{
	foreach (data(DIAGRAMA) as $item) {
		if ($usersname == $item['name'] && $nn[0] == $item['data']) {
			for ($a = 2; $a < 9; ++$a) {
				$res[] = $item[$a];
				$data = $item['data'];
				$ress = $item['result'];
			}
		}
	}
	return [$res, $data, $ress];
}

function MenuDiagram($datareg, $usersname, $nn)
{
	$steck = '';
	$steck .= '<option></option>';
	if ($datareg != '01.01.70') {
		foreach (Data(DIAGRAMA) as $item) {
			if ($datareg == $item['data']) {
				$select = ($item['name'] == $usersname) ? ' selected' : '';
				$steck .= '<option' . $select . '>' . $item['data'] . '|' . $item['name'] . '</option>';
			}
		}
	} elseif ($datareg == '01.01.70') {
		foreach (Data(DIAGRAMA) as $item) {
			$select = ($item['name'] == $usersname && $nn[0] == $item['data']) ? ' selected' : '';
			$steck .= '<option' . $select . '>' . $item['data'] . '|' . $item['name'] . '</option>';
		}
	}
	return $steck;
}

function Diagnostic($usersname, $voprosu)
{
	include CONECT;
	$otvetpol = ['нет', '<span style="color: #1049ea;">редко</span>', '<span style="color: #883b0f;">бывает</span>', '<span style="color: #ff1e13;">часто</span>'];
	$color = ['#71BF44', '#F0DFAC', '#00AEEF', '#FBB040', '#B88BBF', '#F6A8CA', '#1C75BC'];
	$o = 1;
	for ($m = 0; $m < 9; $m++) {
		$result = mysqli_query($mysqli, "SELECT * FROM " . DIAGNISTIC . " where id = $m") or die("Ошибка " . mysqli_error($mysqli));
		$rows = mysqli_num_rows($result);
		for ($i = 0; $i < $rows; ++$i) {
			if (Pol($usersname) == 'Мужской' && $m == 3) $m = 4;
			if (Pol($usersname) == 'Женский' && $m == 4) $m = 5;
			$row = mysqli_fetch_row($result);
			$diagnostic .= '<br><div style="color: ' . $color[$o - 1] . '; font-weight: 800; font-size: 30px;"><b>' . $o . '. ' . $row[1] . '</b></div>';
			for ($k = 0; $k < 10; $k++) {
				$backg = ($k == 0 || $k == 2 || $k == 4 || $k == 6 || $k == 8 || $k == 10) ? 'class="q"' : '';
				$diagnostic .= '<div ' . $backg . ' style="float: left;">
					<div style="float: left; width: 1080px; padding: 5px;">' . $row[$k + 2] . '</div>
					<div style="float: right; width: 60px; padding: 5px;"><b>' . $otvetpol[$voprosu[($o . $k) - 10]] . '</b></div>
				</div>';
			}
			$o++;
		}
	}
	return $diagnostic;
}

function FormaValuta()
{
	$form_valuta = '';
	foreach (Data(VALUTA) as $item) {
		$form_valuta .= '<form action="index.php?name=valuta&id=' . $item['id'] . '" method="post" enctype="multipart/form-data" style="overflow: hidden;">
			<div>
				<div class="punckt2">
					<label class="wf_text">Название валюты:</label>
					<input name="name_vall" class="pole_vvoda" type="text" value="' . $item['valuta'] . '">
				</div>
				<div class="punckt2">
					<label class="wf_text">Коэфициент:</label>
					<input name="sum_vall" class="pole_vvoda" type="text" value="' . $item['coeficient'] . '">
				</div>
				<input class="wf_blanck2 jk right_" name="vall" type="submit" value="Изменить">
			</div>
		</form><br>';
	}
	return $form_valuta;
}

function FinOtchot($datasortir)
{
	$fin = '';
	foreach (Data(FINOTCHET) as $item) {
		$datavvoda = date('d.m.y', strtotime($item['data']));
		if ($datasortir != '01.01.70' && $datasortir != '') {
			if ($datavvoda == $datasortir && $datavvoda != '01.01.70') {
				$fin .= '<div class="punckt2">
					<form action="index.php?name=valuta&sav=savings&id=' . $item['id'] . '" method="post" enctype="multipart/form-data">
						<div class="table_width2b">' . $datavvoda . '</div>
						<input class="pole_vvoda2" name="nevsumdat" placeholder="' . $item['summa'] . '">
						<input class="wf_blanck2 jk" name="saving" type="submit" value="ок">
						<a style="color: red;" name="deldata" href="index.php?name=valuta&deldat=dell&id=' . $item['id'] . '">' . Del('icon3red') . '</a>
					</form>
				</div>';
			}
		} else {
			$fin .= '
			<div class="punckt2">
				<form action="index.php?name=valuta&sav=savings&id=' . $item['id'] . '" method="post" enctype="multipart/form-data">
					<div class="table_width2b">' . $datavvoda . '</div>
					<input class="pole_vvoda2_2 pole_vvoda2" name="nevsumdat" placeholder="' . $item['summa'] . '">
					<input class="wf_blanck2 jk" name="saving" type="submit" value="ок">
					<a style="color: red;" name="deldata" href="index.php?name=valuta&deldat=dell&id=' . $item['id'] . '">' . Del('icon3red') . '</a>
				</form>
			</div>';
		}
	}
	return $fin;
}

function DeletFinOtchot($new_get)
{
	include CONECT;
	$id = $new_get['id'];
	mysqli_query($mysqli, "DELETE FROM " . FINOTCHET . " WHERE  id = $id") or die("Ошибка " . mysqli_error($mysqli));
	return true;
}

function UpdateFinOtchot($new_get, $new_post)
{
	include CONECT;
	$id = $new_get['id'];
	$sumdat = $new_post['nevsumdat'];
	mysqli_query($mysqli, "UPDATE " . FINOTCHET . " SET `summa` = '$sumdat' WHERE " . FINOTCHET . ".`id` = $id;") or die("Ошибка " . mysqli_error($mysqli));
	return true;
}

function UpdateValuta($new_get, $new_post)
{
	include CONECT;
	$idval = $new_get['id'];
	$nameval = $new_post['name_vall'];
	$sumval = $new_post['sum_vall'];
	mysqli_query($mysqli, "UPDATE " . VALUTA . " SET `valuta` = '$nameval', `coeficient` = '$sumval' WHERE " . VALUTA . ".`id` = $idval;") or die("Ошибка " . mysqli_error($mysqli));
	return true;
}

function UpdateCartUserSakas($new_get)
{
	include CONECT;

	$space = new Spacecraft;
	$space2 = new Spacecraft;

	// идентификатор заказа
	$idsak = $new_get['ret'];

	if ($new_get['product_array']) { // Списание заказа
		$data_individual = explode(',', $new_get['client_summa']);

		// получаем список id продукта из заказа
		$ru = 0;
		foreach (Data(CARTCLIENT) as $item) {
			if ($idsak == $item['user_id']) {
				$id_protuct[$ru++] = $item['product_id'];
			}
		}

		// получем описание из фрилансеры
		$rows = count($id_protuct);
		for ($i = 0; $i < $rows; $i++) {
			foreach (Data(PRODUCT) as $item) {
				if ($item['id'] == $id_protuct[$i]) {
					$frilanc_price[$i] = explode(' ', $item['comentari'])[8];
					$frilanc_limit[$i] = explode(' ', $item['comentari'])[4];
				}
			}
		}

		// получение персональных данных
		foreach (Data(POLSOVATEL) as $item) {
			if ($item['lastname'] . ' ' . $item['firstname'] . ' ' . $item['middlename'] == $data_individual[3]) {
				$id_client = $item['id'];
				$otricatelno = $item['otricatelno'];
				$sama_tec = $item['summ'];
				$summ = ConverterValut($item['valuta'], $item['summ'], 'грн');
			}
		}

		$summa_product = ConverterValut($data_individual[1], $data_individual[0], 'грн');

		if (($data_individual[2] == 'off' && $otricatelno == 'on') || ($summ >= $summa_product && $data_individual[2] == 'off')) {

			// подтверждаем заказ обработки
			mysqli_query($mysqli, "UPDATE " . CARTUSER . " SET `sakas` = 'obr' WHERE " . CARTUSER . ".`id` = $idsak") or die("Ошибка " . mysqli_error($mysqli));

			// считаем количество заказаных обработок
			if ($new_get['frilanc']) {
				$obrabotci = $new_get['frilanc'];
			}

			// определяем количесто цыклов по количеству продуктов
			$prod_ar = explode('|', $new_get['product_array']);
			$rows = count($prod_ar);
			for ($i = 0; $i < $rows; $i++) {
				// выбираем из списка название и сумму услуги
				$nr = explode('-', $prod_ar[$i]); // Название, валюта
				$name_usluga = $nr[0];
				$price = $nr[1];

				// если в долг
				if ($sama_tec < 0) {
					$raschet_usluga = 'Долг';
				} else {
					$raschet_usluga = 'Оплачено';
				}

				$pridlog = explode(' ', $name_usluga);

				if (($pridlog[0] . ' ' . $pridlog[1]) == 'Бонусные единицы') {
					//  списываем средства
					$space2->FixdFrilance([
						'id' => $id_client,
						'price' => $frilanc_price[$i],
						'valuta' => 'cor',
						'name' => $name_usluga,
						'usluga' => $raschet_usluga,
						'groups' => 'Фрилансеры',
						'frilanc_plus' => $frilanc_limit[$i]
					]);
				} else {
					//  списываем средства
					$space->Fixed([
						'id' => $id_client,
						'price' => $price,
						'valuta' => $data_individual[1],
						'name' => $name_usluga,
						'usluga' => $raschet_usluga,
						'frilanc' => $obrabotci
					]);
				}
			}
		} elseif ($data_individual[2] == 'on') {

			// записываем обработку
			mysqli_query($mysqli, "UPDATE " . CARTUSER . " SET `sakas` = 'obr' WHERE " . CARTUSER . ".`id` = $idsak") or die("Ошибка " . mysqli_error($mysqli));

			// считаем количество заказаных обработок
			if ($new_get['frilanc']) {
				$obrabotci = $new_get['frilanc'];
			}

			$prod_ar = explode('|', $new_get['product_array']);
			$rows = count($prod_ar);

			for ($i = 0; $i < $rows; $i++) {

				// выбираем из списка название и сумму услуги
				$nr = explode('-', $prod_ar[$i]); // Название, валюта
				$name_usluga = $nr[0];
				$price = $nr[1];

				// если в долг
				if ($sama_tec < 0) {
					$raschet_usluga = 'Долг';
				} else {
					$raschet_usluga = 'Оплачено';
				}

				$pridlog = explode(' ', $name_usluga);

				if ($pridlog[0] . ' ' . $pridlog[1] == 'Бонусные единицы') {
					//  списываем средства
					$space2->FixdFrilance([
						'id' => $id_client,
						'price' => $frilanc_price[$i],
						'valuta' => 'cor',
						'name' => $name_usluga,
						'usluga' => $raschet_usluga,
						'groups' => 'Фрилансеры',
						'frilanc_plus' => $frilanc_limit[$i]
					]);
				}
			}
		}
	}
	return true;
}

function UpdateCartUserOplataGreen($new_get)
{
	include CONECT;
	$idopl = $new_get['ret'];
	mysqli_query($mysqli, "UPDATE " . CARTUSER . " SET `oplata` = '<div style=\"color: green;\">Оплачен</div>' WHERE " . CARTUSER . ".`id` = $idopl") or die("Ошибка " . mysqli_error($mysqli));
	return true;
}

function UpdateCartUserOplataRed($new_get)
{
	include CONECT;
	$idopl = $new_get['ret'];
	mysqli_query($mysqli, "UPDATE " . CARTUSER . " SET `oplata` = '<div style=\"color: red;\">Не оплачен</div>' WHERE " . CARTUSER . ".`id` = $idopl") or die("Ошибка " . mysqli_error($mysqli));
	return true;
}

function DeleteCartUser($new_get)
{
	include CONECT;
	$idtov = $new_get['ret'];

	foreach (Data(CARTCLIENT) as $item) {
		if ($item['user_id'] == $idtov) {
			$id = $item['id'];
			mysqli_query($mysqli, "DELETE FROM " . CARTCLIENT . " WHERE  " . CARTCLIENT . ".`id` = $id") or die("Ошибка " . mysqli_error($mysqli));
		}
	}

	mysqli_query($mysqli, "DELETE FROM " . CARTUSER . " WHERE  " . CARTUSER . ".`id` = $idtov") or die("Ошибка " . mysqli_error($mysqli));
	return true;
}

function CartUser()
{
	foreach (Data(CARTUSER) as $item) {
		if ($item['sakas'] == 'sak' || $item['sakas'] == 'obr') {
			$idclient[] = $item['id'];
			$username[] = $item['name'];
			$sakas[] = $item['sakas'];
			$datasak[] = $item['date'];
			$oplata[] = $item['oplata'];
		}
	}
	return [$idclient, $username, $sakas, $datasak, $oplata];
}

function strip_tags_content($text)
{
	return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
}

function SteacSakas($tt)
{
	$cart_array = CartUser();
	$idclient = $cart_array[0];
	$username =	$cart_array[1];
	$sakas = $cart_array[2];
	$datasak = $cart_array[3];
	$oplata = $cart_array[4];
	$diag = count($idclient);

	$sakas_res = '<div class="south">' . Cart('icon4') . '</div>
	<h1 style="text-align: center;">Список заказов</h1>
	<h2>Редактирование заказов</h2>
	<p class="redd"><span class="red_h">Оплату определить можно по указателю в правом верхнем углу («Оплачено» или «Не оплачено»), указатель может и отсутсвовать (Будте внимательны).<br>
	Необходимые действия в разделе «Корзина»:</span><br>
	<span class="red_h">1.</span> Если подтверждение требует список в котором только фриланс. Проверить сумму на карте, не внося сумму на счет подтвердить заказ, после на счет запишется нужная сумма и добавится нужное количество обработок;<br><br>
	<span class="red_h">2.</span> У фрилансеров подтверждение работает не зависимо от того стоит опата или нет. Нужно убедится в поступлении средств, а потом подтвердить заказ;<br><br>
	<span class="red_h">3.</span> Если фриланс оформлен с товарами, то проводится правильно, средства зачисляються за фриланс, а за остальные товары списывается нужная сумма;<br><br>
	<span class="red_h">4.</span> Если стоит не оплачено и в заказе есть товары кроме бонусных едениц, то нужно проверить поступление на карту или убедится в том, что человек дал эти средства на руки, после внести в персональные данные нужную сумму, а потом, не меняя статус оплаты подтвердить заказ чтобы средства списало со счета. Если средств недостаточно подтверждение не будет проводится. Если стоит оплачен, проведет подтверждение без списания средств;</p>';
	$print = 0;
	for ($e = 0; $e < $diag; $e++) {
		$srt = $idclient[$e];
		foreach (Data(CARTCLIENT) as $item) {
			if ($srt == $item['user_id']) {
				$idhhm[] = $item['user_id'];
				$idtovara[] = $item['product_id'];
				$col[] = $item['quantity'];
				if ($item['valuta'] == '') {
					$valute[] = 'cor';
				} else {
					$valute[] = $item['valuta'];
				}
			}
		}

		$colprod = count($idtovara);
		$print++;

		if (strip_tags($oplata[$e]) == 'Оплачен') {
			$statos_oplatu = 'on';
		} else {
			$statos_oplatu = 'off';
		}

		if ($sakas[$e] == 'sak') {
			$sakk = '<b>Статус заказа:</b> <span style="color: #246ad6;">заказан, ожидает обработку</span>';
		} elseif ($sakas[$e] == 'obr') {
			$sakk = '<b>Статус заказа:</b> <span style="color: #0bbd12;">обработан, отправлен</span>';
		}

		$sakas_res .= '<div class="icon_print"><div style="float: left; padding-right: 10px;">' . $datasak[$e] . ' <b>' . $username[$e] . '</b></div>' . $sakk . '<div style="float: right;">' . $oplata[$e] . '</div></div>
		<div id="print-content' . $print . '" style="border-bottom: 1px solid #555;">
			<div class="cart3"><b>
				<div class="imges"></div>
				<div class="tov_block">Наименование</div>
				<div class="tov_block2">Единиц</div>
				<div class="tov_block2">Цена</div>
				<div class="tov_block2">Всего</div>
				<div class="tov_block2 vis"></div></b>
		</div>' . $tt;

		$col_obr = '';
		$itogresut = '';

		for ($a = 0; $a < $colprod; $a++) {
			if ($idclient[$e] == $idhhm[$a]) {
				foreach (Data(PRODUCT) as $item) {
					if ($item['id'] == $idtovara[$a]) {
						$nameproduct = $item['name'];
						$foto = $item['foto'];
						$price2 = $item['price'];

						if ($item['product_group'] == 'ФРИЛАНСЕРЫ') {
							$col_obrabotoc = explode(' ', $item['comentari']);
							$col_obr += (int) $col_obrabotoc[4];
							$frilanc = $col_obr;
						} else {
							$frilanc = '';
						}
					}
				}

				$vall = 'грн';
				$price = ConverterValut('cor', $price2, 'грн');
				$suma = $col[$a] * $price;
				$sakas_res .= '<div class="cart3">
					<img class="imges" src="images/' . $foto . '">
					<div class="tov_block">' . $nameproduct . '</div>
					<div class="tov_block2">' . $col[$a] . '</div>
					<div class="tov_block2">' . $price . ' ' . $vall . '</div>
					<div class="tov_block2">' . $suma . ' ' . $vall . '</div>
				</div>';
				$itogresut{
					$e} += $suma;
				$array_tov[$a] = $nameproduct . '-' . $suma;
			}
		}

		$arr_tov = implode('|', $array_tov);
		$array = $itogresut[$e] . ',' . $vall . ',' . $statos_oplatu . ',' . $username[$e];

		if ($sakas[$e] == 'sak') {
			$ty = '<div style="width: 100%; overflow: hidden; border-bottom: 1px solid #ddd; padding: 10px 0;">
				<a href="index.php?name=cart&oplata=opl&ret=' . $idclient[$e] . '" class="wf_blanck2 jk right_" value="">Оплачен</a>
				<a href="index.php?name=cart&oplata=noopl&ret=' . $idclient[$e] . '" class="wf_blanck2 jk right_" value="">Не оплачен</a>
				<a href="index.php?name=cart&otp=opt&ret=' . $idclient[$e] . '&client_summa=' . $array . '&product_array=' . $arr_tov . '&frilanc=' . $frilanc . '" class="wf_blanck2 jk right_" value="">Подтвердить заказ</a>
				<a href="index.php?name=cart&deltov=delt&ret=' . $idclient[$e] . '" class="wf_blanck2 jk right_" value="">Удалить</a>
			</div>';
		} else {
			$ty = '<div style="width: 100%; overflow: hidden; border-bottom: 1px solid #ddd; padding: 10px 0;">
				<a href="index.php?name=cart&deltov=delt&ret=' . $idclient[$e] . '" class="wf_blanck2 jk right_" value="12">Удалить</a>
			</div>';
		}

		$sakas_res .= '<div style="width: 100%; overflow: hidden;">
				<div class="itog_"><b>И того:</b> ' . $itogresut[$e] . ' ' . $vall . '</div>
			</div>
			' . $ty . '
		</div>';

		unset($idclient[0], $array_tov);
	}
	return $sakas_res;
}

function LoginOperator($new_post)
{
	include CONECT;
	$login = $new_post['login_admin'];
	$pass = md5($new_post['pass_admin']);
	$new_login_operator = $new_post['new_login'];
	$new_pass = md5($new_post['new_pass_admin']);

	foreach (Data(ADMIN) as $item) {
		if ($login == $item['login'] && $pass == $item['password'] && $new_login_operator && $new_pass) {

			if ($new_login_operator == '') {
				$new_login_operator = $new_post['login_admin'];
			}

			$mysqli->query("UPDATE " . ADMIN . " SET `login` = '$new_login_operator', `password` = '$new_pass' WHERE " . ADMIN . ".`id` = 1");
			$text_ = '<span style="color: green;">Логин администратора изменен успешно!</span>';
		} else {
			$text_ = '<span style="color: red;">Неверные данные оператора!<br>Логин и пароль не изменены!</span>';
		}
	}
	return $text_;
}

function LoginAdmin($new_post)
{
	include CONECT;
	$login = $new_post['login_system'];
	$pass = $new_post['pass_system'];
	$new_login = $new_post['new_sys_login'];
	$new_pass = $new_post['new_pass_system'];
	foreach (Data(SYSTEMADMIN) as $item) {
		if ($login == $item['login'] && $pass == $item['pass'] && $new_login && $new_pass) {
			if ($new_login != '' && $new_login != ' ') {
				$mysqli->query("UPDATE " . SYSTEMADMIN . " SET `login` = '$new_login' WHERE " . SYSTEMADMIN . ".`id` = 1");
				$text_ = '<span style="color: green;">Логин системного администратора изменен успешно!</span>';
			} else {
				$text_ = '<span style="color: red;">Неверные данные системного администратора!</span>';
			}

			if ($new_pass != '' && $new_pass != ' ') {
				$mysqli->query("UPDATE " . SYSTEMADMIN . " SET `pass` = '$new_pass' WHERE " . SYSTEMADMIN . ".`id` = 1");
				$text_2 = '<span style="color: green;">Пароль системного администратора изменен успешно!</span>';
			} else {
				$text_2 = '<span style="color: red;">Неверные данные системного администратора!</span>';
			}
		}
	}
	return [$text_, $text_2];
}

function EmailOperatop($new_post)
{
	include CONECT;
	$email_operator = $new_post['new_email_operator'];
	$mysqli->query("UPDATE " . ADMIN . " SET `email` = '$email_operator' WHERE " . ADMIN . ".`id` = 1");
	$text_3 = '<span style="color: green;">E-mail системного администратора изменен успешно!</span>';
	return $text_3;
}

function EmailSystem1($new_post)
{
	include CONECT;
	$new_email = $new_post['new_email_system_'];
	$mysqli->query("UPDATE " . SYSTEMADMIN . " SET `email` = '$new_email' WHERE " . SYSTEMADMIN . ".`id` = 1");
	$text_3 = '<span style="color: green;">E-mail системного администратора изменен успешно!</span>';
	return $text_3;
}

function EmailSystem2($new_post)
{
	include CONECT;
	$new_email2 = $new_post['new_email_system2_'];
	$mysqli->query("UPDATE " . SYSTEMADMIN . " SET `email2` = '$new_email2' WHERE " . SYSTEMADMIN . ".`id` = 1");
	$text_3 = '<span style="color: green;">E-mail системного администратора изменен успешно!</span>';
	return $text_3;
}

function NewEmailOperator()
{
	foreach (Data(ADMIN) as $item) {
		return $item['email'];
	}
}

function NewEmailSystemAdmin()
{
	foreach (Data(SYSTEMADMIN) as $item) {
		return [$item['email'], $item['email2']]; // востановление, системный аминистратор
	}
}

function EmailOplataAuto($new_post)
{
	include CONECT;
	$mailnameotv = $_POST['emailotvet'];
	$mysqli->query("UPDATE " . EMAIL_OPLATA . " SET `name` = '$mailnameotv' WHERE " . EMAIL_OPLATA . ".`id` = 0");
	return true;
}

function EditColumTable($new_get)
{
	include CONECT;
	if ($new_get['reles'] == 'fio_o') {
		foreach (Data(COLUM) as $item) {
			if ($item['id'] == 1) {
				$on_off = ($item['fio'] == 'on') ? 'off' : 'on';
				$mysqli->query("UPDATE " . COLUM . " SET `fio` = '$on_off' WHERE " . COLUM . ".`id` = 1");
			}
		}
	}
	if ($new_get['reles'] == 'data_r') {
		foreach (Data(COLUM) as $item) {
			if ($item['id'] == 1) {
				$on_off = ($item['data'] == 'on') ? 'off' : 'on';
				$mysqli->query("UPDATE " . COLUM . " SET `data` = '$on_off' WHERE " . COLUM . ".`id` = 1");
			}
		}
	}
	if ($new_get['reles'] == 'ok') {
		foreach (Data(COLUM) as $item) {
			if ($item['id'] == 1) {
				$on_off = ($item['ok'] == 'on') ? 'off' : 'on';
				$mysqli->query("UPDATE " . COLUM . " SET `ok` = '$on_off' WHERE " . COLUM . ".`id` = 1");
			}
		}
	}
	if ($new_get['reles'] == 'time_load') {
		foreach (Data(COLUM) as $item) {
			if ($item['id'] == 1) {
				$on_off = ($item['time_load'] == 'on') ? 'off' : 'on';
				$mysqli->query("UPDATE " . COLUM . " SET `time_load` = '$on_off' WHERE " . COLUM . ".`id` = 1");
			}
		}
	}
	if ($new_get['reles'] == 'personal_number') {
		foreach (Data(COLUM) as $item) {
			if ($item['id'] == 1) {
				$on_off = ($item['personal_number'] == 'on') ? 'off' : 'on';
				$mysqli->query("UPDATE " . COLUM . " SET `personal_number` = '$on_off' WHERE " . COLUM . ".`id` = 1");
			}
		}
	}
	if ($new_get['reles'] == 'group_number') {
		foreach (Data(COLUM) as $item) {
			if ($item['id'] == 1) {
				$on_off = ($item['group_number'] == 'on') ? 'off' : 'on';
				$mysqli->query("UPDATE " . COLUM . " SET `group_number` = '$on_off' WHERE " . COLUM . ".`id` = 1");
			}
		}
	}
	if ($new_get['reles'] == 'card_ras') {
		foreach (Data(COLUM) as $item) {
			if ($item['id'] == 1) {
				$on_off = ($item['card_ras'] == 'on') ? 'off' : 'on';
				$mysqli->query("UPDATE " . COLUM . " SET `card_ras` = '$on_off' WHERE " . COLUM . ".`id` = 1");
			}
		}
	}
	if ($new_get['reles'] == 'oplashen') {
		foreach (Data(COLUM) as $item) {
			if ($item['id'] == 1) {
				$on_off = ($item['oplashen'] == 'on') ? 'off' : 'on';
				$mysqli->query("UPDATE " . COLUM . " SET `oplashen` = '$on_off' WHERE " . COLUM . ".`id` = 1");
			}
		}
	}
	if ($new_get['reles'] == 'sum_opl') {
		foreach (Data(COLUM) as $item) {
			if ($item['id'] == 1) {
				$on_off = ($item['sum_opl'] == 'on') ? 'off' : 'on';
				$mysqli->query("UPDATE " . COLUM . " SET `sum_opl` = '$on_off' WHERE " . COLUM . ".`id` = 1");
			}
		}
	}
	return true;
}

function StyleColum()
{
	foreach (Data(COLUM) as $item) {
		if ($item['id'] == 1) {
			$class_fio = ($item[1] == 'on') ? 'aoff' : 'aon';
			$class_data_r = ($item[2] == 'on') ? 'aoff' : 'aon';
			$class_ok = ($item[3] == 'on') ? 'aoff' : 'aon';
			$class_time_load = ($item[4] == 'on') ? 'aoff' : 'aon';
			$class_personal_number = ($item[5] == 'on') ? 'aoff' : 'aon';
			$class_group_number = ($item[6] == 'on') ? 'aoff' : 'aon';
			$class_card_ras = ($item[7] == 'on') ? 'aoff' : 'aon';
			$class_oplashen = ($item[8] == 'on') ? 'aoff' : 'aon';
			$class_sum_opl = ($item[9] == 'on') ? 'aoff' : 'aon';
		}
	}
	return $array = [$class_fio, $class_data_r, $class_ok, $class_time_load, $class_personal_number, $class_group_number, $class_card_ras, $class_oplashen, $class_sum_opl];
}

function SteckClientu($style_colum)
{
	$client = '';
	$client .= '<div class="form_table">
	<div class="table_contents">
		<div class="namber">№</div>';
	if ($style_colum[0] == 'aon') $client .= '<div class="table_width">ФИО</div>';
	if ($style_colum[1] == 'aon') $client .= '<div class="table_width3">Рождение</div>';
	if ($style_colum[2] == 'aon') $client .= '<div class="table_width2">Обработано</div>';
	if ($style_colum[3] == 'aon') $client .= '<div class="table_width2">Прислано</div>';
	if ($style_colum[4] == 'aon') $client .= '<div class="table_width2a">Перс. №</div>';
	if ($style_colum[5] == 'aon') $client .= '<div class="table_width2a">Группа</div>';
	if ($style_colum[6] == 'aon') $client .= '<div class="table_width">На кого карта</div>';
	if ($style_colum[7] == 'aon') $client .= '<div class="table_width2a">Оплачен</div>';
	if ($style_colum[8] == 'aon') $client .= '<div class="table_width2a">Сумма</div>';
	$client .= '</div>';
	$mas = Data(CLIENTU);
	arsort($mas);
	$z = 0;
	foreach ($mas as $item) {
		$client .= '<div class="form_table">
			<div class="namber">' . ++$z . '</div>';

		if ($style_colum[0] == 'aon') {
			$client .= '<div class="table_width" name=' . $item['id'] . ' id=' . $item['id'] . '>' . $item['lastname'] . ' ' . $item['firstname'] . ' ' . $item['middlename'] . '</div>';
		}
		if ($style_colum[1] == 'aon') {
			$client .= '<div class="table_width3">' . $item['rojdenie'] . '</div>';
		}
		if ($style_colum[2] == 'aon') {
			if (!$item['status']) {
				$client .= '<div style="color: red;" class="table_width2">Не обработано</div>';
			} else {
				$client .= '<div style="color: green;" class="table_width2 green_stat">Обработано</div>';
			}
		}
		$oplata = $item['oplata'];
		$client .= '<a style="color: #429eff;" href="index.php?name=clientlisting&id=' . $item['id'] . '">' . Clientu('icon3') . '</a>
			<a style="color: red;" href="index.php?name=c_del&id=' . $item['id'] . '">' . Del('icon3red') . '</a>';
		if ($style_colum[3] == 'aon') $client .= '<div class="table_width2">' . $item['data_registr'] . '</div>';
		if ($style_colum[4] == 'aon') $client .= '<div class="table_width2a">' . $item['personal_num'] . '</div>';
		if ($style_colum[5] == 'aon') $client .= '<div class="table_width2a">' . $item['group'] . '</div>';
		if ($style_colum[6] == 'aon') $client .= '<div class="table_width" >' . $item['fio_card'] . '</div>';
		if ($style_colum[7] == 'aon') $client .= '<div class="table_width2a" >' . $oplata . '</div>';
		if ($style_colum[8] == 'aon') $client .= '<div class="table_width2a" >' . $item['summ'] . '</div>';
		$client .= '</div>';
	}
	$client .= '</div>';
	return $client;
}

function ClientDataPersonal($new_get)
{
	$id = $new_get['id'];
	$personal_data = '';
	$personal_data .= '<div class="form_table">
		<div class="table_contents">
			<div class="namber">№</div>
			<div class="table_width">ФИО</div>
			<div  class="table_width3">Рождение</div>
			<div class="table_width2">Обработано</div>
			<div  class="table_width2">Регистрация</div>
			<div  class="table_width2a">Перс. №</div>
			<div  class="table_width2a">Группа</div>
			<div  class="table_width">На кого карта</div>
			<div  class="table_width2a">Оплачен</div>
		</div>';
	$t = 0;
	foreach (Data(CLIENTU) as $item) {
		if ($item['id'] == $id) {
			$personal_data .= '<div class="form_table">
				<div  class="namber">' . ++$t . '</div>
				<div  class="table_width" name="' . $item['id'] . '" id="' . $item['id'] . '">' . $item['lastname'] . ' ' . $item['firstname'] . ' ' . $item['middlename'] . '</div>
				<div  class="table_width3">' . $item['rojdenie'] . '</div>';

			$personal_data .= (!$item['status']) ? "<div  class='table_width2 red_stat'>Не обработано</div>" : "<div  class='table_width2 green_stat'>Обработано</div>";

			$personal_data .= '<div class="table_width2">' . $item['data_registr'] . '</div>
				<div  class="table_width2a">' . $item['personal_num'] . '</div>
				<div  class="table_width2a">' . $item['group'] . '</div>
				<div  class="table_width" >' . $item['fio_card'] . '</div>
				<div  class="table_width2a" >' . $item['oplata'] . '</div>
				</div>';
		}
	}
	$personal_data .= "</div>";
	return $personal_data;
}

function FormaObrabotci($new_files, $new_post, $new_get)
{
	include CONECT;
	$filename = $new_files['filename']['name'];
	$tmp = $new_files['filename']['tmp_name'];
	$file_date = date('YmdHis');
	$md = md5($filename) . '-' . $file_date . '.' . pathinfo($filename, PATHINFO_EXTENSION);
	$id = $new_get['id'];

	if (is_uploaded_file($tmp)) {
		move_uploaded_file($tmp, '../download/' . $md);
		$file_set = $filename;
	} else {
		$file_set = '<span style="color: red;">Файл не загружен</span>';
	}

	if ($filename || $new_post['coment_'] != '') {
		$file = $mysqli->real_escape_string(htmlspecialchars($new_post['uploadfile']));
		$mysqli->query("UPDATE " . CLIENTU . " SET `status` = '1', `filepdf` = '$md' WHERE " . CLIENTU . ".`id` =$id");
	}

	$file_upload .= '<div class="content">Имя загружаемого файла: <span style="color: blue;">' . $file_set . '</span><br>
	Имя фала для получателя отправляемое на E-mail: <span style="color: blue;">' . $md . '</span><br></div>';

	foreach (Data(CLIENTU) as $item) {
		if ($id == $item['id']) {
			$fio = $item['lastname'] . ' ' . $item['firstname'] . ' ' . $item['middlename'];
			$email_client = $item['email'];
			$pdf = $item['filepdf'];
			$dop_card = $item['dop_card'];
			$rojdenie = $item['rojdenie'];
			$state = $item['state'];
			$position = $item['position'];
			$treatment = $item['treatment'];
			$fio_card = $item['fio_card'];
			$oplata = $ite['oplata'];
			$complaint = $item['complaint'];
			$comentari_new = $item['comentari'];
			$file = $item['file'];
			$file_upload .= '<div>Регистрация клиента: ' . $fio . ', с адресом E-mail: ' . $email_client . '</div>';

			if ($filename || $new_post['coment_']) {

				if ($new_post['coment_']) {
					$comentari = $new_post['coment_'] . '. ';
				}

				$email = 'http://iridoc.com/cardio/download/' . $pdf;

				if ($filename) {
					$comentariy = 'Результат обработки файла готов для скачивания по ссылке: ' . $email;
				}

				mail($email_client, 'SUM_LINE"', $comentari . $comentariy);
			}
			$file_upload .= '</div>';
		}
	}
	return [$file_upload, $fio, $email_client, $dop_card, $rojdenie, $state, $position, $treatment, $fio_card, $oplata, $complaint, $comentari_new, $file];
}

function PartneruA()
{
	$partner = '';
	$partner .= '<option></option>';
	foreach (Data(PARTNER) as $item) {
		$partner .= '<option>' . $item['lastname'] . ' ' . $item['firstname'] . ' ' . $item['middlename'] . '</option>';
	}
	return $partner;
}

function PersoalDataDelet($new_files, $new_post, $new_get)
{
	include CONECT;
	$form_obr = FormaObrabotci($new_files, $new_post, $new_get);
	$new_fio = explode(' ', $form_obr[1]);
	$id = $new_get['id'];

	if ($new_post['opl']) {
		$mysqli->query("UPDATE " . CLIENTU . " SET `oplata` = '<span style=\"color: green;\">да</span>' WHERE " . CLIENTU . ".`id` =$id");
		$oplata = '<span style="color: green;">да</span>';
	}

	if ($new_post['noopl']) {
		$mysqli->query("UPDATE " . CLIENTU . " SET `oplata` = '<span style=\"color: red;\">нет</span>' WHERE " . CLIENTU . ".`id` =$id");
		$oplata = '<span style="color: red;">нет</span>';
	}

	if ($new_post['number_client']) {		// пользователи
		$lastname = $new_fio[0];
		$firstname = $new_fio[1];
		$middlename = $new_fio[2];
		$email_ = $form_obr[2];
		$num = $new_post['num_client'];
		$limite = $new_post['limite_client'];

		mysqli_query($mysqli, "INSERT INTO " . POLSOVATEL . " (`email`, `number`, `limite`, `group`, `lastname`, `firstname`, `middlename`) VALUES ('$email_', '$num', '$limite', 'Инфогруппа', '$lastname', '$firstname', '$middlename')") or die("Ошибка " . mysqli_error($mysqli));
		$info = '<span style="color: green;">Данные пользователя успешно сохранены в список пользователей!</span>';
	}

	if ($new_post['dath']) {		// партнеры 
		$lastname = $new_fio[0];
		$firstname = $new_fio[1];
		$middlename = $new_fio[2];
		$email_ = $form_obr[2];
		$messenger = $new_post['messenger'];
		$tefone = $new_post['tefone'];
		$checking = $new_post['cardcode'];
		$limite = $new_post['limite_part'];
		$group = $new_post['group'];

		mysqli_query($mysqli, "INSERT INTO " . PARTNER . " (`lastname`, `firstname`, `middlename`, `email`, `messenger`, `checking`, `limite`, `group`, `telefon`) VALUES ('$lastname', '$firstname', '$middlename', '$email', '$messenger', '$checking', '$limite', '$group', '$tefone');") or die("Ошибка " . mysqli_error($mysqli));
		$info = '<span style="color: green;">Данные пользователя успешно сохранены в список партнеров!</span>';
	}
	return [$oplata, $info];
}

function Messenger()
{
	$mes = '';
	$mes .= '<option></option>';
	foreach (Data(MESSENGER) as $item) {
		$mes .= '<option>' . $item['name'] . '</option>';
	}
	return $mes;
}

function Valuta($val)
{
	$valuta = '';
	foreach (Data(VALUTA) as $item) {
		$select = ($item['valuta'] == $val) ? ' selected' : '';
		$valuta .= '<option' . $select . '>' . $item['valuta'] . '</option>';
	}
	return $valuta;
}

function StackPartneru()
{
	$partner = '';
	$n = 0;
	foreach (Data(PARTNER) as $item) {
		$partner .= '<div class="form_table">
			<div class="namber">' . ++$n . '</div>
			<div class="table_width">' . $item['lastname'] . ' ' . $item['firstname'] . ' ' . $item['middlename'] . '</div>
			<div class="table_width2_1">' . $item['email'] . '</div>
			<div class="t_width">' . $item['messenger'] . '</div>
			<div class="t_width">' . $item['telefon'] . '</div>
			<div class="table_width2">' . $item['checking'] . '</div>
			<div class="table_width2a">' . $item['group'] . '</div>
			<div class="table_width2a">' . $item['limite'] . '</div>
			<div class="table_width2a">' . $item['oplata'] . '</div>
			<div class="table_width2a" >' . $item['summ'] . '</div>
			<div class="table_width2a" >' . $item['valuta'] . '</div>
			<a href="index.php?name=edit_partner&id=' . $item['id'] . '">' . Pin('icon3') . '</a>
			<a href="index.php?name=email_partner&id=' . $item['id'] . '">' . Email('icon3') . '</a>
			<a style="color: red;" href="index.php?name=south_del&id=' . $item['id'] . '">' . Del('icon3red') . '</a>
		</div>';
	}
	return $partner;
}

function SavePartnur($new_post)
{
	include CONECT;
	if ($new_post['dath']) {
		$lastname = $new_post['lastname'];
		$firstname = $new_post['firstname'];
		$middlename = $new_post['middlename'];
		$email = $new_post['email'];
		$messenger = $new_post['messenger'];
		$tefone = $new_post['tefone'];

		if ($messenger) {
			$mes = $messenger . ': ' . $tefone;
		}

		$tefone = $new_post['tefone'];
		$checking = $new_post['cardcode'];
		$limite = $new_post['limite'];
		$valuta = $new_post['valut'];

		if ($limite > 0 || $new_post['summa'] > 0) {
			$oplata = '<span style=\"color: green;\">да</span>';
		} else {
			$oplata = '<span style=\"color: red;\">нет</span>';
		}

		$group = $new_post['group'];
		$summa = $new_post['summa'];
		mysqli_query($mysqli, "INSERT INTO " . PARTNER . " (`lastname`, `firstname`, `middlename`, `email`, `messenger`, `checking`, `limite`, `group`, `telefon`, `oplata`, `summ`, `valuta`) VALUES ('$lastname', '$firstname', '$middlename', '$email', '$messenger', '$checking', '$limite', '$group', '$tefone', '$oplata', '$summa', '$valuta')") or die("Ошибка " . mysqli_error($mysqli));
		$block = EmailPartneru($lastname, $firstname, $middlename, $email, $limite, $group, $summa, $mes, $valuta);
	}
	return $block;
}

function RegistriDataPolsovatel($new_post, $id)
{
	include CONECT;
	if ($new_post['ren']) {
		if ($new_post['lastname'] != '' && $new_post['lastname'] != ' ') {
			$mysqli->query("UPDATE " . PARTNER . " SET `lastname` = '" . $new_post['lastname'] . "' WHERE " . PARTNER . ".`id` = " . $id);
		}

		if ($new_post['firstname'] != '' && $new_post['firstname'] != ' ') {
			$mysqli->query("UPDATE " . PARTNER . " SET `firstname` = '" . $new_post['firstname'] . "' WHERE " . PARTNER . ".`id` = " . $id);
		}

		if ($new_post['middlename'] != '' && $new_post['middlename'] != ' ') {
			$mysqli->query("UPDATE " . PARTNER . " SET `middlename` = '" . $new_post['middlename'] . "' WHERE " . PARTNER . ".`id` = " . $id);
		}

		if ($new_post['email'] != '' && $new_post['email'] != ' ') {
			$mysqli->query("UPDATE " . PARTNER . " SET `email` = '" . $new_post['email'] . "' WHERE " . PARTNER . ".`id` = " . $id);
		}

		if ($new_post['messenger'] != '' && $new_post['messenger'] != ' ') {
			$mysqli->query("UPDATE " . PARTNER . " SET `messenger` = '" . $new_post['messenger'] . "' WHERE " . PARTNER . ".`id` = " . $id);
		}

		if ($new_post['cardcode'] != '' && $new_post['cardcode'] != ' ') {
			$mysqli->query("UPDATE " . PARTNER . " SET `checking` = '" . $new_post['cardcode'] . "' WHERE " . PARTNER . ".`id` = " . $id);
		}

		if ($new_post['group'] != '' && $new_post['group'] != ' ') {
			$mysqli->query("UPDATE " . PARTNER . " SET `group` = '" . $new_post['group'] . "' WHERE " . PARTNER . ".`id` = " . $id);
		}

		if ($new_post['limite'] != '' && $new_post['limite'] != ' ') {
			if ($new_post['limite'] > 0) {
				$mysqli->query("UPDATE " . PARTNER . " SET `oplata` = '<span style=\"color: green;\">да</span>' WHERE " . PARTNER . ".`id` = " . $id);
			} else {
				$mysqli->query("UPDATE " . PARTNER . " SET `oplata` = '<span style=\"color: red;\">нет</span>' WHERE " . PARTNER . ".`id` = " . $id);
			}

			$mysqli->query("UPDATE " . PARTNER . " SET `limite` = '" . $new_post['limite'] . "' WHERE " . PARTNER . ".`id` = " . $id);
		}

		if ($new_post['tefone'] != '' && $new_post['tefone'] != ' ') {
			$mysqli->query("UPDATE " . PARTNER . " SET `telefon` = '" . $new_post['tefone'] . "' WHERE " . PARTNER . ".`id` = " . $id);
		}

		if ($new_post['summa'] != '' && $new_post['summa'] != ' ') {
			$mysqli->query("UPDATE " . PARTNER . " SET `summ` = '" . $new_post['summa'] . "' WHERE " . PARTNER . ".`id` = " . $id);
		}

		if ($new_post['valut'] != '' && $new_post['valut'] != ' ') {
			$mysqli->query("UPDATE " . PARTNER . " SET `valuta` = '" . $new_post['valut'] . "' WHERE " . PARTNER . ".`id` = " . $id);
		}
	}

	if ($new_post['opl']) {
		$mysqli->query("UPDATE " . PARTNER . " SET `oplata` = '<span style=\"color: green;\">да</span>' WHERE " . PARTNER . ".`id` = " . $id);
	}

	if ($new_post['noopl']) {
		$mysqli->query("UPDATE " . PARTNER . " SET `oplata` = '<span style=\"color: red;\">нет</span>' WHERE " . PARTNER . ".`id` = " . $id);
	}

	if ($new_post['back']) {
		header('Location: http://iridoc.com/cardio/admin/index.php?name=partner');
	}

	if ($new_post['globals']) {
		foreach (Data(PARTNER) as $item) {
			if ($item['id'] == $id) {
				$http = $item['checking'];
				$mysqli->query("UPDATE " . CART . " SET `name` = '$http' WHERE " . CART . ".`id` = 1;");
			}
		}
	}
	return true;
}

function EditPartneurs($id)
{
	foreach (Data(PARTNER) as $item) {
		if ($item['id'] == $id) {
			$ress = $item;
		}
	}
	return $ress;
}

function CooficientValutu()
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
	return [$grn, $rub, $cor, $eur];
}

function SumaValutaPolsovatela($id)
{
	foreach (Data(VALUTA) as $item) {
		if ($item['id'] == $id) {
			$tsumma = $item['summ'];
			$tvalut = $item['valuta'];
		}
	}
	return [$tsumma, $tvalut];
}

function OnOffPolsovatel($id)
{
	foreach (Data(POLSOVATEL) as $item) {
		if ($item['id'] == $id) {
			$check = ($item['otricatelno'] == 'on') ? 'checked="checked"' : '';
		}
	}
	return $check;
}
require_once  CONECT;

class Kalendar
{
	public function Calendar($id)
	{
		$calendar = $cal_shblon = '';
		foreach (Data(CALENDAR) as $item) {
			if ($item['iduser'] == $id && $item['formulaic'] != 'on' && $item['m'] == '') {
				//  шаблон
				$calendar .= '<p>' . $item['data'] . ': ' . $item['primeth'] . '<a href="index.php?name=edit_polsovateli&id=' . $id . '&id_reg=' . $item['id'] . '&del_calendar=del">' . Del('icon3red') . '</a></p>';
			} elseif ($item['m'] != '' && $item['n'] != '' && $item['iduser'] == $id && $item['data'] == '') {
				// персонально на дни недели
				$calendar .= '<p>' . N_M('regular') . ': ' . $item['primeth'] . ' ( ' . $item['m'] . ' )<a href="index.php?name=edit_polsovateli&id=' . $id . '&id_reg=' . $item['id'] . '&del_calendar=del">' . Del('icon3red') . '</a></p>';
			} elseif ($item['d'] != '' && $item['m'] != '' && $item['iduser'] == $id && $item['data'] == '') {
				// персонально на дни месяца
				$calendar .= '<p>' . D_M('regular') . ': ' . $item['primeth'] . ' ( ' . $item['m'] . ' )<a href="index.php?name=edit_polsovateli&id=' . $id . '&id_reg=' . $item['id'] . '&del_calendar=del">' . Del('icon3red') . '</a></p>';
			} elseif ($item['formulaic'] == 'on') {

				$cal_shblon .= '<p>' . $item['data'] . ': ' . $item['primeth'] . '<a href="index.php?name=edit_polsovateli&id=' . $id . '&id_reg=' . $item['id'] . '&del_calendar=del">' . Del('icon3red') . '</a></p>';
			} elseif ($item['n'] != '' && $item['m'] == '') {
				// к шаблону
				$cal_shblon .= '<p>' . Nedela('regular') . ': ' . $item['primeth'] . '<a href="index.php?name=edit_polsovateli&id=' . $id . '&id_reg=' . $item['id'] . '&del_calendar=del">' . Del('icon3red') . '</a></p>';
			}
		}

		return [$calendar, $cal_shblon];
	}

	public function DelCalendar($id)
	{
		include CONECT;
		mysqli_query($mysqli, "DELETE FROM " . CALENDAR . " WHERE  " . CALENDAR . ".`id` = $id") or die("Ошибка " . mysqli_error($mysqli));
		return true;
	}
}

class Diagramma
{
	public $data; // подставляем месяц
	public $year;
	public $name;
	public $id;
	public $array;

	// получаем данные с базы диаграммы
	public function Diagrams($groups)
	{
		$id = $_SESSION['personal_id'];
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
							'color' => $item['color'],
							'mnojitel' => $item['mnojitel']
						];
					}
				}
			}
		}
		return $massiv_res_diagn;
	}

	public function DiagRes($groups)
	{
		$id = $_SESSION['personal_id'];
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
							'color' => $item['color'],
							'mnojitel' => $item['mnojitel']
						];
					}
				}
			}
		}
		return $massiv_res_diagn;
	}

	public function SteckResultDiagram()
	{
		$res = '';
		$i = 1;
		$column = 4;
		$rows = 0;
		foreach (Data(DIAGRAMMA) as $item) {
			if ($item['id_client'] == $this->id) {
				$rows += 1;
			}
		}

		$rows = ceil($rows / $column);
		$cickl = 0;
		foreach (Data(DIAGRAMMA) as $item) {
			if ($item['id_client'] == $this->id) {
				if ($cickl == 0) {
					$s = '<div class="d_goup_block">';
					$cickl = 1;
				} else {
					$s = '';
				}
				if ($cickl == $rows) {
					$cickl = 0;
					$block = '</div><div class="d_goup_block">';
				} else {
					$block = '';
				}
				$block;
				$res .= $s . '
				<div class="diagram_block">
					<div class="d_bl">
						<div class="num">' . $i++ . '<a href="index.php?name=edit_polsovateli&id=' . $_SESSION['personal_id'] . '&data=base&del_id_diagrams=' . $item['id'] . '">' . Del('icon4red') . '</a></div>
						<input name="categori_' . $item['id'] . '" class="d_cat" value="' . $item['categories'] . '">
						<input name="group_' . $item['id'] . '" class="d_group" value="' . $item['groups'] . '">
						<input name="data_' . $item['id'] . '" class="d_data" value="' . $item['data'] . '">
						<input class="vis" name="id_' . $item['id'] . '" value="' . $item['id'] . '">
					</div>
				</div>' . $block;
				$cickl++;
				unset($block, $s);
			}
		}
		$res .= '</div>';

		return $res;
	}

	public function DelRegDiagram($id)
	{
		include CONECT;
		mysqli_query($mysqli, "DELETE FROM " . DIAGRAMMA . " WHERE  " . DIAGRAMMA . ".`id` = $id") or die("Ошибка " . mysqli_error($mysqli));
		return true;
	}

	public function NewRegDiagram($id)
	{
		include CONECT;
		mysqli_query($mysqli, "INSERT INTO " . DIAGRAMMA . " (`id_client`) VALUES ('$id')") or die("Ошибка " . mysqli_error($mysqli));
		return true;
	}

	public function UpdateRegDiagram()
	{
		include CONECT;
		$m = $y = 0;

		foreach ($this->array as $item) {
			if ($m == 4) {
				$m = 0;
				$y++;
			}

			$arr[$y][$m] = $item;
			$m++;
		}

		$rows = count($arr) - 1;
		for ($i = 0; $i < $rows; $i++) {
			$categories = $arr[$i][0];
			$groups = $arr[$i][1];
			$data = $arr[$i][2];
			$id = $arr[$i][3];

			$mysqli->query("UPDATE " . DIAGRAMMA . " SET `categories` = '$categories', `groups` = '$groups', `data` = '$data' WHERE " . DIAGRAMMA . ".`id` = " . $id);
		}
		return true;
	}
}

function DataPolsovatelPersonal($id)
{
	foreach (Data(POLSOVATEL) as $item) {
		if ($item['id'] == $id) {
			$polsovatel = $item;
		}
	}
	return $polsovatel;
}

function IsmenenieData($id, $new_session)
{
	$is = '';
	$textsms = '';
	$is .= '<div class="block_f">
		<h2>Содержание отправляемого письма</h2>
		<form action="" method="post" enctype="multipart/form-data" name="">';
	$newmasses = array('lastname', 'firstname', 'middlename', 'email', 'numpol', 'group', 'limite', 'card', 'summa', 'valuta', 'strana', 'pol', 'dataname', 'phone', 'login', 'passwordname', 'otricatilno');
	$newmaslog = array('Фамилия', 'Имя', 'Отчество', 'Email', '№ пользователя', 'Группа', 'Лимит', 'Карта', 'Сумма', 'Валюта', 'Страна', 'Пол', 'Дата рождения', 'Телефон', 'Логин', 'Пароль', 'Разрешено в кредит');
	for ($d = 0; $d < 17; $d++) {
		if ($new_session['dgr'][$newmasses[$d]] != $new_session['dfh'][$newmasses[$d]]) {
			$textsms .= $newmaslog[$d] . ' было значение: ' . $new_session['dgr'][$newmasses[$d]] . ', новое значение: ' . $new_session['dfh'][$newmasses[$d]] . ';&#13';
		}
	}
	$rowss = (count(explode(';', $textsms)) >= 2) ? 5 : 2;
	$is .= '<textarea class="mailtextform" name="mailtext" rows="' . $rowss . '">' . date('d.m.Y') . ' были внесены изменения в Вашу запись!&#13' . $textsms . '</textarea>
		<input name="podnam" class="wf_blanck2 jk right_" type="submit" value="Отправить">	
		<a class="wf_blanck2 jk right_" href="index.php?name=edit_polsovateli&id=' . $id . '">Назад</a>
	</form></div>';
	return $is;
}

function UpdatePersonalDataPolsovatel($new_post, $new_get)
{
	include CONECT;

	$space = new Spacecraft;

	$id = $new_get['id'];

	if ($new_post['ren']) {
		if ($new_post['lastname'] != '' && $new_post['lastname'] != ' ') {
			$mysqli->query("UPDATE " . POLSOVATEL . " SET `lastname` = '" . $new_post['lastname'] . "' WHERE " . POLSOVATEL . ".`id` = " . $id);
		}

		if ($new_post['firstname'] != '' && $new_post['firstname'] != ' ') {
			$mysqli->query("UPDATE " . POLSOVATEL . " SET `firstname` = '" . $new_post['firstname'] . "' WHERE " . POLSOVATEL . ".`id` = " . $id);
		}

		if ($new_post['middlename'] != '' && $new_post['middlename'] != ' ') {
			$mysqli->query("UPDATE " . POLSOVATEL . " SET `middlename` = '" . $new_post['middlename'] . "' WHERE " . POLSOVATEL . ".`id` = " . $id);
		}

		if ($new_post['email'] != '' && $new_post['email'] != ' ') {
			$mysqli->query("UPDATE " . POLSOVATEL . " SET `email` = '" . $new_post['email'] . "' WHERE " . POLSOVATEL . ".`id` = " . $id);
		}

		if ($new_post['group'] != '' && $new_post['group'] != ' ') {
			$mysqli->query("UPDATE " . POLSOVATEL . " SET `group` = '" . $new_post['group'] . "' WHERE " . POLSOVATEL . ".`id` = " . $id);
		}

		if ($obrabotci != '') {
			$mysqli->query("UPDATE " . POLSOVATEL . " SET `group` = 'Фрилансеры' WHERE " . POLSOVATEL . ".`id` = " . $id);
		}

		if ($new_post['numpol'] != '' && $new_post['numpol'] != ' ') {
			$mysqli->query("UPDATE " . POLSOVATEL . " SET `number` = '" . $new_post['numpol'] . "' WHERE " . POLSOVATEL . ".`id` = " . $id);
		}

		if ($new_post['limite'] != '' && $new_post['limite'] != ' ') {
			if ($new_post['limite'] > 0) {
				$mysqli->query("UPDATE " . POLSOVATEL . " SET `opl` = '<span style=\"color: green;\">да</span>' WHERE " . POLSOVATEL . ".`id` = " . $id);
			} else {
				$mysqli->query("UPDATE " . POLSOVATEL . " SET `opl` = '<span style=\"color: red;\">нет</span>' WHERE " . POLSOVATEL . ".`id` = " . $id);
			}
			$mysqli->query("UPDATE " . POLSOVATEL . " SET `limite` = '" . $new_post['limite'] . "' WHERE " . POLSOVATEL . ".`id` = " . $id);
		}

		if ($new_post['card'] != '' && $new_post['card'] != ' ') {
			$mysqli->query("UPDATE " . POLSOVATEL . " SET `card` = '" . $new_post['card'] . "' WHERE " . POLSOVATEL . ".`id` = " . $id);
		}

		if ($new_post['summa'] != '' && $new_post['summa'] != ' ') {
			$mysqli->query("UPDATE " . POLSOVATEL . " SET `summ` = '" . $new_post['summa'] . "' WHERE " . POLSOVATEL . ".`id` = " . $id);
		}

		if ($new_post['summa_plus'] != '' && $new_post['summa_plus'] != ' ') {
			// получаем сумму на счету
			foreach (Data(POLSOVATEL) as $item) {
				if ($item['id'] == $id) {
					$summa_ostatock = $item['summ'];
				}
			}

			$summa_dop = $summa_ostatock + $new_post['summa_plus'];

			$mysqli->query("UPDATE " . POLSOVATEL . " SET `summ` = '" . $summa_dop . "' WHERE " . POLSOVATEL . ".`id` = " . $id);
		}

		if ($new_post['valuta'] != '' && $new_post['valuta'] != ' ') {
			$mysqli->query("UPDATE " . POLSOVATEL . " SET `valuta` = '" . $new_post['valuta'] . "' WHERE " . POLSOVATEL . ".`id` = " . $id);
		}

		if ($new_post['strana'] != '' && $new_post['strana'] != ' ') {
			$mysqli->query("UPDATE " . POLSOVATEL . " SET `strana` = '" . $new_post['strana'] . "' WHERE " . POLSOVATEL . ".`id` = " . $id);
		}

		if ($new_post['pol'] != '' && $new_post['pol'] != ' ') {
			$mysqli->query("UPDATE " . POLSOVATEL . " SET `state` = '" . $new_post['pol'] . "' WHERE " . POLSOVATEL . ".`id` = " . $id);
		}

		if ($new_post['dataname'] != '' && $new_post['dataname'] != ' ') {
			$mysqli->query("UPDATE " . POLSOVATEL . " SET `data` = '" . $new_post['dataname'] . "' WHERE " . POLSOVATEL . ".`id` = " . $id);
		}

		if ($new_post['phone'] != '' && $new_post['phone'] != ' ') {
			$mysqli->query("UPDATE " . POLSOVATEL . " SET `phone` = '" . $new_post['phone'] . "' WHERE " . POLSOVATEL . ".`id` = " . $id);
		}

		if ($new_post['login'] != '' && $new_post['login'] != ' ') {
			$mysqli->query("UPDATE " . POLSOVATEL . " SET `login` = '" . $new_post['login'] . "' WHERE " . POLSOVATEL . ".`id` = " . $id);
		}

		if ($new_post['passwordname'] != '' && $new_post['passwordname'] != ' ') {
			$mysqli->query("UPDATE " . POLSOVATEL . " SET `password` = '" . md5($new_post['passwordname']) . "' WHERE " . POLSOVATEL . ".`id` = " . $id);
		}

		if ($new_post['otricatilno'] == '' || $new_post['otricatilno'] == 'on') {
			$mysqli->query("UPDATE " . POLSOVATEL . " SET `otricatelno` = '" . $new_post['otricatilno'] . "' WHERE " . POLSOVATEL . ".`id` = " . $id);
		}
	}

	if ($new_post['summa'] != '' && $new_post['summa'] != ' ' || $new_post['summa_plus'] != '' && $new_post['summa_plus'] != ' ') {
		$space->RegictreChet([
			'id' => $id,
			'name' => 'Изменение платежа',
			'usluga' => 'оплачено'
		]);
	}

	if ($new_post['limite'] != '' && $new_post['limite'] != ' ') {
		$space->RegictreChet([
			'id' => $id,
			'name' => 'Изменение лимита',
			'usluga' => 'оплачено',
			'limite' => $new_post['limite']
		]);
	}

	// проверить и внести изменения в таблицу
	if ($new_post['xxx']) {
		$primeth = $new_post['textprim'];
		$data = $new_post['dataprim'];
		$formulaic = $new_post['formulaic'];
		$d = $new_post['data_month'];
		$n = $new_post['nedelya'];

		// переменные месяцев
		$jan = $new_post['jan'];
		$fiv = $new_post['fiv'];
		$mar = $new_post['mar'];
		$apr = $new_post['apr'];
		$may = $new_post['may'];
		$iun = $new_post['iun'];
		$iul = $new_post['iul'];
		$avg = $new_post['avg'];
		$sen = $new_post['sen'];
		$oct = $new_post['oct'];
		$nov = $new_post['nov'];
		$dec = $new_post['dec'];

		if ($formulaic == 'on') {
			if ($n == '' && $d == '') {
				$mysqli->query("INSERT INTO " . CALENDAR . " (`primeth`, `data`, `formulaic`) VALUES ('$primeth', '$data', '$formulaic')");
			} elseif ($n != '' || $d != '') {
				if ($n != '') {
					$mysqli->query("INSERT INTO " . CALENDAR . " (`primeth`, `n`) VALUES ('$primeth', '$n')");
				}

				if ($d != '') {
					$mysqli->query("INSERT INTO " . CALENDAR . " (`primeth`, `d`) VALUES ('$primeth', '$d')");
				}
			}
		} else {
			if ($id && $primeth && $data) {
				$mysqli->query("INSERT INTO " . CALENDAR . " (`iduser`, `primeth`, `data`) VALUES ('$id', '$primeth', '$data')");
			} elseif ($n != '' && ($jan != '' || $fiv != '' || $mar != '' || $apr != '' || $may != '' || $iun != '' || $iul != '' || $avg != '' || $sen != '' || $oct != '' || $nov != '' || $dec != '')) {
				$cikl_month = '';
				if ($jan != '') $cikl_month .= $jan . ',';
				if ($fiv != '') $cikl_month .= $fiv . ',';
				if ($mar != '') $cikl_month .= $mar . ',';
				if ($apr != '') $cikl_month .= $apr . ',';
				if ($may != '') $cikl_month .= $may . ',';
				if ($iun != '') $cikl_month .= $iun . ',';
				if ($iul != '') $cikl_month .= $iul . ',';
				if ($avg != '') $cikl_month .= $avg . ',';
				if ($sen != '') $cikl_month .= $sen . ',';
				if ($oct != '') $cikl_month .= $oct . ',';
				if ($nov != '') $cikl_month .= $nov . ',';
				if ($dec != '') $cikl_month .= $dec . ',';
				$mysqli->query("INSERT INTO " . CALENDAR . " (`iduser`, `primeth`, `n`, `m`) VALUES ('$id', '$primeth', '$n', '$cikl_month')");
			} elseif ($d != '' && ($jan != '' || $fiv != '' || $mar != '' || $apr != '' || $may != '' || $iun != '' || $iul != '' || $avg != '' || $sen != '' || $oct != '' || $nov != '' || $dec != '')) {
				$cikl_month = '';
				if ($jan != '') $cikl_month .= $jan . ',';
				if ($fiv != '') $cikl_month .= $fiv . ',';
				if ($mar != '') $cikl_month .= $mar . ',';
				if ($apr != '') $cikl_month .= $apr . ',';
				if ($may != '') $cikl_month .= $may . ',';
				if ($iun != '') $cikl_month .= $iun . ',';
				if ($iul != '') $cikl_month .= $iul . ',';
				if ($avg != '') $cikl_month .= $avg . ',';
				if ($sen != '') $cikl_month .= $sen . ',';
				if ($oct != '') $cikl_month .= $oct . ',';
				if ($nov != '') $cikl_month .= $nov . ',';
				if ($dec != '') $cikl_month .= $dec . ',';
				$mysqli->query("INSERT INTO " . CALENDAR . " (`iduser`, `primeth`, `d`, `m`) VALUES ('$id', '$primeth', '$d', '$cikl_month')");
			}

			foreach (Data(POLSOVATEL) as $item) {
				if ($item['id'] == $id) {
					$email_user = $item['email'];
				}
			}
			$mail = new Mail;
			$mail->array = [
				'mail' => $email_user,
				'text' => $primeth
			];
			$mail->EmailKalendar();
		}
	}

	if ($new_post['opl']) {
		$mysqli->query("UPDATE " . POLSOVATEL . " SET `opl` = '<span style=\"color: green;\">да</span>' WHERE " . POLSOVATEL . ".`id` = " . $id);
	}

	if ($new_post['noopl']) {
		$mysqli->query("UPDATE " . POLSOVATEL . " SET `opl` = '<span style=\"color: red;\">нет</span>' WHERE " . POLSOVATEL . ".`id` = " . $id);
	}

	return true;
}

function CategorisProduct()
{
	$categoris = '';
	$categoris .= '<option></option>';
	foreach (Data(CATEGORIS) as $item) {
		if ($_SESSION['categori_product'] == $item['namegroup']) {
			$selected = ' selected';
		} else {
			$selected = '';
		}

		$categoris .= '<option' . $selected . '>' . $item['namegroup'] . '</option>';
	}
	return $categoris;
}

function Product($id)
{
	$prod = '';
	foreach (Data(PRODUCT) as $item) {
		if ($item['id'] == $id) {
			$prod .= '<div class="block_tovara">
				<img class="logotipe" src="images/' . $item['foto'] . '">
					<div class="name_block">' . $item['name'] . '</div>
					<div class="comentari_block">' . $item['comentari'] . '</div>
					<div  class="price_block">' . $item['price'] . ' cor.</div>
				</div>';
			$massiv = $item;
			$_SESSION['categori_product'] = $item['product_group'];
		}
	}
	return [$prod, $massiv];
}

function Initialisacia($id)
{
	foreach (Data(POLSOVATEL) as $item) {
		if ($id == $item['id']) {
			$_SESSION['polnuh_let'] = (int) Datapolnuy($item['data']); // Вывод полных лет
			$_SESSION['pol'] = $item['state']; // Вывод полных лет
			$init = '
			<div class="content pad">
				<div>
					<div class="nameblock">
						<i><b>ФИО</b></i>: ' . $item['lastname'] . ' ' . $item['firstname'] . ' ' . $item['middlename'] . '<br>
						<i><b>Дата рождения</b></i>: ' . $item['data'] . '  (Полных лет: ' . $_SESSION['polnuh_let'] . ')
					</div>
					<div class="nameblock">
						<i><b>Пол</b></i>: ' . $item['state'] . '<br>
						<i><b>Коментарий</b></i>: ' . $item['comentari'] . '
					</div>
				</div>';
		}
	}
	return [$init];
}

function CrovTpl()
{
	include 'component/view/crov.tpl';
}

function SredstvaChet()
{
	include CONECT;
	$summa_uslugi = ConverterValut($_SESSION['data_personal']['valuta_usluga'], $_SESSION['data_personal']['price_usluge'], $_SESSION['data_personal']['valuta_pol']); // валюта в какой товар, сумма к оплате, в какую конвертируем;
	foreach (Data(POLSOVATEL) as $item) {
		if ($item['id'] == IdClient($_SESSION)) {
			if ($item['summ'] >= $summa_uslugi) {

				$ostatock = $item['summ'] - $summa_uslugi;
				$mysqli->query("UPDATE " . POLSOVATEL . " SET `summ` = '$ostatock' WHERE " . POLSOVATEL . ".`id` = " . $item['id']);

				$ostatoc = OpenDataClientChet(['id' => $item['id']]);
				rsort($ostatoc);
				$new_ostatoc = $ostatoc[0];
				unset($ostatoc);
				$new_sum = $item['summ'] - $summa_uslugi;

				$id_client = $item['id'];
				$data_operation = date('d.m.Y H:i');
				$limite_uslovn = $new_ostatoc['limite_uslovn'];
				$rashod_limit = $new_ostatoc['rashod_limit'] + $summa_uslugi;
				$suma_tec =  ConverterValut($_SESSION['data_personal']['valuta_usluga'], $ostatock, 'грн');
				$price_club = ConverterValut($_SESSION['data_personal']['valuta_usluga'], $summa_uslugi, 'грн');
				$raschet_usluga = '';
				$data_pogasheniya = '';
				$obrabotci = $new_ostatoc['obrabotci'];
				$octatoc_obrabotci = $new_ostatoc['octatoc_obrabotci'];

				$mysqli->query("INSERT INTO " . CHETDB . " (`id_client`, `name`, `data`, `limite_uslovn`, `rashod_limit`, `sama_tec`, `price_club`, `raschet_usluga`, `data_pogasheniya`, `obrabotci`, `octatoc_obrabotci`) VALUES ('$id_client', 'Анкетирование', '$data_operation', '$limite_uslovn', '$rashod_limit', '$suma_tec', '$price_club', '$raschet_usluga', '$data_pogasheniya', '$obrabotci', '$octatoc_obrabotci')");

				$off = true;
			} else {
				$off = false;
			}
		}
	}
	return $off;
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

class DeliteChet
{
	public $id;

	/**
	 * Удаление всех записей с персонального счета
	 */
	public function DelChetPersonal()
	{
		include CONECT;
		foreach (Data(CHETDB) as $item) {
			if ($item['id_client'] == $this->id) {
				$id_client = $item['id'];
				mysqli_query($mysqli, "DELETE FROM " . CHETDB . " WHERE  " . CHETDB . ".`id` = $id_client") or die("Ошибка " . mysqli_error($mysqli));
			}
		}
		return true;
	}

	/**
	 * Удаление всех записей всех пользователей с персонального счета
	 */
	public function GlobalDel()
	{
		include CONECT;
		foreach (Data(CHETDB) as $item) {
			$id_client = $item['id'];
			mysqli_query($mysqli, "DELETE FROM " . CHETDB . " WHERE  " . CHETDB . ".`id` = $id_client") or die("Ошибка " . mysqli_error($mysqli));
		}
		return true;
	}
}

class DelHistoriPDF
{
	public $id;
	public $del_id;

	// Получаем список истории
	public function StecDel()
	{
		$anketa = $crov = $ecg = $ad = '';
		foreach (Data(HISTORI) as $item) {
			if ($item['id_client'] == $this->id) {
				if ($item['type'] == 'anketa') {
					$anketa .= '<div class="del_stec"><p><b>Файл</b> ' . $item['name'] . ', был удален ' . $item['data_del'] . '<a href="index.php?name=edit_polsovateli&del_hist=del&id=' . $this->id . '&id_del_=' . $item['id'] . '">' . Del('icon3red') . '</a></p></div>';
				} elseif ($item['type'] == 'krov') {
					$crov .= '<div class="del_stec"><p><b>Файл</b> ' . $item['name'] . ', был удален ' . $item['data_del'] . '<a href="index.php?name=edit_polsovateli&del_hist=del&id=' . $this->id . '&id_del_=' . $item['id'] . '">' . Del('icon3red') . '</a></p></div>';
				} elseif ($item['type'] == 'ecg') {
					$ecg .= '<div class="del_stec"><p><b>Файл</b> ' . $item['name'] . ', был удален ' . $item['data_del'] . '<a href="index.php?name=edit_polsovateli&del_hist=del&id=' . $this->id . '&id_del_=' . $item['id'] . '">' . Del('icon3red') . '</a></p></div>';
				} elseif ($item['type'] == 'ad') {
					$ad .= '<div class="del_stec"><p><b>Файл</b> ' . $item['name'] . ', был удален ' . $item['data_del'] . '<a href="index.php?name=edit_polsovateli&del_hist=del&id=' . $this->id . '&id_del_=' . $item['id'] . '">' . Del('icon3red') . '</a></p></div>';
				}
			}
		}
		return [$anketa, $crov, $ecg, $ad];
	}

	// Выборочное удаление удаление
	public function DelHistori()
	{
		include CONECT;
		mysqli_query($mysqli, "DELETE FROM " . HISTORI . " WHERE  " . HISTORI . ".`id` = $this->del_id") or die("Ошибка " . mysqli_error($mysqli));
		return true;
	}

	// Удаление всех записей
	public function DelHistoriGlobal()
	{
		include CONECT;
		foreach (Data(HISTORI) as $item) {
			$id_client = $item['id'];
			mysqli_query($mysqli, "DELETE FROM " . HISTORI . " WHERE  " . HISTORI . ".`id` = $id_client") or die("Ошибка " . mysqli_error($mysqli));
		}
		return true;
	}
}

function ConverterValut($vt, $G, $valutaoplatu) // $vt - валюта в какой товар, $G - сумма к оплате, $valutaoplatu - в какую конвертируем
{
	$new_cof_valuta = CooficientValutu();
	if ($vt == 'cor') {
		if ($valutaoplatu == 'cor') {
			$summaofsak = $G;
		} elseif ($valutaoplatu == 'грн') {
			$summaofsak = $G * $new_cof_valuta[0];
		} elseif ($valutaoplatu == 'руб') {
			$summaofsak = $G * $new_cof_valuta[1];
		} elseif ($valutaoplatu == 'eur') {
			$summaofsak = $G * $new_cof_valuta[3];
		}
	} elseif ($vt == 'грн') {
		if ($valutaoplatu == 'cor') {
			$summaofsak = $G / $new_cof_valuta[0];
		} elseif ($valutaoplatu == 'грн') {
			$summaofsak = $G;
		} elseif ($valutaoplatu == 'руб') {
			$summaofsak = $G * ($new_cof_valuta[1] / $new_cof_valuta[0]);
		} elseif ($valutaoplatu == 'eur') {
			$summaofsak = $G / $new_cof_valuta[0] / $new_cof_valuta[3];
		}
	} elseif ($vt == 'руб') {
		if ($valutaoplatu == 'cor') {
			$summaofsak = $G / $new_cof_valuta[1];
		} elseif ($valutaoplatu == 'грн') {
			$summaofsak = $G * ($new_cof_valuta[0] / $new_cof_valuta[1]);
		} elseif ($valutaoplatu == 'руб') {
			$summaofsak = $G;
		} elseif ($valutaoplatu == 'eur') {
			$summaofsak = $G / $new_cof_valuta[1] * $new_cof_valuta[3];
		}
	} elseif ($vt == 'eur') {
		if ($valutaoplatu == 'cor') {
			$summaofsak = $G / $new_cof_valuta[3];
		} elseif ($valutaoplatu == 'грн') {
			$summaofsak = $G / $new_cof_valuta[3] * $new_cof_valuta[0];
		} elseif ($valutaoplatu == 'eur') {
			$summaofsak = $G;
		} elseif ($valutaoplatu == 'руб') {
			$summaofsak = $G / $new_cof_valuta[3] * $new_cof_valuta[1];
		}
	}
	return $summaofsak;
}

function ProductUpdateEdit($new_post, $new_files)
{
	include CONECT;
	if ($new_post['prodd']) {
		$name_prod = $new_post['name_prod'];
		$comentari = $new_post['comentari'];
		$price = $new_post['price'];
		$product_group = $new_post['product_group'];
		$identificator = $new_post['identificator'];
		$id = $identificator;
		$filename = $new_files['filename']['name'];
		$tmp = $new_files['filename']['tmp_name'];
		$file_date = date('YmdHis');
		$md = md5($filename) . '-' . $file_date . '.' . pathinfo($filename, PATHINFO_EXTENSION);

		if (is_uploaded_file($tmp)) {
			move_uploaded_file($tmp, 'images/' . $md);
			$file_set = $md;
		} else {
			$file_set = '<span style="color: red;">Файл не загружен</span>';
		}

		if ($name_prod) {
			$mysqli->query("UPDATE `car_product` SET `name` = '$name_prod' WHERE `car_product`.`id` = $id");
		}

		if ($filename) {
			$mysqli->query("UPDATE `car_product` SET `foto` = '$file_set' WHERE `car_product`.`id` = $id");
		}

		if ($comentari) {
			$mysqli->query("UPDATE `car_product` SET `comentari` = '$comentari' WHERE `car_product`.`id` = $id");
		}

		if ($price) {
			$mysqli->query("UPDATE `car_product` SET `price` = '$price' WHERE `car_product`.`id` = $id");
		}

		if ($product_group != '') {
			$mysqli->query("UPDATE `car_product` SET `product_group` = '$product_group' WHERE `car_product`.`id` = $id");
		}
	}
}

function ClientuObrabotca()
{
	$client = '';
	$y = 0;
	foreach (Data(CLIENTU) as $item) {
		$client .= '<div class="form_table">
		<div  class="namber">' . ++$y . '</div>
        <div  class="table_width" name=' . $item['id'] . ' id=' . $item['id'] . '>' . $item['lastname'] . ' ' . $item['firstname'] . ' ' . $item['middlename'] . '</div>
		<div  class="table_width3">' . $item['rojdenie'] . '</div>';
		if (!$item['status']) {
			$client .= '<div style="color: red;" class="table_width2">Не обработано</div>';
		} else {
			$client .= '<div style="color: green;" class="table_width2">Обработано</div>';
		}
		$client .= '<a style="color: #429eff;" href="index.php?name=clientlist&id=' . $item['id'] . '">' . Clientu('icon3') . '</a>
			<div class="table_width2">' . $item['data_registr'] . '</div>
			<div  class="table_width2a">' . $item['personal_num'] . '</div>
			<div  class="table_width2a">' . $item['group'] . '</div>
			<div  class="table_width" >' . $item['fio_card'] . '</div>
			<div  class="table_width2a" >' . $item['oplata'] . '</div>
			<div  class="table_width2a" >' . $item['summ'] . '</div>
			</div>';
	}
	return $client;
}

function DeletCategories()
{
	$dc = '';
	foreach (Data(CATEGORIS) as $item) {
		$dc .= '<div class="groupprod">' . $item['namegroup'] . ' <a style="color: red; float: right;" href="index.php?name=group_pro&id=' . $item['id'] . '">' . Del('icon3red') . '</a></div>';
	}
	return $dc;
}

function SteckProduct($sort_group)
{
	$product = '';
	foreach (Data(PRODUCT) as $item) {
		if ($item['product_group'] == $sort_group) {
			$product .= '<div class="block_tovara">
				<img class="logotipe" src="images/' . $item['foto'] . '">
				<div class="name_block">' . $item['name'] . '</div>
				<div class="comentari_block">' . $item['comentari'] . '</div>
				<div  class="price_block">' . $item['price'] . ' cor.</div>
				<div class="up_down">
					<div><a href="index.php?name=upblock&id=' . $item['id'] . '">' . Up('pin') . '</a></div>
					<div><a href="index.php?name=downblock&id=' . $item['id'] . '">' . Down('pin') . '</a></div>
				</div>
				<div><a href="index.php?name=edit_product&id=' . $item['id'] . '">' . Pin('pin') . '</a></div>
				<div><a href="index.php?name=delite&id=' . $item['id'] . '">' . Del('del') . '</a></div>
				</div>';
		}
		if ($sort_group == '' || $sort_group == 'Все') {
			$product .= '<div class="block_tovara">
				<img class="logotipe" src="images/' . $item['foto'] . '">
				<div class="name_block">' . $item['name'] . '</div>
				<div class="comentari_block">' . $item['comentari'] . '</div>
				<div  class="price_block">' . $item['price'] . ' cor.</div>
				<div class="up_down">
					<div><a href="index.php?name=upblock&id=' . $item['id'] . '">' . Up('pin') . '</a></div>
					<div><a href="index.php?name=downblock&id=' . $item['id'] . '">' . Down('pin') . '</a></div>
				</div>
				<div><a href="index.php?name=edit_product&id=' . $item['id'] . '">' . Pin('pin') . '</a></div>
				<div><a href="index.php?name=delite&id=' . $item['id'] . '">' . Del('del') . '</a></div>
				</div>';
		}
	}
	return $product;
}

function ColumEdit($new_get)
{
	include CONECT;

	if ($new_get['reles'] == 'fio_o') {
		foreach (Data(COLUM) as $item) {
			if ($item['id'] == 2) {
				$on_off = ($item['fio'] == 'on') ? 'off' : 'on';
				$mysqli->query("UPDATE " . COLUM . " SET `fio` = '$on_off' WHERE " . COLUM . ".`id` = 2");
				unset($on_off);
			}
		}
	}

	if ($new_get['reles'] == 'data_r') {
		foreach (Data(COLUM) as $item) {
			if ($item['id'] == 2) {
				$on_off = ($item['data'] == 'on') ? 'off' : 'on';
				$mysqli->query("UPDATE " . COLUM . " SET `data` = '$on_off' WHERE " . COLUM . ".`id` = 2");
				unset($on_off);
			}
		}
	}

	if ($new_get['reles'] == 'ok') {
		foreach (Data(COLUM) as $item) {
			if ($item['id'] == 2) {
				$on_off = ($item['ok'] == 'on') ? 'off' : 'on';
				$mysqli->query("UPDATE " . COLUM . " SET `ok` = '$on_off' WHERE " . COLUM . ".`id` = 2");
				unset($on_off);
			}
		}
	}

	if ($new_get['reles'] == 'time_load') {
		foreach (Data(COLUM) as $item) {
			if ($item['id'] == 2) {
				$on_off = ($item['time_load'] == 'on') ? 'off' : 'on';
				$mysqli->query("UPDATE " . COLUM . " SET `time_load` = '$on_off' WHERE " . COLUM . ".`id` = 2");
				unset($on_off);
			}
		}
	}

	if ($new_get['reles'] == 'personal_number') {
		foreach (Data(COLUM) as $item) {
			if ($item['id'] == 2) {
				$on_off = ($item['personal_number'] == 'on') ? 'off' : 'on';
				$mysqli->query("UPDATE " . COLUM . " SET `personal_number` = '$on_off' WHERE " . COLUM . ".`id` = 2");
				unset($on_off);
			}
		}
	}

	if ($new_get['reles'] == 'group_number') {
		foreach (Data(COLUM) as $item) {
			if ($item['id'] == 2) {
				$on_off = ($item['group_number'] == 'on') ? 'off' : 'on';
				$mysqli->query("UPDATE " . COLUM . " SET `group_number` = '$on_off' WHERE " . COLUM . ".`id` = 2");
				unset($on_off);
			}
		}
	}

	if ($new_get['reles'] == 'card_ras') {
		foreach (Data(COLUM) as $item) {
			if ($item['id'] == 2) {
				$on_off = ($item['card_ras'] == 'on') ? 'off' : 'on';
				$mysqli->query("UPDATE " . COLUM . " SET `card_ras` = '$on_off' WHERE " . COLUM . ".`id` = 2");
				unset($on_off);
			}
		}
	}

	if ($new_get['reles'] == 'oplashen') {
		foreach (Data(COLUM) as $item) {
			if ($item['id'] == 2) {
				$on_off = ($item['oplashen'] == 'on') ? 'off' : 'on';
				$mysqli->query("UPDATE " . COLUM . " SET `oplashen` = '$on_off' WHERE " . COLUM . ".`id` = 2");
				unset($on_off);
			}
		}
	}

	if ($new_get['reles'] == 'sum_opl') {
		foreach (Data(COLUM) as $item) {
			if ($item['id'] == 2) {
				$on_off = ($item['sum_opl'] == 'on') ? 'off' : 'on';
				$mysqli->query("UPDATE " . COLUM . " SET `sum_opl` = '$on_off' WHERE " . COLUM . ".`id` = 2");
				unset($on_off);
			}
		}
	}
	return true;
}

function SummaZaSutki($poiskdata)
{
	$summasutok = '';
	foreach (Data(FINOTCHET) as $item) {
		$dataoplatu = $item['data'];
		if ($dataoplatu == $poiskdata) {
			$summasutok += $item['summa'];
		}
	}
	return $summasutok;
}

function SummaZaDen()
{
	$summasaden = '';
	foreach (Data(FINOTCHET) as $item) {
		if ($item['data'] == date('y-m-d')) {
			$summasaden += $item['summa'];
		}
	}
	return $summasaden;
}

function StyleColumDuo()
{
	foreach (Data(COLUM) as $item) {
		if ($item['id'] == 2) {
			$class_fio = ($item['fio'] == 'on') ? 'aoff' : 'aon';
			$class_data_r = ($item['data'] == 'on') ? 'aoff' : 'aon';
			$class_ok = ($item['ok'] == 'on') ? 'aoff' : 'aon';
			$class_time_load = ($item['time_load'] == 'on') ? 'aoff' : 'aon';
			$class_personal_number = ($item['personal_number'] == 'on') ? 'aoff' : 'aon';
			if ($item['group_number'] == 'on') {
				$class_group_number = 'aoff';
				$class_email = 'table_width2z';
			} else {
				$class_group_number = 'aon';
				$class_email = 'table_width2';
			}
			$class_card_ras = ($item['card_ras'] == 'on') ? 'aoff' : 'aon';
			$class_oplashen = ($item['oplashen'] == 'on') ? 'aoff' : 'aon';
			$class_sum_opl = ($item['sum_opl'] == 'on') ? 'aoff' : 'aon';
		}
	}
	return [$class_fio, $class_data_r, $class_ok, $class_time_load, $class_personal_number, $class_group_number, $class_email, $class_card_ras, $class_oplashen, $class_sum_opl];
}

function SteckPolsovateli($new_post, $style)
{
	$pl = '';

	if ($style[0] == 'aon') {
		$pl .= '<div class="table_width">ФИО</div>';
	}

	if ($style[1] == 'aon') {
		$pl .= '<div class="' . $style[6] . '">E-mail</div>';
	}

	if ($style[2] == 'aon') {
		$pl .= '<div class="table_width2a">№ Пол.</div>';
	}

	if ($style[3] == 'aon') {
		$pl .= '<div class="table_width2a">Группа</div>';
	}

	if ($style[4] == 'aon') {
		$pl .= '<div class="table_width2a">Лимит</div>';
	}

	if ($style[5] == 'aon') {
		$pl .= '<div class="table_width">На кого карта</div>';
	}

	if ($style[7] == 'aon') {
		$pl .= '<div class="table_width2a">Оплачено</div>';
	}

	if ($style[8] == 'aon') {
		$pl .= '<div class="table_width2a">Сумма</div>';
	}

	if ($style[9] == 'aon') {
		$pl .= '<div class="table_width2a">Валюта</div>';
	}

	$pl .= '</div>
	<div class="miniblock">';
	$p = 0;
	if ($new_post['sortpol']) {
		foreach (Data(POLSOVATEL) as $item) {
			$regulyar = '/' . mb_strtolower($new_post['sortpol']) . '/';
			if (preg_match($regulyar, mb_strtolower($item['lastname'])) || preg_match($regulyar, mb_strtolower($item['firstname'])) || preg_match($regulyar, mb_strtolower($item['middlename'])) || preg_match($regulyar, mb_strtolower($item['group'])) || preg_match($regulyar, mb_strtolower($item['email']))) {
				$pl .= '<div class="form_table">
				<div class="namber">' . ++$p . '</div>';

				if ($style[0] == 'aon') {
					$pl .= '<div class="table_width">' . $item['lastname'] . ' ' . $item['firstname'] . ' ' . $item['middlename'] . '</div>';
				}

				if ($style[1] == 'aon') {
					$pl .= '<div class="' . $style[6] . '">' . $item['email'] . '</div>';
				}

				if ($style[2] == 'aon') {
					$pl .= '<div class="table_width2a">' . $item['number'] . '</div>';
				}

				if ($style[3] == 'aon') {
					$pl .= '<div class="table_width2a">' . $item['group'] . '</div>';
				}

				if ($style[4] == 'aon') {
					$pl .= '<div class="table_width2a">' . $item['limite'] . '</div>';
				}

				if ($style[5] == 'aon') {
					$pl .= '<div class="table_width">' . $item['card'] . '</div>';
				}

				if ($style[7] == 'aon') {
					$pl .= '<div class="table_width2a">' . $item['opl'] . '</div>';
				}

				if ($style[8] == 'aon') {
					$pl .= '<div class="table_width2a">' . $item['summ'] . '</div>';
				}

				if ($style[9] == 'aon') {
					$pl .= '<div class="table_width2a">' . $item['valuta'] . '</div>';
				}

				$pl .= '<a name="' . $item['id'] . '" href="index.php?name=edit_polsovateli&id=' . $item['id'] . '">' . Pin('icon3') . '</a>
					<a href="index.php?name=email_polsovateli&id=' . $item['id'] . '">' . Email('icon3') . '</a>
					<a style="color: red;" href="index.php?name=polsovatel_del&id=' . $item['id'] . '">' . Del('icon3red') . '</a>
					<a style="color: #429eff;" href="list.php?name=' . $item['id'] . '"></a>
				</div>';
			}
		}
	} else {
		foreach (Data(POLSOVATEL) as $item) {
			$pl .= '<div class="form_table">
			<div class="namber">' . ++$p . '</div>';

			if ($style[0] == 'aon') {
				$pl .= '<div class="table_width" id="l' . $item['id'] . '">' . $item['lastname'] . ' ' . $item['firstname'] . ' ' . $item['middlename'] . '</div>';
			}

			if ($style[1] == 'aon') {
				$pl .= '<div class="' . $style[6] . '">' . $item['email'] . '</div>';
			}

			if ($style[2] == 'aon') {
				$pl .= '<div class="table_width2a">' . $item['number'] . '</div>';
			}

			if ($style[3] == 'aon') {
				$pl .= '<div class="table_width2a">' . $item['group'] . '</div>';
			}

			if ($style[4] == 'aon') {
				$pl .= '<div class="table_width2a">' . $item['limite'] . '</div>';
			}

			if ($style[5] == 'aon') {
				$pl .= '<div class="table_width">' . $item['card'] . '</div>';
			}

			if ($style[7] == 'aon') {
				$pl .= '<div class="table_width2a">' . $item['opl'] . '</div>';
			}

			if ($style[8] == 'aon') {
				$pl .= '<div class="table_width2a">' . $item['summ'] . '</div>';
			}

			if ($style[9] == 'aon') {
				$pl .= '<div class="table_width2a">' . $item['valuta'] . '</div>';
			}

			$pl .= '<a href="index.php?name=edit_polsovateli&id=' . $item['id'] . '">' . Pin('icon3') . '</a>
				<a href="index.php?name=email_polsovateli&id=' . $item['id'] . '">' . Email('icon3') . '</a>
				<a style="color: red;" href="index.php?name=polsovatel_del&id=' . $item['id'] . '">' . Del('icon3red') . '</a>
				<a style="color: #429eff;" href="list.php?name=' . $item['id'] . '"></a>
			</div>';
		}
	}
	return $pl;
}

function PoiskPoData($new_post)
{
	$sum = '';
	if ($new_post['datasort']) {
		$datt = $new_post['datastart'];
		$dstar = strtotime($new_post['datastart']);
		$dstop = strtotime($new_post['datastop']);
		$re = ceil(abs($dstar - $dstop) / 86400);
		for ($dat = 0; $dat < $re; $dat++) {
			$poiskdata = date('y-m-d', strtotime($datt . ' + ' . $dat . ' day'));
			$sum .= '<div style="color: #666; width: 275px; float: left;">' . $poiskdata . ' ' . SummaZaSutki($poiskdata) . '</div>';
		}
	}
	return $sum;
}

function RegistrationNewPolsovatel($new_post)
{
	include CONECT;
	if ($new_post['pars']) {
		$cofval = CooficientValutu();
		$email_ = $new_post['email_'];
		$num = $new_post['num'];
		$limite = $new_post['limite'];
		$limm = ($limite > 0 || $new_post['summa'] > 0) ? '<span style=\"color: green;\">да</span>' : '<span style=\"color: red;\">нет</span>';
		$lastname = trim($new_post['lastname']);
		$firstname = trim($new_post['firstname']);
		$middlename = trim($new_post['middlename']);
		$numgrup = trim($new_post['numgrup']); // дубликат почты
		$card = $new_post['card'];
		$summa = $new_post['summa'];
		$valut = $new_post['valut'];
		$strana = $new_post['strana'];
		$pol = $new_post['pol'];
		$dataname = $new_post['dataname'];
		$phone = $new_post['phone'];
		$login = $new_post['login'];
		$passwordname = md5($new_post['passwordname']);

		if ($new_post['card'] == '' || $new_post['card'] == ' ') {
			$card = $lastname . ' ' . $firstname . ' ' . $middlename;
		}

		foreach (Data(SYSTEMADMIN) as $item) {
			$maildubl = $item['email2'];
		}

		// Отправляем почту
		EmailPolsovatel([
			'lastname' => $lastname,
			'firstname' => $firstname,
			'middlename' => $middlename,
			'email' => [
				$email_,
				$maildubl
			],
			'limite' => $limite,
			'num' => $num,
			'numgrup' => $numgrup,
			'summa' => $summa,
			'valut' => $valut
		]); // 3732

		mysqli_query($mysqli, "INSERT INTO " . POLSOVATEL . " (`email`, `number`, `group`, `limite`, `lastname`, `firstname`, `middlename`, `card`, `opl`, `summ`, `valuta`, `strana`, `state`, `data`, `phone`, `login`, `password`) VALUES ('$email_', '$num', '$numgrup', '$limite', '$lastname', '$firstname', '$middlename', '$card', '$limm', '$summa', '$valut', '$strana', '$pol', '$dataname', '$phone', '$login', '$passwordname')") or die("Ошибка " . mysqli_error($mysqli));

		if ($summa > 0) {
			$tdata = date('y-m-d');

			if ($valut == 'грн') {
				$coroth = $summa / $cofval[0];
			}

			if ($valut == 'руб') {
				$coroth = $summa / $cofval[1];
			}

			if ($valut == 'cor') {
				$coroth = $summa / $cofval[2];
			}

			mysqli_query($mysqli, "INSERT INTO " . FINOTCHET . " (`summa`, `data`) VALUES ('$coroth', '$tdata')") or die("Ошибка " . mysqli_error($mysqli));
		}
		unset($new_post['pars']);
	}
	return true;
}

function ResultatSumma()
{
	$otricat = $poloj = '';
	$cofval = CooficientValutu();
	foreach (Data(POLSOVATEL) as $item) {
		if ($item['valuta'] == 'грн') $cor = $item['summ'] / $cofval[0];
		if ($item['valuta'] == 'руб') $cor = $item['summ'] / $cofval[1];
		if ($item['valuta'] == 'cor') $cor = $item['summ'] / $cofval[2];
		if ($item['summ'] < 0) $otricat += $cor;
		if ($item['summ'] > 0) $poloj += $cor;
	}
	$ressumm = $poloj + $otricat;
	return [$poloj, $otricat, $ressumm];
}

class Statistic
{
	public function StatisticFin()
	{
		$i = 0;
		foreach (Data(POLSOVATEL) as $item) {
			$id_pol[$i++] = [
				'id' => $item['id'],
				'summa' => $item['summ'],
				'valuta' => $item['valuta']
			];
		}
		return $id_pol;
	}

	public function StaticSumma()
	{
		$res_summa = 0;
		$res_summa_plus = 0;
		$polsovateli = $this->StatisticFin();

		foreach ($polsovateli as $item) {
			if ($item['summa'] < 0) {
				$id = $item['id'];
				$summa = ConverterValut($item['valuta'], $item['summa'], 'грн'); // вход, сумма, выход
				$_item_ = [
					'id' => $id,
					'summa' => $summa,
					'valuta' => 'грн'
				];

				$res_summa += $_item_['summa'];
				$minus = round($res_summa, 2); // сумма задолжености пользователей

			}
		}

		foreach ($polsovateli as $item) {
			if ($item['summa'] > 0) {
				$id = $item['id'];
				$summa = ConverterValut($item['valuta'], $item['summa'], 'грн'); // вход, сумма, выход
				$_item_ = [
					'id' => $id,
					'summa' => $summa,
					'valuta' => 'грн'
				];

				$res_summa_plus += $_item_['summa'];
				$plus = round($res_summa_plus, 2); // сумма на счетах

			}
		}

		$raznica = $plus + $minus; // разница в суммах

		return [
			'plus' => $plus,
			'minus' => $minus,
			'raznica' => $raznica
		];
	}

	public function FinData()
	{
		$id = $this->StatisticFin();
		$ih = 0;
		foreach ($id as $item) {
			foreach (Data(CHETDB) as $fin) {
				if ($item['id'] == $fin['id_client']) {
					$result[$fin['id']] = [
						'limite_uslovn' => $fin['limite_uslovn'],
						'rashod_limit' => $fin['rashod_limit'],
						'id' => $fin['id']
					];
				}
			}
			rsort($result);
			if ($result[0] != NULL) {
				$resultat[$ih++] = $result[0];
			}
			unset($result);
		}
		return $resultat;
	}

	public function Limite()
	{
		$limite = $rashod = 0;
		foreach ($this->FinData() as $item) {
			$limite += $item['limite_uslovn'];
			$rashod += $item['rashod_limit'];
		}
		return [
			'limit' => $limite,
			'rshod' => $rashod
		];
	}

	public function DataFinans()
	{
		$data = date('y-m-d');
		$summa = 0;
		foreach (Data(FINOTCHET) as $item) {
			if ($data == $item['data']) {
				$summa += $item['summa'];
			}
		}
		return round($summa, 2);
	}
}

class OperationFinans
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

function Zakluchenie($new_post)
{
	$zacluchenie = '';
	foreach (Data(ZACLUCHENIE) as $item) {
		$select = ($item['categori'] == $new_post['zakl_categori']) ? ' selected' : '';
		$zacluchenie .= '<option' . $select . '>' . $item['categori'] . '</option>';
	}
	return $zacluchenie;
}

function ZakluchenieEdit($new_post)
{
	$zacluchenie = '';
	foreach (Data(ZACLUCHENIE) as $item) {
		if ($item['categori'] == $new_post['zakl_categori']) {
			$zacluchenie .= '<form action="index.php?name=recept&zakl=' . $item['id'] . '" method="post" enctype="multipart/form-data" name="myform">
				<div>Уровень здоровья: <b>' . $item['categori'] . '</b></div>
				<div class="zakl_block1">Описание уровня здоровья:</div>
				<div class="zakl_block1">Реакция активации:</div>
				<div class="zakl_block1">Описание и применение:</div>
				<textarea name="status" class="zakl_block">' . $item['status'] . '</textarea>
				<textarea name="uroven" class="zakl_block">' . $item['uroven_riakciy'] . '</textarea>
				<textarea name="comentari" class="zakl_block">' . $item['comentari'] . '</textarea>
				<input name="zakluthenie" class="wf_blanck2 jk right_" type="submit" value="Изменить">
			</form>';
		}
	}
	return $zacluchenie;
}

function UpdateZacluchenie($new_post, $new_get)
{
	include CONECT;
	if ($new_post['zakluthenie']) {
		$status = $new_post['status'];
		$uroven = $new_post['uroven'];
		$comentari = $new_post['comentari'];
		$id = $new_get['zakl'];
		$mysqli->query("UPDATE " . ZACLUCHENIE . " SET `status` = '$status', `uroven_riakciy` = '$uroven', `comentari` = '$comentari' WHERE " . ZACLUCHENIE . ".`id` = " . $id);
	}
}

function DzCrovRig()
{
	$i = '';
	foreach (Data(DZ_CROV) as $item) {
		$rig[$i++] = $item['name'] . ' ' . $item['cat'];
	}
	return $rig;
}

function DzCrovEdit()
{
	$i = '';
	$edit = '';
	$rig = DzCrovRig();
	foreach (Data(DZ_CROV) as $item) {
		$colorfiel = 'background: ' . $item['color'];
		$nonorm = explode('-', $item['no_signal']);
		$edit .= '<div class="blokked">
			<label class="receptblockform5">' . $rig[$i] . '</label>
			<div class="receptblockform1">';
		for ($we = 1; $we < 2; $we++) {

			$edit .= '<fieldset style="' . $colorfiel . '" class="setfil">';

			for ($eri = 0; $eri < 2; $eri++) {
				if ($eri == 0) {
					$styleclass = 'ty';
				}

				if ($eri == 1) {
					$styleclass = 'ty1';
				}

				$edit .= '<input class="' . $styleclass . '" name="' . $i . $we . ($eri + 2) . '" value="' . $nonorm[$eri] . '">';
			}
			$edit .= '</fieldset>';
		}
		$edit .= '</div></div>';
		unset($rtm);
		$i++;
	}
	return $edit;
}

function DzSignalEdit()
{
	$dz = '';
	$i = 0;
	foreach (Data(DZ_SIGNAL) as $item) {
		$colorfiel = 'background: ' . $item[10];
		$god = explode('-', $item[2]);
		$norm = explode('-', $item[3]);
		++$i;
		$dz .= '<div class="blokked">
			<label class="receptblockform5">' . $item[1] . '</label>
				<div class="receptblockform1">';
		for ($we = 1; $we < 2; $we++) {
			$dz .= '<fieldset style="' . $colorfiel . '" class="setfil">';

			for ($er = 0; $er < 2; $er++) {
				if ($er == 0) {
					$styleclass = 'ty';
				}

				if ($er == 1) {
					$styleclass = 'ty1';
				}

				$dz .= '<input class="' . $styleclass . '" name="' . $i . $we . $er . '" value="' . $god[$er] . '">';
			}

			$dz .= '</fieldset>
			<fieldset style="' . $colorfiel . '" class="setfil">';

			for ($eri = 0; $eri < 2; $eri++) {
				if ($eri == 0) {
					$styleclass = 'ty';
				}

				if ($eri == 1) {
					$styleclass = 'ty1';
				}

				$dz .= '<input class="' . $styleclass . '" name="' . $i . $we . ($eri + 2) . '" value="' . $norm[$eri] . '">';
			}
			$dz .= '</fieldset>';
		}
		$dz .= '</div></div>';
		unset($god, $norm);
	}
	return $dz;
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
		$mnojitel = $this->data_test['mnojitel'];
		mysqli_query($mysqli, "INSERT INTO " . DIAGRAMMA . " (`id_client`, `categories`, `groups`, `mnojitel`, `data`) VALUES ('$id', '$categories', '$groups', '$mnojitel', '$data')") or die("Ошибка " . mysqli_error($mysqli));
		return true;
	}
}

class CorectSumma
{
	public $sum_val;

	public function Corect()
	{
		$i = 0;
		foreach (Data(CORECT) as $item) {
			$corect[$i++] = $item;
		}
		return $corect;
	}

	public function SaveCorect()
	{
		include CONECT;
		$price = $this->sum_val['individual']['price'];
		$valuta = $this->sum_val['individual']['valuta'];
		$mysqli->query("UPDATE " . CORECT . " SET `price` = '$price', `valuta` = '$valuta' WHERE " . CORECT . ".`id` = 1");
		unset($price, $valuta);

		$price = $this->sum_val['minus']['price'];
		$valuta = $this->sum_val['minus']['valuta'];
		$mysqli->query("UPDATE " . CORECT . " SET `price` = '$price', `valuta` = '$valuta' WHERE " . CORECT . ".`id` = 2");
		unset($price, $valuta);

		$price = $this->sum_val['vne']['price'];
		$valuta = $this->sum_val['vne']['valuta'];
		$mysqli->query("UPDATE " . CORECT . " SET `price` = '$price', `valuta` = '$valuta' WHERE " . CORECT . ".`id` = 3");
		unset($price, $valuta);

		return true;
	}
}

class Finotchet
{
	public function DelFinOtchet()
	{
		include CONECT;
		foreach (Data(FINOTCHET) as $item) {
			$id = $item['id'];
			mysqli_query($mysqli, "DELETE FROM " . FINOTCHET . " WHERE  " . FINOTCHET . ".`id` = $id") or die("Ошибка " . mysqli_error($mysqli));
		}
		return true;
	}
}

function DiapasonLiEdit($new_post)
{
	include CONECT;
	if ($new_post['diapason_li']) {
		$dj = explode('*', implode('*', $new_post));

		for ($ddf = 0; $ddf < 36; $ddf++) {
			$a = $dj[($ddf + 0)];

			if ($dj[($ddf + 1)] != '') {
				$b = '-' . $dj[($ddf + 1)];
			} else {
				$b = '';
			}

			$diapason_li[] = $a . $b;
			unset($a, $b);
			$ddf += 1;
		}

		for ($i = 0; $i < 20; $i++) {
			$mysqli->query("UPDATE " . DZ_CROV . " SET `no_signal` = '" . $diapason_li[$i] . "' WHERE " . DZ_CROV . ".`id` = " . ($i + 1));
		}
	}
	return true;
}

function DiapasonSignalEdit($new_post)
{
	include CONECT;
	if ($new_post['god_norm']) {
		$dj = explode('*', implode('*', $new_post));

		for ($ddf = 0; $ddf < 52; $ddf++) {
			$a[] = $dj[$ddf + 0] . '-' . $dj[$ddf + 1];
			$b[] = $dj[$ddf + 2] . '-' . $dj[$ddf + 3];
			$ddf += 3;
		}

		for ($i = 0; $i < 14; $i++) {
			$mysqli->query("UPDATE " . DZ_SIGNAL . " SET `vosrast` = '" . $a[$i] . "', `norma` = '" . $b[$i] . "' WHERE " . DZ_SIGNAL . ".`id` = " . ($i + 1));
		}
	}
	return true;
}

function Crov($new_post)
{
	$tera = '';
	if ($new_post['krov']) {
		$polnuhlet = $new_post['poldata'];
		$monocitu = $new_post['num3'];
		$eosinofilu = $new_post['num2'];
		$basofilu = $new_post['num1'];
		$neytrofilu = $new_post['num5'];
		$leycocitu = $new_post['num7'];
		$num4 = $new_post['num4'];
		$segmentoyadernue = $new_post['num6'];
		$procent = ($basofilu + $eosinofilu + $monocitu + $leycocitu + $neytrofilu + $segmentoyadernue);
		foreach (Data(DZ_SIGNAL) as $item) {
			$op = explode('-', $item['vosrast']);
			$hd = ($op[1] == '>') ? ($op[0] <= $polnuhlet) : (($op[0] <= $polnuhlet) && ($op[1] >= $polnuhlet));
			if ($hd) {
				if ($item['name'] == 'Палочкояд. нейтроф') {
					$elo = explode('-', $item['norma']);
					$dif = (($elo[0] <= $neytrofilu) && ($elo[1] >= $neytrofilu)) ? 0 : 1;
				}

				if ($item['name'] == 'Базофилы') {
					$ela = explode('-', $item['norma']);
					$dif = (($ela[0] <= $basofilu) && ($ela[1] >= $basofilu)) ? 0 : 1;
				}

				if ($item['name'] == 'Эозинофилы') {
					$elu = explode('-', $item['norma']);
					$dif = (($elu[0] <= $eosinofilu) && ($elu[1] >= $eosinofilu)) ? 0 : 1;
				}

				if ($item['name'] == 'Моноциты') {
					$elk = explode('-', $item['norma']);
					$dif = (($elk[0] <= $monocitu) && ($elk[1] >= $monocitu)) ? 0 : 1;
				}

				if ($item['name'] == 'Лейкоцитов') {
					$ell = explode('-', $item['norma']);
					$dif = (($ell[0] <= $num4) && ($ell[1] >= $num4)) ? 0 : 1;
				}

				$tera += $dif;
			}
			unset($hd);
		}

		if ($procent != 100) {
			$procenttext = '<fieldset class="fiel">
				<legend>Не верные данные</legend>
				<div style="color: red;">Процентное соотношение не соответствует! Всего: ' . $procent . '</div>
			</fieldset>';
		} else {
			$procenttext = '';
		}

		foreach (Data(DZ_CROV) as $item) {
			$li = explode(',', $item['li']);
			$diapson = explode('-', $li[0]);
			if ($li[1] != NULL) {
				$koreckt = explode('-', $li[1]);
			}
			if ($tera == NULL && $li[1] == NULL) {
				if ($diapson[0] == '>') {
					$rm = $leycocitu > $diapson[1];
				} elseif ($diapson[0] == '<') {
					$rm = $leycocitu < $diapson[1];
				} elseif ($diapson[0] != '<' && $diapson[0] != '>') {
					$rm = ($leycocitu >= $diapson[0]) && ($leycocitu <= $diapson[1]);
				}
			} else {
				if ($diapson[0] == '>' && count($koreckt) == 1) {
					$rm = $leycocitu > $diapson[1] && $koreckt[0] == $tera;
				} elseif ($diapson[0] == '>' && count($koreckt) == 2) {
					$rm = $leycocitu > $diapson[1] && $koreckt[0] <= $tera && $koreckt[1] >= $tera;
				} elseif ($diapson[0] == '<' && count($koreckt) == 1) {
					$rm = $leycocitu < $diapson[1] && $koreckt[0] == $tera;
				} elseif ($diapson[0] == '<' && count($koreckt) == 2) {
					$rm = $leycocitu < $diapson[1] && $koreckt[0] <= $tera && $koreckt[1] >= $tera;
				} elseif ($diapson[0] != '<' && $diapson[0] != '>' && count($koreckt) == 1) {
					$rm = (($leycocitu >= $diapson[0]) && ($leycocitu <= $diapson[1])) && ($tera == $koreckt[0]);
				} elseif ($diapson[0] != '<' && $diapson[0] != '>' && count($koreckt) == 2) {
					$rm = ($leycocitu >= $diapson[0]) && ($leycocitu <= $diapson[1]) && ($tera >= $koreckt[0]) && ($tera <= $koreckt[1]);
				}
			}
			if ($rm) {
				$yuu = '<b>' . $item['id'] . '</b> ' . $item['name'] . '<br><b>' . $item['cat'] . '</b> ' . $item['text'] . ' (' . $koreckt[0] . '-' . $koreckt[1] . ')';
			}
			unset($li);
		}
		unset($tera);
	}
	return [$procenttext, 	$yuu];
}

function Ds()
{
	$ds = '';
	$i = 0;
	foreach (Data(DS) as $item) {
		$colorfiel = 'background: ' . $item['color'];
		$i++;

		for ($nnm = 4; $nnm < 8; $nnm++) {
			$rtm[] = $item[$nnm];
		}

		$ds .= '<div class="blokked">
		<label class="receptblockform5">' . $item['status'] . ' ' . $item['categiries'] . '</label>
		<div class="receptblockform1">';
		$sdd = 0;

		for ($we = 1; $we < 3; $we++) {
			$ds .= '<fieldset style="' . $colorfiel . '" class="setfil">';

			for ($er = 0; $er < 2; $er++) {
				if ($er == 0) $styleclass = 'ty';
				if ($er == 1) $styleclass = 'ty1';
				$ds .= '<input class="' . $styleclass . '" name="' . $i . $we . $er . '" value="' . $rtm[$sdd++] . '">';
			}

			$ds .= '</fieldset>';
		}
		$ds .= '</div></div>';
		unset($rtm, $sdd);
	}
	return $ds;
}

function Ekg($new_post)
{
	if ($new_post['ekg']) {
		include CONECT;
		$r = explode(',', implode(',', $new_post));
		$sh = 1;
		for ($fg = 0; $fg < 72; $fg += 4) {
			for ($dd = $fg; $dd < ($fg + 4); $dd++) { }
			$mysqli->query("UPDATE " . DS . " SET `sn1` = '" . $r[($fg + 0)] . "', `sn2` = '" . $r[($fg + 1)] . "', `sn3` = '" . $r[($fg + 2)] . "', `sn4` = '" . $r[($fg + 3)] . "' WHERE " . DS . ".`id` = " . $sh);
			$sh++;
		}
	}
	return true;
}

function Dz()
{
	$i = '';
	foreach (Data(DZ) as $item) {
		$rui[$i++] = $item['name'] . ' ' . $item['categori'];
	}
	return $rui;
}

function OprosAncetaEdit()
{
	$opros = $i = '';
	$rui = Dz();
	foreach (Data(OPROS_ANCETA) as $item) {
		$d1 = explode(',', $item[2]);
		$d2 = explode(',', $item[3]);
		$d3 = explode(',', $item[4]);
		$d4 = explode(',', $item[5]);
		$d5 = explode(',', $item[6]);
		$d6 = explode(',', $item[7]);
		$d7 = explode(',', $item[8]);
		$d8 = explode(',', $item[9]);
		$d9 = explode(',', $item[10]);
		$d10 = explode(',', $item[11]);
		$opros .= '<div class="blokked"><label class="receptblockform3">' . $rui[$i] . '</label><div class="receptblockform1">';
		for ($we = 1; $we < 11; $we++) {
			$opros .= '<fieldset class="setfil">';
			for ($er = 0; $er < 2; $er++) {
				if ($er == 0) {
					$styleclass = 'ty';
				}
				if ($er == 1) {
					$styleclass = 'ty1';
				}
				$opros .= '<input class="' . $styleclass . '" name="' . $i . $we . $er . '" value="' . ${'d' . $we}[$er] . '">';
			}
			$opros .= '</fieldset>';
		}
		$opros .= '</div></div>';
		$i++;
	}
	return $opros;
}

function AncetaEdid($new_post)
{
	include CONECT;
	if ($new_post['anketres']) {
		$r = explode(',', implode(',', $new_post));
		for ($ee = 0; $ee < 360; $ee += 2) {
			if ($r[(0 + $ee)] != '' && $r[(1 + $ee)] != '') {
				$wq[] = $r[(0 + $ee)] . ',' . $r[(1 + $ee)];
			}
			if ($r[(0 + $ee)] != '' && $r[(1 + $ee)] == '') {
				$wq[] = $r[(0 + $ee)] . '' . $r[(1 + $ee)];
			}
			if ($r[(0 + $ee)] == '' && $r[(1 + $ee)] == '') {
				$wq[] = $r[(0 + $ee)] . '' . $r[(1 + $ee)];
			}
		}
		$kl = 0;
		for ($fg = 0; $fg < 18; ++$fg) {
			for ($dd = ($fg * 10); $dd < ($fg * 10 + 10); $dd++) {
				$kl += 1;
				${'sm' . $kl} = $wq[($dd)];
			}
			$mysqli->query("UPDATE " . OPROS_ANCETA . " SET `trevojnost` = '" . $sm1 . "', `rasdrojitelnost` = '" . $sm2 . "', `utomlyaemost` = '" . $sm3 . "', `ugnetennost` = '" . $sm4 . "', `aktivnost` = '" . $sm5 . "', `optimism` = '" . $sm6 . "', `son` = '" . $sm7 . "', `appetit` = '" . $sm8 . "', `skorost` = '" . $sm9 . "', `vrema` = '" . $sm10 . "' WHERE " . OPROS_ANCETA . ".`id` = " . ($fg + 1));
			unset($kl);
		}
	}
	return true;
}

function StacTableBS($new_session)
{
	$table = '';
	foreach (Data(TABLE_BS) as $item) {
		$name = $item['biostimulyator'] . ', ' . $item['reakciya'] . ', ' . $item['uroven'];
		if ($name == $new_session['recept_spisock']) {
			$select = ' selected';
			$id[] = $item['id'];
		} else {
			$select = '';
		}
		if ($item['cickl'] == 1 && $item['chust'] == 1) $table .= '<option' . $select . '>' . $name . '</option>';
	}
	$id = implode(',', $id);
	return [$table, $id];
}

class Reakciya
{
	public function ReUr()
	{
		$table = '<option></option>';
		foreach (Data(AD) as $item) {
			$table .= '<option>' . $item['sostoyanie'] . '</option>';
		}
		return $table;
	}
}

// array_unique

function StacTableBSDuo()
{
	foreach (Data(NAME_BS) as $item) {
		$biostym = $item['name'];
		foreach (Data(TABLE_BS) as $item_bio) {
			if ($item_bio['biostimulyator'] == $biostym) {
				$table = '<option>' . $biostym . '</option>';
			}
		}
		$new_teblet[] = $table;
		unset($table);
	}
	$tabl = implode('', $new_teblet);
	return $tabl;
}

function ImpotrTabletRecept($new_post)
{
	include CONECT;
	$export = explode(', ', $new_post['export_biostimulator']);
	$import = explode(', ', $new_post['import_biostimulator']);

	foreach (Data(TABLE_BS) as $item) {
		if ($item['biostimulyator'] == $export[0] && $item['reakciya'] == $export[1] && $item['uroven'] == $export[2]) {
			$ex_data[++$i] = [$item['dosa1'], $item['rasvedenie1'], $item['dosa2'], $item['rasvedenie2']];
		}
	}

	foreach (Data(TABLE_BS) as $item) {
		if ($item['biostimulyator'] == $import[0] && $item['reakciya'] == $import[1] && $item['uroven'] == $import[2]) {
			$im_data[++$z] = $item['id'];
		}
	}

	for ($i_e = 1; $i_e < 7; $i_e++) {
		$mysqli->query("UPDATE " . TABLE_BS . " SET `dosa1` = '" . $ex_data[$i_e][0] . "', `rasvedenie1` = '" . $ex_data[$i_e][1] . "', `dosa2` = '" . $ex_data[$i_e][2] . "', `rasvedenie2` = '" . $ex_data[$i_e][3] . "' WHERE " . TABLE_BS . ".`id` = " . $im_data[$i_e]);
	}
	return true;
}

function EditTableBS($new_session)
{
	$table1 = $table2 = '';
	$y = $rt = 0;

	$dosatext = array('Первая доза', 'Разбавление первой дозы', 'Вторая доза', 'Разбавление второй дозы');
	foreach (Data(TABLE_BS) as $item) {
		$recept_sp = $item['biostimulyator'] . ', ' . $item['reakciya'] . ', ' . $item['uroven'];
		if ($recept_sp == $new_session['recept_spisock'] && $item['chust'] == 1) {
			$table1 .= '<div class="block10">
				<div>Реакция: <b>' . $item['reakciya'] . '</b></div>
				<div>Уровень реактивности: <b>' . $item['uroven'] . '</b></div>
				<div>Десятидневка: <b>' . $item['cickl'] . '</b></div>';
			$d1 = explode(',', $item['dosa1']);
			$d2 = explode(',', $item['rasvedenie1']);
			$d3 = explode(',', $item['dosa2']);
			$d4 = explode(',', $item['rasvedenie2']);
			$id[] = $item['id'];
			$y++;
			for ($we = 1; $we < 5; $we++) {
				$table1 .= '<div class="blokked"><label class="receptblockform2">' . $dosatext[($we - 1)] . '</label><div class="receptblockform">';
				for ($er = 0; $er < 10; $er++) {
					$table1 .= '<input class="ty" name="posit_a' . $y . $we . $er . '" value="' . ${'d' . $we}[$er] . '">';
				}
				$table1 .= '</div></div>';
			}
			$table1 .= '</div>';
		}
		if ($recept_sp == $new_session['recept_spisock'] && $item['chust'] == 2) {
			$table2 .= '<div class="block10">
				<div>Реакция: <b>' . $item['reakciya'] . '</b></div>
				<div>Уровень реактивности: <b>' . $item['uroven'] . '</b></div>
				<div>Десятидневка: <b>' . $item['cickl'] . '</b></div>';
			$t1 = explode(',', $item['dosa1']);
			$t2 = explode(',', $item['rasvedenie1']);
			$t3 = explode(',', $item['dosa2']);
			$t4 = explode(',', $item['rasvedenie2']);
			$id[] = $item['id'];
			$rt++;
			for ($weo = 1; $weo < 5; $weo++) {
				$table2 .= '<div class="blokked"><label class="receptblockform2">' . $dosatext[($weo - 1)] . '</label><div class="receptblockform">';
				for ($ero = 0; $ero < 10; $ero++) {
					$table2 .= '<input class="ty" name="posit_b' . $rt . $weo . $ero . '" value="' . ${'t' . $weo}[$ero] . '">';
				}
				$table2 .= '</div></div>';
			}
			$table2 .= '</div>';
		}
	}
	$table = '<fieldset class="ram4">
			<legend><b class="chust">Малочувствительные (М-23-63)</b></legend>
			' . $table1 . '
		</fieldset>
		<fieldset class="ram4">
			<legend><b class="chust">Сильно чувствительные (Ж, М-19-23, М>63, болезни)</b></legend>
			' . $table2 . '
		</fieldset>';
	return $table;
}

function EditReceprt($new_post, $new_get)
{
	if ($new_post['edit']) {
		include CONECT;
		$idn = explode(',', $new_get['id']);
		$idnet = $new_post['id'];
		$r = 0;
		for ($gh = 0; $gh < 2; $gh++) {
			if ($gh == 0) $dhh = '_a';
			if ($gh == 1) $dhh = '_b';
			for ($eri = 0; $eri < 3; $eri++) {
				for ($qe = 1; $qe < 5; $qe++) {
					for ($df = 0; $df < 10; $df++) {
						$ter[] = $new_post['posit' . $dhh . ($eri + 1) . $qe . $df];
					}
					$sd = implode(',', $ter);
					${'doss' . ($eri + 1) . $qe} = $sd;
					unset($sd);
					unset($ter);
				}
			}
			for ($eri = 0; $eri < 3; $eri++) {
				for ($qe = 1; $qe < 5; $qe++) {
					${'dosa' . $qe} = ${'doss' . ($eri + 1) . $qe};
				}
				$result = $mysqli->query("UPDATE " . TABLE_BS . " SET `dosa1` = '" . $dosa1 . "', `rasvedenie1` = '" . $dosa2 . "', `dosa2` = '" . $dosa3 . "', `rasvedenie2` = '" . $dosa4 . "' WHERE " . TABLE_BS . ".`id` = " . $idn[$r++]);
			}
		}
	}
	return true;
}

function EditBs($new_get, $new_post)
{
	$_bs = '';
	foreach (Data(NAME_BS) as $item) {
		$newid = $item['id'];
		$classed = $item['name'];
		$onf = $item['vide'];
		if ($new_post['vide_edit']) {
			if ($new_get['idos'] == $newid) $editname = $item['name'];
			$id = $new_get['idos'];
			$vide_edit_rams = '<div class="videdit">
				<form action="index.php?name=recept&idos=' . $id . '" method="post" enctype="multipart/form-data">
					<input name="biostimulyator_name" class="pole_vvoda5" type="text" value="' . $editname . '">
					' . Status($id) . '
					<input class="wf_blanck2 jk" name="biostimedit" type="submit" value="Изменить">
				</form>
			</div>';
			unset($id);
		}
		$ch = ($onf == 'on') ? ' checked' : '';
		$_bs .= '<div class="groupprod">' . $classed . ' <a style="color: red; float: right;" href="index.php?name=recept&page=dell&id=' . $newid . '">' . Del('icon3red') . '</a>
		<form class="formpoint" action="index.php?name=recept&idos=' . $newid . '" method="post" enctype="multipart/form-data">
			<button class="butt" name="vide" type="submit" value="yes">' . Saving('icon6') . '</button>
			<label class="switch">
			  <input type="checkbox" name="onoff"' . $ch . '>
			  <span class="slider round"></span>
			</label>
			<button class="butt" name="vide_edit" type="submit" value="yes">' . Edit('icon3') . '</button>
		</form>
		</div>';
	}
	return [$_bs, $vide_edit_rams];
}

function SaveBsEdit($new_post, $new_get)
{
	include CONECT;
	if ($new_post['biostimedit']) {
		$id = $new_get['idos'];
		$name = $new_post['biostimulyator_name'];
		$dosa1 = $new_post['col_biostimulyator1'];
		$dosa1_col = $new_post['vid_biostemulatora1'];
		$dosa2 = $new_post['col_biostimulyator2'];
		$dosa3 = $new_post['col_biostimulyator3'];
		$comentari = $new_post['biostimulyator_dosa3_coment'];
		foreach (Data(COMENTARI_BS) as $item) {
			if ($item['id_stimulyator'] == $id) {
				$mysqli->query("UPDATE " . COMENTARI_BS . " SET `max_dosa` = '$dosa1', `dosirovka1` = '$dosa1_col', `aver_dosa` = '$dosa2', `min_dosa` = '$dosa3', `comentari` = '$comentari' WHERE " . COMENTARI_BS . ".`id` = " . $item['id']);
			}
		}
		$result = $mysqli->query("UPDATE " . NAME_BS . " SET `name` = '$name' WHERE " . NAME_BS . ".`id` = " . $id);
	}
	return true;
}

function SaveNewBs($new_post)
{
	if ($new_post['biostim']) {
		include CONECT;
		$biostimul = $new_post['biostimulyator'];
		mysqli_query($mysqli, "INSERT INTO " . NAME_BS . " (`name`) VALUES ('$biostimul')") or die("Ошибка " . mysqli_error($mysqli));

		foreach (Data(NAME_BS) as $item) {
			$id_biostymulyator = $item['id'];
		}

		mysqli_query($mysqli, "INSERT INTO " . COMENTARI_BS . " (`id_stimulyator`) VALUES ('$id_biostymulyator')") or die("Ошибка " . mysqli_error($mysqli));
	}
	return true;
}

function UpdateBs($new_post, $new_get)
{
	if ($new_post['vide'] == 'yes') {
		include CONECT;
		$vide = $new_post['onoff'];
		$id = $new_get['idos'];
		$mysqli->query("UPDATE " . NAME_BS . " SET `vide` = '" . $vide . "' WHERE " . NAME_BS . ".`id` = " . $id);
		unset($id);
	}
	return true;
}

function DeleteBs($new_get)
{
	if ($new_get['page'] == 'dell') {
		include CONECT;
		$id_bio = $new_get['id'];
		mysqli_query($mysqli, "DELETE FROM " . NAME_BS . " WHERE " . NAME_BS . ".`id` = $id_bio") or die("Ошибка " . mysqli_error($mysqli));

		foreach (Data(COMENTARI_BS) as $item) {
			if ($item['id_stimulyator'] == $id_bio) {
				$new_id_biostim = $item['id'];
				mysqli_query($mysqli, "DELETE FROM " . COMENTARI_BS . " WHERE " . COMENTARI_BS . ".`id` = $new_id_biostim") or die("Ошибка " . mysqli_error($mysqli));
			}
		}
	}
	return true;
}

function PolsovatelDelit($id)
{
	include CONECT;
	mysqli_query($mysqli, "DELETE FROM " . POLSOVATEL . " WHERE  id = $id") or die("Ошибка " . mysqli_error($mysqli));
	return true;
}

function PartnerDelit($id)
{
	include CONECT;
	mysqli_query($mysqli, "DELETE FROM " . PARTNER . " WHERE  id = $id") or die("Ошибка " . mysqli_error($mysqli));
	return true;
}

function ClientDelitPDF($id)
{
	include CONECT;
	foreach (Data(CLIENTU) as $item) {
		if ($item['id'] == $id) {
			unlink('download/' . $item['filepdf']);
		}
	}
	mysqli_query($mysqli, "DELETE FROM " . CLIENTU . " WHERE  id = $id") or die("Ошибка " . mysqli_error($mysqli));
	return true;
}

function SystemAdminEmail()
{
	foreach (Data(SYSTEMADMIN) as $item) {
		$mailpolsov = $item['email2'];
	}
	return $mailpolsov;
}

function VideObrabotci()
{
	$obrabotka = '';
	$r = 0;
	foreach (Data(OBRABOTKA) as $item) {
		$obrabotka .= '<div class="form_table">
			<div  class="namber">' . ++$r . '</div>
			<div  class="table_width2_2">' . $item['name'] . '</div>
			<div  class="table_width3">' . $item['price'] . '</div>
			<a style="color: #429eff;" href="list.php?name=' . $item['id'] . '"></a>
			<a style="color: red;" href="index.php?name=vide&id=' . $item['id'] . '">' . Del('icon3red') . '</a>
		</div>';
	}
	return $obrabotka;
}

function NewVideObrabotci($new_post)
{
	if ($new_post['save_vide']) {
		include CONECT;
		if ($new_post['vide']) {
			$vide = $new_post['vide'];
			$price = $new_post['price'];
		}

		mysqli_query($mysqli, "INSERT INTO " . OBRABOTKA . " (`name`, `price`) VALUES ('$vide', '$price')") or die("Ошибка " . mysqli_error($mysqli));
	}
	return true;
}

function Biostemulator()
{
	$biostymulyator = '';
	$biostymulyator .= '<option></option>';
	foreach (Data(NAME_BS) as $item) {
		$biostymulyator .= '<option>' . $item['name'] . '</option>';
	}
	return $biostymulyator;
}

function NewReceptSave($new_post)
{
	include CONECT;
	if ($new_post['new_recept_save']) {
		$recept_spisock_import = $new_post['recept_spisock_import'];
		$new_name_recept = $new_post['new_recept'];
		$parametr_spisok = explode(', ', $recept_spisock_import);
		foreach (Data(TABLE_BS) as $item) {
			if ($item['biostimulyator'] == $parametr_spisok[0]) {
				$cickl[] = $item['cickl'];
				$dosa1[] = $item['dosa1'];
				$rasvedenie1[] = $item['rasvedenie1'];
				$dosa2[] = $item['dosa2'];
				$rasvedenie2[] = $item['rasvedenie2'];
				$chustvitelnost[] = $item['chust'];
				$reakciya[] = $item['reakciya'];
				$uroven[] = $item['uroven'];
			}
		}

		for ($i = 0; $i < 108; $i++) {
			mysqli_query($mysqli, "INSERT INTO " . TABLE_BS . " (`reakciya`, `uroven`, `biostimulyator`, `cickl`, `dosa1`, `rasvedenie1`, `dosa2`, `rasvedenie2`, `chust`) VALUES ('$reakciya[$i]', '$uroven[$i]', '$new_name_recept', '$cickl[$i]', '$dosa1[$i]', '$rasvedenie1[$i]', '$dosa2[$i]', '$rasvedenie2[$i]', '$chustvitelnost[$i]')") or die("Ошибка " . mysqli_error($mysqli));
		}
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

function TabletChetClient($new_get)
{
	$chet = '';
	$z = 0;
	$array = OpenDataClientChet($new_get);
	
	foreach ($array as $item) {
		$chet .= '
		<div class="tblet_chet1">
			<form action="index.php?name=edit_polsovateli&print_rejim=edit&id=' . $item['id_client'] . '&id_chet=' . $item['id'] . '" method="post" enctype="multipart/form-data">
				<div class="chet_edit chet_pp1 chet1">' . ++$z . '</div>
				<textarea name="name_usluga" type="text" class="chet_edit chet_data1 chet1" value="">' . $item['name'] . '</textarea>
				<textarea name="data" type="text" class="chet_edit chet_operation1 chet1" value="">' . $item['data'] . '</textarea>
				<textarea name="limite_uslovn" type="text" class="chet_edit chet_data12_ chet1" value="">' . $item['limite_uslovn'] . '</textarea>
				<textarea name="rashod_limit" type="text" class="chet_edit chet_dolg1 chet1" value="">' . $item['rashod_limit'] . '</textarea>
				<textarea name="sama_tec" type="text" class="chet_edit chet_bes1 chet1" value="">' . $item['sama_tec'] . '</textarea>
				<textarea name="price_club" type="text" class="chet_edit chet_data11_ chet1" value="">' . $item['price_club'] . '</textarea>
				<textarea name="raschet_usluga" type="text" class="chet_edit chet_oplata1 chet1" value="">' . $item['raschet_usluga'] . '</textarea>
				<textarea name="data_pogasheniya" type="text" class="chet_edit chet_limit11_ chet1" value="">' . $item['data_pogasheniya'] . '</textarea>
				<textarea name="obrabotci" type="text" class="chet_edit chet_ostatoc1 chet1" value="">' . $item['obrabotci'] . '</textarea>
				<textarea name="octatoc_obrabotci" type="text" class="chet_edit chet_ostatoc12 chet1" value="">' . $item['octatoc_obrabotci'] . '</textarea>
				<button class="butt_left position_" name="save_chet" type="submit" value="on">' . Saving('icon6') . '</button>
			</form> 
			<a class="butt_left position_" href="index.php?name=edit_polsovateli&print_rejim=edit&id=' . $item['id_client'] . '&id_client=' . $item['id'] . '&chets=dell">' . Del('icon3red') . '</a>
		</div>';
	}
	return $chet;
}


class Histori // получение списка файлов
{
	public $file;
	public $personal;

	public function DelHictori() // Функция
	{
		var_dump(explode('/', $this->file));
		include CONECT;
		$data_file = explode('.', explode('/', $this->file)[2]);
		$id_client = $data_file[0];
		$file_data = $data_file[1];
		$type_file = $data_file[3];
		$data_del = date('d.m.Y H:i');

		// записываем результат в реестр HISTORI
		$mysqli->query("INSERT INTO " . HISTORI . " (`id_client`, `name`, `data_del`, `type`) VALUES ('$id_client', '$file_data', '$data_del', '$type_file')");

		// Удаляем файл
		unlink($this->file);
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

	public function ResultatAnket()
	{
		$scdir = scandir('../histori', 1);
		$rows = count($scdir);
		$data = [
			'anketa' => '',
			'krov' => '',
			'ecg' => '',
			'ad' => ''
		];

		for ($i = 0; $i < $rows; $i++) {
			$array = explode('.', $scdir[$i]);
			
			if ($array[0] == $this->personal['id']) {
				if ($array[3] == 'anketa') {
					$data['anketa'] .= '<p class="steck"><a href="index.php?name=edit_polsovateli&id=' . $this->personal['id'] . '&bloc=anketa&histori=../histori/' . $scdir[$i] . '"><b>Результат анкетирования: </b></a>' . $scdir[$i] . '<a href="index.php?name=edit_polsovateli&id=' . $this->personal['id'] . '&bloc=anketa&histori=../histori/' . $scdir[$i] . '&delhist=del">' . Del('icon3red') . '</a></p>';
				}

				if ($array[3] == 'krov') {
					$data['krov'] .= '<p class="steck"><a href="index.php?name=edit_polsovateli&id=' . $this->personal['id'] . '&bloc=krov&histori=../histori/' . $scdir[$i] . '"><b>Результат по крови: </b></a>' . $array[1] . '<a href="index.php?name=edit_polsovateli&id=' . $this->personal['id'] . '&bloc=krov&histori=../histori/' . $scdir[$i] . '&delhist=del">' . Del('icon3red') . '</a></p>';
				}

				if ($array[3] == 'ecg') {
					$data['ecg'] .= '<p class="steck"><a href="index.php?name=edit_polsovateli&id=' . $this->personal['id'] . '&bloc=ecg&histori=../histori/' . $scdir[$i] . '"><b>Результат по ЭКГ: </b></a>' . $array[1] . '<a href="index.php?name=edit_polsovateli&id=' . $this->personal['id'] . '&bloc=ecg&histori=../histori/' . $scdir[$i] . '&delhist=del">' . Del('icon3red') . '</a></p>';
				}

				if ($array[3] == 'ad') {
					$data['ad'] .= '<p class="steck"><a href="index.php?name=edit_polsovateli&id=' . $this->personal['id'] . '&bloc=ad&histori=../histori/' . $scdir[$i] . '"><b>Результат по ЭКГ: </b></a>' . $array[1] . '<a href="index.php?name=edit_polsovateli&id=' . $this->personal['id'] . '&bloc=ad&histori=../histori/' . $scdir[$i] . '&delhist=del">' . Del('icon3red') . '</a></p>';
				}
			}

		}
		
		return $data;
	}
}

function TabletChetClientPint($new_get)
{
	$chet = '';
	$z = 0;
	$array = OpenDataClientChet($new_get);

	foreach ($array as $item) {
		$chet .= '
		<div class="tblet_chet1_print">
			<div class="chet_edit chet_pp1 chet1">' . ++$z . '</div>
			<div name="name_usluga" type="text" class="chet_edit chet_data1 chet1" value="">' . $item['name'] . '</div>
			<div name="data" type="text" class="chet_edit chet_operation1 chet1" value="">' . $item['data'] . '</div>
			<div name="limite_uslovn" type="text" class="chet_edit chet_data12_ chet1" value="">' . $item['limite_uslovn'] . '</div>
			<div name="rashod_limit" type="text" class="chet_edit chet_dolg1 chet1" value="">' . $item['rashod_limit'] . '</div>
			<div name="sama_tec" type="text" class="chet_edit chet_bes1 chet1" value="">' . $item['sama_tec'] . '</div>
			<div name="price_club" type="text" class="chet_edit chet_data11_ chet1" value="">' . $item['price_club'] . '</div>
			<div name="raschet_usluga" type="text" class="chet_edit chet_oplata1 chet1" value="">' . $item['raschet_usluga'] . '</div>
			<div name="data_pogasheniya" type="text" class="chet_edit chet_limit11_ chet1" value="">' . $item['data_pogasheniya'] . '</div>
			<div name="obrabotci" type="text" class="chet_edit chet_ostatoc1 chet1" value="">' . $item['obrabotci'] . '</div>
			<div name="octatoc_obrabotci" type="text" class="chet_edit chet_ostatoc12_print chet1" value="">' . $item['octatoc_obrabotci'] . '</div>
		</div>';
	}
	return $chet;
}

function SaveEditChet($new_post, $new_get)
{
	include CONECT;
	$id = $new_get['id_chet'];
	$name_usluga = $new_post['name_usluga'];
	$data = $new_post['data'];
	$limite_uslovn = $new_post['limite_uslovn'];
	$rashod_limit = $new_post['rashod_limit'];
	$sama_tec = $new_post['sama_tec'];
	$price_club = $new_post['price_club'];
	$raschet_usluga = $new_post['raschet_usluga'];
	$data_pogasheniya = $new_post['data_pogasheniya'];
	$obrabotci = $new_post['obrabotci'];
	$octatoc_obrabotci = $new_post['octatoc_obrabotci'];

	$mysqli->query("UPDATE " . CHETDB . " SET `name` = '" . $name_usluga . "', `data` = '" . $data . "', `limite_uslovn` = '" . $limite_uslovn . "', `rashod_limit` = '" . $rashod_limit . "', `sama_tec` = '" . $sama_tec . "', `price_club` = '" . $price_club . "', `raschet_usluga` = '" . $raschet_usluga . "', `data_pogasheniya` = '" . $data_pogasheniya . "', `obrabotci` = '" . $obrabotci . "', `octatoc_obrabotci` = '" . $octatoc_obrabotci . "' WHERE " . CHETDB . ".`id` = " . $id);

	return true;
}

function DeleteChetTable($new_get)
{
	include CONECT;
	$id = $new_get['id_client'];
	mysqli_query($mysqli, "DELETE FROM " . CHETDB . " WHERE  id = $id") or die("Ошибка " . mysqli_error($mysqli));
	return true;
}

function EditMail()
{
	$mail = '';
	$mail .= '<option value=""></option>';
	foreach (Data(EMAILCATEGORI) as $item) {
		$mail .= '
		<form name="vd" action="index.php?name=mails&id_mail=' . $item['id'] . '" method="post" enctype="multipart/form-data">
			<div class="block_email">
				<input name="categories_mail" class="mail_categories" value="' . $item['name'] . '">
				<button class="butt" name="sav_em_cat" type="submit" value="yes">' . Saving('icon6') . '</button>
				<button class="butt" name="del_em_cat" type="submit" value="yes">' . Del('icon3red') . '</button>
			</div>
		</form>';
	}
	return $mail;
}

function CorectMails($new_get, $new_post)
{
	include CONECT;
	if ($new_post['sav_em_cat']) {
		$mysqli->query("UPDATE " . EMAILCATEGORI . " SET `name` = '" . $new_post['categories_mail'] . "' WHERE " . EMAILCATEGORI . ".`id` = " . $new_get['id_mail']);
	}

	if ($new_post['del_em_cat']) {
		mysqli_query($mysqli, "DELETE FROM " . EMAILCATEGORI . " WHERE  id =" . $new_get['id_mail']) or die("Ошибка " . mysqli_error($mysqli));
	}

	if ($new_post['mail_cat']) {
		$new_mail = $new_post['new_mail_cat'];
		mysqli_query($mysqli, "INSERT INTO " . EMAILCATEGORI . " (`name`) VALUES ('$new_mail')") or die("Ошибка " . mysqli_error($mysqli));
	}

	return true;
}

function SesssionInterpritation($id)
{
	$polsovatel = DataPolsovatelPersonal($id);
	$_SESSION['dfh']['lastname']    = $polsovatel[5];
	$_SESSION['dfh']['firstname']    = $polsovatel[6];
	$_SESSION['dfh']['middlename']    = $polsovatel[7];
	$_SESSION['dfh']['email']        = $polsovatel[1];
	$_SESSION['dfh']['numpol']        = $polsovatel[2];
	$_SESSION['dfh']['group']        = $polsovatel[3];
	$_SESSION['dfh']['limite']        = $polsovatel[4];
	$_SESSION['dfh']['card']        = $polsovatel[8];
	$_SESSION['dfh']['summa']        = $polsovatel[10];
	$_SESSION['dfh']['valuta']        = $polsovatel[11];
	$_SESSION['dfh']['strana']        = $polsovatel[13];
	$_SESSION['dfh']['pol']            = $polsovatel[14];
	$_SESSION['dfh']['dataname']    = $polsovatel[15];
	$_SESSION['dfh']['phone']        = $polsovatel[16];
	$_SESSION['dfh']['login']        = $polsovatel[17];
	$_SESSION['dfh']['passwordname'] = '';
	return $polsovatel;
}

function Del($style_icon)
{
	return '<svg class=' . $style_icon . ' version="1.1" xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512">
		<title>Удалить</title>
		<path d="M256 0c-141.385 0-256 114.615-256 256s114.615 256 256 256 256-114.615 256-256-114.615-256-256-256zM256 464c-114.875 0-208-93.125-208-208s93.125-208 208-208 208 93.125 208 208-93.125 208-208 208z"></path>
		<path d="M336 128l-80 80-80-80-48 48 80 80-80 80 48 48 80-80 80 80 48-48-80-80 80-80z"></path>
	</svg>';
}

function Pin($style_icon)
{
	return '<svg class=' . $style_icon . ' version="1.1" xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512">
		<title>Редактировать</title>
		<path d="M432 0c44.182 0 80 35.817 80 80 0 18.010-5.955 34.629-16 48l-32 32-112-112 32-32c13.371-10.045 29.989-16 48-16zM32 368l-32 144 144-32 296-296-112-112-296 296zM357.789 181.789l-224 224-27.578-27.578 224-224 27.578 27.578z"></path>
	</svg>';
}

function Sys($style_icon)
{
	return '<svg class=' . $style_icon . ' version="1.1" xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512">
		<title></title>
		<path d="M466.895 305.125c-26.863-46.527-10.708-106.152 36.076-133.244l-50.313-87.146c-14.375 8.427-31.088 13.259-48.923 13.259-53.768 0-97.354-43.873-97.354-97.995h-100.629c0.133 16.705-4.037 33.641-12.979 49.126-26.862 46.528-86.578 62.351-133.431 35.379l-50.312 87.146c14.485 8.236 27.025 20.294 35.943 35.739 26.819 46.454 10.756 105.96-35.854 133.112l50.313 87.146c14.325-8.348 30.958-13.127 48.7-13.127 53.598 0 97.072 43.596 97.35 97.479h100.627c-0.043-16.537 4.136-33.285 12.983-48.609 26.818-46.453 86.388-62.297 133.207-35.506l50.313-87.145c-14.39-8.233-26.846-20.249-35.717-35.614zM256 359.666c-57.254 0-103.668-46.412-103.668-103.667 0-57.254 46.413-103.667 103.668-103.667s103.666 46.413 103.666 103.667c-0.001 57.255-46.412 103.667-103.666 103.667z"></path>
	</svg>';
}

function Prod($style_icon)
{
	return '<svg class=' . $style_icon . ' version="1.1" xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512">
		<title></title>
		<path d="M480 160h-96v-48c0-44.183-85.961-80-192-80s-192 35.817-192 80v320c0 44.183 85.961 80 192 80s192-35.817 192-80v-48h96c17.673 0 32-14.327 32-32v-160c0-17.673-14.327-32-32-32zM88.028 129.199c-18.497-6.095-29.704-12.623-35.705-17.199 6.002-4.576 17.208-11.104 35.705-17.199 28.971-9.545 65.895-14.801 103.972-14.801s75.002 5.256 103.972 14.801c18.497 6.094 29.704 12.623 35.705 17.199-6.001 4.576-17.208 11.104-35.705 17.199-28.97 9.545-65.895 14.801-103.972 14.801s-75.001-5.256-103.972-14.801zM448 320h-64v-96h64v96z"></path>
	</svg>';
}

function Cark($style_icon)
{
	return '<svg class=' . $style_icon . ' version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="-55 147 500 500">
		<title></title>
		<path class="st0" d="M337.7,181.5c33.6,48,66.7,96.5,90.5,150.5c34,77.6-36.9,131.8-94.3,130.5c-46.9-1.1-86.5-36.9-96-70	c-5.6-18.7-2.9-36,4.7-54.2c22.7-55.1,56.2-103.6,89.8-152.3C333.2,184.2,334.3,182.2,337.7,181.5z"/>
		<path class="st0" d="M153.2,371.4c-1.6,40-23.8,65.8-58.5,81.8c-50.2,23.3-112.5,0.4-135.6-49.1c-12-25.6-7.3-50.5,3.6-74.9	c15.3-34.5,34.9-66.5,55.6-98c9.8-15.1,21.1-29.3,30.5-44.9c2.4-4,4.7-5.8,8-0.9c35.6,51.4,71.8,102.3,92.9,162.1
		C151.8,354.9,152.7,362.9,153.2,371.4z"/>
		<path class="st0" d="M313.7,475.6c-2.2-8.7-6.7-12-15.1-14.4c-34.7-10-60.9-30-72.7-65.8c-7.1-21.8-0.4-41.6,7.1-61.4	c1.8-4.9,1.6-8.9-1.3-13.1c-9.3-13.1-18.7-26.5-28-39.8c-2.4-3.6-4.4-8-10.2-6.4c-14.7,10.9-21.3,28-32.2,41.3	c-6.7,8-6.7,15.6-2.7,25.3c10,23.6,10.9,48-2.7,70.5c-15.3,25.1-36.9,42.7-66,50.2C77.3,465.4,72,473,72,486.3	c0,2.7,0,5.1-0.2,7.8c-6.4,70.5,65.1,120.3,117.4,118.7c0-0.1,0.1-0.1,0.1-0.2c4.6,1.7,9.3,1.5,14.1,0.9
		c39.6-5.1,72-21.3,95.6-55.1C317.2,532.3,321.4,505.6,313.7,475.6z"/>
	</svg>';
}

function Cardio($style_icon)
{
	return '<svg class=' . $style_icon . ' version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="-55 147 500 500" style="enable-background:new -55 147 500 500;">
		<title></title>
		<g>
		<path id="XMLID_5_" class="st0" d="M270.3,381.5c-4,11-4.9,21.1-5.7,31.2c-0.3,4.4-1.1,8.8-3,12.7c-4.8,10.2-16.8,11.5-22.9,2.	c-1.8-2.7-3-2.3-4.7-0.1c-1.8,2.3-2.4,5.1-2.5,7.8c-1.6,21.6-3.1,43.4-4.8,65c-1.1,14-1.8,28-5.1,41.7c-0.6,2.5-1.4,5.1-3.1,7.2	c-4.5,5.4-12.6,3.8-15-3.1c-3.3-9.2-3.1-18.9-4-28.6c-4.7-54.9-5.4-110-5.7-165c-0.1-24-2-47.9-3.1-72c0-1.4,0.3-3.1-1.6-4.7	c-1.1,14.3-2.4,28.1-3.3,42c-2.5,38.5-4.9,76.9-7.5,115.5c-0.8,11.7-9.2,17.4-20.6,13.1c-5.8-2.1-8.5-1.3-11.5,4.2	c-4.7,8.8-15.7,9-21.8,1.1c-4.2-5.4-5.8-11.9-7.4-18.4c-0.8-3.8-1.7-7.6-3.7-11.6c-0.8,3.4-1.8,6.8-2.7,10.3	c-2.3,9-8.2,14-17.4,15.1c-2.4,0.3-4.9,0.7-7.4,0.4c-41.3-3.3-82.7-0.8-124.1-1.6c-1.3,0-2.5,0.1-3.7,0c-4.4-0.8-6.8-3.5-6.6-8.1	c0.1-4.5,2.5-7.1,7.1-7.6c1.4-0.1,2.8,0,4.2,0c27.4,0,54.7,0,82.1,0c13,0,25.9,0.1,38.9,1.3c10.6,1,10.7,0.6,13.1-10	c1.4-5.8,2.5-11.6,5.8-16.8c2.8-4.7,6.5-7.8,12.4-7.1c5.9,0.7,9.5,4.1,11.6,9.3c2.5,6.2,3.3,12.9,4.8,19.4	c0.8,3.7,1.1,7.5,3.5,11.5c1.7-1.8,2.8-3.5,4.5-4.8c5.5-4.4,11.6-6.5,18.5-3c3.5,1.8,4.2,0.7,4.5-2.8c1.1-19.9,2.4-39.9,3.8-59.8	c2.8-41.8,4.7-83.7,10.5-125.3c0.8-6.6,2-13.1,4.1-19.5c0.6-1.8,1.4-3.7,2.4-5.2c2.3-3.7,5.5-5.4,9.8-4.9c4.2,0.4,6.5,3.3,7.6,6.9	c2.5,8.6,3,17.7,3.4,26.6c3.4,59.7,6.5,119.3,5.7,179.3c-0.1,14.8,1.3,29.7,2.8,44.5c0.7-9.6,1.4-19.1,2.1-28.7	c0.4-5.4,0.6-10.9,2.4-16.1c2.7-7.5,7.5-12.9,15.4-15.1c5.5-1.6,10.6-1.6,15.7,3c1.3-10.3,1.8-19.9,4.2-29.3	c1.6-5.7,3.4-11,6.1-16.1c1.1-2.1,2.4-3.8,4.1-5.4c6.9-6.5,15.3-4.9,19.2,3.7c4.1,9,5.1,18.9,6.4,28.6c1.7,13.6,3,27.1,4.5,40.7	c0.3,2.3,0.7,4.4,1.1,6.5c0.6,0,1.1,0.1,1.1,0c4.5-8.8,11.7-11.6,21.6-11.6c37.3,0.4,74.6,0.1,112.1,0.1c6.2,0,9.6,2.8,9.8,7.8	c0,4.9-3.4,8.1-9.5,8.1c-37.2,0-74.4,0.1-111.5-0.1c-5.7,0-8.3,1.8-9.5,7.1c-0.7,3.3-2.1,6.4-3.5,9.3c-2.3,4.9-5.9,8.1-11.9,8.1
		c-5.8-0.1-8.3-4-10-8.6c-4.4-11.5-5.2-23.6-6.8-35.5C274.2,411.9,273.7,397.1,270.3,381.5z"/>
		</g>
	</svg>';
}

function Home($style_icon)
{
	return '<svg class=' . $style_icon . ' version="1.1" xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512">
		<title>Дамой</title>
		<path d="M512 295.222l-256-198.713-256 198.714v-81.019l256-198.713 256 198.714zM448 288v192h-128v-128h-128v128h-128v-192l192-144z"></path>
	</svg>';
}

function Client($style_icon)
{
	return '<svg class=' . $style_icon . ' version="1.1" xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512">
		<title></title>
		<path d="M181.861 361.026l20.649-28.908-22.627-22.628-28.909 20.648c-5.361-2.997-11.102-5.387-17.133-7.096l-5.841-35.042h-32l-5.84 35.043c-6.031 1.709-11.772 4.099-17.133 7.096l-28.909-20.649-22.628 22.628 20.649 28.908c-2.997 5.36-5.387 11.103-7.096 17.133l-35.043 5.841v32l35.043 5.841c1.709 6.030 4.099 11.772 7.096 17.133l-20.649 28.908 22.627 22.628 28.909-20.648c5.361 2.997 11.102 5.387 17.133 7.096l5.841 35.042h32l5.84-35.043c6.031-1.709 11.772-4.099 17.133-7.096l28.909 20.648 22.627-22.628-20.649-28.908c2.997-5.36 5.387-11.103 7.096-17.133l35.044-5.84v-32l-35.043-5.841c-1.709-6.030-4.099-11.772-7.096-17.133zM112 432c-17.674 0-32-14.327-32-32s14.326-32 32-32 32 14.327 32 32-14.326 32-32 32zM512 192v-32l-33.691-6.125c-0.621-4.023-1.416-7.989-2.362-11.895l28.779-18.55-12.246-29.564-33.472 7.234c-2.107-3.455-4.363-6.81-6.746-10.065l19.503-28.171-22.628-22.627-28.171 19.503c-3.256-2.383-6.61-4.638-10.065-6.747l7.234-33.472-29.564-12.247-18.55 28.779c-3.906-0.946-7.872-1.741-11.895-2.362l-6.126-33.691h-32l-6.126 33.691c-4.023 0.621-7.988 1.416-11.895 2.362l-18.549-28.779-29.564 12.246 7.234 33.472c-3.455 2.108-6.81 4.364-10.065 6.747l-28.171-19.503-22.627 22.627 19.503 28.171c-2.383 3.255-4.639 6.61-6.747 10.065l-33.472-7.234-12.246 29.564 28.779 18.55c-0.946 3.906-1.741 7.871-2.362 11.895l-33.692 6.126v32l33.691 6.125c0.621 4.023 1.416 7.989 2.362 11.895l-28.779 18.55 12.246 29.564 33.472-7.234c2.108 3.455 4.364 6.809 6.747 10.065l-19.503 28.171 22.627 22.628 28.171-19.503c3.255 2.383 6.61 4.638 10.065 6.746l-7.234 33.472 29.564 12.246 18.551-28.779c3.905 0.946 7.871 1.741 11.894 2.362l6.126 33.692h32l6.126-33.691c4.022-0.621 7.988-1.416 11.895-2.362l18.55 28.779 29.564-12.246-7.234-33.472c3.455-2.108 6.81-4.363 10.065-6.746l28.171 19.503 22.628-22.628-19.503-28.171c2.383-3.256 4.638-6.61 6.746-10.065l33.472 7.234 12.246-29.565-28.779-18.55c0.946-3.906 1.741-7.871 2.362-11.895l33.691-6.125zM336 245.6c-38.439 0-69.6-31.161-69.6-69.6s31.16-69.6 69.6-69.6 69.6 31.161 69.6 69.6c0 38.439-31.16 69.6-69.6 69.6z"></path>
	</svg>';
}

function User($style_icon)
{
	return '<svg class=' . $style_icon . ' version="1.1" xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512">
		<title></title>
		<path d="M480 304l-144 144-48-48-32 32 80 80 176-176z"></path>
		<path d="M224 384h160v-57.564c-33.61-19.6-78.154-33.055-128-37.13v-26.39c35.249-19.864 64-69.386 64-118.916 0-79.529 0-144-96-144s-96 64.471-96 144c0 49.53 28.751 99.052 64 118.916v26.39c-108.551 8.874-192 62.21-192 126.694h224v-32z"></path>
	</svg>';
}

function Pass($style_icon)
{
	return '<svg class=' . $style_icon . ' version="1.1" xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512">
		<title></title>
		<path d="M501.066 157.121l-50.553-50.552c-12.396-12.397-32.685-32.684-45.081-45.082l-50.553-50.552c-12.396-12.397-34.477-14.583-49.065-4.858l-138.219 92.146c-14.588 9.726-20.109 30.514-12.268 46.195l35.243 70.487c1.077 2.153 2.323 4.448 3.695 6.83l-178.265 178.265-16 112h96v-32h64v-64h64v-64h64v-35.593c3.198 1.906 6.267 3.608 9.096 5.022l70.485 35.244c15.683 7.841 36.47 2.319 46.195-12.269l92.147-138.22c9.727-14.586 7.539-36.665-4.857-49.063zM75.314 427.313l-22.627-22.627 155.786-155.785 22.627 22.627-155.786 155.785zM458.51 211.882l-22.628 22.628c-6.223 6.222-16.404 6.222-22.627 0l-135.765-135.765c-6.223-6.222-6.223-16.405 0-22.627l22.628-22.628c6.223-6.222 16.404-6.222 22.627 0l135.765 135.765c6.223 6.222 6.223 16.405 0 22.627z"></path>
	</svg>';
}

function ClientDel($style_icon)
{
	return '<svg class=' . $style_icon . ' version="1.1" xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512">
		<title></title>
		<path d="M192 368c0-75.617 47.937-140.243 115.016-165.1 8.14-18.269 12.984-38.582 12.984-58.9 0-79.529 0-144-96-144s-96 64.471-96 144c0 49.53 28.751 99.052 64 118.916v26.39c-108.551 8.874-192 62.21-192 126.694h198.653c-4.332-15.265-6.653-31.366-6.653-48z"></path>
		<path d="M368 224c-79.529 0-144 64.471-144 144s64.471 144 144 144c79.528 0 144-64.471 144-144s-64.471-144-144-144zM448 384h-160v-32h160v32z"></path>
	</svg>';
}

function Vide($style_icon)
{
	return '<svg class=' . $style_icon . ' version="1.1" xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512">
		<title></title>
		<path d="M505.087 457.875l-274.317-249.729 12.767-12.799c10.447-10.477 16.094-24.015 16.959-37.805 0.501-0.225 1.001-0.456 1.479-0.721l51.495-32.201c6.967-8.196 6.458-21.134-1.142-28.751l-89.56-89.804c-7.595-7.617-20.499-8.131-28.672-1.142l-32.118 51.634c-0.263 0.483-0.495 0.983-0.72 1.487-13.751 0.868-27.25 6.528-37.699 17.003l-48.714 48.851c-10.449 10.478-16.092 24.013-16.959 37.802-0.502 0.225-1.002 0.458-1.482 0.723l-51.493 32.203c-6.971 8.195-6.458 21.132 1.138 28.748l89.56 89.802c7.597 7.619 20.498 8.131 28.675 1.143l32.114-51.635c0.264-0.479 0.494-0.98 0.721-1.483 13.751-0.869 27.252-6.525 37.699-17.002l14.146-14.186 249.061 275.057c7.218 7.972 18.35 9.259 24.737 2.856l25.178-25.244c6.382-6.404 5.098-17.566-2.853-24.807z"></path>
	</svg>';
}

function Polsovateli($style_icon)
{
	return '<svg class=' . $style_icon . ' version="1.1" xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512">
		<title></title>
		<path d="M128 48c0 26.51-21.49 48-48 48s-48-21.49-48-48c0-26.509 21.49-48 48-48s48 21.491 48 48z"></path>
		<path d="M416 48c0 26.51-21.49 48-48 48s-48-21.49-48-48c0-26.509 21.49-48 48-48s48 21.491 48 48z"></path>
		<path d="M128 128h-96c-17.673 0-32 14.327-32 32v160h32v192h40v-192h16v192h40v-192h32v-160c0-17.673-14.326-32-32-32z"></path>
		<path d="M487.5 256l24.5-17.75-66.643-103.058c-2.96-4.49-7.979-7.192-13.357-7.192h-128c-5.378 0-10.396 2.702-13.357 7.192l-66.643 103.058 24.5 17.75 55.322-71.798 19.229 44.87-67.051 122.928h61.333l10.667 160h32v-160h16v160h32l10.667-160h61.333l-67.052-122.929 19.229-44.87 55.323 71.799z"></path>
	</svg>';
}

function Partneru($style_icon)
{
	return '<svg class=' . $style_icon . ' version="1.1" xmlns="http://www.w3.org/2000/svg" width="576" height="512" viewBox="0 0 576 512">
		<title></title>
		<path d="M384 385.306v-26.39c35.249-19.864 64-69.386 64-118.916 0-79.529 0-144-96-144s-96 64.471-96 144c0 49.53 28.751 99.052 64 118.916v26.39c-108.551 8.874-192 62.21-192 126.694h448c0-64.484-83.449-117.82-192-126.694z"></path>
		<path d="M163.598 397.664c27.655-18.075 62.040-31.818 99.894-40.207-7.527-8.892-14.354-18.811-20.246-29.51-15.207-27.617-23.246-58.029-23.246-87.947 0-43.021 0-83.655 15.3-116.881 14.853-32.252 41.564-52.248 79.611-59.744-8.457-38.24-30.97-63.375-90.911-63.375-96 0-96 64.471-96 144 0 49.53 28.751 99.052 64 118.916v26.39c-108.551 8.874-192 62.21-192 126.694h139.503c7.259-6.455 15.298-12.586 24.095-18.336z"></path>
	</svg>';
}

function Clientu($style_icon)
{
	return '<svg class=' . $style_icon . ' version="1.1" xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512">
		<title></title>
		<path d="M288 353.306v-26.39c35.249-19.864 64-69.386 64-118.916 0-79.529 0-144-96-144s-96 64.471-96 144c0 49.53 28.751 99.052 64 118.916v26.39c-108.551 8.874-192 62.21-192 126.694h448c0-64.484-83.449-117.82-192-126.694z"></path>
	</svg>';
}

function Email($style_icon)
{
	return '<svg class=' . $style_icon . ' version="1.1" xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512">
		<title></title>
		<path d="M426.671 0h-341.328c-46.937 0-85.343 38.405-85.343 85.345v341.311c0 46.969 38.406 85.344 85.343 85.344h341.328c46.938 0 85.329-38.375 85.329-85.345v-341.31c0-46.94-38.391-85.345-85.329-85.345zM426.671 64c3.994 0 7.773 1.167 11.010 3.171l-181.681 150.202-181.677-150.2c3.239-2.005 7.022-3.173 11.020-3.173h341.328zM85.343 448c-0.962 0-1.91-0.073-2.842-0.204l112.813-156.483-14.628-14.627-116.686 116.685v-305.569l192 232.198 192-232.197v305.568l-116.686-116.685-14.627 14.627 112.814 156.484c-0.929 0.13-1.873 0.203-2.831 0.203h-341.327z"></path>
	</svg>';
}

function Edit($style_icon)
{
	return '<svg class=' . $style_icon . ' version="1.1" xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512">
		<title></title>
		<path d="M501.467 408.938l-230.276-197.38c10.724-20.149 16.809-43.141 16.809-67.558 0-79.529-64.471-144-144-144-14.547 0-28.586 2.166-41.823 6.177l83.195 83.195c12.445 12.445 12.445 32.81 0 45.255l-50.745 50.745c-12.445 12.445-32.81 12.445-45.255 0l-83.195-83.195c-4.011 13.237-6.177 27.276-6.177 41.823 0 79.529 64.471 144 144 144 24.417 0 47.409-6.085 67.558-16.81l197.38 230.276c11.454 13.362 31.008 14.113 43.452 1.669l50.746-50.746c12.444-12.444 11.693-31.997-1.669-43.451z"></path>
	</svg>';
}

function Saving($style_icon)
{
	return '<svg class=' . $style_icon . ' version="1.1" xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512">
		<title></title>
		<path d="M448 0h-448v512h512v-448l-64-64zM256 64h64v128h-64v-128zM448 448h-384v-384h32v160h288v-160h37.489l26.511 26.509v357.491z"></path>
	</svg>';
}

function Cart($style_icon)
{
	return '<svg class=' . $style_icon . ' version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1000 1000" enable-background="new 0 0 1000 1000" xml:space="preserve">
		<g><path d="M186.1,132.5H40.6c-16.9,0-30.6-13.7-30.6-30.6C10,85,23.7,71.3,40.6,71.3h145.5c16.9,0,30.6,13.7,30.6,30.6C216.7,118.8,203,132.5,186.1,132.5L186.1,132.5z M844.5,775.6H346.9c-16.9,0-30.6-13.7-30.6-30.6c0-16.9,13.7-30.6,30.6-30.6h497.7c16.9,0,30.6,13.7,30.6,30.6C875.2,761.9,861.4,775.6,844.5,775.6L844.5,775.6z M959.4,255H232c-16.9,0-30.6-13.7-30.6-30.6c0-16.9,13.7-30.6,30.6-30.6h727.3c16.9,0,30.6,13.7,30.6,30.6C990,241.3,976.3,255,959.4,255L959.4,255z M911.5,438.8H279.9c-16.9,0-30.6-13.7-30.6-30.6c0-16.9,13.7-30.6,30.6-30.6h631.6c16.9,0,30.6,13.7,30.6,30.6C942.1,425,928.4,438.8,911.5,438.8L911.5,438.8z M867.5,622.5H327.7c-16.9,0-30.6-13.7-30.6-30.6c0-16.9,13.7-30.6,30.6-30.6h539.8c16.9,0,30.6,13.7,30.6,30.6C898.1,608.8,884.4,622.5,867.5,622.5L867.5,622.5z M588,618.7c-16.9,0-30.6-13.7-30.6-30.6V258.8c0-16.9,13.7-30.6,30.6-30.6c16.9,0,30.6,13.7,30.6,30.6V588C618.7,605,605,618.7,588,618.7L588,618.7z M798.8,236.8l-39.2,326.9c-2,16.8-17.3,28.8-34.1,26.8c-16.8-2-28.8-17.3-26.8-34L738,229.6c2-16.8,17.3-28.8,34.1-26.8C788.9,204.8,800.8,220.1,798.8,236.8L798.8,236.8z M988.3,232.6l-88.3,356c-4,16.4-20.6,26.5-37.1,22.4c-16.4-4-26.5-20.6-22.4-37.1l88.3-356c4-16.4,20.6-26.5,37.1-22.4C982.3,199.6,992.3,216.2,988.3,232.6L988.3,232.6z M451.5,595.2c-16.8,2.2-32.1-9.7-34.3-26.5l-39.4-307.6c-2.2-16.8,9.7-32.1,26.5-34.3c16.8-2.2,32.1,9.7,34.3,26.5L478,560.9C480.1,577.7,468.3,593,451.5,595.2L451.5,595.2z M352.6,768.4c-16.5,4.1-33.1-5.9-37.2-22.3L158,115.5c-4.1-16.4,5.9-33,22.4-37.1c16.5-4.1,33.1,5.9,37.2,22.3l157.3,630.6C379,747.7,369,764.4,352.6,768.4L352.6,768.4z M400.5,928.7c-33.8,0-61.2-27.4-61.2-61.2c0-33.8,27.4-61.3,61.2-61.3c33.8,0,61.2,27.4,61.2,61.3C461.7,901.3,434.3,928.7,400.5,928.7L400.5,928.7z M775.6,928.7c-33.8,0-61.2-27.4-61.2-61.2c0-33.8,27.4-61.3,61.2-61.3c33.8,0,61.3,27.4,61.3,61.3C836.9,901.3,809.4,928.7,775.6,928.7L775.6,928.7z"/></g>
	</svg>';
}

function Down($style_icon)
{
	return '<svg class=' . $style_icon . ' version="1.1" xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512">
		<title>В низ</title>
		<path d="M256 496l240-240h-144v-256h-192v256h-144z"></path>
	</svg>';
}

function Up($style_icon)
{
	return '<svg class=' . $style_icon . ' version="1.1" xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512">
		<title>В верх</title>
		<path d="M256 16l-240 240h144v256h192v-256h144z"></path>
	</svg>';
}

function Recept($style_icon)
{
	return '<svg class=' . $style_icon . ' version="1.2" baseProfile="tiny" id="Слой_1"	 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="512" y="512" viewBox="0 0 500 500" xml:space="preserve">
	<g>
	<g>
		<path d="M78.9,336.3c18.1-2,35.6-4,53-6c0-0.5-0.1-1-0.1-1.4c-16.8,0-33.7,0-52.1,0c4.6-18.2,8.9-35.4,13.3-52.9	c5-0.3,9.2-0.6,13.5-0.8c0.1-0.3,0.2-0.7,0.3-1c-3.7-1.2-7.4-2.5-11.6-3.9c3.5-10.4,6.8-20.2,10.3-30.5c9.9,0,19.4,0,28.9,0	c0.1-0.5,0.1-1,0.2-1.4c-8.6-1.8-17.2-3.6-25.5-5.3c5.3-24.7,10.5-48.7,15.8-73.4c11.3-0.8,23.1-1.7,34.9-2.6c0-0.3,0-0.5,0.1-0.8	c-11.4-1.3-22.8-2.5-34.4-3.8c1.2-18.1,2.4-35.4,3.6-52.6c30.1-9.3,232.6-5.4,270.5,5.1c9,37.2,2.8,73.4-6.4,109.4	c-3.7,14.3-8.1,28.5-11.4,42.9c-1.4,6.1-4.1,8.2-10.1,7.8c-5.8-0.4-11.6-0.1-17.7,1.5c7.9,1.2,15.8,2.3,24.2,3.6	c-1.5,5.2-2.8,9.9-4.2,15c-4.5,0-8.8,0-13.1,0c-0.1,0.6-0.3,1.1-0.4,1.7c3.8,1,7.7,2,12.1,3.2c-4.5,22.6-2.1,44.6,3,66.6	c1.7,7.2,4.8,7.3,10.8,7c8.2-0.3,16.8,0.3,24.8,2.2c4.1,1,7.4,5.6,11.1,8.5c-0.3,1-0.5,2.1-0.8,3.1c-19.1,3.1-38.2,6.9-57.4,9.1	c-69.5,7.9-139.1,2.5-208.6,0.1c-2.5-0.1-5.8-2.7-7.3-5.1c-5.1-8.4-8.9-19.1-21.2-17.5c-11.3,1.4-14.3,11.5-17,20.9	c-0.9,3.2-1.3,6.6-2,10.6c7,0,13,0,19,0c0.1,0.6,0.2,1.1,0.4,1.7c-4.8,1.2-9.9,2-14.4,3.9c-2.3,0.9-5.7,4.1-5.5,5.8	c1.9,12.9,4,25.8,7.2,38.4c1.5,6.1,5.6,13.7,12.9,11.7c5.4-1.5,10.6-7.5,13.8-12.7c2.6-4.3,2.2-10.5,3.2-16.6	c-2.8,0-4.5-0.4-6,0.1c-6.4,2-10.9,0.4-12.7-6.4c-1.7-6.4,2.1-13.2,8.6-15.1c3.1-0.9,6.3-1.3,9.4-1.7c2.9-0.4,5.8-0.4,10.9-0.6	c-0.9,21.1-1.9,41.8-2.8,63.6c89.9-27,180.8-18.9,273.6-1.3c-10.4,8.4-15.9,19.5-31.8,17.2c-47.9-7.1-96.3-10.8-144.6-7	c-39.3,3.1-78.4,9.5-117.6,14.8c-9.7,1.3-17.1-2.6-23.5-8.8c-13.4-12.9-20.5-29.4-26.3-46.6C70.9,402.8,73.3,369.7,78.9,336.3z"/>
		<path d="M125.6,46.1c0.4,4.3,0.6,7.4,0.9,11c-8.5,0.5-16.5,0.7-24.6,1.4c-19.7,1.8-26.6,14-18.4,33.4c7.4-0.8,15-1.7,23.6-2.7	c-1.5,11-4.9,20.3-11.8,28.1c-6.1,6.9-12.1,6.9-18.7,0.3C66.3,107.5,63.3,94,63.7,80.7c0.5-17,3-34.1,6.4-50.8	c2.6-12.9,9.9-17.1,23-16c24.9,2.2,49.8,6,74.7,7.2c42.1,2.1,84.4,3.5,126.6,3.6c20.8,0.1,41.7-3.6,62.6-5.1
			c3.2-0.2,6.8,1.4,9.7,3.1c8.2,4.7,15.5,15,18.6,25.8C298.8,53.4,212.4,53.8,125.6,46.1z"/>
		</g>
		</g>
	</svg>';
}

function Printer($style_icon)
{
	return '<svg class=' . $style_icon . ' version="1.1" xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512">
		<title>Печать</title>
		<g>
		</g>
		<path d="M128 32h256v64h-256v-64z"></path>
		<path d="M480 128h-448c-17.6 0-32 14.4-32 32v160c0 17.6 14.397 32 32 32h96v128h256v-128h96c17.6 0 32-14.4 32-32v-160c0-17.6-14.4-32-32-32zM64 224c-17.673 0-32-14.327-32-32s14.327-32 32-32 32 14.327 32 32-14.326 32-32 32zM352 448h-192v-160h192v160z"></path>
	</svg>';
}

function Libr($style_icon)
{
	return '<svg class=' . $style_icon . ' version="1.1" xmlns="http://www.w3.org/2000/svg" width="544" height="512" viewBox="0 0 544 512">
		<title></title>
		<g>
		</g>
		<path d="M512 480v-32h-32v-192h32v-32h-96v32h32v192h-96v-192h32v-32h-96v32h32v192h-96v-192h32v-32h-96v32h32v192h-96v-192h32v-32h-96v32h32v192h-32v32h-32v32h544v-32h-32z"></path>
		<path d="M256 0h32l256 160v32h-544v-32l256-160z"></path>
	</svg>';
}

function PDF($style_icon)
{
	return '<svg class=' . $style_icon . ' version="1.1" xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512">
		<title></title>
		<g id="icomoon-ignore">
		</g>
		<path d="M421.006 294.74c-6.824-6.723-21.957-10.283-44.986-10.586-15.589-0.172-34.351 1.201-54.085 3.964-8.837-5.099-17.946-10.647-25.094-17.329-19.231-17.958-35.284-42.886-45.288-70.297 0.652-2.56 1.207-4.81 1.724-7.106 0 0 10.833-61.53 7.966-82.333-0.396-2.853-0.638-3.681-1.404-5.898l-0.941-2.417c-2.947-6.796-8.724-13.997-17.782-13.604l-5.458-0.172c-10.101 0-18.332 5.166-20.493 12.887-6.569 24.217 0.209 60.446 12.49 107.369l-3.144 7.643c-8.794 21.438-19.815 43.030-29.539 62.079l-1.264 2.477c-10.23 20.020-19.513 37.014-27.928 51.411l-8.688 4.594c-0.632 0.334-15.522 8.209-19.014 10.322-29.628 17.69-49.262 37.771-52.519 53.708-1.036 5.085-0.265 11.593 5.007 14.606l8.403 4.229c3.646 1.826 7.489 2.751 11.427 2.751 21.103 0 45.601-26.286 79.349-85.183 38.965-12.685 83.326-23.229 122.206-29.045 29.629 16.684 66.071 28.272 89.071 28.272 4.084 0 7.606-0.39 10.466-1.147 4.411-1.168 8.129-3.684 10.396-7.097 4.463-6.716 5.367-15.966 4.156-25.438-0.36-2.811-2.605-6.287-5.034-8.66zM105.823 407.024c3.849-10.521 19.080-31.322 41.603-49.778 1.416-1.148 4.904-4.416 8.097-7.451-23.552 37.562-39.324 52.533-49.7 57.229zM239.217 99.843c6.783 0 10.642 17.097 10.962 33.127s-3.429 27.28-8.079 35.604c-3.851-12.324-5.713-31.75-5.713-44.452 0 0-0.283-24.279 2.83-24.279v0zM199.426 318.747c4.725-8.458 9.641-17.378 14.665-26.839 12.246-23.158 19.979-41.278 25.739-56.173 11.455 20.842 25.722 38.56 42.492 52.756 2.093 1.771 4.31 3.551 6.638 5.325-34.105 6.748-63.582 14.955-89.534 24.931v0zM414.451 316.826c-2.076 1.299-8.026 2.050-11.854 2.050-12.354 0-27.636-5.647-49.063-14.833 8.234-0.609 15.781-0.919 22.551-0.919 12.391 0 16.060-0.054 28.175 3.036 12.114 3.090 12.269 9.367 10.191 10.666v0z"></path>
		<path d="M458.903 114.538c-11.105-15.146-26.587-32.85-43.589-49.852s-34.706-32.482-49.852-43.589c-25.787-18.91-38.296-21.097-45.462-21.097h-248c-22.056 0-40 17.944-40 40v432c0 22.056 17.943 40 40 40h368c22.056 0 40-17.944 40-40v-312c0-7.166-2.186-19.675-21.097-45.462v0zM392.687 87.313c15.35 15.35 27.4 29.199 36.29 40.687h-76.977v-76.973c11.491 8.89 25.339 20.939 40.687 36.286v0zM448 472c0 4.336-3.664 8-8 8h-368c-4.336 0-8-3.664-8-8v-432c0-4.336 3.664-8 8-8 0 0 247.978-0.001 248 0v112c0 8.836 7.162 16 16 16h112v312z"></path>
	</svg>';
}

function Dat($style_icon)
{
	return '<svg class=' . $style_icon . ' version="1.2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="-1161 1870 512 512"
		 xml:space="preserve">
	<path d="M-905,1876c-136.1,0-246.8,108.8-249.9,244.1c2.9-118.1,92.7-212.9,203-212.9c112.2,0,203.1,97.9,203.1,218.7
		c0,25.9,21,46.9,46.9,46.9c25.9,0,46.9-21,46.9-46.9C-655,1987.9-766.9,1876-905,1876z M-905,2375.9
		c136.1,0,246.8-108.8,249.9-244.1c-2.9,118.1-92.7,212.9-203,212.9c-112.2,0-203.1-97.9-203.1-218.7c0-25.9-21-46.9-46.9-46.9
		c-25.9,0-46.9,21-46.9,46.9C-1155,2264-1043.1,2375.9-905,2375.9z"/>
	<g>
		<path d="M-824.3,2172.5h21.2l-12.1,45.7h-223.3l12.1-45.7h144l30.3-112.9H-864c-10.1,0-18.9,1.1-26.3,3.3
			c-7.4,2.2-13.6,5.5-18.6,9.9c-5.1,4.4-9.5,9-13.1,13.9c-3.6,4.9-6.5,10-8.7,15.3c-1.1,2.2-2.1,4.4-2.9,6.6
			c-0.8,2.2-1.5,4.4-2.1,6.6c-0.4,1.5-0.7,2.9-1.1,4.3c-0.4,1.4-0.7,2.7-1.1,4c-0.2,0.5-0.4,1.1-0.6,1.8c-0.2,0.6-0.4,1.2-0.5,1.8
			c0,0.2,0,0.3,0,0.4c0,0.1,0,0.2,0,0.4c-0.2,0.2-0.3,0.3-0.3,0.4c0,0.1,0,0.2,0,0.4c0,0.2-0.1,0.5-0.3,0.8c-0.2,0.2-0.3,0.4-0.3,0.6
			c0,0.2,0,0.4,0,0.6c-0.6,1.8-1,3.7-1.2,5.6c-0.3,1.9-0.6,3.9-1,5.9c0,0.6,0,1.2-0.1,1.8c-0.1,0.6-0.1,1.2-0.1,1.8
			c-0.2,1.3-0.3,2.5-0.4,3.6c-0.1,1.1-0.1,2.2-0.1,3.3c-0.2,1.1-0.3,2.2-0.4,3.2c-0.1,1-0.1,2-0.1,2.9c0,0.2,0,0.4,0,0.7
			c0,0.3,0,0.6,0,1c0,0.6,0,1.1,0,1.5c0,0.5,0,1,0,1.5h-57.8c-0.2-0.6-0.3-1.1-0.3-1.7c0-0.5,0-1.1,0-1.7c0-0.6,0-1.2,0-1.9
			c0-0.7,0.1-1.5,0.3-2.2c0-2.6,0.1-5.4,0.4-8.5c0.3-3.1,0.6-6.4,1-9.9c0.4-3.7,0.9-7.4,1.7-11.2c0.7-3.8,1.7-7.7,2.8-11.7
			c0.9-2.8,1.8-5.6,2.8-8.7c0.9-3,2-6.3,3.3-9.8c1.3-3.5,2.8-7,4.5-10.6c1.7-3.6,3.7-7.1,5.9-10.6c4.4-7.5,9.9-14.8,16.5-21.9
			c6.6-7.1,14.4-13.7,23.4-20c8.8-6.4,19.3-11.2,31.4-14.5c12.1-3.2,26-4.8,41.6-4.8h84L-824.3,2172.5z"/>
	</g>
	</svg>';
}

function D_M($style_icon)
{
	return '<svg class=' . $style_icon . ' version="1.1" baseProfile="basic" id="Слой_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="-41 164.9 512 512"
		xml:space="preserve">
	<path d="M215,164.9c-139.4,0-252.7,111.4-255.9,250c3-120.9,94.9-218,207.9-218c114.9,0,208,100.3,208,224c0,26.5,21.5,48,48,48
		s48-21.5,48-48C471,279.5,356.4,164.9,215,164.9z M215,676.9c139.4,0,252.7-111.4,255.9-250c-3,120.9-94.9,218-207.9,218
		c-114.9,0-208-100.3-208-224c0-26.5-21.5-48-48-48s-48,21.5-48,48C-41,562.3,73.6,676.9,215,676.9z"/>
	<g>
		<path d="M230.9,571.7c0.2-2.1,0.5-4.6,0.6-7.2c0.1-2.6,0.1-5.5,0.1-8.7c0-3.2-0.1-6.4-0.2-9.5c-0.2-3.3-0.4-6.4-0.9-9.8
			c-0.4-2.9-1-5.7-1.6-8.6c-0.7-2.9-1.4-5.6-2.3-8.4c-1-2.9-2.1-5.5-3.4-7.9c-1.3-2.4-2.7-4.8-4.3-7.1l-24.9,93.6h-45.3l42.5-159.3
			h45.3c0.3,0.4,0.6,0.8,0.9,1.1c0.3,0.3,0.6,0.7,0.9,1.1c0.2,0.3,0.6,0.7,0.9,1.1c0.2,0.4,0.6,0.9,0.9,1.3c0.2,0.4,0.6,0.9,0.9,1.3
			c0.2,0.4,0.7,0.9,1.1,1.3c0.3,0.4,0.6,0.9,0.9,1.4c0.3,0.5,0.6,1,0.9,1.4c0.6,1,1.1,2,1.7,3.3c0.6,1.1,1.1,2.3,1.7,3.4
			c0.6,1.1,1.1,2.3,1.7,3.4c0.6,1.1,1.1,2.3,1.7,3.4c1.1,2.4,2.1,4.9,3,7.4c0.9,2.5,1.6,5.1,2.4,7.7c0.9,2.7,1.6,5.5,2.4,8.2
			c0.7,2.7,1.4,5.4,2,7.9c0.6,2.7,1,5.3,1.3,7.6c0.2,2.4,0.5,4.6,0.7,6.8h0.9c1.1-2.1,2.4-4.4,4-6.8c1.5-2.4,3.3-5,5.3-7.7
			c2-2.7,4.2-5.5,6.4-8.2c2.3-2.8,4.6-5.5,7.1-8.2c0.9-1.1,1.7-2.2,2.7-3.3c0.9-1,1.9-2,2.9-3.3c1-1,2-2,3-3.1c1-1.1,2-2.1,3-3.1
			c2-2,4-4,5.9-6c2-2,3.8-3.9,5.7-5.8c1.5-1.3,3-2.5,4.4-3.7c1.4-1.2,2.8-2.4,4.2-3.5c1.3-1.1,2.6-2.3,3.8-3.3c1.3-1.1,2.6-2,3.8-2.9
			h45.3L328,598h-45.3l24.9-93.6c-1.1,1-2.4,2-3.7,3.3c-1.3,1.1-2.7,2.4-4.1,3.7c-1.5,1.5-2.9,2.9-4.4,4.5c-1.5,1.5-3,3.3-4.6,5.1
			c-2.6,2.9-5.1,6-7.7,9.5c-2.6,3.5-5.2,7.3-7.9,11.5c-2.7,4-5.4,8.5-7.9,13.4c-2.6,5-5.1,10.4-7.7,16.2L230.9,571.7L230.9,571.7z"/>
	</g>
	<g>
		<path d="M234.2,365.8h17.3l-9.9,37.2h-182l9.9-37.2h117.4l24.7-92h-9.7c-8.2,0-15.4,0.9-21.4,2.7c-6,1.8-11.1,4.5-15.2,8.1
			c-4.2,3.6-7.7,7.3-10.7,11.3c-2.9,4-5.3,8.2-7.1,12.5c-0.9,1.8-1.7,3.6-2.4,5.4c-0.7,1.8-1.2,3.6-1.7,5.4c-0.3,1.2-0.6,2.4-0.9,3.5
			c-0.3,1.1-0.6,2.2-0.9,3.3c-0.2,0.4-0.3,0.9-0.5,1.5c-0.2,0.5-0.3,1-0.4,1.5c0,0.2,0,0.2,0,0.3c0,0.1,0,0.2,0,0.3
			c-0.2,0.2-0.2,0.2-0.2,0.3c0,0.1,0,0.2,0,0.3s-0.1,0.4-0.2,0.7c-0.2,0.2-0.2,0.3-0.2,0.5c0,0.2,0,0.3,0,0.5c-0.5,1.5-0.8,3-1,4.6
			c-0.2,1.5-0.5,3.2-0.8,4.8c0,0.5,0,1-0.1,1.5c-0.1,0.5-0.1,1-0.1,1.5c-0.2,1.1-0.2,2-0.3,2.9c-0.1,0.9-0.1,1.8-0.1,2.7
			c-0.2,0.9-0.2,1.8-0.3,2.6c-0.1,0.8-0.1,1.6-0.1,2.4c0,0.2,0,0.3,0,0.6s0,0.5,0,0.8c0,0.5,0,0.9,0,1.2c0,0.4,0,0.8,0,1.2H90.1
			c-0.2-0.5-0.2-0.9-0.2-1.4c0-0.4,0-0.9,0-1.4c0-0.5,0-1,0-1.5s0.1-1.2,0.2-1.8c0-2.1,0.1-4.4,0.3-6.9c0.2-2.5,0.5-5.2,0.8-8.1
			c0.3-3,0.7-6,1.4-9.1c0.6-3.1,1.4-6.3,2.3-9.5c0.7-2.3,1.5-4.6,2.3-7.1c0.7-2.4,1.6-5.1,2.7-8c1.1-2.9,2.3-5.7,3.7-8.6
			c1.4-2.9,3-5.8,4.8-8.6c3.6-6.1,8.1-12.1,13.4-17.8c5.4-5.8,11.7-11.2,19.1-16.3c7.2-5.2,15.7-9.1,25.6-11.8
			c9.9-2.6,21.2-3.9,33.9-3.9h68.5L234.2,365.8z"/>
	</g>
	</svg>';
}

function N_M($style_icon)
{
	return '<svg class=' . $style_icon . ' version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
		viewBox="-41 164.9 512 512" style="enable-background:new -41 164.9 512 512;" xml:space="preserve">
	<path d="M215,164.9c-139.4,0-252.7,111.4-255.9,250c3-120.9,94.9-218,207.9-218c114.9,0,208,100.3,208,224c0,26.5,21.5,48,48,48
		s48-21.5,48-48C471,279.5,356.4,164.9,215,164.9z M215,676.9c139.4,0,252.7-111.4,255.9-250c-3,120.9-94.9,218-207.9,218
		c-114.9,0-208-100.3-208-224c0-26.5-21.5-48-48-48s-48,21.5-48,48C-41,562.3,73.6,676.9,215,676.9z"/>
	<g>
		<path d="M230.9,571.7c0.2-2.1,0.5-4.6,0.6-7.2c0.1-2.6,0.1-5.5,0.1-8.7s-0.1-6.4-0.2-9.5c-0.2-3.3-0.4-6.4-0.9-9.8
			c-0.4-2.9-1-5.7-1.6-8.6c-0.7-2.9-1.4-5.6-2.3-8.4c-1-2.9-2.1-5.5-3.4-7.9c-1.3-2.4-2.7-4.8-4.3-7.1L194,598.1h-45.3l42.5-159.3
			h45.3c0.3,0.4,0.6,0.8,0.9,1.1c0.3,0.3,0.6,0.7,0.9,1.1c0.2,0.3,0.6,0.7,0.9,1.1c0.2,0.4,0.6,0.9,0.9,1.3c0.2,0.4,0.6,0.9,0.9,1.3
			c0.2,0.4,0.7,0.9,1.1,1.3c0.3,0.4,0.6,0.9,0.9,1.4c0.3,0.5,0.6,1,0.9,1.4c0.6,1,1.1,2,1.7,3.3c0.6,1.1,1.1,2.3,1.7,3.4
			c0.6,1.1,1.1,2.3,1.7,3.4c0.6,1.1,1.1,2.3,1.7,3.4c1.1,2.4,2.1,4.9,3,7.4s1.6,5.1,2.4,7.7c0.9,2.7,1.6,5.5,2.4,8.2
			c0.7,2.7,1.4,5.4,2,7.9c0.6,2.7,1,5.3,1.3,7.6c0.2,2.4,0.5,4.6,0.7,6.8h0.9c1.1-2.1,2.4-4.4,4-6.8c1.5-2.4,3.3-5,5.3-7.7
			s4.2-5.5,6.4-8.2c2.3-2.8,4.6-5.5,7.1-8.2c0.9-1.1,1.7-2.2,2.7-3.3c0.9-1,1.9-2,2.9-3.3c1-1,2-2,3-3.1s2-2.1,3-3.1c2-2,4-4,5.9-6
			c2-2,3.8-3.9,5.7-5.8c1.5-1.3,3-2.5,4.4-3.7s2.8-2.4,4.2-3.5c1.3-1.1,2.6-2.3,3.8-3.3c1.3-1.1,2.6-2,3.8-2.9h45.3L328,598h-45.3
			l24.9-93.6c-1.1,1-2.4,2-3.7,3.3c-1.3,1.1-2.7,2.4-4.1,3.7c-1.5,1.5-2.9,2.9-4.4,4.5c-1.5,1.5-3,3.3-4.6,5.1
			c-2.6,2.9-5.1,6-7.7,9.5s-5.2,7.3-7.9,11.5c-2.7,4-5.4,8.5-7.9,13.4c-2.6,5-5.1,10.4-7.7,16.2L230.9,571.7L230.9,571.7z"/>
	</g>
	<g>
		<path d="M167.3,236.9L122.9,403H75.7L120,236.9L167.3,236.9L167.3,236.9z M268.9,236.9L224.6,403h-47.2l22-82h-45.7l9.8-37.4h45.7
			l12.5-46.8L268.9,236.9L268.9,236.9z"/>
	</g>
	</svg>';
}

function Nedela($style_icon)
{
	return '<svg class=' . $style_icon . ' version="1.2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="-1161 1870 512 512"
		xml:space="preserve">
	<path d="M-905,1876c-136.1,0-246.8,108.8-249.9,244.1c2.9-118.1,92.7-212.9,203-212.9c112.2,0,203.1,97.9,203.1,218.7
	c0,25.9,21,46.9,46.9,46.9c25.9,0,46.9-21,46.9-46.9C-655,1987.9-766.9,1876-905,1876z M-905,2375.9
	c136.1,0,246.8-108.8,249.9-244.1c-2.9,118.1-92.7,212.9-203,212.9c-112.2,0-203.1-97.9-203.1-218.7c0-25.9-21-46.9-46.9-46.9
	c-25.9,0-46.9,21-46.9,46.9C-1155,2264-1043.1,2375.9-905,2375.9z"/>
	<g>
	<path d="M-904,2013.9l-54.5,204.3h-58.1l54.5-204.3H-904z M-779,2013.9l-54.5,204.3h-58.1l27-100.8h-56.2l12.1-46h56.2l15.4-57.6
		H-779z"/>
	</g>
	</svg>';
}

function Mont($style_icon)
{
	return '<svg class=' . $style_icon . ' version="1.2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="-1161 1870 512 512"
		xml:space="preserve">
	<path d="M-905,1870c-139.4,0-252.7,111.4-255.9,250c3-120.9,94.9-218,207.9-218c114.9,0,208,100.3,208,224c0,26.5,21.5,48,48,48
	s48-21.5,48-48C-649,1984.6-763.6,1870-905,1870z M-905,2382c139.4,0,252.7-111.4,255.9-250c-3,120.9-94.9,218-207.9,218
	c-114.9,0-208-100.3-208-224c0-26.5-21.5-48-48-48s-48,21.5-48,48C-1161,2267.4-1046.4,2382-905,2382z"/>
	<g>
	<path d="M-940.2,2191.3c0.3-2.6,0.6-5.6,0.7-8.8c0.1-3.2,0.1-6.8,0.1-10.7c0-3.9-0.1-7.8-0.3-11.7c-0.2-4-0.5-7.9-1.1-12
		c-0.5-3.5-1.2-7-2-10.5c-0.8-3.5-1.7-6.9-2.8-10.3c-1.2-3.5-2.6-6.8-4.2-9.7c-1.6-3-3.3-5.9-5.3-8.7l-30.6,114.8h-55.6l52.1-195.4
		h55.6c0.4,0.5,0.7,1,1.1,1.4c0.4,0.4,0.7,0.9,1.1,1.4c0.3,0.4,0.7,0.8,1.1,1.3c0.3,0.5,0.7,1.1,1.1,1.6c0.3,0.5,0.7,1.1,1.1,1.6
		c0.3,0.5,0.8,1.1,1.3,1.6c0.4,0.5,0.7,1.1,1.1,1.7c0.4,0.6,0.7,1.2,1.1,1.7c0.7,1.2,1.4,2.5,2.1,4c0.7,1.4,1.4,2.8,2.1,4.2
		c0.7,1.4,1.4,2.8,2.1,4.2c0.7,1.4,1.4,2.8,2.1,4.2c1.4,3,2.6,6,3.7,9.1c1.1,3.1,2,6.2,2.9,9.4c1.1,3.3,2,6.7,2.9,10
		c0.9,3.3,1.7,6.6,2.4,9.7c0.7,3.3,1.2,6.5,1.6,9.3c0.3,2.9,0.6,5.7,0.8,8.3h1.1c1.4-2.6,3-5.4,4.9-8.4c1.8-3,4-6.1,6.5-9.5
		c2.5-3.3,5.1-6.7,7.9-10.1c2.8-3.4,5.7-6.8,8.7-10.1c1.1-1.4,2.1-2.7,3.3-4c1.1-1.2,2.3-2.5,3.6-4c1.2-1.2,2.5-2.5,3.7-3.8
		c1.2-1.3,2.5-2.6,3.7-3.8c2.5-2.5,4.9-4.9,7.2-7.4c2.4-2.5,4.7-4.8,7-7.1c1.9-1.6,3.7-3.1,5.4-4.6c1.7-1.5,3.4-2.9,5.1-4.3
		c1.6-1.4,3.2-2.8,4.7-4.1c1.6-1.3,3.2-2.5,4.7-3.6h55.6l-52.2,195.4h-55.6l30.6-114.8c-1.4,1.2-2.9,2.5-4.5,4
		c-1.6,1.4-3.3,2.9-5,4.5c-1.8,1.8-3.6,3.6-5.4,5.5c-1.8,1.9-3.7,4-5.7,6.3c-3.2,3.5-6.3,7.4-9.5,11.7c-3.2,4.3-6.4,9-9.7,14.1
		c-3.3,4.9-6.6,10.4-9.7,16.5c-3.2,6.1-6.3,12.7-9.5,19.9H-940.2z"/>
	</g>
	</svg>';
}

class Mail
{
	public $array;
	public function EmailKalendar()
	{
		foreach (Data(SYSTEMADMIN) as $item) {
			$emailsystem = $item['email2'];
		}

		mail($emailsystem, '"SUM_LINE"', 'Врач-Эксперт назначил вам индивидуальное мероприятие по контролю за вашим здоровьем. В вашем личном кабинете в разделе "Календарь" эти назначения выделены красным цветом. Текст назначения: ' . $this->array['text']);
		mail($this->array['mail'], '"SUM_LINE"', 'Врач-Эксперт назначил вам индивидуальное мероприятие по контролю за вашим здоровьем. В вашем личном кабинете в разделе "Календарь" эти назначения выделены красным цветом. Текст назначения: ' . $this->array['text']);
	}
}

function EmailPolsovatelDublicat($lastname, $firstname, $middlename, $email, $limite, $summa, $mailpolsov, $grup, $personall, $valuta)
{
	mail(
		$email,
		'"SUM_LINE"',
		'Вы включены в список членов Ассоциации "Язык Сердца" с такими данными: 
		ФИО: ' . $lastname . ' ' . $firstname . ' ' . $middlename . '
		E-mail: ' . $email . '
		Ваш лимит: ' . $limite . '
		Номер Вашей группы: ' . $grup . '
		Персональный номер: ' . $personall . '
		На вашем счету: ' . $summa . ' ' . $valuta . '.
		Ссылка на форму обработки: http://iridoc.com/cardio/index.php?name=card
		Устав Ассоциации "Язык Сердца" : http://iridoc.ru/ustav-onlajn-kluba-zdorovya-wellness-lifestyle/
		 Более подробная информация по ссылке: http://iridoc.ru/vy-vklyucheny-v-spisok-polzovatelej-kluba-wellness-lifestyle/
		 С уважением Правление Ассоциации "Язык Сердца".'
	);
	mail(
		$mailpolsov,
		'"SUM_LINE"',
		'Вы включены в список членов Ассоциации "Язык Сердца" с такими данными: 
		ФИО: ' . $lastname . ' ' . $firstname . ' ' . $middlename . '
		E-mail: ' . $email . '
		Ваш лимит: ' . $limite . '
		Номер Вашей группы: ' . $grup . '
		Персональный номер: ' . $personall . '
		На вашем счету: ' . $summa . ' ' . $valuta . '.
		Ссылка на форму обработки: http://iridoc.com/cardio/index.php?name=card
		Устав Ассоциации "Язык Сердца" : http://iridoc.ru/ustav-onlajn-kluba-zdorovya-wellness-lifestyle/
		 Более подробная информация по ссылке: http://iridoc.ru/vy-vklyucheny-v-spisok-polzovatelej-kluba-wellness-lifestyle/
		 С уважением Правление Ассоциации "Язык Сердца".'
	);
	$block = 'polsovateli';
	return $block;
}

function EmailPolsovatel($s)
{
	for ($i = 0; $i < 2; $i++) {
		mail(
			$s['email'][$i],
			'SUM_LINE"',
			'Вы включены в список членов Ассоциации "Язык Сердца" с такими данными: 
			ФИО: ' . $s['lastname'] . ' ' . $s['firstname'] . ' ' . $s['middlename'] . '
			E-mail: ' . $s['email'][0] . '
			Ваш лимит: ' . $s['limite'] . '
			Ваш персональный номер: ' . $s['num'] . '
			Номер группы: ' . $s['numgrup'] . '
			На вашем счету: ' . $s['summa'] . ' ' . $s['valut'] . '.
			Ссылка на форму обработки: http://iridoc.com/cardio/index.php?name=card
			Устав Ассоциации "Язык Сердца" : http://iridoc.ru/ustav-onlajn-kluba-zdorovya-wellness-lifestyle/
			Более подробная информация по ссылке: http://iridoc.ru/vy-vklyucheny-v-spisok-polzovatelej-kluba-wellness-lifestyle/
			С уважением Правление Ассоциации "Язык Сердца".'
		);
	}
	$block = 'polsovateli';
	return $block;
}

function EmailPartneruDublicat($lastname, $firstname, $middlename, $email, $limite, $group, $summa, $mes, $valuta, $personall)
{
	if ($group != '' && $group != ' ') $group = 'Вам не присвоен номер группы!';
	if ($personall != '' && $personall != ' ') $personall = 'Вам пока не присвоин персональный номер!';
	mail(
		$email,
		'"SUM_LINE"',
		'Вы включены в список членов Ассоциации "Язык Сердца" с такими данными: 
		ФИО: ' . $lastname . ' ' . $firstname . ' ' . $middlename . '
		E-mail: ' . $email . '
		' . $mes . '
		Ваш лимит: ' . $limite . '
		Номер Вашей группы: ' . $group . '
		На вашем счету: ' . $summa . ' ' . $valuta . '.
		Ссылка на форму обработки: http://iridoc.com/cardio/index.php?name=card
		Устав Ассоциации "Язык Сердца" : http://iridoc.ru/ustav-onlajn-kluba-zdorovya-wellness-lifestyle/
		Более подробная информация по ссылке: http://iridoc.ru/vy-vklyucheny-v-spisok-polzovatelej-kluba-wellness-lifestyle/
		С уважением Правление Ассоциации "Язык Сердца".'
	);
	mail(
		$email,
		'"SUM_LINE"',
		'Вы включены в список членов Ассоциации "Язык Сердца" с такими данными: 
		ФИО: ' . $lastname . ' ' . $firstname . ' ' . $middlename . '
		E-mail: ' . $email . '
		' . $mes . '
		Ваш лимит: ' . $limite . '
		Номер Вашей группы: ' . $group . '
		На вашем счету: ' . $summa . ' ' . $valuta . '.
		Ссылка на форму обработки: http://iridoc.com/cardio/index.php?name=card
		Устав Ассоциации "Язык Сердца" : http://iridoc.ru/ustav-onlajn-kluba-zdorovya-wellness-lifestyle/
		Более подробная информация по ссылке: http://iridoc.ru/vy-vklyucheny-v-spisok-polzovatelej-kluba-wellness-lifestyle/
		С уважением Правление Ассоциации "Язык Сердца".'
	);
	$block = 'partner';
	return $block;
}

function EmailPartneru($lastname, $firstname, $middlename, $email, $limite, $group, $summa, $mes, $valuta)
{
	mail(
		$email,
		'SUM_LINE"',
		'Вы включены в список партнеров Клуба «Wellness Lifestyle» с такими данными:
		ФИО: ' . $lastname . ' ' . $firstname . ' ' . $middlename . '
		E-mail: ' . $email . '
		' . $mes . '
		Ваш лимит: ' . $limite . '
		Номер Вашей группы: ' . $group . '
		На вашем счету: ' . $summa . ' ' . $valuta . '.
		Ссылка на форму обработки: http://iridoc.com/cardio/index.php?name=card
		Устав Ассоциации "Язык Сердца" : http://iridoc.ru/ustav-onlajn-kluba-zdorovya-wellness-lifestyle/
		Более подробная информация по ссылке: http://iridoc.ru/vy-vklyucheny-v-spisok-polzovatelej-kluba-wellness-lifestyle/
		С уважением Правление Ассоциации "Язык Сердца".'
	);
	foreach (Data(SYSTEMADMIN) as $item) {
		$emailsystem = $item['email2'];
	}
	mail(
		$emailsystem,
		'SUM_LINE"',
		'Вы включены в список партнеров Клуба «Wellness Lifestyle» с такими данными:
		ФИО: ' . $lastname . ' ' . $firstname . ' ' . $middlename . '
		E-mail: ' . $email . '
		' . $mes . '
		Ваш лимит: ' . $limite . '
		Номер Вашей группы: ' . $group . '
		На вашем счету: ' . $summa . ' ' . $valuta . '.
		Ссылка на форму обработки: http://iridoc.com/cardio/index.php?name=card
		Устав Ассоциации "Язык Сердца" : http://iridoc.ru/ustav-onlajn-kluba-zdorovya-wellness-lifestyle/
		Более подробная информация по ссылке: http://iridoc.ru/vy-vklyucheny-v-spisok-polzovatelej-kluba-wellness-lifestyle/
		С уважением Правление Ассоциации "Язык Сердца".'
	);
	$block = 'partner';
	return $block;
}

function Diagram($snak)
{
	for ($u = 0; $u < 7; $u++) {
		$f = count(explode('.', $snak[$u]));

		if ($snak[$u] >= 0 && $snak[$u] <= 0.6) {
			$snakk = 0;
		} elseif ($snak[$u] >= 0.7 && $snak[$u] <= 1.6) {
			$snakk = 1;
		} elseif ($snak[$u] >= 1.7 && $snak[$u] <= 2.6) {
			$snakk = 2;
		} elseif ($snak[$u] >= 2.7) {
			$snakk = 3;
		}

		for ($i = 0; $i < 4; $i++) {
			if ($snakk == $i) {
				if ($f == 1) ${'cir' . $u . $i} = 0;
				if ($f == 2) ${'cir' . $u . $i} = 1;
				${'end' . $u . $i} = 1;
			} else {
				if ($f == 1) ${'cir' . $u . $i} = 0;
				if ($f == 2) ${'cir' . $u . $i} = 0;
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
		<g>
		<circle  style="opacity: ' . $cir03 . ';" id="XMLID_1_" fill="#FFFFFF" stroke="#000000" stroke-width="3" stroke-miterlimit="10" cx="501" cy="93" r="19"/>
		<circle  style="opacity: ' . $cir02 . ';" id="XMLID_2_" fill="#FFFFFF" stroke="#000000" stroke-width="3" stroke-miterlimit="10" cx="501" cy="207" r="19"/>
		<circle  style="opacity: ' . $cir01 . ';" id="XMLID_3_" fill="#FFFFFF" stroke="#000000" stroke-width="3" stroke-miterlimit="10" cx="501" cy="325" r="19"/>
		<circle  style="opacity: ' . $cir00 . ';" id="XMLID_4_" fill="#FFFFFF" stroke="#000000" stroke-width="3" stroke-miterlimit="10" cx="501" cy="417" r="19"/>
	</g>
	<g>
		<circle  style="opacity: ' . $cir13 . ';" id="XMLID_28_" fill="#FFFFFF" stroke="#000000" stroke-width="3" stroke-miterlimit="10" cx="817.5" cy="246.8" r="19"/>
		<circle  style="opacity: ' . $cir12 . ';" id="XMLID_27_" fill="#FFFFFF" stroke="#000000" stroke-width="3" stroke-miterlimit="10" cx="728.4" cy="317.8" r="19"/>
		<circle  style="opacity: ' . $cir11 . ';" id="XMLID_26_" fill="#FFFFFF" stroke="#000000" stroke-width="3" stroke-miterlimit="10" cx="636.1" cy="391.4" r="19"/>
		<circle  style="opacity: ' . $cir10 . ';" id="XMLID_25_" fill="#FFFFFF" stroke="#000000" stroke-width="3" stroke-miterlimit="10" cx="564.2" cy="448.8" r="19"/>
	</g>
	<g>
		<circle  style="opacity: ' . $cir23 . ';" id="XMLID_24_" fill="#FFFFFF" stroke="#000000" stroke-width="3" stroke-miterlimit="10" cx="896.6" cy="590.1" r="19"/>
		<circle  style="opacity: ' . $cir22 . ';" id="XMLID_23_" fill="#FFFFFF" stroke="#000000" stroke-width="3" stroke-miterlimit="10" cx="783.5" cy="564.7" r="19"/>
		<circle  style="opacity: ' . $cir21 . ';" id="XMLID_22_" fill="#FFFFFF" stroke="#000000" stroke-width="3" stroke-miterlimit="10" cx="668.4" cy="538.5" r="19"/>
		<circle  style="opacity: ' . $cir20 . ';" id="XMLID_21_" fill="#FFFFFF" stroke="#000000" stroke-width="3" stroke-miterlimit="10" cx="578.7" cy="518" r="19"/>
	</g>
	<g>
		<circle  style="opacity: ' . $cir33 . ';" id="XMLID_20_" fill="#FFFFFF" stroke="#000000" stroke-width="3" stroke-miterlimit="10" cx="674.3" cy="864.5" r="19"/>
		<circle  style="opacity: ' . $cir32 . ';" id="XMLID_19_" fill="#FFFFFF" stroke="#000000" stroke-width="3" stroke-miterlimit="10" cx="624.8" cy="761.7" r="19"/>
		<circle  style="opacity: ' . $cir31 . ';" id="XMLID_18_" fill="#FFFFFF" stroke="#000000" stroke-width="3" stroke-miterlimit="10" cx="573.6" cy="655.4" r="19"/>
		<circle  style="opacity: ' . $cir30 . ';" id="XMLID_17_" fill="#FFFFFF" stroke="#000000" stroke-width="3" stroke-miterlimit="10" cx="533.7" cy="572.5" r="19"/>
	</g>
	<g>
		<circle  style="opacity: ' . $cir43 . ';" id="XMLID_16_" fill="#FFFFFF" stroke="#000000" stroke-width="3" stroke-miterlimit="10" cx="322.4" cy="863.2" r="19"/>
		<circle  style="opacity: ' . $cir42 . ';" id="XMLID_15_" fill="#FFFFFF" stroke="#000000" stroke-width="3" stroke-miterlimit="10" cx="371.9" cy="760.5" r="19"/>
		<circle  style="opacity: ' . $cir41 . ';" id="XMLID_14_" fill="#FFFFFF" stroke="#000000" stroke-width="3" stroke-miterlimit="10" cx="423.1" cy="654.2" r="19"/>
		<circle  style="opacity: ' . $cir40 . ';" id="XMLID_13_" fill="#FFFFFF" stroke="#000000" stroke-width="3" stroke-miterlimit="10" cx="463" cy="571.3" r="19"/>
	</g>
	<g>
		<circle  style="opacity: ' . $cir53 . ';" id="XMLID_12_" fill="#FFFFFF" stroke="#000000" stroke-width="3" stroke-miterlimit="10" cx="104" cy="587.4" r="19"/>
		<circle  style="opacity: ' . $cir52 . ';" id="XMLID_11_" fill="#FFFFFF" stroke="#000000" stroke-width="3" stroke-miterlimit="10" cx="215.1" cy="562" r="19"/>
		<circle  style="opacity: ' . $cir51 . ';" id="XMLID_10_" fill="#FFFFFF" stroke="#000000" stroke-width="3" stroke-miterlimit="10" cx="330.1" cy="535.7" r="19"/>
		<circle  style="opacity: ' . $cir50 . ';" id="XMLID_9_" fill="#FFFFFF" stroke="#000000" stroke-width="3" stroke-miterlimit="10" cx="419.8" cy="515.3" r="19"/>
	</g>
	<g>
		<circle  style="opacity: ' . $cir63 . ';" id="XMLID_8_" fill="#FFFFFF" stroke="#000000" stroke-width="3" stroke-miterlimit="10" cx="183.4" cy="244.6" r="19"/>
		<circle  style="opacity: ' . $cir62 . ';" id="XMLID_7_" fill="#FFFFFF" stroke="#000000" stroke-width="3" stroke-miterlimit="10" cx="272.6" cy="315.7" r="19"/>
		<circle  style="opacity: ' . $cir61 . ';" id="XMLID_6_" fill="#FFFFFF" stroke="#000000" stroke-width="3" stroke-miterlimit="10" cx="366.8" cy="389.2" r="19"/>
		<circle  style="opacity: ' . $cir60 . ';" id="XMLID_5_" fill="#FFFFFF" stroke="#000000" stroke-width="3" stroke-miterlimit="10" cx="436.8" cy="446.6" r="19"/>
	</g>
	</svg>';
	return $diagramm;
}

function Status($id)
{
	include('conect.php');
	$resultat = mysqli_query($mysqli, "SELECT * FROM " . COMENTARI_BS) or die("Ошибка " . mysqli_error($mysqli));
	if ($resultat) {
		$rows = mysqli_num_rows($resultat);
		for ($uy = 0; $uy < $rows; $uy++) {
			$rowy = mysqli_fetch_row($resultat);
			if ($id == $rowy[1]) {
				$resultbio = mysqli_query($mysqli, "SELECT * FROM " . DOSA) or die("Ошибка " . mysqli_error($mysqli));
				if ($resultbio) {
					$rowsbio = mysqli_num_rows($resultbio);
					if ($rowsbio > 1) {
						$dosa1 .= '<option> </option>';
					}
					for ($i = 0; $i < $rowsbio; $i++) {
						$rowbio = mysqli_fetch_row($resultbio);
						if ($rowbio[1] == $rowy[3]) {
							$selected = ' selected';
						} else {
							$selected = '';
						}
						$dosa1 .= '<option' . $selected . '>' . $rowbio[1] . '</option>';
					}
				}

				$status = '
					<div class="biostim_block">
						<select name="vid_biostemulatora1" class="menu_biosti" keydown="">' . $dosa1 . '</select>
						<lable class="wf_text"><b>максимальная доза</b></lable>
						<input name="col_biostimulyator1" class="biostim" type="number" width="5" value="' . $rowy[2] . '">
					</div>
					<div class="biostim_block">
						<lable class="wf_text"><b>средняя доза</b></lable>
						<input name="col_biostimulyator2" class="biostim" type="number" width="5" value="' . $rowy[4] . '">
					</div>
					<div class="biostim_block">
						<lable class="wf_text"><b>минимальная доза</b></lable>
						<input name="col_biostimulyator3" class="biostim" type="number" width="5" value="' . $rowy[5] . '">
						<textarea name="biostimulyator_dosa3_coment" class="pole_vvoda4" type="text" value="">' . $rowy[6] . '</textarea>
					</div>
				';
			}
		}
	}
	return $status;
}
