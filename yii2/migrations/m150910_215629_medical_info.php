<?php

use common\components\Migration;

class m150910_215629_medical_info extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%medical_info}}', [
            'id' => $this->primary(),
            'contractor_id' => $this->int(true),
            'height' => $this->double(),
            'weight' => $this->double(),
            'gp_name' => $this->string(45),
            'gp_phone' => $this->string(45),
            'gp_city' => $this->string(45),
            'gp_post_code' => $this->string(10),
            'created_at' => $this->int(),
            'created_by' => $this->int(),
            'updated_at' => $this->int(),
            'updated_by' => $this->int(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%medical_info}}');
    }
}
