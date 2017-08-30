<?php

namespace sazik\cart\Models;

use Yii;

/**
 * @property integer $cart_id 
 * @property integer $position 
 * @property integer $count 
 */
class Position extends \yii\db\ActiveRecord {

    public static function tableName() {
        return "yii2_cart_positions";
    }

    public function rules() {
        return [
            [['cart_id', 'position', 'count'], 'required'],
            [['cart_id', 'position', 'count'], 'integer']
        ];
    }

    public function getCart() {
        return $this->hasOne(Cart::className(), ['id' => 'cart_id']);
    }

    public function onClose() {
        $module = \sazik\cart\Module::getInstance();
        $position_class = $module->position_class;
        if ($position_class instanceof \sazik\cart\IFaces\IPosition) {
            return $position_class::moveByID($this->position, $this->count);
        }
        return FALSE;
    }

    public function canClose() {
        $module = \sazik\cart\Module::getInstance();
        $position_class = $module->position_class;
        if ($position_class instanceof \sazik\cart\IFaces\IPosition) {
            return $position_class::CanMove($this->position, $this->count);
        }
        return FALSE;
    }

    public function unClose() {
        $module = \sazik\cart\Module::getInstance();
        $position_class = $module->position_class;
        if ($position_class instanceof \sazik\cart\IFaces\IPosition) {
            return $position_class::unmoveByID($this->position, $this->count);
        }
        return FALSE;
    }

    public function recount($count) {
        $this->count = $count;
        return $this->save();
    }

    public function delete() {
        if ($this->cart->closed == 1 && $this->unClose()) {
            return parent::delete();
        } else {
            return parent::delete();
        }

        return FALSE;
    }

}
