<?php

/*
    Блок для выборочной загрузки страницы
*/

if ($kar == 'card' || $kar == 'card_fio') {
	require_once(CARDIO);
} elseif ($kar == 'crov') {
	require_once(CONTENT);
} elseif ($kar == 'cart') {
	require_once(CARTS);
} elseif ($kar == 'cartpersonal') {
	require_once(CARTPERS);
} elseif ($kar == 'diagnostic') {
	require_once(DIAGNIST);
} elseif ($kar == 'metodic') {
	require_once(METODIC);
} elseif ($kar == 'forma') {
	require_once(FORMA);
} elseif ($kar == 'basis') {
	require_once(GOOD);
} elseif ($kar == 'anketa') {
	require_once(ANCETA);
} elseif ($kar == 'registration') {
	require_once(REGISTR);
} elseif ($kar == 'entrance') {
	require_once(ENTRANC);
} elseif ($kar == 'personal_area') {
	require_once(PERSONAL);
} elseif ($kar == 'recomendacii') {
	require_once(RECOMENDACII);
} elseif ($kar == 'recept') {
	require_once(RECEPTS);
} elseif ($kar == 'diagrams') {
	require_once(DIAGRAMS);
} elseif ($kar == 'kalendar') {
	require_once(KALENDAR);
} elseif ($kar == 'personal') {
	require_once(PERSONALL);
} elseif ($kar == 'criatemail') {
	require_once(EMAILCREATE);
} elseif ($kar == 'chet') {
	require_once(CHET);
} else {
	require_once(HOME);
}