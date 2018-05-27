<?php

namespace common\models;

use Yii;
use yii\base\ErrorException;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\IdentityInterface;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $fist_name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property string $other_contacts
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $access_token
 * @property string $auth_key
 * @property string $verification_code
 * @property string $is_open_access
 * @property string $about
 * @property string $zip
 * @property string $street
 * @property string $city
 * @property string $state
 * @property string $country
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 */
class User extends ActiveRecord
{

    const ROLE_A = 'Admin';
    const ROLE_U = 'User';

    public static $aRoles = [self::ROLE_A, self::ROLE_U];

    public $password;



    public $roles = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }


    /**
     * Дефолтное условие выборки
     *
     * @return \yii\db\ActiveQuery
     */
    public static function find()
    {
        return parent::find()->where(['deleted_at' => null]);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['first_name', 'auth_key', 'password_hash', 'email'], 'required'],
            [['created_at', 'updated_at', 'deleted_at'], 'integer'],
            [[
                'first_name',
                'last_name',
                'email',
                'phone',
                'password',
                'password_hash',
                'password_reset_token',
                'street',
                'city',
                'state',
                'zip',
                'country'
            ], 'string', 'max' => 255],
            [['other_contacts'], 'string', 'max' => 510],
            [[
                'auth_key',
                'access_token',
                'verification_code',
                'password_reset_token',
            ], 'string', 'max' => 32],
            [['email'], 'unique'],
            [['is_open_access'], 'boolean'],
            [['about'], 'string'],
            [['about'], 'trim'],

            [['roles'], 'required', 'on' => ['create', 'update']],
            [['roles'], 'safe'],

        ];
    }

    public function scenarios()
    {
        return [
            'login' => ['email', 'password'],
            'register' => [
                'email',
                'password',
                'first_name',
                'last_name',
                'phone'
            ],

            'profile' => [
                'password',
                'first_name',
                'last_name',
                'email',
                'phone',
                'other_contacts',
                'zip',
                'street',
                'city',
                'state',
                'country',
            ],
            'create' => [
                'first_name',
                'last_name',
                'email',
                'phone',
                'password',


                'roles',
            ],
            'update' => [
                'email',
                'password',
                'first_name',
                'last_name',
                'phone',
                'roles',
                'is_open_access',
                'verification_code'
            ],
            'delete' => ['deleted_at'],
            'verification' => ['verification_code'],
            'isOpenAccess' => ['is_open_access'],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'email' => 'Email',
            'phone' => 'Телефон',
            'other_contacts' => 'Другие контакты',
            'password' => 'Пароль',

            'street' => 'Улица и дом',
            'city' => 'Город',
            'state' => 'Регион',
            'zip' => 'Индекс',
            'country' => 'Страна',

        ];
    }


    /**
     * Безопасные поля
     *
     * @return array
     */
    public function fields()
    {

        $fields = [
            'id',
            'first_name',
            'last_name',
            'about',

        ];

        if (Yii::$app->user->can('Admin')) {
            $fields = ArrayHelper::merge($fields, [
                'phone',
                'email',
                'verification_code',
                'is_open_access' => function ($q) {
                    return $q->is_open_access ? true : false;
                },
                'created_at',
                'roles' => function ($q) {
                    return $q->getRoles();
                },

            ]);
        }

        return $fields;
    }

    public function extraFields()
    {
        return ['country', 'city','zip','state','street'];
    }


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
//        return static::findOne( (int) $id );
        return UserIdentity::findIdentity($id);
    }

    /**
     * @param $email
     *
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    public function setAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword()
    {
        if (!empty($this->password)) {
            $this->password_hash = Yii::$app->security->generatePasswordHash($this->password);
        }
    }


    public function setAccessToken()
    {
        $this->access_token = Yii::$app->security->generateRandomString();
    }

    public function setVerificationCode()
    {
        $this->verification_code = Yii::$app->security->generateRandomString(30);
    }

    /**
     * Установка дефолтной роли
     */
    public function setUserRole()
    {
        \Yii::$app->authManager->assign(\Yii::$app->authManager->getRole(self::ROLE_U), $this->id);
    }


    /**
     *
     * Создать пользователя
     *
     * @param $attributes
     *
     * @return User
     */
    public static function create($attributes, $scenario = 'register')
    {

        $oUser = new self;

        $oUser->setScenario($scenario);

        $oUser->attributes = $attributes;

        $oUser->setAuthKey();

        $oUser->setPassword();

        $oUser->setAccessToken();

        $oUser->setVerificationCode();

        if ($oUser->save()) {
            $oUser->setUserRole();
            $oUser->sendEmailVerification();
        }

        if ($oUser->errors) {
            return false;
        }
        return $oUser;
    }



    public function sendEmailVerification()
    {
        Yii::$app->mailer->compose('sign-up-verification', ['oUser' => $this])
            ->setFrom(Yii::$app->params['noreplyEmail'])
            ->setTo($this->email)
            ->setSubject('★ Пожалуйста, подтвердите адрес Вашей электронной почты')
            ->send();
    }



    /**
     *
     * @param $id
     * @param $attributes
     *
     * @return static
     */
    public static function edit($attributes, $id = null, $scenario = 'profile')
    {

        if ($id !== null) {
            $oUser = self::findOne((int)$id);
        } else {
            $oUser = Yii::$app->user->identity;
        }

        $oUser->setScenario($scenario);

        $oUser->attributes = $attributes;
        $oUser->is_open_access = $attributes['is_open_access'] ? 1 : 0;

        $oUser->setPassword();

        $oUser->save();

        return $oUser;
    }


    /**
     * @return bool|int
     * @throws ErrorException
     */
    public function delete()
    {

//        if ($this->id == Yii::$app->user->identity->id) {
//            throw new ErrorException('Невозможно удалить свою учетную запись');
//        }

        $this->setScenario('delete');
        $this->deleted_at = time();

        return $this->save();
    }

    /**
     * Удалить пользователя по ID
     *
     * @param $id
     *
     * @return bool|int|void
     * @throws NotFoundHttpException
     */
    public static function deleteById($id)
    {

        $oModel = self::findOne($id);

        if (!$oModel) {
            throw new NotFoundHttpException('Пользователь не найден.');
        }

        return $oModel->delete();
    }

    public function afterSave($insert, $changedAttributes)
    {

        if (Yii::$app->user->can('Admin') && $this->id !== Yii::$app->user->identity->id) {

            Yii::$app->authManager->revokeAll($this->id);

            foreach ($this->roles as $role) {

                Yii::$app->authManager->assign(Yii::$app->authManager->getRole($role), $this->id);
            }
        }

        parent::afterSave($insert, $changedAttributes);
    }


