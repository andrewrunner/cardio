<?php

/**
 * Класс для операций с финансами
 */
class Spacecraft
{
    public $id;
    public $price;
    public $valuta;
    public $name;
    public $usluga;
    public $frilanc;
    public $frilanc_plus;
    public $groups;
    public $limite;

    /**
     * регистрация в счета суммы
     */
    public function RegictreChetLimite($reg)
    {
        $this->id = $reg['id'];
        $this->name = $reg['name'];
        $this->usluga = $reg['usluga'];

        $this->Chet();
    }

    /**
     * регистрация в счета суммы
     */
    public function RegictreChet($reg)
    {
        $this->id = $reg['id'];
        $this->name = $reg['name'];
        $this->usluga = $reg['usluga'];

        $this->Chet();
    }

    public function FixdFrilance($reg)
    {
        // оглашение переменных
        $this->id = $reg['id'];
        $this->price = $reg['price'];
        $this->valuta = $reg['valuta'];
        $this->name = $reg['name'];
        $this->usluga = $reg['usluga'];
        $this->groups = $reg['groups'];
        $this->frilanc_plus = $reg['frilanc_plus'];
        $this->frilanc = '';

        // выполнение операций
        $this->PersonalPribulLimite()->Chet();
    }

    /**
     * выполняем работу со счетом если только лимит
     */
    public function FixedLimit($reg)
    {
        // оглашение переменных
        $this->id = $reg['id'];
        $this->price = $reg['price'];
        $this->valuta = $reg['valuta'];
        $this->name = $reg['name'];
        $this->usluga = $reg['usluga'];
        $this->frilanc = $reg['frilanc'];
        $this->groups = $reg['groups'];

        // выполнение операций
        $this->PersonalRashodLimite()->FinOtchet()->Chet();
    }

    /**
     * выполняем работу со счетом
     */
    public function Fixed($reg)
    {
        // оглашение переменных
        $this->id = $reg['id'];
        $this->price = $reg['price'];
        $this->valuta = $reg['valuta'];
        $this->name = $reg['name'];
        $this->usluga = $reg['usluga'];
        $this->frilanc = $reg['frilanc'];

        // выполнение операций
        if ($this->frilanc != '') {
            $this->PersonalLimite();
        } else {
            $this->PersonalChet();
        }

        $this->FinOtchet();
        $this->Chet();
    }

    /**
     * Внесение записей в счета
     */
    public function Chet()
    {
        include CONECT;
        $array = [];

        // получение записи о считах
        foreach ($this->Data(CHETDB) as $item) {
            if ($item['id_client'] == $this->id) {
                $array[count($array)] = $item;
            }
        }

        $personal_data_array = $this->Polsovatel();
        $personal_data = $this->getMaxId($array);

        // группа переменных для счета
        $id_client = $this->id;
        $name_usluga = $this->name;
        $data_operation = date('d.m.Y H:i');
        $limite_uslovn = $personal_data['limite_uslovn'];

        if ($this->frilanc_plus == '') {
            if ($this->price < 0) {
                $r_l = gmp_neg($this->price);
            } else {
                $r_l = $this->price;
            }

            $rashod_limit = $personal_data['rashod_limit'] + $this->ConverterValut($this->valuta, $r_l, 'грн');
        } else {
            $rashod_limit = $personal_data['rashod_limit'];
        }

        $suma_tec = $this->ConverterValut($personal_data_array['valuta'], $personal_data_array['summ'], 'грн');
        $price_club = $this->ConverterValut($this->valuta, $this->price, 'грн');

        if ($this->usluga != '') {
            $raschet_usluga = $this->usluga;
            $data_pogasheniya = date('d.m.Y H:i');
        } else {
            $raschet_usluga = '';
            $data_pogasheniya = '';
        }

        if ($personal_data_array['limite'] == $personal_data['octatoc_obrabotci']) {
            $personal_data_array['limite'] = 0;
            $personal_data['octatoc_obrabotci'] = 0;
        }

        if ($this->limite != '') {
            $limite = $this->limite;
        } else {
            $limite = $personal_data_array['limite'];
        }

        if ($this->frilanc != '') {
            $octatoc_obrabotci = $personal_data['octatoc_obrabotci'] + $this->frilanc;
        } else {
            $octatoc_obrabotci = $personal_data['octatoc_obrabotci'];
        }

        $mysqli->query("INSERT INTO " . CHETDB . " (`id_client`, `name`, `data`, `limite_uslovn`, `rashod_limit`, `sama_tec`, `price_club`, `raschet_usluga`, `data_pogasheniya`, `obrabotci`, `octatoc_obrabotci`) VALUES ('$id_client', '$name_usluga', '$data_operation', '$limite_uslovn', '$rashod_limit', '$suma_tec', '$price_club', '$raschet_usluga', '$data_pogasheniya', '$limite', '$octatoc_obrabotci')");
        return true;
    }

    /**
     * Получение последней записи пользователя из массива
     */
    public function getMaxId($array)
    {
        $max_id = [];

        foreach ($array as $item) {
            if ($max_id['ID'] === NULL) {
                $max_id = $item;
            }

            if ($max_id['ID'] > $item['ID']) {
                $max_id = $item;
            }
        }

        return $max_id;
    }

