<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use app\widgets\googleMapMarker\GoogleMapMarker;

?>
<div class="site-contact">
    <div style="font-size: 18px; margin-bottom: 20px;">
        Наша страничка <?= Html::a(Html::img('/img/vkontakte.png', ['width' => '150px']), '//vk.com/krasotkame', ['target' => '_blank']) ?>
    </div>
    <div style="display: inline-block;">
        <img src="/img/contacts.jpg" style="vertical-align: top;"/>
        <?= GoogleMapMarker::widget([
        'name' => 'mapMarker',
        // Initial map center latitude. Used only when the input has no value.
        // Otherwise the input value latitude will be used as map center.
        // Defaults to 0.
        'latitude' => '54.2197328690558',
        // Initial map center longitude. Used only when the input has no value.
        // Otherwise the input value longitude will be used as map center.
        // Defaults to 0.
        'longitude' => '28.50788114592433',

        'hasCoordinates' => true,

        // Initial map zoom.
        // Defaults to 0.
        'zoom' => 17,
        // Map container width.
        // Defaults to '100%'.
        'width' => '500px',
        // Map container height.
        // Defaults to '300px'.
        'height' => '350px',
        // Coordinates representation pattern. Will be use to construct a value of an actual input.
        // Will also be used to parse an input value to show the initial input value on the map.
        // You can use two macro-variables: '%latitude%' and '%longitude%'.
        // Defaults to '(%latitude%,%longitude%)'.
        'pattern' => '[%latitude%:%longitude%]',
        // Google map type. See official Google maps reference for details.
        // Defaults to 'roadmap'
        //'mapType' => 'satellite',
        'mapType' => 'roadmap',
        // Marker animation behavior defines if a marker should be animated on position change.
        // Defaults to false.
        'animateMarker' => true,
        // Map alignment behavior defines if a map should be centered when a marker is repositioned.
        // Defaults to true.
        'alignMapCenter' => true,
        // A flag which defines if a search bar should be rendered over the map.
        'enableSearchBar' => true,
        // label for marker that currently set
        'currentMarkerLabel' => 'Свадебный салон "Красотка", Борисов, ул.Чапаева 32',
        'latitudeInputSelector' => 'input[name*="[coordinates][lat]"]',
        'longitudeInputSelector' => 'input[name*="[coordinates][lng]"]',
        ]);
        ?>
    </div>
</div>
