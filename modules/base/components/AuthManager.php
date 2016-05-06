<?php

namespace app\modules\base\components;
use Yii;
use yii\base\Event;
use yii\rbac\Assignment;
use yii\web\Controller;
use yii\web\HttpException;


class AuthManager extends \yii\rbac\PhpManager
{
    /**
     * @inheritdoc
     */
    public $itemFile = '@app/modules/base/components/rbac/items.php';
    /**
     * @inheritdoc
     */
    public $assignmentFile = '@app/modules/base/components/rbac/assignments.php';
    /**
     * @inheritdoc
     */
    public $ruleFile = '@app/modules/base/components/rbac/rules.php';

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
        $controller = $event->sender;
        if (!Yii::$app->user->can($controller->module->id.'/'.$controller->id.'/'.$controller->action->id)) {
            throw new HttpException(403, Yii::t('app/rbac', 'Access denied'));
        }
    }

    /**
     * @inheritdoc
     */
    public function checkAccess($userId, $permissionName, $params = [])
    {
        $permissionName = preg_replace('#^\/(.*)#', '$1', $permissionName);
        foreach ($this->getPermissions() as $permission) {
            if ($permission->type == $permission::TYPE_ROLE) {
                continue;
            }
            if (!preg_match('#^'.$permission->name.'$#', $permissionName)) {
                continue;
            }
            if (parent::checkAccess($userId, $permission->name, $params)) {
                return true;
            }
        }
        return parent::checkAccess($userId, $permissionName, $params);
    }
}