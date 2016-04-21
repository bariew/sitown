<?php
/**
 * Created by PhpStorm.
 * User: pt
 * Date: 21.04.16
 * Time: 20:31
 */

namespace app\modules\code\models;


use app\modules\code\components\Github;
use yii\base\Model;
use yii\data\ArrayDataProvider;

class PullRequest extends Model
{
    public $url, $title, $number, $login, $sha;

    public function search($params = [])
    {
        /** @var Github $github */
        $github = \Yii::$app->github;
        $rows = $github->pullRequestList($params);
        return new ArrayDataProvider([
            'allModels' => static::populateAll($rows),
        ]);
    }

    protected static function populateAll($rows)
    {
        $result = [];
        foreach ($rows as $row) {
            $result[] = static::populate($row);
        }
        return $result;
    }

    protected static function populate($row)
    {
        return new static([
            'url' => $row['html_url'],
            'title' => $row['title'],
            'number' =>  $row['number'],
            'login' =>  $row['user']['login'],
            'sha' =>  $row['head']['sha'],
        ]);
    }
}