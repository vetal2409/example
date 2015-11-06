<?php

use yii\db\Migration;

class m150911_123912_foreign_keys extends Migration
{
    public function up()
    {
        //user_skill
        $this->createIndex('fk_user_skill_skill_idx', '{{%user_skill}}', 'skill_id');
        $this->createIndex('fk_user_skill_image_idx', '{{%user_skill}}', 'image_id');

        $this->addForeignKey('fk_user_skill_user', '{{%user_skill}}', 'user_id', '{{%user}}', 'id');
        $this->addForeignKey('fk_user_skill_skill', '{{%user_skill}}', 'skill_id', '{{%skill}}', 'id');
        $this->addForeignKey('fk_user_skill_image', '{{%user_skill}}', 'image_id', '{{%image}}', 'id');

        //user_area
        $this->createIndex('fk_user_area_area_idx', '{{%user_area}}', 'area_id');

        $this->addForeignKey('fk_user_area_user', '{{%user_area}}', 'user_id', '{{%user}}', 'id');
        $this->addForeignKey('fk_user_area_area', '{{%user_area}}', 'area_id', '{{%area}}', 'id');

        //area
        $this->createIndex('fk_area_area_idx', '{{%area}}', 'parent_id');

        $this->addForeignKey('fk_area_area', '{{%area}}', 'parent_id', '{{%area}}', 'id');

        //postcode
        $this->createIndex('fk_postcode_area_idx', '{{%postcode}}', 'area_id');

        $this->addForeignKey('fk_postcode_area', '{{%postcode}}', 'area_id', '{{%area}}', 'id');

        //contractor_policy
        $this->createIndex('fk_policy_policy_idx', '{{%contractor_policy}}', 'policy_id');

        $this->addForeignKey('fk_policy_contractor', '{{%contractor_policy}}', 'contractor_id', '{{%contractor}}', 'id');
        $this->addForeignKey('fk_policy_policy', '{{%contractor_policy}}', 'policy_id', '{{%policy}}', 'id');

        //contractor_holiday
        $this->createIndex('fk_contractor_holiday_contractor_idx', '{{%contractor_holiday}}', 'contractor_id');

        $this->addForeignKey('fk_contractor_holiday_contractor', '{{%contractor_holiday}}', 'contractor_id', '{{%contractor}}', 'id');

        //medical_answer
        $this->createIndex('fk_medical_answer_contractor_idx', '{{%medical_answer}}', 'contractor_id');
        $this->createIndex('fk_medical_answer_medical_question_idx', '{{%medical_answer}}', 'medical_question_id');

        $this->addForeignKey('fk_medical_answer_contractor', '{{%medical_answer}}', 'contractor_id', '{{%contractor}}', 'id');
        $this->addForeignKey('fk_medical_answer_medical_question', '{{%medical_answer}}', 'medical_question_id', '{{%medical_question}}', 'id');

        //how_hear
        $this->createIndex('fk_how_hear_how_hear_option_idx', '{{%how_hear}}', 'how_hear_option_id');

        $this->addForeignKey('fk_how_hear_contractor', '{{%how_hear}}', 'id', '{{%contractor}}', 'id');
        $this->addForeignKey('fk_how_hear_how_hear_option', '{{%how_hear}}', 'how_hear_option_id', '{{%how_hear_option}}', 'id');

        //medical_info_address
        $this->createIndex('fk_medical_info_address_medical_info_idx', '{{%medical_info_address}}', 'medical_info_id');

        $this->addForeignKey('fk_medical_info_address_medical_info', '{{%medical_info_address}}', 'medical_info_id', '{{%medical_info}}', 'id');

        //medical_info
        $this->addForeignKey('fk_medical_info_contractor', '{{%medical_info}}', 'id', '{{%contractor}}', 'id');

        //contractor_address
        $this->createIndex('fk_contractor_address_contractor_idx', '{{%contractor_address}}', 'contractor_id');

        $this->addForeignKey('fk_contractor_address_contractor', '{{%contractor_address}}', 'contractor_id', '{{%contractor}}', 'id');

        //user
        $this->createIndex('fk_user_image_idx', '{{%user}}', 'image_id');

        $this->addForeignKey('fk_user_image', '{{%user}}', 'image_id', '{{%image}}', 'id');

        //client
        $this->createIndex('fk_client_client_idx', '{{%client}}', 'parent_id');

        $this->addForeignKey('fk_client_user', '{{%client}}', 'id', '{{%user}}', 'id');
        $this->addForeignKey('fk_client_client', '{{%client}}', 'parent_id', '{{%client}}', 'id');

        //contractor
        $this->createIndex('fk_contractor_postcode_idx', '{{%contractor}}', 'postcode_id');
        $this->createIndex('fk_contractor_payment_method_idx', '{{%contractor}}', 'payment_method_id');

        $this->addForeignKey('fk_contractor_user', '{{%contractor}}', 'id', '{{%user}}', 'id');
        $this->addForeignKey('fk_contractor_postcode', '{{%contractor}}', 'postcode_id', '{{%postcode}}', 'id');
        $this->addForeignKey('fk_contractor_payment_method', '{{%contractor}}', 'payment_method_id', '{{%payment_method}}', 'id');
    }

