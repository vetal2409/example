<?php

use common\components\Migration;

class m150910_173532_contractor_address extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%contractor_address}}', [
            'id' => $this->primary(),
            'contractor_id' => $this->int(true),
            'name' => $this->string(255)->notNull(),
            'created_at' => $this->int(),
            'created_by' => $this->int(),
            'updated_at' => $this->int(),
            'updated_by' => $this->int(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%contractor_address}}');
    }
}
