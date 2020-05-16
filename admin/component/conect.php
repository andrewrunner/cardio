<?php
// DB Table
define('ADMIN', '`cardio_administrator`');
define('CLIENTU', '`cardio_clientu`');
define('CART', '`cardio_global_cadr`');
define('MESSENGER', '`cardio_messenger`');
define('POLSOVATEL', '`cardio_number`');
define('PARTNER', '`cardio_south`');
define('SYSTEMADMIN', '`cardio_system`');
define('OBRABOTKA', '`cardio_vid`');
define('CARTCLIENT', '`cart_client`');
define('CARTUSER', '`cart_user`');
define('TABLE_BS', '`car_18sostoyaniy`');
define('ZACLUCHENIE', '`car_algoritm_zaklutheniya`');
define('NAME_BS', '`car_biostemulyator`');
define('COMENTARI_BS', '`car_biostemulyator_comentari`');
define('DOSA', '`car_biostemulyator_dosa`');
define('CALENDAR', '`car_calendar`');
define('REGISTRATION_CLIENT', '`car_client`');
define('CLIENT_U', '`car_clientu_u`');
define('COLUM', '`car_colum`');
define('DIAGNISTIC', '`car_diagnostic`');
define('DIAGRAMA', '`car_diagram`');
define('AD', 'car_ad');
define('DS', '`car_ds`');
define('DZ', '`car_dz`');
define('DZ_CROV', '`car_dzcrov`');
define('DZ_SIGNAL', '`car_dzcrovsignal`');
define('DZ_SOSTOYANIE', '`car_dzsost`');
define('EMAIL_OPLATA', '`car_email_opl`');
define('FINOTCHET', '`car_finoth`');
define('CATEGORIS', '`car_group_product`');
define('OPROS_ANCETA', '`car_opr18sost`');
define('OPROS', '`car_opros`');
define('PREPARAT', '`car_preparate`');
define('PRODUCT', '`car_product`');
define('DATA_CATEGORI', 'car_dzcrov_categories');
define('HISTORI', 'car_delit_histori');
define('CORECT', 'car_corect_sum');
define('DIAGRAMMA', 'car_diagramma_resultat');
define('DIAGRAM_CATEGORI', 'car_new_diagrams');
define('RECEPT', '`car_recept`');
define('RESULT_ANCET', '`car_resultat_anketu`');
define('VALUTA', '`car_valute`');
define('CHETDB', '`cart_chet`');
define('EMAILCATEGORI', 'car_mail_categories');

// CONECT
define('CONECT', 'component/conect.php');

// PHP
define('DIAGRAMS', 'component/diagnostic.php');
define('_CONTROLER_', '../system/Controllers.php');
define('_CROV_', '../system/ControllerCrov.php');
define('_DOP_CATEGORI_', '../system/ControllerDopCategories.php');
define('_MONTH_', '../system/ControllerDiagramMonth.php');
define('_YEAR_', '../system/ControllerDiagramYear.php');

// tpl
define('MAILS', 'component/view/mails.tpl');
define('SABOLEVANIYA', 'component/view/sabolevaniya.tpl');
define('MONTH', 'component/view/month.tpl');

// DB
define('DB_HOST', 'cnmiriaj.beget.tech');
define('DB_USER', 'cnmiriaj_card');
define('DB_PASSWORD', 'card2000');
define('DB_NAME', 'cnmiriaj_card');

$mysqli = @new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$mysqli->set_charset('utf8');
if ($mysqli->connect_errno) exit('Ошибка соединения с DB');
