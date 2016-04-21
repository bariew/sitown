<?php
/**
 * LoginForm class file.
 * @copyright (c) 2015, Pavel Bariev
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace app\modules\user\models;

use Yii;
use yii\base\Model;
 
/**
 * For user login form.
 * 
 * 
 * @author Pavel Bariev <bariew@yandex.ru>
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    protected $_user = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email'    => Yii::t('modules/user', 'Email'),
            'rememberMe'    => Yii::t('modules/user', 'Remember me'),
            'password'    => Yii::t('modules/user', 'Password'),
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     */
    public function validatePassword()
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError('password', 'Incorrect email or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided email and password.
     * @param bool $validate
     * @return boolean whether the user is logged in successfully
     */
    public function login($validate = true)
    {
        if (!$validate || $this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[email]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findOne(['email' => $this->email]);
        }

        return $this->_user;
    }
}
