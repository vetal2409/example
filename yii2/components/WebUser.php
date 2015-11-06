<?php
namespace common\components;

use Yii;
use yii\web\User;

/**
 * Class WebUser
 * @package common\components
 * @property boolean $isRoot
 * @property boolean $isAdmin
 * @property boolean $isModer
 * @property boolean $isManager
 * @property mixed $role
 */
class WebUser extends User
{
    /**
     * @return bool
     */
    public function getIsRoot()
    {
        return $this->getRole() === 'root';
    }

    /**
     * @return bool
     */
    public function getIsAdmin()
    {
        return $this->getRole() === 'admin';
    }

    /**
     * @return bool
     */
    public function getIsModer()
    {
        return $this->getRole() === 'moder';
    }

    /**
     * @return bool
     */
    public function getIsManager()
    {
        return $this->getRole() === 'manager';
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return Yii::$app->user->isGuest ? null : Yii::$app->user->identity->role;
    }

}