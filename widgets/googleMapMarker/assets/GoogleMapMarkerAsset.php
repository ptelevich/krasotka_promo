<?php

namespace app\widgets\googleMapMarker\assets;

class GoogleMapMarkerAsset extends \yii\web\AssetBundle
{

    public static $key;

    public $sourcePath = '@googleMapMarker/web/';

    public $depends = [
        'yii\web\YiiAsset',
    ];

    public $jsOptions =
    [
        'position' => \yii\web\View::POS_END,
    ];

    public function __construct($config = [])
    {
        $this->js[] = $this->getGoogleMapScriptUrl();
        $this->js[] = 'js/google-map-marker.js';
        $this->css[] = 'css/google-map-marker.css';
        parent::__construct($config);
    }

    private function getGoogleMapScriptUrl()
    {
        $scriptUrl  =  "//maps.googleapis.com/maps/api/js?";
        $scriptUrl .= http_build_query([
            'key' => self::$key,
            'libraries' => 'places',
        ]);
        return $scriptUrl;
    }
}
