<style>
    ul.hr {
        margin: 4px; /* Значение полей */
        text-align: center;
    }
    ul.hr li {
        display: inline-block; /* Отображать как строчный элемент */
        margin-right: 5px; /* Отступ слева */
        margin: 3px; /* Поля вокруг текста */
    }
    ul.hr div.descriptionText {
        color: hotpink;
        font-size: 16px;
        padding: 10px;
        line-height: 25px;
    }
    ul.hr li {
        border: 5px floralwhite solid;
        border-radius: 20px;
        padding-bottom: 0px;
    }
    ul.hr a img {
    }
    ul.hr li a {
        text-decoration: none;
    }
    ul.hr li:hover {
        /*background-color: floralwhite;*/
        border: 5px hotpink dotted;
    }
</style>
<ul class="hr">
    <?php foreach ($albums as $album): ?>
        <li title="Открыть">
            <a href="<?= Yii::$app->urlManager->createUrl(['/site/view', 'id' => $album['album_id']]); ?>">
                <div class="descriptionText">
                    <?= $album['title'] ?><br/><?= $album['description'] ?>
                </div>
                <img src="<?= Yii::getAlias('@mediaDir') ?>/<?= $album['album_id'] ?>/<?= $album->photos[0]['photo_name'] ?>" height="350"/>
            </a>
        </li>
    <?php endforeach; ?>
</ul>