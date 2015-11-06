<?php

use common\components\Migration;

class m151103_114057_notification_user extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%notification_user}}', [

            'notification_id' => $this->int(true),
            'user_id' => $this->int(true),
            'status' =>  $this->enum(['active', 'read', 'archived']),
            'created_at' => $this->int(),
            'created_by' => $this->int(),
            'updated_at' => $this->int(),
            'updated_by' => $this->int()

        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%notification_user}}');
    }
}
