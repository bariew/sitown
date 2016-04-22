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
    const STATE_OPEN = 'open';
    const STATE_CLOSED = 'closed';


    public $url, $title, $number, $login, $sha;
    public $state = self::STATE_OPEN;
    public $isNewRecord = true;


    public function rules()
    {
        return [
            [['state'], 'in', 'range' => array_keys(static::stateList())],
        ];
    }

    public function search($params = [])
    {
        $rows = $this->getGithub()->pullRequestList(array_merge([
            'state' => $this->state,
        ], $params));
        return new ArrayDataProvider([
            'allModels' => static::populateAll($rows),
        ]);
    }

    public function merge($message = null)
    {
        return $this->getGithub()->pullRequestMerge($this->number, $this->sha, $message);
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
            'state' =>  $row['state'],
            'login' =>  $row['user']['login'],
            'sha' =>  $row['head']['sha'],
        ]);
    }

    public static function stateList()
    {
        $data = [static::STATE_OPEN, static::STATE_CLOSED];
        return array_combine($data, $data);
    }

    /**
     * @return Github
     */
    public static function getGithub()
    {
        return \Yii::$app->github;
    }
}