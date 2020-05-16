<div class="south">
    <?php echo Email('icon4'); ?>
</div>
<h1>ПИСЬМА</h1>
<h2>Управление темами письма</h2>
<p class="db">Таблица DB: car_mail_categories</p>
<div class="mail_block">
    <?php echo EditMail(); ?>
    <div>
        <form name="vd" action="index.php?name=mails" method="post" enctype="multipart/form-data">
            <input class="pole_vvoda" name="new_mail_cat" type="text">
            <input class="wf_blanck2 jk" name="mail_cat" type="submit" value="Создать новую категорию">
        </form>
    </div>
</div>