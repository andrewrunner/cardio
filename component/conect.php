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
define('REACTIVNOST', '`car_reactivnost`'); // ? удалино с работы
define('RECEPT', '`car_recept`');
define('RESULT_ANCET', '`car_resultat_anketu`');
define('VALUTA', '`car_valute`');
define('CHETDB', '`cart_chet`');
define('EMAILCATEGORI', 'car_mail_categories');
define('DATA_CATEGORI', 'car_dzcrov_categories');
define('HISTORI', 'car_delit_histori');
define('DIAGRAMMA', 'car_diagramma_resultat');
define('CORECTION', 'car_corect_sum');
define('DIAGRAM_CATEGORI', 'car_new_diagrams');

// PHP
define('CONECT', 'component/conect.php');
define('_FUNCTION_', 'component/function.php');
define('_ERRORS_', 'component/errors.php');
define('_HEADER_', 'component/header.php'); 
define('CARDIO', 'component/card.php');
define('CONTENT', 'component/content.php');
define('CONTENTS', 'component/blockcontent.php');
define('CARTS', 'component/cart.php');
define('CARTPERS', 'component/cartpersonal.php');
define('DIAGNIST', 'component/diagnostic.php');
define('METODIC', 'component/metodic.php');
define('FORMA', 'component/forma.php');
define('GOOD', 'component/good.php');
define('ANCETA', 'component/anketa.php');
define('REGISTR', 'component/registration.php');
define('ENTRANC', 'component/entrance.php');
define('PERSONAL', 'component/personal_area.php');
define('RECOMENDACII', 'component/recomendacii.php');
define('RECEPTS', 'component/recept.php');
define('DIAGRAMS', 'component/diagrams.php');
define('KALENDAR', 'component/kalendar.php');
define('PERSONALL', 'component/personal.php');
define('EMAILCREATE', 'component/criatemail.php');
define('HOME', 'component/home.php');
define('FOOTER', 'component/footer.php');
define('CHET', 'component/chet.php');
define('OBRANCET', 'component/obr_ancet.php');
define('_CONTROLER_', 'system/Controllers.php');
define('_CROV_', 'system/ControllerCrov.php');
define('_DOP_CATEGORI_', 'system/ControllerDopCategories.php');
define('MONTH', 'system/ControllerDiagramMonth.php');
define('YEAR', 'system/ControllerDiagramYear.php');
define('_LOG_', 'component/log.php');

// TPL
define('SABOLEVANIYA', 'view/sabolevaniya.tpl');
define('CROV', 'view/crov.tpl');
define('ECG', 'view/ecg.tpl');
define('MENU', 'view/menu_rastheta.tpl');
define('OPROSS', 'view/opros.tpl');
define('CALENDAROZ', 'view/calendar.tpl');
define('DIAGRAM', 'view/mount.tpl');

// DB
define('DB_HOST', '');
define('DB_USER', '');
define('DB_PASSWORD', '');
define('DB_NAME', '');

$mysqli = @new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$mysqli->set_charset('utf8');
if ($mysqli->connect_errno) exit('ќшибка соединени¤ с DB');
