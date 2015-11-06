<?php

use common\components\Migration;

class m150910_141440_skill extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
//$this->addForeignKey()
        $this->createTable('{{%skill}}', [
            'id' => $this->primary(),
            'name' => $this->string(60)->notNull()->unique(),
            'begin' => $this->int(true),
            'end' => $this->int(true),
            'pay_rate' => $this->decimal(10, 2) . ' unsigned NOT NULL',
            'hidden' => $this->enum([0, 1], true),
            'created_at' => $this->int(),
            'created_by' => $this->int(),
            'updated_at' => $this->int(),
            'updated_by' => $this->int(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%skill}}');
    }
}
