<?php

namespace sazik\cart;

use yii\base\BootstrapInterface;
use yii\base\Application;

class Bootstrap implements BootstrapInterface {

    public function bootstrap($app) {
        $app->on(Application::EVENT_BEFORE_REQUEST, function () {
            \Yii::$app->urlManager->addRules([
                [
                    'class' => 'yii\web\UrlRule',
                    'route' => 'cart/cart/request',
                    'pattern' => 'cart',
                ]
                    ], false);
        });
    }

}
