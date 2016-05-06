<?php
/**
 * PullRequest class file.
 * @copyright (c) 2016, Pavel Bariev
 * @license http://www.opensource.org/licenses/bsd-license.php
 */
namespace app\modules\code\models;


use app\modules\code\components\Github;
use app\modules\poll\helpers\ModelHelper;
use app\modules\poll\models\Question;
use yii\base\Model;
use yii\base\ModelEvent;
use yii\data\ArrayDataProvider;
/**
 * Description.
 *
 * Usage:
 * @author Pavel Bariev <bariew@yandex.ru>
 *
 */
class PullRequest extends Model
{
    const EVENT_BEFORE_MERGE = 'beforeMerge';
    const EVENT_BEFORE_CLOSE = 'beforeClose';
    const EVENT_BEFORE_REOPEN = 'beforeReopen';

    const STATE_OPEN = 'open';
    const STATE_CLOSED = 'closed';


    /**
     * @var string variables from github
     */
    public $url, $title, $number, $login, $sha;
    public $state = self::STATE_OPEN;
    public $isNewRecord = true;

    /**
     * @var null|Question[] models polls storage
     */
    private static $_polls;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['state'], 'in', 'range' => array_keys(static::stateList())],
            [['url', 'title', 'number', 'login', 'sha'], 'safe'],
        ];
    }

    /**
     * Searches pull requests in Github
     * @param array $params
     * @return ArrayDataProvider
     */
    public function search($params = [])
    {
        $rows = $this->getGithub()->pullRequestList(array_merge([
            'state' => $this->state,
        ], $params));
        return new ArrayDataProvider([
            'allModels' => static::populateAll($rows),
        ]);
    }

    /**
     * Merges pull request
     * @param null|string $message
     * @return array
     */
    public function merge($message = null)
    {
        $this->trigger(static::EVENT_BEFORE_MERGE, new ModelEvent());
        return !$this->errors && $this->getGithub()->pullRequestMerge($this->number, $this->sha, $message);
    }

    /**
     * Closes pull request
     * @return array
     */
    public function close()
    {
        $this->trigger(static::EVENT_BEFORE_CLOSE, new ModelEvent());
        return $this->getGithub()->pullRequestUpdate($this->number, ['state' => 'closed']);
    }

    /**
     * Reopens pull request
     * @return array
     */
    public function reopen()
    {
        $this->trigger(static::EVENT_BEFORE_REOPEN, new ModelEvent());
        return $this->getGithub()->pullRequestUpdate($this->number, ['state' => 'open']);
    }

    /**
     * Generates self models from an array of data
     * @param $rows
     * @return self[]
     * @see app\modules\code\models\PullRequest::populate()
     */
    public static function populateAll($rows)
    {
        $result = [];
        foreach ($rows as $row) {
            $result[] = static::populate($row);
        }
        return $result;
    }

    /**
     * Creates model from a data array
     * @param $row
     * @return static
     */
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

    /**
     * Available state list
     * @return array
     */
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
     * Gets the last poll related to this pull request
     * @return Question
     */
    public function getPoll()
    {
        if (static::$_polls === null) {
            static::$_polls = Question::find()
                ->where(['like', 'relation_id', get_class($this)])
                ->indexBy('relation_id') // this will get only the last code poll
                ->all();
        }
        return @static::$_polls[ModelHelper::getRelationId($this)];
    }

    /**
     * "ID" for the request
     * @return string
     */
    public function getId()
    {
        return $this->number . '_' . $this->sha;
    }

    /**
     * Gets request github url for the poll.
     * @return string
     */
    public function getPollUrl()
    {
        return static::getGithub()->pullRequestUrl($this->number);
    }
}