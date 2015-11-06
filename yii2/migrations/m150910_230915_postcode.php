<?php

use common\components\Migration;

class m150910_230915_postcode extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%postcode}}', [
            'id' => $this->primary(),
            'area_id' => $this->int(true),
            'name' => $this->string(45)->notNull(),
            'code' => $this->string(10),
            'code_search' => $this->string(10),
            'county' => $this->string(60),
            'latitude' => $this->double(),
            'longitude' => $this->double(),
            'created_at' => $this->int(),
            'created_by' => $this->int(),
            'updated_at' => $this->int(),
            'updated_by' => $this->int(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%postcode}}');
    }
}
