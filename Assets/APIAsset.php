<?php

namespace sazik\cart\Assets;

use Yii;

class APIAsset extends \yii\web\AssetBundle {

    public $sourcePath = '@sazik/cart/Assets/files';
    public $css = [
    ];
    public $js = [
        'API.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

    public function getFilePath($path) {
        return $this->baseUrl . $path;
    }

}
