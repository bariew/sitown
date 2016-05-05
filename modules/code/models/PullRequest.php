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
use app\modules\poll\widgets\Poll;
use yii\base\Model;
use yii\base\ModelEvent;
use yii\data\ArrayDataProvider;

class PullRequest extends Model
{
    const EVENT_BEFORE_MERGE = 'beforeMerge';
    const EVENT_BEFORE_CLOSE = 'beforeClose';
    const EVENT_BEFORE_REOPEN = 'beforeReopen';

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
        $this->trigger(static::EVENT_BEFORE_MERGE, new ModelEvent());
        return !$this->errors && $this->getGithub()->pullRequestMerge($this->number, $this->sha, $message);
    }

    public function close()
    {
        $this->trigger(static::EVENT_BEFORE_CLOSE, new ModelEvent());
        return $this->getGithub()->pullRequestUpdate($this->number, ['state' => 'closed']);
    }

    public function reopen()
    {
        $this->trigger(static::EVENT_BEFORE_REOPEN, new ModelEvent());
        return $this->getGithub()->pullRequestUpdate($this->number, ['state' => 'open']);
    }

    public static function populateAll($rows)
    {
        $result = [];
        foreach ($rows as $row) {
            $result[] = static::populate($row);
        }
        return $result;
    }

    public static function populate($row)
    {
        return new static([
            'url' => @$row['html_url'],
            'title' => @$row['title'],
            'number' =>  @$row['number'],
            'state' =>  @$row['state'],
            'login' =>  @$row['user']['login'],
            'sha' =>  @$row['head']['sha'],
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
                ->where(['like', 'relation_id', get_class($this)])
                ->indexBy('relation_id')
                ->all();
        }
        return @static::$_polls[Question::getRelationId($this)];
    }

    public function getId()
    {
        return $this->number . '_' . $this->sha;
    }

    public function getPollUrl()
    {
        return static::getGithub()->pullRequestUrl($this->number);
    }
}