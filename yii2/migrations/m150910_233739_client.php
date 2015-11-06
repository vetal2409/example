<?php

use common\components\Migration;

class m150910_233739_client extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%client}}', [
            'id' => $this->primary(),
            'parent_id' => $this->int(),
            'organisation' => $this->string(60),
            'representative_name' => $this->string(60),
            'representative_email' => $this->string(60),
            'week_begin' => $this->enum(['sat', 'mon'], true),
            'created_at' => $this->int(),
            'created_by' => $this->int(),
            'updated_at' => $this->int(),
            'updated_by' => $this->int(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%client}}');
    }
}
