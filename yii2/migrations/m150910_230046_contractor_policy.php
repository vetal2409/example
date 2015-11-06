<?php

use common\components\Migration;

class m150910_230046_contractor_policy extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%contractor_policy}}', [
            'policy_id' => $this->int(true),
            'contractor_id' => $this->int(true),
            'PRIMARY KEY (`contractor_id`, `policy_id`)',
            'created_at' => $this->int(),
            'created_by' => $this->int(),
            'updated_at' => $this->int(),
            'updated_by' => $this->int(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%contractor_policy}}');
    }
}
