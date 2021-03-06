<?php
/**
 * User class file.
 * @copyright (c) 2015, Pavel Bariev
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace app\modules\user\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use Yii;
 
/**
 * Application user model.
 * 
 * 
 * @author Pavel Bariev <bariew@yandex.ru>
 * 
 * @property integer $id
 * @property string $auth_key
 * @property string $email
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property string $password_reset_token
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            [['email'], 'unique'],
            [['password'], 'string', 'min' => 2, 'max' => 255],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email'        => Yii::t('modules/user', 'Email'),
            'password'     => Yii::t('modules/user', 'Password'),
            'created_at'   => Yii::t('modules/user', 'Created At'),
            'updated_at'   => Yii::t('modules/user', 'Updated At'),
            'auth_key'     => Yii::t('modules/user', 'Auth key'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_user}}';
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
        ];
    }

    /**
     * @return array
     */
    public static function listAll()
    {
        return static::find()->indexBy('id')
            ->select(['(CONCAT("user_",id))'])
            ->column();
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($auth_key, $type = NULL)
    {
        static::findOne(compact('auth_key'));
    }

    /**
     * Finds user by password reset token
     *
     * @param  string      $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        $expire    = \Yii::$app->getModule('user')->params['resetTokenExpireSeconds'];
        $parts     = explode('_', $token);
        $timestamp = (int) end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
            return null;
        }

        return static::findOne(['password_reset_token' => $token]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key == $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password original password.
     * @return string hashed password.
     */
    public function generatePassword($password)
    {
        return Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        return $this->auth_key = md5(Yii::$app->security->generateRandomKey());
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = md5(Yii::$app->security->generateRandomKey()) . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        if ($insert && !$this->auth_key) {
            $this->generateAuthKey();
        }
        if ($insert || $this->isAttributeChanged('password')) {
            $this->password = $this->generatePassword($this['password']);
        }
        return true;
    }
}