//    RELATIONS



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignments()
    {
        return $this->hasMany(RolesAssignment::className(), ['user_id' => 'id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoles()
    {
        return $this->hasMany(RolesItem::className(), ['name' => 'item_name'])->viaTable('auth_assignment',
            ['user_id' => 'id'])
            ->select('name')->andWhere('type = 1')->column();
    }



    /**
     * @param string $password password to validate
     *
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }




    /**
     * Верификация аккаунта
     *
     * @param $token
     *
     * @return array
     * @throws BadRequestHttpException
     * @throws ErrorException
     */
    public static function verification($token)
    {

        $oUser = self::find()->andWhere(['verification_code' => $token])->one();

        if (!$oUser) {
            throw new BadRequestHttpException('Аккаунт уже подтвержден или ссылка не верна.
            Войдите на сайт используя данные, указанные при регистрации, либо свяжитесь с нами по телефону.');
        }

        $oUser->setScenario('verification');

        $oUser->verification_code = null;

        $oUser->is_open_access = 1;

        if ($oUser->save()) {
            return [
                'first_name' => $oUser->first_name
            ];
        } else {
            throw new ErrorException('Ошибка верификации аккаунта. Обратитесь в службу поддержки.');
        }
    }


    /**
     * Открытие доступа в систему с уведомлением
     *
     * @param $id
     *
     * @return static
     * @throws BadRequestHttpException
     * @throws ErrorException
     */
    public static function sendInvitation($id)
    {
        $oUser = self::findOne((int)$id);

        if (!$oUser) {
            throw new BadRequestHttpException('Неверный id пользователя.');
        }

        if (!$oUser->roles) {
            throw new ErrorException('Нельзя открыть доступ. Назначьте роли доступа.');
        }

        $oUser->setScenario('isOpenAccess');
        $oUser->is_open_access = 1;

        if ($oUser->save()) {
            Yii::$app->mailer->compose('sign-up-invitation', ['oUser' => $oUser])
                ->setFrom(Yii::$app->params['noreplyEmail'])
                ->setTo($oUser->email)
                ->setSubject('★ Вы успешно зарегистрированы!')
                ->send();
        }

        return $oUser;
    }


//    OLD style
    public function sendConfirmation($password)
    {

        return Yii::$app->mailer->compose()
            ->setTo($this->email)
            ->setFrom('sender@ivmanufaktura.ru')
            ->setSubject('Подтверждение регистрации на сайте ivmanufaktura.ru')
            ->setHtmlBody(
                "Подтверждение регистрации <br>".
                "Вы зарегистрировались на сайте ivmanufaktura.ru <br>".

                " <br/> для подтверждения регистрации пройдите по ссылке: ".
                "http://".Yii::$app->params['site']."/user/confirm/".$this->authKey .
                " <br/> После подтвеждения регитстрации Вы сможете войти под именем: ".$this->username.
                " <br/> Email: ".$this->email.
                " <br/> Сгенерированный пароль: ".$password.
                " <br/> В целях безопасности рекомендуем сменить сгенерированный пароль по ссылке: "."http://".Yii::$app->params['site'] ."/user/change_password"
            )
            ->send();


    }
}
