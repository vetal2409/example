<?php

use common\components\Migration;

class m151103_115354_foreign_keys extends Migration
{
    public function up()
    {

        //  notification_templates
        $this->createIndex('fk_notification_type_idx', '{{%notification_templates}}', 'notification_type_id');
        $this->createIndex('fk_role_idx', '{{%notification_templates}}', 'role_id');

        $this->addForeignKey('fk_notification_user_notification', '{{%notification_templates}}', 'notification_type_id', '{{%notification_type}}', 'id');
        $this->addForeignKey('fk_notification_user_user', '{{%notification_templates}}', 'role_id', '{{%role}}', 'id');

//          notification_user
        $this->createIndex('fk_notification_user_notification_idx', '{{%notification_user}}', 'notification_id');
        $this->createIndex('fk_notification_user_user_idx', '{{%notification_user}}', 'user_id');

        $this->addForeignKey('fk_user_notification', '{{%notification_user}}', 'notification_id', '{{%notification}}', 'id');
        $this->addForeignKey('fk_user_user', '{{%notification_user}}', 'user_id', '{{%user}}', 'id');

//        //  notification_templates
//        $this->createIndex('fk_notification_settings_notification_type_idx', '{{%notification_templates}}', 'notification_type_id');
//        $this->createIndex('fk_notification_settings_role_idx', '{{%notification_templates}}', 'role_id');
//
//        $this->addForeignKey('fk_notification_user_notification', '{{%notification_templates}}', 'notification_type_id', '{{%notification_type}}', 'id');
//        $this->addForeignKey('fk_notification_user_user', '{{%notification_templates}}', 'role_id', '{{%role}}', 'id');
//
//        //  notification_user
//        $this->createIndex('fk_notification_user_notification_idx', '{{%notification_user}}', 'notification_id');
//        $this->createIndex('fk_notification_user_user_idx', '{{%notification_user}}', 'user_id');
//
//        $this->addForeignKey('fk_notification_user_notification', '{{%notification_user}}', 'notification_id', '{{%notification}}', 'id');
//        $this->addForeignKey('fk_notification_user_user', '{{%notification_user}}', 'user_id', '{{%user}}', 'id');

    }

    public function down()
    {
        //  notification_templates
        $this->dropForeignKey('fk_notification_user_notification', '{{%notification_templates}}');
        $this->dropForeignKey('fk_notification_user_user', '{{%notification_templates}}');

        //  notification_user
        $this->dropForeignKey('fk_user_notification', '{{%notification_user}}');
        $this->dropForeignKey('fk_user_user', '{{%notification_user}}');

        $this->dropIndex('fk_notification_user_notification_idx', '{{%notification_user}}');
        $this->dropIndex('fk_notification_user_user_idx', '{{%notification_user}}');

        $this->dropIndex('fk_notification_type_idx', '{{%notification_templates}}');
        $this->dropIndex('fk_role_idx', '{{%notification_templates}}');
    }

}
