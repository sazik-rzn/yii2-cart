<?php

namespace sazik\cart\Models;

use Yii;

/**
 * @property integer $id 
 * @property integer $user 
 * @property integer $closed 
 */
class Cart extends \yii\db\ActiveRecord {

    public static function tableName() {
        return "yii2_cart_cart";
    }

    public function rules() {
        return [
            [['user'], 'required'],
            [['user', 'closed'], 'integer'],
            ['closed', 'default', 'value' => 0],
        ];
    }

    public function getPositions() {
        return $this->hasMany(Position::className(), ['cart_id' => 'id']);
    }

    public function addPosition($position, $count) {
        $positionModel = new Position;
        $positionModel->cart_id = $this->id;
        $positionModel->position = $position;
        $positionModel->count = $count;
        return $positionModel->save();
    }

    public function removePosition($position) {
        foreach ($this->positions as $_position) {
            if ($position == $_position->position) {
                return $_position->delete();
            }
        }
        return false;
    }

    public function recountPosition($position, $count) {
        foreach ($this->positions as $_position) {
            if ($position == $_position->position) {
                return $_position->recount($count);
            }
        }
        return false;
    }

    public function close() {
        $enable = true;
        $closed = [];
        foreach ($this->positions as $position) {
            if (!$position->canClose()) {
                $enable = false;
                break;
            }
        }
        if ($enable) {
            foreach ($this->positions as $position) {
                if ($position->onClose()) {
                    $closed[] = $position;
                } else {
                    $enable = false;
                    break;
                }
            }
        }
        if ($enable) {
            $this->closed = 1;
        }
        if (!$enable || !$this->save()) {
            $enable = false;
            foreach ($closed as $position) {
                $position->unClose();
            }
        }
        return $enable;
    }

    public static function getCartByUser($user, $createIfNotExists = false) {
        $cart = self::find()->andWhere(['user' => $user, 'closed' => 0])->one();
        if (!$cart && $createIfNotExists) {
            $cart = new Cart;
            $cart->user = $user;
        }
        return $cart;
    }

    public function delete() {
        $enable = true;
        foreach ($this->positions as $position) {
            if (!$position->delete()) {
                $enable = false;
                break;
            }
        }
        if ($enable) {
            return parent::delete();
        }
        return false;
    }

}
