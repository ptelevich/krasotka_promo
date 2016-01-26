<?php

namespace app\widgets\googleMapMarker;

use app\widgets\googleMapMarker\assets\GoogleMapMarkerAsset;
use Yii;

class GoogleMapMarker extends \yii\widgets\InputWidget
{
    // Google maps browser key
    public $browserKey;

    public $latitude = 0;

    public $longitude = 0;

    public $hasCoordinates = false;

    public $zoom = 0;

    public $width = '100%';

    public $height = '300px';

    public $pattern = '(%latitude%,%longitude%)';

    public $mapType = 'roadmap';

    public $animateMarker = false;

    public $alignMapCenter = true;

    public $enableSearchBar = true;

    public $disableDepends = false;

    public $currentMarkerLabel = '';

    public $latitudeInputSelector = '';

    public $longitudeInputSelector = '';

    public function run()
    {

        Yii::setAlias('@googleMapMarker','@app/widgets/googleMapMarker/');

        // Asset bundle should be configured with the application key
        $this->configureAssetBundle();

        return $this->render(
            'mapMarkerView',
            [
                'id' => $this->getId(),
                'model' => $this->model,
                'attribute' => $this->attribute,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'hasCoordinates' => $this->hasCoordinates,
                'zoom' => $this->zoom,
                'width' => $this->width,
                'height' => $this->height,
                'pattern' => $this->pattern,
                'mapType' => $this->mapType,
                'animateMarker' => $this->animateMarker,
                'alignMapCenter' => $this->alignMapCenter,
                'enableSearchBar' => $this->enableSearchBar,
                'currentMarkerLabel' => $this->currentMarkerLabel,
                'latitudeInputSelector' => $this->latitudeInputSelector,
                'longitudeInputSelector' => $this->longitudeInputSelector,
            ]
        );
    }

    private function configureAssetBundle()
    {
        GoogleMapMarkerAsset::$key = $this->browserKey;
    }
}