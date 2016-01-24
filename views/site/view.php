<!-- basic stylesheet -->
<link rel="stylesheet" href="http://dimsemenov.com/plugins/royal-slider/royalslider/royalslider.css">

<!-- skin stylesheet (change it if you use another) -->
<link rel="stylesheet" href="http://dimsemenov.com/plugins/royal-slider/royalslider/skins/default/rs-default.css?v=1.0.4">

<!-- Plugin requires jQuery 1.8+  -->
<!-- If you already have jQuery on your page, you shouldn't include it second time. -->
<script src='http://dimsemenov.com/plugins/royal-slider/royalslider/jquery-1.8.3.min.js'></script>

<!-- Main slider JS script file -->
<!-- Create it with slider online build tool for better performance. -->
<script src="http://dimsemenov.com/plugins/royal-slider/royalslider/jquery.royalslider.min.js?v=9.3.6"></script>

<style>
    .royalSlider {
        width: 100%;
        height: 600px;
    }
</style>

<a href="/">
    <img src="/img/back-arrow.png" title="Назад к альбому" width="20"/> Назад к альбомам
</a>

<div class="royalSlider rsDefault">
    <?php foreach ($photos as $photo): ?>
        <div>
            <img class="rsImg" src="/media/<?= $photo['album_id'] ?>/<?= $photo['photo_name'] ?>" />
            <p><?= $photo['text'] ?></p>
        </div>
    <?php endforeach; ?>
</div>

<script>
    jQuery(document).ready(function($) {
        $(".royalSlider").royalSlider({
            // general options go gere
            keyboardNavEnabled: true,
            visibleNearby: {
                enabled: true,
                centerArea: 0.3,
                center: true,
                breakpoint: 650,
                breakpointCenterArea: 0.64,
                navigateByCenterClick: true
            },
            //autoScaleSlider: true,
            controlNavigation: 'none',
            fullscreen: {
                // fullscreen options go gere
                enabled: true,
                nativeFS: false
            }
        });
    });
</script>