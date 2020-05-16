<?php

if($_GET['reles']){
	EditColumTable($_GET);
}

$style_colum = StyleColum();
include'view/client_del.tpl';
