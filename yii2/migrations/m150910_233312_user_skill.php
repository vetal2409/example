<?php

use common\components\Migration;

class m150910_233312_user_skill extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user_skill}}', [
            'user_id' => $this->int(true),
            'skill_id' => $this->int(true),
            'PRIMARY KEY (`user_id`, `skill_id`)',
            'image_id' => $this->int(true),
            'expiry_date' => $this->integer()->notNull(),
            'title' =>  $this->enum([0, 1], true),
            'created_at' => $this->integer(10) . ' UNSIGNED',
            'created_by' => $this->integer(10) . ' UNSIGNED',
            'updated_at' => $this->integer(10) . ' UNSIGNED',
            'updated_by' => $this->integer(10) . ' UNSIGNED',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%user_skill}}');
    }
}
