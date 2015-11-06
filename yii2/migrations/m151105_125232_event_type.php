<?php

use common\components\Migration;

class m151105_125232_event_type extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%event_type}}', [
            'id' => $this->primary(),
            'type' => $this->string(255),
            'created_at' => $this->int(),
            'created_by' => $this->int(),
            'updated_at' => $this->int(),
            'updated_by' => $this->int(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%event_type}}');
    }
}
