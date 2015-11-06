<?php

use common\components\Migration;

class m151103_113503_notification extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%notification}}', [
            'id' => $this->primary(),
            'role_id' => $this->int(true),
            'date' => $this->int(),
            'notification_type_id'  => $this->int(true),
            'event_id' => $this->int(true),
            'text' => $this->string(255),
            'url' => $this->string(255),
            'created_at' => $this->int(),
            'created_by' => $this->int(),
            'updated_at' => $this->int(),
            'updated_by' => $this->int(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%notification}}');
    }
}