    public function down()
    {
        //contractor
        $this->dropForeignKey('fk_contractor_payment_method', '{{%contractor}}');
        $this->dropForeignKey('fk_contractor_postcode', '{{%contractor}}');
        $this->dropForeignKey('fk_contractor_user', '{{%contractor}}');

        $this->dropIndex('fk_contractor_payment_method_idx', '{{%contractor}}');
        $this->dropIndex('fk_client_client_idx', '{{%contractor}}');

        //client
        $this->dropForeignKey('fk_client_client', '{{%client}}');
        $this->dropForeignKey('fk_client_user', '{{%client}}');

        $this->dropIndex('fk_client_client_idx', '{{%client}}');

        //user
        $this->dropForeignKey('fk_user_image', '{{%user}}');

        $this->dropIndex('fk_user_image_idx', '{{%user}}');

        //contractor_address
        $this->dropForeignKey('fk_contractor_address_contractor', '{{%contractor_address}}');

        $this->dropIndex('fk_contractor_address_contractor_idx', '{{%contractor_address}}');

        //medical_info
        $this->dropForeignKey('fk_medical_info_contractor', '{{%medical_info}}');

        //medical_info_address
        $this->dropForeignKey('fk_medical_info_address_medical_info', '{{%medical_info_address}}');

        $this->dropIndex('fk_medical_info_address_medical_info_idx', '{{%medical_info_address}}');

        //how_hear
        $this->dropForeignKey('fk_how_hear_how_hear_option', '{{%how_hear}}');
        $this->dropForeignKey('fk_how_hear_contractor', '{{%how_hear}}');

        $this->dropIndex('fk_how_hear_how_hear_option_idx', '{{%how_hear}}');

        //medical_answer
        $this->dropForeignKey('fk_medical_answer_medical_question', '{{%medical_answer}}');
        $this->dropForeignKey('fk_medical_answer_contractor', '{{%medical_answer}}');

        $this->dropIndex('fk_medical_answer_medical_question_idx', '{{%medical_answer}}');
        $this->dropIndex('fk_medical_answer_contractor_idx', '{{%medical_answer}}');

        //contractor_holiday
        $this->dropForeignKey('fk_contractor_holiday_contractor', '{{%contractor_holiday}}');

        $this->dropIndex('fk_contractor_holiday_contractor_idx', '{{%contractor_holiday}}');

        //contractor_policy
        $this->dropForeignKey('fk_policy_policy', '{{%contractor_policy}}');
        $this->dropForeignKey('fk_policy_contractor', '{{%contractor_policy}}');

        $this->dropIndex('fk_policy_policy_idx', '{{%contractor_policy}}');

        //postcode
        $this->dropForeignKey('fk_postcode_area', '{{%postcode}}');

        $this->dropIndex('fk_postcode_area_idx', '{{%postcode}}');

        //area
        $this->dropForeignKey('fk_area_area', '{{%area}}');

        $this->dropIndex('fk_area_area_idx', '{{%area}}');

        //user_area
        $this->dropForeignKey('fk_user_area_user', '{{%user_area}}');
        $this->dropForeignKey('fk_user_area_area', '{{%user_area}}');

        $this->dropIndex('fk_user_area_area_idx', '{{%user_area}}');

        //user_skill
        $this->dropForeignKey('fk_user_skill_image', '{{%user_skill}}');
        $this->dropForeignKey('fk_user_skill_user', '{{%user_skill}}');
        $this->dropForeignKey('fk_user_skill_skill', '{{%user_skill}}');

        $this->dropIndex('fk_user_skill_image_idx', '{{%user_skill}}');
        $this->dropIndex('fk_user_skill_skill_idx', '{{%user_skill}}');
    }
}