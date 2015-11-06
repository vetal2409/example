<?php

use common\components\Migration;

class m151103_103019_role extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%role}}', [
            'id' => $this->primary(),
            'username' => $this->string(45),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%user_skill}}');
    }
}
