<?php

if ($_POST['autorisation']) {
	$dann = Autorisation($_POST);
}

include 'view/registration.tpl';
