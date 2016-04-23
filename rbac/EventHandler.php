<?php
/**
 * Created by PhpStorm.
 * User: pt
 * Date: 21.04.16
 * Time: 4:08
 */

namespace app\rbac;
use Yii;
use yii\base\Event;
use yii\rbac\Role;
use yii\web\HttpException;

class EventHandler
{
    /**
     * Checks whether current user has access to current controller action.
     * @param Event $event controller beforeAction event.
     * @throws \yii\web\HttpException
     */
    public static function beforeActionAccess($event)
    {
        $controller = $event->sender;
        if (!static::checkAccess([$controller->module->id, $controller->id, $controller->action->id])) {
            throw new HttpException(403, Yii::t('app/rbac', 'Access denied'));
        }
    }

    /**
     * Check whether the user has access to permission.
     * @param array $route permission name or its components for self::createPermissionName.
     * @return boolean whether user has access to permission name.
     */
    private static function checkAccess($route)
    {
        $permission = implode('/', $route);
        $anyActionPermission = preg_replace('/(.*\/)\w+$/', '$1*', $permission);
        $anyControllerPermission = preg_replace('/(.*\/)\w+\/\*$/', '$1*/*', $permission);
        return
            \Yii::$app->user->can($anyControllerPermission)
            || \Yii::$app->user->can($anyActionPermission)
            || \Yii::$app->user->can($permission);
    }
}