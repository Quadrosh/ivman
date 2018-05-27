<?php
namespace common\models;

use Yii;
use yii\base\ErrorException;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    public $is_open_access;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'email'    => 'E-mail',
            'password' => 'Пароль',
        ];
    }


    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Неверный логин или пароль.');
                return false;
            }
        }
        return true;
    }


    public function validateAccess()
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user->is_open_access) {
                $this->addError('password','В настоящее время аккаунт не активирован, либо заблокирован.');
                return false;
            }
        }
        return true;

    }

   /*
    * Проверка активирован ли аккаунт
    * */
    public function validateVerification() {
        if ( !$this->hasErrors() ) {
            $user = $this->getUser();

            if ( !empty($user->verification_code) ) {
                $this->addError( 'password', 'Вы не активировали аккаунт. Письмо с активацией было отправлено Вам на почту.' );
                return false;
            }
        }
        return true;
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login() {
        if ( $this->validate() && $this->validateAccess() && $this->validateVerification() ) {
            return Yii::$app->user->login( $this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0 );
        } else {
            if (!$this->validate()) {
                Yii::info([
                    'action'=>'!$this->validate()',
                    'errors'=>$this->errors,
                ], 'back');
            }
            if (!$this->validateAccess()){
                Yii::info([
                    'action'=>'!$this->validateAccess()',
                    'errors'=>$this->errors,
                ], 'back');
            }
            if (!$this->validateVerification()){
                Yii::info([
                    'action'=>'!$this->validateVerification()',
                    'errors'=>$this->errors,
                ], 'back');
            }

            throw new ErrorException('ERROR (Дальше еще не придумал). Обратитесь в службу поддержки.');

            return false;
        }
    }

    /**
     * Finds user by email
     *
     * @return UserIdentity|null
     */
    public function getUser() {
        if ( $this->_user === false ) {
            $this->_user = UserIdentity::findByEmail( $this->email );
        }
        return $this->_user;
    }
}
