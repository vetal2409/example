<?php

use common\components\Migration;

class m150910_224348_contractor_holiday extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%contractor_holiday}}', [
            'id' => $this->primary(),
            'contractor_id' => $this->int(true),
            'begin' => $this->int(true),
            'end' => $this->int(true),
            'reason' =>  $this->string(255),
            'answer_details' => $this->string(255),
            'created_at' => $this->int(),
            'created_by' => $this->int(),
            'updated_at' => $this->int(),
            'updated_by' => $this->int(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%contractor_holiday}}');
    }
}
