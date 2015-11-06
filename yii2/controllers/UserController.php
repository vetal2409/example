<?php

namespace backend\controllers;

use backend\models\UserCreateForm;
use common\models\UserData;
use common\models\UserHotelMapping;
use Yii;
use common\models\User;
use common\models\UserSearch;
use yii\filters\AccessControl;
use common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['root']
                    ],
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['admin']
                    ],
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $model->scenario = 'create';
        $userData = new UserData();
        //$hotelMapping = new UserHotelMapping();

        if ($model->load(Yii::$app->request->post()) &&
            $userData->load(Yii::$app->request->post())
        ) //  && $hotelMapping->load(Yii::$app->request->post())
        {
            $validUser = $model->validate();
            $validUserData = $userData->validate();
            //$validHotelMapping = $hotelMapping->validate();
            if ($validUser && $validUserData) { // && $validHotelMapping
                $model->setPassword($model->password);
                $model->generateAuthKey();
                if ($model->save()) {
                    $userData->user_id = $model->id;
                    //$hotelMapping->user_id = $model->id;
                    $userData->save(false);
                    //$hotelMapping->save(false);
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'userData' => $userData,
            //'hotelMapping' => $hotelMapping,
        ]);

    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $userData = $model->userData;
        $hotelMapping = $model->hotelMapping;

        if ($model->load(Yii::$app->request->post()) &&
            $userData->load(Yii::$app->request->post())
        ) //  && $hotelMapping->load(Yii::$app->request->post())
        {
            $validUser = $model->validate();
            $validUserData = $userData->validate();
            //$validHotelMapping = $hotelMapping->validate();
            if ($validUser && $validUserData) { // && $validHotelMapping
                if ($model->save(false) && $userData->save(false)) { // && $hotelMapping->save(false)
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'userData' => $userData,
            //'hotelMapping' => $hotelMapping,
        ]);

    }

    public function actionChangePassword($id)
    {
        $model = $this->findModel($id);
        $model->setScenario('changePassword');
        if (Yii::$app->request->post()) {
            if ($model->load(Yii::$app->request->post()) && ($model->new_password === $model->password_repeat)) {
                $model->setPassword($model->new_password);
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            };
        }

        return $this->render('change_password', [
            'model' => $model
        ]);
    }
}
