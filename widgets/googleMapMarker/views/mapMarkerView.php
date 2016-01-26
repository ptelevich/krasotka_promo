<?php

use yii\helpers\Html;
use app\widgets\googleMapMarker\assets\GoogleMapMarkerAsset;

// Register asset bundle
GoogleMapMarkerAsset::register($this);

// [BEGIN] - Map input widget container
echo Html::beginTag(
    'div',
    [
        'class' => 'google-map-marker-input-widget',
        'style' => "width: $width; height: $height; display: inline-table;",
        'id' => $id,
        'data' =>
        [
            'latitude' => $latitude,
            'longitude' => $longitude,
            'has-coordinates' => $hasCoordinates,
            'zoom' => $zoom,
            'pattern' => $pattern,
            'map-type' => $mapType,
            'animate-marker' => $animateMarker,
            'align-map-center' => $alignMapCenter,
            'enable-search-bar' => $enableSearchBar,
            'current-marker-label' => $currentMarkerLabel,
            'latitude-input-selector' => $latitudeInputSelector,
            'longitude-input-selector' => $longitudeInputSelector,
        ],
    ]
);

    // The actual hidden input
    echo Html::hiddenInput(
        'coord_map',
        '',
        [
            'class' => 'google-map-marker-input-widget-input',
        ]
    );

    // Search bar input
    echo Html::input(
        'text',
        null,
        null,
        [
            'class' => 'google-map-marker-input-widget-search-bar',
        ]
    );

    // Map canvas
    echo Html::tag(
        'div',
        '',
        [
            'class' => 'google-map-marker-input-widget-canvas',
        ]
    );

// [END] - Map input widget container
echo Html::endTag('div');