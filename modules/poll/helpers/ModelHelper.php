<?php
/**
 * Created by PhpStorm.
 * User: pt
 * Date: 05.05.16
 * Time: 17:40
 */

namespace app\modules\poll\helpers;


use yii\base\Event;
use yii\base\Model;
use yii\db\ActiveRecord;

class ModelHelper
{
    /**
     * @param $data
     * @return Model
     */
    public static function initModel($data)
    {
        list($class, $attributes, $dirtyAttributes) = array_values($data);
        /** @var ActiveRecord $model */
        $model = new $class();
        if ($model instanceof ActiveRecord) {
            $model::populateRecord($model, $attributes);
            $model->oldAttributes = $model->primaryKey ? array_diff_key($attributes, $dirtyAttributes) : null;
        } else {
            $model->attributes = $attributes;
        }
        return $model;
    }

    public static function getRelationId($model)
    {
        return $model->id ? get_class($model).'_'.$model->id : null;
    }


    public static function getRelationTitle($model)
    {
        foreach (['title', 'name', 'username', 'email', 'id'] as $attribute) {
            if (isset($model->$attribute) && ($result = $model->$attribute)) {
                return $result;
            }
        }
        return null;
    }

    public static function getUrl($model)
    {
        return @$model->id
            ? \Yii::$app->urlManager->createAbsoluteUrl([
                preg_replace(
                    '#.*app\\\\modules\\\\(\w+)\\\\models\\\\(\w+)#',
                    '/$1/$2/view',
                    strtolower(get_class($model))
                ),
                'id' => $model->id
            ])
            : null;
    }

    public static function attributeDifference(Event $event)
    {
        /** @var ActiveRecord $model */
        $model = $event->sender;
        $diff = new \cogpowered\FineDiff\Diff();
        if (!isset($model->dirtyAttributes)) {
            $old = [];
            $new = $model->attributes;
        } else {
            $old = array_intersect_key($model->oldAttributes, $model->dirtyAttributes);
            $new = array_intersect_key($model->attributes, $model->dirtyAttributes);
        }

        return $diff->render(print_r($old, true), print_r($new, true));
    }
}