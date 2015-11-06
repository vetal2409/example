<?php

use common\components\Migration;

class m151103_112302_notification_templates extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%notification_templates}}', [
            'id' => $this->primary(),
            'role_id' => $this->int(true) ,
            'notification_type_id' => $this->int(true) ,
            'UNIQUE (`role_id`, `notification_type_id`)',
            'type' => $this->string(45),
            'name' => $this->string(255),
            'title' =>  $this->enum(['email', 'notification', 'all','none']),
            'text' => $this->string(255),
            'created_at' => $this->int(),
            'created_by' => $this->int(),
            'updated_at' => $this->int(),
            'updated_by' => $this->int(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%notification_templates}}');
    }
}
