<?php

class SkillController extends Controller {

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
//	public function accessRules()
//	{
//		return array(
//			array('allow',  // allow all users to perform 'index' and 'view' actions
//				'actions'=>array('index','view'),
//				'users'=>array('*'),
//			),
//			array('allow', // allow authenticated user to perform 'create' and 'update' actions
//				'actions'=>array('create','update'),
//				'users'=>array('@'),
//			),
//			array('allow', // allow admin user to perform 'admin' and 'delete' actions
//				'actions'=>array('admin','delete'),
//				'users'=>array('@'),
//			),
//			array('deny',  // deny all users
//				'users'=>array('*'),
//			),
//		);
//	}

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        if (Yii::app()->user->checkAccess('manageContractors')) {
            $this->render('view', array(
                'model' => $this->loadModel($id),
            ));
        }
        else
            $this->redirect(Yii::app()->createUrl('site/index'));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        if (Yii::app()->user->checkAccess('manageContractors')) {
            $model = new Skill;
            $lastPayRateContractor = new PayRateContractor();
            if (isset($_POST['Skill'])) {
                $model->attributes = $_POST['Skill'];
                if ($model->save())
                    $this->redirect(array('index'));
            }
            $this->render('create', array(
                'model' => $model,
                'lastPayRateContractor' => $lastPayRateContractor
            ));
        }
        else
            $this->redirect(Yii::app()->createUrl('site/index'));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        if (Yii::app()->user->checkAccess('manageContractors')) {
            $model = $this->loadModel($id);
            $lastPayRateContractor = PayRateContractor::getLast($id);
            $historicalPayRateContractor = PayRateContractor::getLast($id, true);
            if (isset($_POST['Skill'])) {
                $model->attributes = $_POST['Skill'];
                $model->setAttribute('pay_rate_contractor_begin', strtotime($_POST['Skill']['pay_rate_contractor_begin']));
                $model->setAttribute('pay_rate_contractor_end', strtotime($_POST['Skill']['pay_rate_contractor_end']));
                if ($model->save())
                    $this->redirect(array('index'));
            }
            $this->render('update', array(
                'model' => $model,
                'lastPayRateContractor' => $lastPayRateContractor,
                'historicalPayRateContractor' => $historicalPayRateContractor
            ));
        }
        else
            $this->redirect(Yii::app()->createUrl('site/index'));
    }


    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->user->checkAccess('manageContractors')) {
            $this->loadModel($id)->delete();
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            $this->redirect(Yii::app()->createUrl('site/index'));
    }


    public function actionDeleteMapping($id) {
        $model = SkillMapping::model()->findByPk($id);
        if (Yii::app()->user->checkAccess('manageContractors') || $model->user_id == Yii::app()->user->id) {
            Skill::deleteMappingById($id);
        }
        else
            $this->redirect(Yii::app()->createUrl('site/index'));
    }


    /**
     * Lists all models.
     */
    public function actionIndex() {
        if (Yii::app()->user->checkAccess('manageContractors')) {
            $model = new Skill('search');
            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['Skill']))
                $model->attributes = $_GET['Skill'];

            $this->render('index', array(
                'model' => $model,
            ));
        }
        else
            $this->redirect(Yii::app()->createUrl('site/index'));
    }


    public function actionUpdateMapping($id) {
        if (Yii::app()->user->checkAccess('manageContractors')) {
            $model = SkillMapping::model()->findByPk($id);
            if (isset($_POST['SkillMapping'])) {
                $model->attributes = $_POST['SkillMapping'];
                $model->image = CUploadedFile::getInstance($model, 'image');
                if ($model->save()) {
                    $this->redirect(array('user/update', 'id' => $model->user_id));
                }
            }
            $this->render('updateMapping', array('model' => $model));
        }
        else
            $this->redirect(Yii::app()->createUrl('site/index'));
    }

    /**
     * Manages all models.
     */

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Skill the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Skill::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, Yii::t('error', 'The requested page does not exist.'));
        return $model;
    }


    /**
     * Performs the AJAX validation.
     * @param Skill $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'skill-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }


    public function actionAdd($contractor_id) {
        $role = Yii::app()->user->role;
        $isAjax = isset($_REQUEST['ajax']);
		if($isAjax)
		{
            AjaxResponser::getUserModel();
			if( ! (Yii::app()->user->checkAccess('manageContractors') || $role == 'Contractor') ){
				AjaxResponser::error(E::$PERMISSION_DENIED);
			}
			$model = new SkillMapping;
			$licenseModel = new LicenseMapping;
			if(! isset($_POST['SkillMapping'])){
				AjaxResponser::error('expected parameter SkillMapping');
			}

			$model->attributes = $_POST['SkillMapping'];
			$model->user_id = $contractor_id;
			if($model->save())
			{
				if(isset($_POST['LicenseMapping']))
				{
					$licenseModel->attributes = $_POST['LicenceMapping'];
					$licenseModel->image=CUploadedFile::getInstance($licenseModel, 'image');
					Skill::createLicense($model->id, $licenseModel->image);
				}
				if($role == 'Contractor')
				{
					Notification::contractorAddSkill(Yii::app()->user->id, $model->id);
				}
				AjaxResponser::success(AjaxResponser::getAllUserSkills());
			}else{
				AjaxResponser::error($model->errors);
			}

		}


        if (Yii::app()->user->checkAccess('manageContractors') || $role == 'Contractor') {
            $model = new SkillMapping;
            $licenseModel = new LicenseMapping;
            $endOfName = Skill::getEndOfName(array_shift($this->getAllBegin()));
            if (isset($_POST['SkillMapping'])) {
                $model->attributes = $_POST['SkillMapping'];
                if(empty($model->expiry_date))
                {
                    $model->addError('expiry_date', 'Expiry date can\'t be empty');
                }
                else
                {
                    $model->expiry_date = date('y-m-d', strtotime($model->expiry_date));
                    $model->setBeginAndEndOfName($_POST['SkillMapping']);
                    $model->user_id = $contractor_id;
                    if ($model->save()) {
                        if (isset($_POST['LicenseMapping'])) {
                            $licenseModel->attributes = $_POST['LicenceMapping'];
                            $licenseModel->image = CUploadedFile::getInstance($licenseModel, 'image');
                            Skill::createLicense($model->id, $licenseModel->image);
                        }
                        if ($role == 'Contractor') {
                            Notification::contractorAddSkill(Yii::app()->user->id, $model->id);
                            $this->redirect(Yii::app()->createUrl('profileChange/create', array('id' => $contractor_id)));
                        }
                        $this->redirect(Yii::app()->createUrl('user/update', array('id' => $contractor_id)));
                    }
                }
            }
            $this->render('addSkill', array('model' => $model, 'licenseModel' => $licenseModel, 'endOfName' => $endOfName));
        }
        else
            $this->redirect(Yii::app()->createUrl('site/index'));
    }


    public function actionSkillDetails($id) {
        if (Yii::app()->user->checkAccess('manageContractors'))
            $this->renderPartial('skillDetails', array('id' => $id));
        else
            $this->redirect(Yii::app()->user->createUrl('site/index'));
    }


    public function actionAddLicense($skillMappingId, $contractorId = null) {
        $isAjax = isset($_REQUEST['ajax']);
        $role = Yii::app()->user->role;

		if($isAjax){
            AjaxResponser::getUserModel();
			if( ! (Yii::app()->user->checkAccess('manageContractors') || $role == 'Contractor') ){
				AjaxResponser::error(E::$PERMISSION_DENIED);
			}

			$model = new LicenseMapping;
			$model->image=CUploadedFile::getInstance($model, 'image');
			if(Skill::createLicense($skillMappingId, $model->image)){
				AjaxResponser::success(AjaxResponser::getAllUserSkills());
			}else{
				AjaxResponser::error($model->errors);
			}
		}


        if (Yii::app()->user->checkAccess('manageContractors') || $role == 'Contractor') {
            $model = new LicenseMapping;
            if (isset($_POST['LicenseMapping'])) {
                $model->image = CUploadedFile::getInstance($model, 'image');
                if (Skill::createLicense($skillMappingId, $model->image)) {
                    if ($role == 'Contractor')
                        $this->redirect(Yii::app()->createUrl('user/myProfile'));
                    else
                        $this->redirect(Yii::app()->createUrl('user/update', array('id' => $contractorId)));
                }
                else $this->redirect(Yii::app()->createUrl('user/update', array('id' => $contractorId)));
            }
            $this->renderPartial('addLicence', array('model' => $model, 'id' => $skillMappingId));
        }
        else
            $this->redirect(Yii::app()->createUrl('site/index'));
    }


    public function actionRemoveLicense($licenseId, $contractorId = null)
    {
        if (Yii::app()->user->checkAccess('manageContractors') || $contractorId == Yii::app()->user->id) {
            $model = LicenseMapping::model()->findByPk($licenseId);
            $model->delete();
        }
        else
            $this->redirect(Yii::app()->createUrl('site/index'));
    }


    public function actionToggleStatus($id)
    {
        if (Yii::app()->user->checkAccess('manageContractors')){
            Skill::toggleMappingStatus($id);
        }
        else{
            $this->redirect(Yii::app()->createUrl('site/index'));
        }
    }


    public function actionStatus($id, $withLink = false)
    {
        if (!Yii::app()->user->isGuest) {
            $skill = SkillMapping::model()->findByPk($id);
            $this->renderPartial('skillStatus', array('skill' => $skill, 'withLink' => $withLink), false, true);
        }
        else
            $this->redirect(Yii::app()->createUrl('site/index'));
    }


    public function actionContractorSkills($id, $noJS = false)
    {
        if (!Yii::app()->user->isGuest) {
            if (!$noJS){
                $this->renderPartial('/user/contractorSkills', array('id' => $id, 'update' => true), false, true);
            }
            else{
                $this->renderPartial('/user/contractorSkills', array('id' => $id, 'update' => true));
            }
        }
        else{
            $this->redirect(Yii::app()->createUrl('site/index'));
        }
    }


    public static function getAll()
    {
        return CHtml::listData(Skill::All(), 'id', 'name');
    }


    public static function getAllBegin()
    {
        return CHtml::listData(Skill::AllBegin(), 'begin_of_name', 'begin_of_name');
    }


    public static function actionGetEndOfName()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('begin_of_name', $_POST['SkillMapping']['begin_of_skill_name']);
        $skills = Skill::model()->findAll($criteria);
        $data = CHtml::listData($skills, 'end_of_name', 'end_of_name');

        foreach($data as $key=>$name){
            echo CHtml::tag('span', array('val'=>$key), CHtml::encode($name),true);
        }
    }
}
