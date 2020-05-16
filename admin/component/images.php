<?php
// обработка картинок
class Images
{
    public function DirImages()
    {
        $direct = scandir('images', 3);
        return $direct;
    }

    public function Del($file)
    {
        unlink($file);
        return true;
    }
}

$direct_images = new Images;

if ($_GET['del']) {
    $direct_images->Del($_GET['del']);
}

echo '<div class="content">
    <h2>Удаление фото товаров</h2>
</div>
<div class="content skroll">';

foreach ($direct_images->DirImages() as $item) {
    $svg = explode('.', $item)[1];
    if ($svg != 'svg' && $item != '..' && $item != '.') {
        echo '<div class="images_block">
            <img class="img_del" src="images/' . $item . '">
            <div class="ima_del">
                <a href="index.php?name=mails&del=images/' . $item . '">' . Del('icon3red') . '</a>
            </div>
        </div>';
    }
}

echo '</div>';