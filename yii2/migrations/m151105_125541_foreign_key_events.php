<?php

use yii\db\Schema;
use yii\db\Migration;

class m151105_125541_foreign_key_events extends Migration
{
    public function up()
    {

        //  event
        $this->createIndex('fk_event_event_type_idx', '{{%event}}', 'event_type_id');
        $this->addForeignKey('fk_event_event_type', '{{%event}}', 'event_type_id', '{{%event_type}}', 'id');

        //  notification
        $this->createIndex('fk_notification_event_idx', '{{%notification}}', 'event_id');
        $this->createIndex('fk_notification_notification_type_idx', '{{%notification}}', 'notification_type_id');

        $this->addForeignKey('fk_notification_event', '{{%notification}}', 'event_id', '{{%event}}', 'id');
        $this->addForeignKey('fk_notification_notification_type', '{{%notification}}', 'notification_type_id', '{{%notification_type}}', 'id');

    }

    public function down()
    {
        //  event
        $this->dropForeignKey('fk_event_event_type', '{{%event}}');

        //  notification
        $this->dropForeignKey('fk_notification_event', '{{%notification}}');
        $this->dropForeignKey('fk_notification_notification_type', '{{%notification}}');


        //  event
        $this->dropIndex('fk_event_event_type_idx', '{{%event}}');

        //  notification
        $this->dropIndex('fk_notification_event_idx', '{{%notification}}');
        $this->dropIndex('fk_notification_notification_type_idx', '{{%notification}}');
    }
}
