<?php
$id = $_GET['id'];
RegistriDataPolsovatel($_POST, $_GET, $id);
$ress = EditPartneurs($id);
include'view/edit_partner.tpl';
// Не работает добавление в партнеры