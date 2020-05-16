<div class="sidebar_left">
    <?php if($superuser != true){ ?>
    <a class="menu_admin" href="index.php?name=home">
        <div class="block_menu">
            <div>
                <?php echo Home('ico'); ?>
            </div>
            <div class="menu">Главная</div>
        </div>
    </a>
    <?php }
if($superuser == true){ ?>
    <a class="menu_admin" href="index.php?name=recept">
        <div class="block_menu">
            <div>
                <?php echo Cark('ico'); ?>
            </div>
            <div class="menu">Рецепт</div>
        </div>
    </a>
    <a class="menu_admin" href="index.php?name=product">
        <div class="block_menu">
            <div>
                <?php echo Prod('ico'); ?>
            </div>
            <div class="menu">Товары</div>
        </div>
    </a>
    <a class="menu_admin" href="index.php?name=client_del">
        <div class="block_menu">
            <div>
                <?php echo ClientDel('ico'); ?>
            </div>
            <div class="menu">Клиенты</div>
        </div>
    </a>
    <a class="menu_admin" href="index.php?name=ao">
        <div class="block_menu">
            <div>
                <?php echo PDF('ico'); ?>
            </div>
            <div class="menu">Расчет АО</div>
        </div>
    </a>
    <a class="menu_admin" href="index.php?name=polsovateli">
        <div class="block_menu">
            <div>
                <?php echo Polsovateli('ico'); ?>
            </div>
            <div class="menu">Пользователи</div>
        </div>
    </a>
    <a class="menu_admin" href="index.php?name=partner">
        <div class="block_menu">
            <div>
                <?php echo Partneru('ico'); ?>
            </div>
            <div class="menu">Партнеры</div>
        </div>
    </a>
    <a class="menu_admin" href="index.php?name=obrabotka">
        <div class="block_menu">
            <div>
                <?php echo Vide('ico'); ?>
            </div>
            <div class="menu">Вид обработки</div>
        </div>
    </a>
    <a class="menu_admin" href="index.php?name=valuta">
        <div class="block_menu">
            <div>
                <?php echo Libr('ico'); ?>
            </div>
            <div class="menu">Валюта</div>
        </div>
    </a>
    <a class="menu_admin" href="index.php?name=logins">
        <div class="block_menu">
            <div>
                <?php echo Pass('ico'); ?>
            </div>
            <div class="menu">Ключи</div>
        </div>
    </a>
    <a class="menu_admin" href="index.php?name=cart">
        <div class="block_menu">
            <div>
                <?php echo Cart('ico'); ?>
            </div>
            <div class="menu">Корзина</div>
        </div>
    </a>
    <a class="menu_admin" href="index.php?name=avtorisovanue">
        <div class="block_menu">
            <div>
                <?php echo Polsovateli('ico'); ?>
            </div>
            <div class="menu">Кабинет</div>
        </div>
    </a>
    <a class="menu_admin" href="index.php?name=mails">
        <div class="block_menu">
            <div>
                <?php echo Email('ico'); ?>
            </div>
            <div class="menu">Письма</div>
        </div>
    </a>
    <?php } ?>
</div>