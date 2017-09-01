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

    public function recount($count) {
        $this->count = $count;
        return $this->save();
    }
    
    public static function primaryKey() {
        return ['cart_id', 'position'];
    }

}
