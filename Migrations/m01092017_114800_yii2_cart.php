<?php

use yii\db\Migration;

class m01092017_114800_yii2_cart extends Migration {

    public function up() {
        $options = 'ENGINE=InnoDB CHARSET=utf8';
        $tables = [
            'yii2_cart_cart' => [
                'id' => $this->primaryKey(),
                'user' => $this->integer()->notNull()
            ],
            'yii2_cart_positions'=>[
                'cart_id'=>  $this->integer()->notNull(),
                'position' => $this->integer()->notNull(),
                'count'=>  $this->integer()->notNull(),
            ],            
        ];
        foreach ($tables as $table => $columns) {
            $this->createTable($table, $columns, $options);
        }
    }

    public function down() {
        echo "m01092017_114800_yii2_cart cannot be reverted.\n";

        return false;
    }

}
