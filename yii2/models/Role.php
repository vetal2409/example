<?php


namespace backend\models;


use Yii;
use yii\base\Model;

class Role extends Model
{
    public static function  getChildren()
    {
        switch (Yii::$app->user->role) {
            case 'root':
                return ['admin' => 'Admin', 'moder' => 'Event Manager', 'manager' => 'Manager'];
                break;
            case 'admin':
                return ['moder' => 'Event Manager', 'manager' => 'Manager'];
                break;
            case 'moder':
                return ['manager' => 'Manager'];
                break;
            default:
                return [];
        }


    }
}