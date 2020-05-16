<?php
// Формируем список дополнительныхкатегорий анкетирования для диаграммы
class DopCategoriDiagrams
{
    public $id;
    public $name_dop;
    public $groups;
    public $data_dop;

	public function DopCategori()
	{
		$steck = '';
		foreach (Data(DIAGRAM_CATEGORI) as $item) {
			if ($item['personal_id'] == '0' || $item['personal_id'] == $this->id) {
				$steck .= '<option value="' . $item['groups'] . '">' . $item['name'] . '</option>';
			}
		}
		return $steck;
    }
    
    public function DopCategoriDelet()
	{
		$steck = '';
		foreach (Data(DIAGRAM_CATEGORI) as $item) {
			if ($item['personal_id'] == $this->id) {
				$steck .= '<option value="' . $item['id'] . '">' . $item['name'] . '</option>';
			}
		}
		return $steck;
    }

    public function DopCatDelet($id)
	{
        include CONECT;

        foreach (Data(DIAGRAM_CATEGORI) as $item) {
            $groups = $item['groups'];
        }

        foreach (Data(DIAGRAMMA) as $item) {
            if ($item['groups'] == $groups) {
                $id_groups = $item['id'];

                mysqli_query($mysqli, "DELETE FROM " . DIAGRAMMA . " WHERE  " . DIAGRAMMA . ".`id` = $id_groups") or die("Ошибка " . mysqli_error($mysqli));
            }
        }

        mysqli_query($mysqli, "DELETE FROM " . DIAGRAM_CATEGORI . " WHERE  " . DIAGRAM_CATEGORI . ".`id` = $id") or die("Ошибка " . mysqli_error($mysqli));
		return true;
    }

    public function DopCategoriSpisok()
	{
		foreach (Data(DIAGRAM_CATEGORI) as $item) {
			if ($item['personal_id'] == '0' || $item['personal_id'] == $this->id) {
				$steck[$item['groups']] = $item['name'];
			}
		}
		return $steck;
    }
    
    public function DopCategoriMod()
	{
        $s = 4;
        $steck = [];

		foreach (Data(DIAGRAM_CATEGORI) as $item) {
			if ($item['personal_id'] == '0' || $item['personal_id'] == $this->id) {
				$steck[$s++] = $item['groups'];
			}
		}
		return $steck;
    }
    
    public function NewDopCategori()
    {
        include CONECT;
        $mysqli->query("INSERT INTO " . DIAGRAM_CATEGORI . " (`name`, `groups`, `personal_id`) VALUES ('$this->name_dop', '$this->groups', '$this->id')");
		return true;
    }

    public function SaveResultDop()
    {
        include CONECT;

        $cats = ['1А', '1Б', '2А', '2Б', '3А', '3Б', '4А', '4Б', '5А', '5Б', '6А', '6Б', '7А', '7Б', '8А', '8Б', '9А', '9Б'];
        $diapason_cat = ['0-5.56', '5.57-11.12', '11.13-16.68', '16.69-22.24', '22.25-27.8', '27.8-33.36', '33.37-38.92', '38.93-44.48', '44.49-50.04', '50.05-55.6', '55.61-61.16', '61.17-66.72', '66.73-72.28', '72.28-77.84', '77.85-83.4', '83.41-88.96', '88.97-94.52', '94.53-100'];

        if ($this->data_dop['pokasanie'] > 100) {
            $data_dop_ = 100;
        } else {
            $data_dop_ = $this->data_dop['pokasanie'];
        }

        for ($i = 0; $i < 18; $i++) {
            $_s_ = explode('-', $diapason_cat[$i]);

            if ($data_dop_ >= $_s_[0] && $data_dop_ <= $_s_[1]) {
                $categories = $cats[$i];
            }
        }
        
        $groups = $this->data_dop['psevdonim'];
        $data = $this->data_dop['data'];

        if ($groups == 'kletochno_tkanevaya_intoksikaciya') {
            if ($this->data_dop['pokasanie'] >= 0 && $this->data_dop['pokasanie'] <= 2) {
                $color = 'green';
            } elseif ($this->data_dop['pokasanie'] > 2 && $this->data_dop['pokasanie'] <= 4) {
                $color = 'yellow';
            } elseif ($this->data_dop['pokasanie'] > 4) {
                $color = 'red';
            }
        } elseif ($groups == 'kishechnaya_intoksikaciya') {
            if ($this->data_dop['pokasanie'] >= 0 && $this->data_dop['pokasanie'] <= 5) {
                $color = 'green';
            } elseif ($this->data_dop['pokasanie'] > 5 && $this->data_dop['pokasanie'] <= 13) {
                $color = 'yellow';
            } elseif ($this->data_dop['pokasanie'] > 13) {
                $color = 'red';
            }
        } elseif ($groups == 'endorfinodificit') {
            if ($this->data_dop['pokasanie'] >= 0 && $this->data_dop['pokasanie'] <= 7.5) {
                $color = 'green';
            } elseif ($this->data_dop['pokasanie'] > 7.5 && $this->data_dop['pokasanie'] <= 13) {
                $color = 'yellow';
            } elseif ($this->data_dop['pokasanie'] > 13) {
                $color = 'red';
            }
        } else {
            $color = '';
        }
        $pocasatel = $this->data_dop['pokasanie'];

        $mysqli->query("INSERT INTO " . DIAGRAMMA . " (`id_client`, `categories`, `groups`, `data`, `color`, `pocasatel`) VALUES ('$this->id', '$categories', '$groups', '$data', '$color', '$pocasatel')");
		return true;
    }
}

class Translit
{
    public $text;

    public function Transliterator()
    {
        $rus = ['А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я','а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я',' ', '-'];
        
        $lat = ['a','b','v','g','d','e','e','gh','z','i','y','k','l','m','n','o','p','r','s','t','u','f','h','c','ch','sh','sch','y','y','y','e','yu','ya','a','b','v','g','d','e','e','gh','z','i','y','k','l','m','n','o','p','r','s','t','u','f','h','c','ch','sh','sch','y','y','y','e','yu','ya','_', '_'];

        $text = str_replace($rus, $lat, $this->text);
        
        return $text;
    }
}