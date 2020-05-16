<!DOCTYPE html>
<html lang="ru">

<head>
    <title>cardio</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Как распознать не видимые признаки болезни и предпринять меры направленные на сохранение здоровья Сайт ориентирован на всех желающих вести здоровый образ жизни">
    <meta name="keywords" content="ЭКГ, онлайн врач, консультация, профилактика заболевания, к врачу, диагностика">
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="stylesheet" id="google_fonts-css"
        href="//fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic" type="text/css" media="all">
    <link href="/cardio/css/style.css" rel="stylesheet">
    <link href="/cardio/css/style_mobile.css" rel="stylesheet">
    <script src="/cardio/js/function.js"></script>
    <script>
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE
            }, 'google_translate_element');
        }
    </script>
    <script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</head>

<body>
    <div class="hed_menu">
        <div class="content">
            <p class="scrin_block">
                <a class="a" href="http://iridoc.com/">
                    <span class="text_menu_ a">Язык сердца</span>
                    <span class="text_menu_2 a">Узнайте, что говорит сердце о вашем здоровье</span>
                </a>
            </p>
            <?php echo $ex; ?>
            <a href="http://iridoc.com/cardio/index.php">
                <span class="menu_reg">ГЛАВНАЯ</span>
            </a>
            <a href="index.php?name=cart">
                <span class="menu_reg">
                    <?php echo $coo.Cart('cart'); ?> КОРЗИНА</span>
            </a>
            <?php echo $cabinet; ?>
        </div>
    </div>
    <div class="logon">
        <a href="http://iridoc.com/cardio/index.php">
            <img src="images/iridoc.svg" alt="">
        </a>
        <div class="text_logo">
            <p class="tl_1">Новый подход к анализу электрокардиограммы</p>
            <p class="tl_1">и другой медикобиологической информации</p>
        </div>
    </div>
    <div class="content">
        <div id="google_translate_element"></div>