<?php

namespace common\components;

use Yii;
use yii\web\ForbiddenHttpException;

class Controller extends \yii\web\Controller
{

    public $nonCSRF = ['after-payment', 'thanks'];
    public function init()
    {
        Yii::$classMap['yii\helpers\Url'] = Yii::getAlias('@common/helpers/Url.php');
    }

    /**
     * @param bool $allow
     * @throws ForbiddenHttpException
     */
    protected function allowAccess($allow = false)
    {
        if (!Yii::$app->user->isRoot && !$allow) {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }
    }

    public function beforeAction($action)
    {
        if (in_array($this->action->id, $this->nonCSRF, true))
        {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }
}