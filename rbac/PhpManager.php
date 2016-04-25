<?php

namespace app\rbac;
use Yii;
use yii\base\Event;
use yii\rbac\Assignment;
use yii\web\Controller;
use yii\web\HttpException;


class PhpManager extends \yii\rbac\PhpManager
{
    public $debug = false;

    public function init()
    {
        parent::init();
        Event::on(Controller::className(), 'beforeAction', [$this, 'beforeActionAccess']);
        if(Yii::$app->user->isGuest){
            return;
        }
        $this->assignments[Yii::$app->user->id]['default'] = new Assignment([
            'userId' => Yii::$app->user->id,
            'roleName' => 'default',
            'createdAt' => time(),
        ]);
    }

    /**
     * Checks whether current user has access to current controller action.
     * @param Event $event controller beforeAction event.
     * @throws \yii\web\HttpException
     */
    public function beforeActionAccess(Event $event)
    {
        if ($this->debug) {
            return;
        }
        $controller = $event->sender;
        if (!$this->checkActionAccess($controller->module->id, $controller->id, $controller->action->id)) {
            throw new HttpException(403, Yii::t('app/rbac', 'Access denied'));
        }
    }

    /**
     * Check whether the user has access to permission.
     * @param $module
     * @param $controller
     * @param $action
     * @return bool whether user has access to permission name.
     * @internal param array $route permission name or its components for self::createPermissionName.
     */
    private function checkActionAccess($module, $controller, $action)
    {
        $route = "$module/$controller/$action";
        foreach ($this->getPermissions() as $permission) {
            if ($permission->type == $permission::TYPE_ROLE) {
                continue;
            }
            if (!preg_match('#^'.$permission->name.'$#', $route)) {
                continue;
            }
            if (Yii::$app->user->can($permission->name)) {
                return true;
            }
        }
        return false;
    }
}