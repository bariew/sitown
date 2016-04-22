<?php
/**
 * Created by PhpStorm.
 * User: pt
 * Date: 21.04.16
 * Time: 20:31
 */

namespace app\modules\code\models;


use app\modules\code\components\Github;
use app\modules\poll\models\Question;
use yii\base\Model;
use yii\data\ArrayDataProvider;

class PullRequest extends Model
{
    const STATE_OPEN = 'open';
    const STATE_CLOSED = 'closed';


    public $url, $title, $number, $login, $sha;
    public $state = self::STATE_OPEN;
    public $isNewRecord = true;

    private static $_polls;

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

    public function close()
    {
        return $this->getGithub()->pullRequestUpdate($this->number, ['state' => 'closed']);
    }

    public function reopen()
    {
        return $this->getGithub()->pullRequestUpdate($this->number, ['state' => 'open']);
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

    /**
     * @return Question
     */
    public function getPoll()
    {
        if (static::$_polls === null) {
            static::$_polls = Question::find()
                ->where(['type' => Question::TYPE_CODE_POLL_REQUEST])
                ->indexBy('relation_id')
                ->all();
        }
        return @static::$_polls[$this->getRelationId()];
    }

    public function getRelationId()
    {
        return $this->url . '?' . $this->sha;
    }
}