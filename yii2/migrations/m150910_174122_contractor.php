<?php

use common\components\Migration;

class m150910_174122_contractor extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%contractor}}', [
            'id' => $this->primary(),
            'payment_method_id' => $this->int(),
            'postcode_id' => $this->int(),
            'organisation' => $this->string(64),
            'notes' =>  $this->string(),
            'light_status' =>  $this->enum([1, 2, 3]),
            'national_insurance' =>  $this->string(32)->unique(),
            'kin_name' =>  $this->string(32)->notNull(),
            'kin_number' =>  $this->string(32)->notNull(),
            'kin_relationship' =>  $this->string(32)->notNull(),
            'bank_name' =>  $this->string(32),
            'acc_number' =>  $this->string(32),
            'sort_code' =>  $this->string(32),
            'city' => $this->string(45),
            'country' => $this->string(45),
            'created_at' => $this->int(),
            'created_by' => $this->int(),
            'updated_at' => $this->int(),
            'updated_by' => $this->int(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%contractor}}');
    }
}
