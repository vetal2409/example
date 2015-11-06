<?php

use yii\db\Schema;
use yii\db\Migration;

class m151029_163226_contractor_client_foreign_keys extends Migration
{
    public function up()
    {
        //contractor_client
        $this->createIndex('fk_contractor_client_idx', '{{%contractor_client}}', 'contractor_id');

        $this->addForeignKey('fk_user_area_client', '{{%contractor_client}}', 'client_id', '{{%client}}', 'id');
        $this->addForeignKey('fk_user_area_contractor', '{{%contractor_client}}', 'contractor_id', '{{%contractor}}', 'id');

    }

    public function down()
    {
        //contractor_client
        $this->dropForeignKey('fk_user_area_client', '{{%contractor_client}}');
        $this->dropForeignKey('fk_user_area_contractor', '{{%contractor_client}}');

        $this->dropIndex('fk_contractor_client_idx', '{{%contractor_client}}');
    }
}
