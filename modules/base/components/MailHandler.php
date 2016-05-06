<?php
/**
 * Created by PhpStorm.
 * User: pt
 * Date: 06.05.16
 * Time: 18:50
 */

namespace app\modules\base\components;


use yii\base\Event;
use yii\base\Exception;
use yii\db\ActiveRecord;

class MailHandler
{

    public static function sendToAll(Event $event)
    {
        /** @var ActiveRecord $userClass */
        $userClass = \Yii::$app->user->identityClass;
        return static::sendDefaultData($event, null, $userClass::find()->select('email')->column());
    }

    public static function sendToAuthor(Event $event)
    {
        return static::sendDefaultData($event, null, $event->sender->email);
    }

    public static function sendToAdmin(Event $event)
    {
        return static::sendDefaultData($event, null, \Yii::$app->params['adminEmail']);
    }

    private static function sendDefaultData(Event $event, $from, $to)
    {
        $modelName = preg_replace('#.*\\\\(\w+)\\\\models\\\\(.*)#', '$1 $2', get_class($event->sender));
        $eventName = preg_replace('#.*([A-Z][a-z]+)$#', '$1', $event->name);
        $subject = \Yii::$app->name . ' notification.';
        switch ($eventName) {
            case 'Insert' :
                $body = \Yii::t('app', 'New {model} has been added.', ['model' => $modelName]);
                break;
            case 'Update' :
                $body = \Yii::t('app', '{model} N{ID} has been updated.', ['model' => $modelName, 'ID' => $event->sender->id]);
                break;
            case 'Delete' :
                $body = \Yii::t('app', '{model} N{ID} has been deleted.', ['model' => $modelName, 'ID' => $event->sender->id]);
                break;
            default: throw new Exception("Unexpected model event " . $event->name);
        }
        return static::sendEmail($from, $to, $subject, $body);
    }

    /**
     * Sends Email
     * @param $from
     * @param $to
     * @param $subject
     * @param $body
     * @param array $attachments ['/path/to/file.jpg' => ['fileName' => 'YourFile.jpg', 'contentType'=>'jpeg']]
     * @return bool
     */
    private static function sendEmail($from, $to, $subject, $body, $attachments = [])
    {
        if (!$to || !$body) {
            return true;
        }
        $from = $from ? : \Yii::$app->params['adminEmail'];
        $email = \Yii::$app->mailer->compose();
        foreach ($attachments as $file => $options) {
            $email->attach($file, $options);
        }
        $email->setSubject($subject)
            ->setHtmlBody($body)
            ->setTo($to)
            ->setFrom($from)
            ->send();
    }
}