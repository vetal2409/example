<?php

use common\components\Migration;

class m150910_223419_medical_answer extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%medical_answer}}', [
            'id' => $this->primary(),
            'contractor_id' => $this->int(true),
            'medical_question_id' => $this->int(true),
            'answer' =>  $this->tinyint(1),
            'answer_details' => $this->string(255),
            'created_at' => $this->int(),
            'created_by' => $this->int(),
            'updated_at' => $this->int(),
            'updated_by' => $this->int(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%medical_answer}}');
    }
}
