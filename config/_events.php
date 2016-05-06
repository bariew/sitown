<?php return [
    'app\modules\poll\models\Vote' => [
        'afterInsert' => [
            ['app\modules\poll\models\Question', 'voteAfterInsertHandler']
        ],
    ],
    // POLL BLOCK
    'app\modules\user\models\User' => [
        'beforeInsert' => [
            ['app\modules\poll\models\Question', 'modelEventHandler']
        ],
        'beforeUpdate' => [
            ['app\modules\poll\models\Question', 'modelEventHandler']
        ],
        'beforeDelete' => [
            ['app\modules\poll\models\Question', 'modelEventHandler']
        ],
    ],
    'bariew\pageModule\models\Item' => [
        'beforeInsert' => [
            ['app\modules\poll\models\Question', 'modelEventHandler']
        ],
        'beforeUpdate' => [
            ['app\modules\poll\models\Question', 'modelEventHandler']
        ],
        'beforeDelete' => [
            ['app\modules\poll\models\Question', 'modelEventHandler']
        ],
    ],
    'app\modules\code\models\PullRequest' => [
        'beforeMerge' => [
            ['app\modules\poll\models\Question', 'modelEventHandler']
        ],
        'beforeClose' => [
            ['app\modules\poll\models\Question', 'modelEventHandler']
        ],
        'beforeReopen' => [
            ['app\modules\poll\models\Question', 'modelEventHandler']
        ],
    ],
    // EMAILING
    'app\modules\poll\models\Question' => [
        'afterInsert' => [
            ['app\modules\base\components\MailHandler', 'sendToAll']
        ],
    ],
];
