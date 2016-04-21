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
            throw new HttpException(403, Yii::t('rbac', 'Access denied'));
        }
    }

    /**
     * Check whether the user has access to permission.
     * @param mixed $permissionName permission name or its components for self::createPermissionName.
     * @return boolean whether user has access to permission name.
     */
    private static function checkAccess($permissionName)
    {
        $permissionName = is_array($permissionName) ? implode('/', $permissionName) : $permissionName;
        return \Yii::$app->user->can($permissionName);
    }
}