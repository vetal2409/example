<?php

use yii\db\Schema;
use yii\db\Migration;

class m151103_233717_insert_value extends Migration
{
    public function up()
    {
        $this->insert('notification_type',['name'=>'Admin Add Comment To Job', 'type' =>'AdminAddCommentToJob']);
        $this->insert('notification_type',['name'=>'Admin Add Comment To Shift', 'type' =>'AdminAddCommentToShift']);
        $this->insert('notification_type',['name'=>'Admin Create Shift', 'type' =>'AdminCreateShift']);
        $this->insert('notification_type',['name'=>'Admin Remove Shift', 'type' =>'AdminRemoveShift']);
        $this->insert('notification_type',['name'=>'Admin Update Shift', 'type' =>'AdminUpdateShift']);
        $this->insert('notification_type',['name'=>'Client Add Comment To Shift', 'type' =>'ClientAddCommentToShift']);
        $this->insert('notification_type',['name'=>'Client Approve Timesheet', 'type' =>'ClientApproveTimesheet']);
        $this->insert('notification_type',['name'=>'Client Create Shift', 'type' =>'ClientCreateShift']);
        $this->insert('notification_type',['name'=>'Client Modify Timesheet', 'type' =>'ClientModifyTimesheet']);
        $this->insert('notification_type',['name'=>'Client Reject Contractor', 'type' =>'ClientRejectContractor']);

        $this->insert('notification_type',['name'=>'Client Remove Shift', 'type' =>'ClientRemoveShift']);
        $this->insert('notification_type',['name'=>'Client Update Shift', 'type' =>'ClientUpdateShift']);
        $this->insert('notification_type',['name'=>'Contractor Add Comment To Job', 'type' =>'ContractorAddCommentToJob']);
        $this->insert('notification_type',['name'=>'Contractor Add Comment To Timesheet', 'type' =>'ContractorAddCommentToTimesheet']);
        $this->insert('notification_type',['name'=>'Contractor Add Holiday', 'type' =>'ContractorAddHoliday']);
        $this->insert('notification_type',['name'=>'Contractor Add Skill', 'type' =>'ContractorAddSkill']);
        $this->insert('notification_type',['name'=>'Contractor Apply For Job', 'type' =>'ContractorApplyForJob']);
        $this->insert('notification_type',['name'=>'Contractor Assign To Course', 'type' =>'ContractorAssignToCourse']);
        $this->insert('notification_type',['name'=>'Contractor Changed Profile', 'type' =>'ContractorChangedProfile']);
        $this->insert('notification_type',['name'=>'Contractor Decline Job', 'type' =>'ContractorDeclineJob']);

        $this->insert('notification_type',['name'=>'Contractor Got Job', 'type' =>'ContractorGotJob']);
        $this->insert('notification_type',['name'=>'Contractor Reject Job', 'type' =>'ContractorRejectJob']);
        $this->insert('notification_type',['name'=>'Contractor Submit Timesheet', 'type' =>'ContractorSubmitTimesheet']);
        $this->insert('notification_type',['name'=>'Contractor Timesheet Modify', 'type' =>'ContractorTimesheetModify']);
        $this->insert('notification_type',['name'=>'Contractors Profile Updated', 'type' =>'ContractorsProfileUpdated']);
        $this->insert('notification_type',['name'=>'Course Read', 'type' =>'Course Read']);
        $this->insert('notification_type',['name'=>'Course Updated', 'type' =>'CourseUpdated']);
        $this->insert('notification_type',['name'=>'Create New Postcode', 'type' =>'CreateNewPostcode']);
        $this->insert('notification_type',['name'=>'Holiday Approved', 'type' =>'HolidayApproved']);
        $this->insert('notification_type',['name'=>'New Course', 'type' =>'NewCourse']);

        $this->insert('notification_type',['name'=>'New Timesheet', 'type' =>'NewTimesheet']);
        $this->insert('notification_type',['name'=>'New User', 'type' =>'NewUser']);
        $this->insert('notification_type',['name'=>'Remove Contractor', 'type' =>'RemoveContractor']);
        $this->insert('notification_type',['name'=>'Sub User Attach', 'type' =>'SubUserAttach']);
        $this->insert('notification_type',['name'=>'Timesheet Status Changed', 'type' =>'TimesheetStatusChanged']);
        $this->insert('notification_type',['name'=>'Tls Change Contractor Profile', 'type' =>'TlsChangeContractorProfile']);
        $this->insert('notification_type',['name'=>'User Is Registered', 'type' =>'UserIsRegistered']);
        $this->insert('notification_type',['name'=>'Wants Delete Postcode', 'type' =>'WantsDeletePostcode']);
        $this->insert('notification_type',['name'=>'Contractor qualification or skill will expire in 3 months', 'type' =>'ContractorQualificationOrSkillWillExpireIn3months']);
        $this->insert('notification_type',['name'=>'Contractor qualification or skill will expire in 1 months', 'type' =>'ContractorQualificationOrSkillWillExpireIn1months']);
        $this->insert('notification_type',['name'=>'Contractor qualification or skill expired', 'type' =>'ContractorQualificationOrSkillExpired']);

        $this->insert('role',['username'=>'contractor']);
        $this->insert('role',['username'=>'SubClient']);
        $this->insert('role',['username'=>'client']);
        $this->insert('role',['username'=>'executiveStaff']);
        $this->insert('role',['username'=>'fildStaff']);
        $this->insert('role',['username'=>'officeStaff']);
        $this->insert('role',['username'=>'admin']);
        $this->insert('role',['username'=>'superAdmin']);

        $this->insert('medical_question',['name'=>'Have you had or are you due to have any operation']);
        $this->insert('medical_question',['name'=>'Have you ever had or are currently suffering from any of the following:']);
        $this->insert('medical_question',['name'=>'Any disease of the brain or nervous system eg.fits, paralysis, vertigo, nervous breakdown or neurosis']);
        $this->insert('medical_question',['name'=>'Any disease of the throat or respiratory system eg asthma, broncitis, emphysema, hay fever, allergies']);
        $this->insert('medical_question',['name'=>'Any disease of the stomach or gastric disorder eg. Peptic Ulcer']);
        $this->insert('medical_question',['name'=>'Heart Disease or disorder eg.Angina']);
        $this->insert('medical_question',['name'=>'Any disease of renal/circulatory system eg breath shortness/chest pain/varicose veins/blood pressure']);
        $this->insert('medical_question',['name'=>'Any disease of the kidneys, bladder eg stones, nephritis']);
        $this->insert('medical_question',['name'=>'Any disease of the Glandular system eg anemid, diabetes, glandular problems?']);
        $this->insert('medical_question',['name'=>'Any disease of the skin,muscles  bones, joints, ears, eyes']);
        $this->insert('medical_question',['name'=>'Any back problem or repetitive strain injuries']);
        $this->insert('medical_question',['name'=>'Loss of vision or defect in either eye']);
        $this->insert('medical_question',['name'=>'Are you currently taking any pills or medicines, prescribed or not?']);
        $this->insert('medical_question',['name'=>'Are you suffering from any other illness not listed above?']);
        $this->insert('medical_question',['name'=>'Do you suffer from any disability or other condition that you may wish to make us aware of in order that we may fully consider your application and suitability for employment?']);
    }

    public function down()
    {
            return true;
    }
}
