<?php

use common\components\Migration;

class m150910_140816_profile_change extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%profile_change}}', [
            'id' => $this->primary(),
            'contractor_id' => $this->int(true),
            'payment_methods_id' => $this->int(true),
            'postcode_id' => $this->int(true),
            'image_id' => $this->int(true),
            'username' => $this->string(32)->notNull(),
            'forename' => $this->string(32)->notNull(),
            'surname' => $this->string(32)->notNull(),
            'title' => $this->enum(['Mr.', 'Mrs.', 'Miss']),
            'birthday' => $this->integer(),
            'password_hash' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'mobile' => $this->string(32),
            'phone' => $this->string(32),
            'organisation' => $this->string(64),
            'address' => $this->string(),
            'notes' => $this->string(),
            'light_status' => $this->enum([1, 2, 3]),
            'national_insurance' => $this->string(32),
            'kin_name' => $this->string(32),
            'kin_number' => $this->string(32),
            'kin_relationship' => $this->string(32),
            'bank_name' => $this->string(32),
            'acc_number' => $this->string(32),
            'sort_code' => $this->string(32),
            'payment_method' => $this->string(32),
            'created_at' => $this->int(),
            'created_by' => $this->int(),
            'updated_at' => $this->int(),
            'updated_by' => $this->int(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%profile_change}}');
    }
}
