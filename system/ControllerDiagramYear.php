<?php
// Диаграмма за год

// получем с базы на год
${'masres' . $g_cat} = $d->DiagRes($g_cat);

$svg = '<div style="width: 100%; height: 500px; float: left;">
<div style="width: 30px; height: 500px; float: left; position: relative; top: 7px;">';

for ($as = 18; $as > 0; $as--) {
    $svg .= '<div style="width: 30px; height: 27px; font-size: 12px; text-align: center; border-top: 1px solid #999; float: left;">' . $as . '</div>';
}

// таблица
$svg .= '</div><svg style="overflow: inherit; width: 1160px; height: 500px; border-left: 1px solid #999; border-bottom: 1px solid #999;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.2" baseProfile="tiny" id="Слой_1" x="0px" y="0px" viewBox="130 -100 200 200" xml:space="preserve">';

$line = 0.07; // толщина линии
$x1 = -15.6; // шаг ячейки

// получаем количество дней и формируем решотку
for ($i = 0; $i < 12 + 1; $i++) { // линии вертикальные
    if ($i == 0) {
        $ri = -97;
        for ($nm = 19; $nm > 1; $nm--) { // линии горизонтальные
            $svg .= '<line fill="none" stroke="' . $color2 . '" stroke-width="' . $line . '" stroke-miterlimit="10" x1="-50" y1="' . $ri . '" x2="1000" y2="' . $ri . '"/>';
            $ri += 11.2;
        }
    }
    if ($i > 0) {
        $svg .= '<line fill="none" stroke="' . $color2 . '" stroke-width="' . $line . '" stroke-miterlimit="10" x1="' . $x1 . '" y1="-100" x2="' . $x1 . '" y2="100"/>';
    }
    $x1 += 38.4;
}

unset($x1);
$nul = 0;

// формируем кривую
$rows = count($mod);
for ($ty = 0; $ty < $rows; $ty++) { // запрос по каждому из методов в массиве
    $cx = 23; // отступ от края
    for ($i = 0; $i < count(${'masres' . $mod[$ty]}); $i++) {
        if (${'masres' . $mod[$ty]}) {

            for ($ren = 0; $ren < 18; $ren++) {
                if (${'masres' . $mod[$ty]}[$i]['categories'] == $_cat_[$ren]) {
                    $cy = $_number_[$ren];
                    break;
                } else {
                    $cy = '';
                }
            }

            $ci = ${'masres' . $mod[$ty]}[$i]['pocasatel'];

            // точка
            if ($cy != '') {
                if ($g_cat == 'kletochno_tkanevaya_intoksikaciya' || $g_cat == 'kishechnaya_intoksikaciya' || $g_cat == 'endorfinodificit') {
                    $color_n = $color_ty;
                    $color_str = ${'masres' . $mod[$ty]}[$i]['color'];
                } else {
                    $color_str = $color[$ty];
                    $color_n =  $color[$ty];
                }

                $cc = 105 - ($cy * 11.2); // ось вертикаль текст подставляем
                
                if ($g_cat == 'anketa' || $g_cat == 'crov' || $g_cat == 'ecg' || $g_cat == 'ad') {
                    $svg .= '<text class="text_svg" fill="#000" x="' . $cx . '" y="' . ($cc - 5) . '">' . ${'masres' . $mod[$ty]}[$i]['categories'] . '</text>';
                }
                
                if (${'masres' . $mod[$ty]}[$i]['pocasatel'] != '0') {
                    $svg .= '<text class="text_svg_p" fill="#000" x="' . ($cx + 5) . '" y="' . ($cc - 5) . '">' . ${'masres' . $mod[$ty]}[$i]['pocasatel'] . '</text>';
                }
                $svg .= '<circle fill="' . $color_str . '" cx="' . $cx . '" cy="' . $cc . '" r="3"><title>' . $ci . '</title></circle>';	
                
                if ($nul != 0) {
                    if ($i > 0) {
                        $svg .= '
                        <linearGradient id="SVGID_' . $i . '_" gradientUnits="userSpaceOnUse" x1="' . $x1 . '" y1="' . $y1 . '" x2="' . $cx . '" y2="' . $cc . '">
                            <stop  offset="0" style="stop-color:' . $color_n . '"/>
                            <stop  offset="1" style="stop-color:' . $color_str . '"/>
                        </linearGradient>

                        <line fill="none" stroke="url(#SVGID_' . $i . '_)" stroke-width="2" stroke-miterlimit="10" x1="' . $x1 . '" y1="' . $y1 . '" x2="' . $cx . '" y2="' . $cc . '"/>';
                    }
                }
                $color_ty = $color_str;
                $nul = 1;
                $y1 = $cc;
                $x1 = $cx;
            }
            $cx += 38.4; // отступ точки
            $etr = $x1;
        }
    }
    unset($y1, $x1, $cx, $cy);
}

$svg .= '</svg></div><div style="width: 100%; font-size: 12px; height: 20px; position: relative; float: left; left: -1px;">';

// формируем дату
for ($i = 0; $i < 12; $i++) {
    $svg .= '<div style="width: 95px; float: left; border-right: 1px solid #999; text-align: right;">' . ($i + 1) . '</div>';
}

$svg .= '</div>';
