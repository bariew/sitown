<?php

namespace app\rbac;
use Yii;
use yii\rbac\Assignment;


class PhpManager extends \yii\rbac\PhpManager
{
    public function init()
    {
        parent::init();
        if(Yii::$app->user->isGuest){
            return;
        }
        $this->assignments[Yii::$app->user->id]['default'] = new Assignment([
            'userId' => Yii::$app->user->id,
            'roleName' => 'default',
            'createdAt' => time(),
        ]);
    }
}