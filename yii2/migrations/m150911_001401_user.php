<?php

use common\components\Migration;

class m150911_001401_user extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primary(),
            'image_id' => $this->int(),
            'username' => $this->string(32)->unique(),
            'forename' => $this->string(32)->notNull(),
            'surname' => $this->string(32)->notNull(),
            'title' =>  $this->enum(['Mr.', 'Mrs.', 'Miss']),
            'birthday' => $this->integer() ,
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'mobile' => $this->string(32),
            'phone' => $this->string(32),
            'status' => $this->tinyint(2, true),
            'role' => $this->tinyint(2, true),
            'last_activity_at' => $this->int(),
            'created_at' => $this->int(),
            'created_by' => $this->int(),
            'updated_at' => $this->int(),
            'updated_by' => $this->int(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
