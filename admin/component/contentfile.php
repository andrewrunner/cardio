<?php
// Блк вывода на страницу

if ($block == 'home') {
    require_once('component/home.php');
} elseif ($block == 'client_del') {
    require_once('component/client_del.php');
} elseif ($block == 'recept') {
    require_once('component/recept.php');
} elseif ($block == 'clientlisting') {
    require_once('component/clientlisting.php');
} elseif ($block == 'clientlist') {
    require_once('component/clientlist.php');
} elseif ($block == 'product') {
    require_once('component/product.php');
} elseif ($block == 'edit_product') {
    require_once('component/edit_product.php');
} elseif ($block == 'polsovateli') {
    require_once('component/polsovateli.php');
} elseif ($block == 'partner') {
    require_once('component/partner.php');
} elseif ($block == 'edit_polsovateli') {
    require_once('component/edit_polsovateli.php');
} elseif ($block == 'edit_partner') {
    require_once('component/edit_partner.php');
} elseif ($block == 'obrabotka') {
    require_once('component/obrabotka.php');
} elseif ($block == 'valuta') {
    require_once('component/valuta.php');
} elseif ($block == 'logins') {
    require_once('component/login.php');
} elseif ($block == 'ao') {
    require_once('component/ao.php');
} elseif ($block == 'cart') {
    require_once('component/cart.php');
} elseif ($block == 'avtorisovanue') {
    require_once('component/avtorisovanue.php');
} elseif ($block == 'mails') {
    require_once('component/mails.php');
} else {
    require_once('component/home.php');
}
