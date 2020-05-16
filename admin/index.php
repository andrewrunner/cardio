<?php
//admincardio systemcardioadmin
//iridocadmin L@V@Oz61
session_start();

// require_once('component/errors.php'); // Для определеня ошибки

if ($_GET['name'] == 'resset') {
	session_destroy();
	$viss = false;
	header('Location: http://iridoc.com/cardio/admin/index.php');
}
if ($_GET['newdel'] == 'del') {
	unset($_SESSION['dfh'], $_SESSION['dgr']);
}
$block = $_GET['name'];
$id = $_GET['id'];
// это для примера, значение не несет
require_once 'component/conect.php';
require_once 'component/function.php';
require_once _CONTROLER_;
require_once _CROV_;
require_once _DOP_CATEGORI_;

// Заносим в базу продажи
$fin = new OperationFinans;

if ($_GET['name'] == 'polsovatel_del') {
	PolsovatelDelit($id);
	$block = 'polsovateli';
}

if ($_GET['name'] == 'south_del') {
	PartnerDelit($id);
	$block = 'partner';
}

if ($_GET['name'] == 'c_del') {
	ClientDelitPDF($id);
	$block = 'client_del';
}

foreach (Data(ADMIN) as $item) {
	if ($_POST['login'] == $item['login'] && md5($_POST['pass']) == $item['password'] || $_SESSION['log'] == $item['login']) {
		session_start();
		if ($_SESSION['log'] == '') {
			$_SESSION['log'] = $_POST['login'];
		}
		$logus = $item['login'];
		$doppanel = false;
		$viss = true;
		$operator = true;
	}
}

foreach (Data(SYSTEMADMIN) as $item) {
	if ($_POST['login'] == $item['login'] && md5($_POST['pass']) == $item['pass'] || $_SESSION['log'] == $item['login']) {
		session_start();
		if ($_SESSION['log'] == '') {
			$_SESSION['log'] = $_POST['login'];
		}
		$logus = $item['login'];
		$doppanel = true;
		$viss = true;
		$superuser = true;
	}
}

require_once 'component/header.php';

