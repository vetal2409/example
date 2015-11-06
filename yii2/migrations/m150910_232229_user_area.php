<?php

use common\components\Migration;

class m150910_232229_user_area extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user_area}}', [
            'user_id' => $this->int(true),
            'area_id' => $this->int(true),
            'PRIMARY KEY (`user_id`, `area_id`)',
            'created_at' => $this->int(),
            'created_by' => $this->int(),
            'updated_at' => $this->int(),
            'updated_by' => $this->int(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%user_area}}');
    }
}
