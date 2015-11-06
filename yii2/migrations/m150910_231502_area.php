<?php

use common\components\Migration;

class m150910_231502_area extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%area}}', [
            'id' => $this->primary(),
            'parent_id' => $this->int(),
            'name' => $this->string(60)->notNull(),
            'parent' => $this->enum([0, 1]),
            'created_at' => $this->int(),
            'created_by' => $this->int(),
            'updated_at' => $this->int(),
            'updated_by' => $this->int(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%area}}');
    }
}
