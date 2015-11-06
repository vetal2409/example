<?php

use common\components\Migration;

class m151104_134524_event extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%event}}', [
            'id' => $this->primary(),
            'event_type_id' => $this->int(true),
            'confirm_by' => $this->integer(),

            'status' =>  $this->enum(['active','done']),
            'confirmation' =>  $this->tinyint(1),
            'json' =>  $this->text(),

            'created_at' => $this->int(),
            'created_by' => $this->int(),
            'updated_at' => $this->int(),
            'updated_by' => $this->int(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%event}}');
    }
}
