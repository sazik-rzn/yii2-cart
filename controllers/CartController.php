<?php

namespace sazik\cart\controllers;

use Yii;

class CartController extends \yii\base\Controller {

    private $user = false;

    public function actionRequest() {
        $request = json_decode(\Yii::$app->request->post('json', '{}'), true);
        $response = [
            'void' => false,
            'user' => false,
            'params' => false,
            'result' => false,
            'warnings' => []
        ];
        if (empty($request)) {
            $response['warnings'][] = 'empty field "json" in post';
        } else {
            if (!isset($request['void'])) {
                $response['warnings'][] = 'void is required';
            } elseif (!method_exists($this, $request['void'])) {
                $response['warnings'][] = 'void is not declared';
                $response['void'] = $request['void'];
            } else {
                $response['void'] = $request['void'];
                if (!isset($request['user'])) {
                    $response['warnings'][] = 'user is required';
                } else {
                    $response['user'] = $request['user'];
                    $this->user = $request['user'];
                    if (!isset($request['params'])) {
                        $response['warnings'][] = 'params is required';
                    } elseif (!is_array($request['params'])) {
                        $response['warnings'][] = 'params is not array';
                        $response['params'] = $request['params'];
                    } else {
                        $response['params'] = $request['params'];
                        $response['result'] = $this->{$request['void']}($request['params']);
                    }
                }
            }
        }

        return json_encode($response);
    }

    private function getRendered($params = []){
        $result = [
            'warnings' => [],
            'result' => []
        ];
        if (isset($params['cart'])) {
            $cart = \sazik\cart\Models\Cart::find()->andWhere(['id' => $params['cart'], 'user' => $this->user])->one();
            if ($cart) {
                if(isset($params['positionClass'])){
                    
                }
                else{
                    $result['warnings'][] = 'param cart is not setted';
                }
                foreach ($cart->positions as $position) {
                    $result['result'][] = ['position' => $position->position, 'count' => $position->count];
                }
            } else {
                $result['warnings'][] = "cart with ID {$params['cart']} is not exists for user {$this->user}";
            }
        } else {
            $result['warnings'][] = 'param cart is not setted';
        }
        return $result;
    }
    
    private function getCart($params = []) {
        $result = [
            'warnings' => [],
            'result' => []
        ];
        if (isset($params['cart'])) {
            $cart = \sazik\cart\Models\Cart::find()->andWhere(['id' => $params['cart'], 'user' => $this->user])->one();
            if ($cart) {
                foreach ($cart->positions as $position) {
                    $result['result'][] = ['position' => $position->position, 'count' => $position->count];
                }
            } else {
                $result['warnings'][] = "cart with ID {$params['cart']} is not exists for user {$this->user}";
            }
        } else {
            $result['warnings'][] = 'param cart is not setted';
        }
        return $result;
    }

    private function recountPosition($params = []) {
        $result = [
            'warnings' => [],
            'result' => []
        ];
        if (isset($params['cart'])) {
            $cart = \sazik\cart\Models\Cart::find()->andWhere(['id' => $params['cart'], 'user' => $this->user])->one();
            if ($cart) {
                if (isset($params['position'])) {
                    if (isset($params['count'])) {
                        $result['result'][] = $cart->recountPosition($params['position'], $params['count']);
                    } else {
                        $result['warnings'][] = 'param count is not setted';
                    }
                } else {
                    $result['warnings'][] = 'param position is not setted';
                }
            } else {
                $result['warnings'][] = "cart with ID {$params['cart']} is not exists for user {$this->user}";
            }
        } else {
            $result['warnings'][] = 'param cart is not setted';
        }
        return $result;
    }

    private function removePosition($params = []) {
        $result = [
            'warnings' => [],
            'result' => []
        ];
        if (isset($params['cart'])) {
            $cart = \sazik\cart\Models\Cart::find()->andWhere(['id' => $params['cart'], 'user' => $this->user])->one();
            if ($cart) {
                if (isset($params['position'])) {
                    $result['result'][] = $cart->removePosition($params['position']);
                } else {
                    $result['warnings'][] = 'param position is not setted';
                }
            } else {
                $result['warnings'][] = "cart with ID {$params['cart']} is not exists for user {$this->user}";
            }
        } else {
            $result['warnings'][] = 'param cart is not setted';
        }
        return $result;
    }

    private function addPosition($params = []) {
        
    }

    private function delete($params = []) {
        $result = [
            'warnings' => [],
            'result' => []
        ];
        if (isset($params['cart'])) {
            $cart = \sazik\cart\Models\Cart::find()->andWhere(['id' => $params['cart'], 'user' => $this->user])->one();
            if ($cart) {
                $result['result'][] = $cart->delete();
            } else {
                $result['warnings'][] = "cart with ID {$params['cart']} is not exists for user {$this->user}";
            }
        } else {
            $result['warnings'][] = 'param cart is not setted';
        }
        return $result;
    }

}