if ($operator == true || $superuser == true) {
	require_once('component/sidebar_left.php');
	if ($block == 'delite') {
		foreach (Data(PRODUCT) as $item) {
			if ($item['id'] == $id) {
				unlink('images/' . $item['foto']);
			}
		}
		$result = mysqli_query($mysqli, "DELETE FROM " . PRODUCT . " WHERE  id = $id") or die("Ошибка " . mysqli_error($mysqli));
		$block = 'product';
	}

	if ($_POST['dob']) {
		$name = $_POST['name'];
		$comentari = $_POST['comentari'];
		$price = $_POST['price'];
		$product_group = $_POST['product_group'];
		$filename = $_FILES['filename']['name'];
		$tmp = $_FILES['filename']['tmp_name'];
		$file_date = date('YmdHis');
		$md = md5($filename) . '-' . $file_date . '.' . pathinfo($filename, PATHINFO_EXTENSION);
		if (is_uploaded_file($tmp)) {
			move_uploaded_file($tmp, 'images/' . $md);
			$file_set = $md;
		} else {
			$file_set = '<span style="color: red;">Файл не загружен</span>';
		}
		$result = $mysqli->query("INSERT INTO " . PRODUCT . " (`name`, `foto`, `comentari`, `price`, `product_group`) VALUES ('$name', '$file_set', '$comentari', '$price', '$product_group')");
		$block = 'product';
	}

	if ($_POST['prodd']) $block = 'edit_product';
	if ($_POST['back']) $block = 'partner';
	if ($_GET['name'] == 'email_partner') {
		foreach (Data(PARTNER) as $item) {
			if ($item['id'] == $id) {
				$lastname = 	$item['lastname'];
				$firstname = 	$item['firstname'];
				$middlename = 	$item['middlename'];
				$email = 		$item['email'];
				$limite = 		$item['limite'];
				$group = 		$item['group'];
				$summa = 		$item['summ'];
				$valuta =		$item['valuta'];
				if ($item['telefon']) {
					$mes = $item['messenger'] . ': ' . $item['telefon'];
				}
			}
		}
		$block = EmailPartneruDublicat($lastname, $firstname, $middlename, $email, $limite, $group, $summa, $mes, $valuta, SystemAdminEmail());
	}

	if ($_GET['name'] == 'email_polsovateli') {
		foreach (Data(POLSOVATEL) as $item) {
			if ($item['id'] == $id) {
				$grup = $item['group'];
				$personall = $item['number'];
				$lastname = $item['lastname'];
				$firstname = $item['firstname'];
				$middlename = $item['middlename'];
				$email = $item['email'];
				$limite = $item['limite'];
				$summa = $item['summ'];
				$valuta = $item['valuta'];
			}
		}
		$block = EmailPolsovatelDublicat($lastname, $firstname, $middlename, $email, $limite, $summa, SystemAdminEmail(), $grup, $personall, $valuta);
	}

	if ($_GET['name'] == 'vide') {
		$result = mysqli_query($mysqli, "DELETE FROM " . OBRABOTKA . " WHERE  " . OBRABOTKA . ".`id` =" . $id) or die("Ошибка " . mysqli_error($mysqli));
		$block = 'obrabotka';
	}

	if ($_POST['vall']) {
		$block = 'valuta';
    }
    
	if ($_GET['name'] == 'avtorisovanue') {
		$block = 'avtorisovanue';
    }
    
	if ($_GET['name'] == 'recept') {
		$block = 'recept';
    }
    
	if ($_GET['cart'] == 'cart') {
		$block = 'cart';
    }
    
	if ($_GET['name'] == 'valuta') {
		$block = 'valuta';
    }
    
	if ($_GET['name'] == 'edit_polsovateli') {
		$block = 'edit_polsovateli';
    }
    
	if ($_GET['name'] == 'polsovateli') {
		unset($_SESSION['dfh'], $_SESSION['dgr']);
    }
    
	if ($_GET['name'] == 'group_pro') {
		$block = 'product';
    }
    
	if ($_GET['name'] == 'mails') {
		$block = 'mails';
    }
    
	if ($_GET['name'] == 'product') {
		$block = 'product';
    }
    
	if ($_POST['ngpa']) {
		$block = 'product';
    }
    
	if ($_POST['sort_group']) {
		$block = 'product';
    }

    if ($_GET['name'] == 'ao') {
		$block = 'ao';
    }
    
	if ($doppanel == true && $_GET['name'] == '') {
		$block = 'client_del';
	}

	if ($_GET['name'] == 'upblock') {
		$id2 = $id;
		$result = mysqli_query($mysqli, "UPDATE " . PRODUCT . " SET `id` = '0' WHERE " . PRODUCT . ".`id` = $id;") or die("Ошибка " . mysqli_error($mysqli));
		$id -= 1;
		$result = mysqli_query($mysqli, "UPDATE " . PRODUCT . " SET `id` = '$id2' WHERE " . PRODUCT . ".`id` = $id;") or die("Ошибка " . mysqli_error($mysqli));
		$result = mysqli_query($mysqli, "UPDATE " . PRODUCT . " SET `id` = '$id' WHERE " . PRODUCT . ".`id` = 0;") or die("Ошибка " . mysqli_error($mysqli));
		$block = 'product';
	}
	if ($_GET['name'] == 'downblock') {
		$id2 = $id;
		$result = mysqli_query($mysqli, "UPDATE " . PRODUCT . " SET `id` = '0' WHERE " . PRODUCT . ".`id` = $id;") or die("Ошибка " . mysqli_error($mysqli));
		$id += 1;
		$result = mysqli_query($mysqli, "UPDATE " . PRODUCT . " SET `id` = '$id2' WHERE " . PRODUCT . ".`id` = $id;") or die("Ошибка " . mysqli_error($mysqli));
		$result = mysqli_query($mysqli, "UPDATE " . PRODUCT . " SET `id` = '$id' WHERE " . PRODUCT . ".`id` = 0;") or die("Ошибка " . mysqli_error($mysqli));
		$block = 'product';
	}

	require_once('component/contentfile.php');
	require_once('component/footer.php');
} else {
	echo '</div><div class="login">	
		<form name="passw" id="passw" action="" method="post" enctype="multipart/form-data">
			<div class="hed_log">Введите логин и пароль</div>
			<label class="logins">Логин</label>
			<input name="login" type="text" class="passwords">
			<label class="logons">Пароль</label>
			<input name="pass" type="password" class="passwords">
			<input name="open" class="but_login" type="submit" value="Войти">
		</form>
	</div>';
}
