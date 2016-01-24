<style>
    ul.hr {
        margin: 0; /* Обнуляем значение отступов */
        padding: 4px; /* Значение полей */
    }
    ul.hr li {
        display: inline-block; /* Отображать как строчный элемент */
        margin-right: 5px; /* Отступ слева */
        padding: 3px; /* Поля вокруг текста */
    }
</style>
<ul class="hr">
    <?php foreach ($albums as $album): ?>
        <li style="padding-bottom: 30px;">
            <a href="<?= Yii::$app->urlManager->createUrl(['/site/view', 'id' => $album['album_id']]); ?>">
                <div align="center" style="font-size: 16px;"><?= $album['title'] ?><br/><?= $album['description'] ?></div>
                <img src="/media/<?= $album['album_id'] ?>/<?= $album->photos[0]['photo_name'] ?>" height="350"/>
            </a>
        </li>
    <?php endforeach; ?>
</ul>