    /**
     * Внесение записей в финотчет, отображается за день
     */
    public function FinOtchet()
    {
        include CONECT;
        $data = date('y-m-d');
        $summa = $this->ConverterValut($this->valuta, $this->price, 'грн');
        $mysqli->query("INSERT INTO " . FINOTCHET . " (`summa`, `data`) VALUES ('$summa', '$data')");
        return true;
    }

    /**
     * Персональные данные пользователя
     */
    public function Polsovatel()
    {
        foreach ($this->Data(POLSOVATEL) as $item) {
            if ($item['id'] == $this->id) {
                $personal_data = $item;
            }
        }
        return $personal_data;
    }

    /**
     * Внесение записи в персональный лимит
     */
    public function PersonalLimite()
    {
        include CONECT;
        $personal_data = $this->Polsovatel();
        $limite = $personal_data['limite'] + $this->frilanc;
        $mysqli->query("UPDATE " . POLSOVATEL . " SET `limite` = '$limite' WHERE " . POLSOVATEL . ".`id` = " . $this->id);
        return true;
    }

    /**
     * Расход по лимиту
     */
    public function PersonalRashodLimite()
    {
        include CONECT;
        $personal_data = $this->Polsovatel();
        $limite = $personal_data['limite'] - $this->frilanc;
        $mysqli->query("UPDATE " . POLSOVATEL . " SET `limite` = '$limite', `group` = '$this->groups' WHERE " . POLSOVATEL . ".`id` = " . $this->id);
        return true;
    }

    /**
     * Записываем в базу сумму положеную на счет
     */
    public function PersonalPribulLimite()
    {
        include CONECT;
        $personal_data = $this->Polsovatel();
        $limite = $personal_data['limite'] + $this->frilanc_plus;
        $summa = $personal_data['summ'] + $this->ConverterValut($this->valuta, $this->price, 'грн');
        $mysqli->query("UPDATE " . POLSOVATEL . " SET `limite` = '$limite', `summ` = '$summa', `group` = '$this->groups' WHERE " . POLSOVATEL . ".`id` = " . $this->id);
        return true;
    }

    /**
     * Внесение записей в персональный счет
     */
    public function PersonalChet()
    {
        include CONECT;
        $personal_data = $this->Polsovatel();
        $new_sum = $personal_data['summ'] - $this->ConverterValut($this->valuta, $this->price, $personal_data['valuta']);
        $mysqli->query("UPDATE " . POLSOVATEL . " SET `summ` = '$new_sum' WHERE " . POLSOVATEL . ".`id` = " . $this->id);
        return true;
    }

    /**
     * Конвертер валют (вход, цена, выход)
     */
    public function ConverterValut($incoming_currency, $price, $outgoing_currency)
    {
        $new_cof_valuta = $this->ValutaCof();
        if ($incoming_currency == 'cor') {
            if ($outgoing_currency == 'cor') {
                $summaofsak = $price;
            } elseif ($outgoing_currency == 'грн') {
                $summaofsak = $price * $new_cof_valuta['grn'];
            } elseif ($outgoing_currency == 'руб') {
                $summaofsak = $price * $new_cof_valuta['rub'];
            } elseif ($outgoing_currency == 'eur') {
                $summaofsak = $price * $new_cof_valuta['eur'];
            }
        } elseif ($incoming_currency == 'грн') {
            if ($outgoing_currency == 'cor') {
                $summaofsak = $price / $new_cof_valuta['grn'];
            } elseif ($outgoing_currency == 'грн') {
                $summaofsak = $price;
            } elseif ($outgoing_currency == 'руб') {
                $summaofsak = $price * ($new_cof_valuta['rub'] / $new_cof_valuta['grn']);
            } elseif ($outgoing_currency == 'eur') {
                $summaofsak = $price / $new_cof_valuta['grn'] * $new_cof_valuta['eur'];
            }
        } elseif ($incoming_currency == 'руб') {
            if ($outgoing_currency == 'cor') {
                $summaofsak = $price / $new_cof_valuta['rub'];
            } elseif ($outgoing_currency == 'грн') {
                $summaofsak = $price * ($new_cof_valuta['grn'] / $new_cof_valuta['rub']);
            } elseif ($outgoing_currency == 'руб') {
                $summaofsak = $price;
            } elseif ($outgoing_currency == 'eur') {
                $summaofsak = $price / $new_cof_valuta['rub'] * $new_cof_valuta['eur'];
            }
        } elseif ($incoming_currency == 'eur') {
            if ($outgoing_currency == 'eur') {
                $summaofsak = $price;
            } elseif ($outgoing_currency == 'cor') {
                $summaofsak = $price / $new_cof_valuta['eur'];
            } elseif ($outgoing_currency == 'грн') {
                $summaofsak = $price / $new_cof_valuta['eur'] * $new_cof_valuta['grn'];
            } elseif ($outgoing_currency == 'руб') {
                $summaofsak = $price / $new_cof_valuta['eur'] * $new_cof_valuta['rub'];
            }
        }

        return round($summaofsak, 3);
    }

    /**
     * Вычисление коэфициента валюты коефициента валют
     */
    public function ValutaCof()
    {
        foreach ($this->Data(VALUTA) as $item) {
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

    /**
     * Обращение к базе данных
     */
    public function Data($db)
    {
        include 'component/conect.php';
        $result = mysqli_query($mysqli, "SELECT * FROM " . $db) or die("Ошибка " . mysqli_error($mysqli));
        while ($row = mysqli_fetch_array($result)) {
            $public[] = $row;
        }
        mysqli_free_result($result);
        return $public;
    }
}
