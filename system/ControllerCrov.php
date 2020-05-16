<?php
// Расчет по крови
class Crov
{
    public $post;

    function PrcentOtcloneniya()
    {
        $monocitu = $this->post['monocitu']; // не сигнальный
        $eosinofilu = $this->post['eosinofilu']; // не сигнальный
        $basofilu = $this->post['basofilu']; // не сигнальный
        $neytrofilu = $this->post['paloch_neytrofilu']; // не сигнальный
        $limfocitu = $this->post['limficitu']; // сигнальные показатели
        $obthee_chislo_leycocitov = $this->post['obthee_chislo_leycocitov']; // не сигнальный
        $sernistost = $this->post['sernistost']; // не сигнальный
        $cletka = $this->post['cletka']; // не сигнальный
        $tera = '';

        if ($sernistost == 'on') {
            $tera += 1;
        }

        if ($cletka == 'on') {
            $tera += 1;
        }

        // Опредиление сигнальных и не сигнальных показателей
        foreach (Data(DZ_SIGNAL) as $item) {
            $op = explode('-', $item['vosrast']);
            $hd = ($op[1] == '>') ? ($op[0] >= $_SESSION['polnuh_let']) : (($op[0] >= $_SESSION['polnuh_let']) && ($op[1] <= $_SESSION['polnuh_let']));
            if ($hd) {
                if ($item['name'] == 'Палочкояд. нейтроф') {
                    $elo = explode('-', $item['norma']);
                    $dif = ($elo[0] <= $neytrofilu && $elo[1] >= $neytrofilu) ? 0 : 1;
                }

                if ($item['name'] == 'Базофилы') {
                    $ela = explode('-', $item['norma']);
                    $dif = ($ela[0] <= $basofilu && $ela[1] >= $basofilu) ? 0 : 1;
                }

                if ($item['name'] == 'Эозинофилы') {
                    $elu = explode('-', $item['norma']);
                    $dif = ($elu[0] <= $eosinofilu && $elu[1] >= $eosinofilu) ? 0 : 1;
                }

                if ($item['name'] == 'Моноциты') {
                    $elk = explode('-', $item['norma']);
                    $dif = ($elk[0] <= $monocitu && $elk[1] >= $monocitu) ? 0 : 1;
                }

                if ($item['name'] == 'Лейкоцитов') {
                    $ell = explode('-', $item['norma']);
                    $dif = ($ell[0] <= $obthee_chislo_leycocitov && $ell[1] >= $obthee_chislo_leycocitov) ? 0 : 1;
                }

                $tera += $dif; // не сигнальные показатели пользователя
            }
            unset($hd);
        }
        
        if ($tera == NULL) $tera = 0;

        // опредиляем категорию по возрасту
        foreach(Data(DATA_CATEGORI) as $item) {
            $data_cat = explode('-', $item['data']);
            $p_l = $_SESSION['data_personal']['polnuh_let'];

            if (count($data_cat) == 2) {
                if ($p_l >= $data_cat[0] && $p_l <= $data_cat[1]) {
                    $cat_vub = $item['name'];
                    ${$item['name']} = explode('-', $item['data']); // опредиление возраста
                }
            } elseif (count($data_cat) == 1) {
                if ($p_l >= $data_cat[0]) {
                    $cat_vub = $item['name'];
                    ${$item['name']} = explode('-', $item['data']); // опредиление возраста
                }
            }
        }
         
        // массив отклонений
        if ($tera > 4) {
           $tera = 4;
        }
    
        foreach (Data(DZ_CROV) as $item) {
        
            //  не сигнальные показатели
            $koreckt = explode('-', $item['no_signal']); // не сигнальные
            $diapason = explode('-', $item[$cat_vub]); // опредиляем диапазон Li %
            $diapason[1] = round($diapason[1]);
            $limfocitu = round($limfocitu);
            
            // Опредиление метода проверки
            if ( ($tera == NULL || $tera == '' || $tera == '0') && ($koreckt[0] == NULL || $koreckt[0] == '') ) {
                if ($diapason[0] == '>') {
                    
                    $rm = $limfocitu > $diapason[1];
                    
                } elseif ($diapason[0] == '<') {
                    
                    $rm = $limfocitu < $diapason[1];

                } elseif ($diapason[0] != '<' && $diapason[0] != '>') {
                    
                    $rm = ($limfocitu >= $diapason[0] && $limfocitu <= $diapason[1]);
                    
                }
            } else {
                if ($diapason[0] == '>' && count($koreckt) == 1) {
                    
                    $rm = $limfocitu > $diapason[1] && $koreckt[0] == $tera;
                    
                } elseif ($diapason[0] == '>' && count($koreckt) == 2) {
                    
                    $rm = $limfocitu > $diapason[1] && $tera >= $koreckt[0] && $koreckt[1] <= $tera;
                    
                } elseif ($diapason[0] == '<' && count($koreckt) == 1) {
                    
                    $rm = $limfocitu < $diapason[1] && $koreckt[0] == $tera;
                    
                } elseif ($diapason[0] == '<' && count($koreckt) == 2) {
                    
                    $rm = $limfocitu < $diapason[1] && $tera >= $koreckt[0] && $tera <= $koreckt[1];
                    
                } elseif ($diapason[0] != '<' && $diapason[0] != '>' && count($koreckt) == 1) {
                    
                    $rm = ($limfocitu >= $diapason[0] && $limfocitu <= $diapason[1] && $tera == $koreckt[0]);
                    
                } elseif ($diapason[0] != '<' && $diapason[0] != '>' && count($koreckt) == 2) {
                    
                    $rm = ($limfocitu >= $diapason[0] && $limfocitu <= $diapason[1] && $tera >= $koreckt[0] && $tera <= $koreckt[1]);
                    
                }
            }
            
            // Приверка по определенному методу, выбор 1А и тд..
            if ($rm) {
                $colors = $item['color'];
                $categories = $item['cat'];
                $opisanie = $item['text'];
                $reakciya_aktivacii = $item['name'];
                $sostoyanie = explode(',', $item['sostoyanie']);
                $yuu = '<div class="block_string" style="background: ' . $colors . '; color: #fff;"><b>' . $item['id'] . '</b> ' . $reakciya_aktivacii . '<br><b>' . $categories . '</b> ' . $opisanie . ' (' . $koreckt[0] . '-' . $koreckt[1] . ')</div>';
                $i = $rows;
                break;
            }
        }
        
        unset($rm);
        
        // Опредиление заключения
        foreach (Data(ZACLUCHENIE) as $item) {
            for ($luo = 1; $luo < 11; $luo++) {
                if ($item['categori'] == $categories) {
                    $opisanie_urovnya_zdorovia = $item['status'];
                    $reakciya_aktivacii = $item['uroven_riakciy'];
                    $opisanie_primenenie = $item['comentari'];
                }
            }
        }
        
        //unset($tera);
        return [$procenttext, $yuu, $colors, $categories, $opisanie, $opisanie_urovnya_zdorovia, $reakciya_aktivacii, $opisanie_primenenie, $sostoyanie];
    }
}