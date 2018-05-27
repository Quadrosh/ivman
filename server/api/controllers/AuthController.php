<?php
namespace api\controllers;

use common\models\Category;
use common\models\LoginForm;
use common\models\Product;
use common\models\User;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\filters\RateLimiter;
use yii\helpers\Json;
use yii\rest\ActiveController;
use yii\web\Response;
use Yii;

class AuthController extends RestController
{

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [

            'contentNegotiator' => [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'authenticator' => [
                'class' => HttpBearerAuth::className(),
                'only' => [ 'logout'],
            ],

            'access' => [
                'class' => AccessControl::className(),
//                'only' => ['logout'],
                'rules' => [
//                    [
//                        'allow' => true,
//                        'roles' => ['Admin'],
//                    ],
                    [
                        'actions' => [ 'signup', 'login','options'],
                        'allow'   => true
                    ],
                    [
                        'actions' => [ 'logout' ],
                        'allow'   => '@'
                    ],

                ],
            ],
            'corsFilter'  => [
                'class' => \yii\filters\Cors::class,
                'cors'  => [
                    // restrict access to domains:
                    'Origin'                           => static::allowedDomains(),
                    'Access-Control-Request-Method'    => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                    'Access-Control-Allow-Methods'    => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                    'Access-Control-Allow-Credentials' => true,
//                    'Access-Control-Allow-Credentials' => false,
                    'Access-Control-Max-Age'           => 3600,                 // Cache (seconds)

                    'Access-Control-Request-Headers' => ['*'],
                ],

            ],
        ]);
    }

    public static function allowedDomains()
    {
        return [
            // '*',                        // star allows all domains
            'http://localhost:4200',
        ];
    }

    public function actionLogin($isAdmin = false)
    {


        $oLoginModel = new LoginForm();
        $oLoginModel->attributes = Yii::$app->request->post();
        $isLogin = $oLoginModel->login();

        Yii::info([
            'action'=>'authController $isLogin',
            '$isLogin'=>$isLogin,
        ], 'api');

        if ($isAdmin && $isLogin && !Yii::$app->user->can('Admin')) {
            $isLogin = false;
            $oLoginModel->addError('password','Недостаточно прав');
        }

        if ($isLogin) {
            $user = $oLoginModel->getUser();
            $authToken = $user['access_token'];
            $user['access_token'] = null;
            return [
                'user'=>$oLoginModel->getUser(),
                'token'=>$authToken
            ];
        }
//        return $isLogin ? $oLoginModel->getUser() : $oLoginModel;


    }


    public function actionLogout()
    {
        return ['success' => 'Вы успешно вышли из аккаунта'];
    }


    public function actionSignup()
    {


        $email = Yii::$app->request->post('email');

       $exist = User::find()->where(['email'=>$email])->one();
        if ($exist) {
            return ['error' => 'пользователь с email '.$email.' уже зарегистрирован'];
        } else {

            $user = User::create(Yii::$app->request->post('user'));
            if ($user) {
                return ['success' => 'На email '.$user['email'].' отправлен запрос на подтверждение. <br>Подтвердите email для авторизации на сайте'];
            } else {

                if (isset($user->errors['username'])) {
                    return ['error' => 'Имя пользователя '. $user['username'].' уже занято. Попробуйте другое'];
                } elseif (isset($user->errors['email'])){
                    return ['error' => 'пользователь с email '. $user['email'].' уже зарегистрирован. <br> Проверьте почту или зарегистриуйте другой email'];
                } else {
                    return ['error' => 'Ошибка добавления нового пользователя. Для регистрации свяжитесь с нами по телефону. Подробнее об ошибке:'.print_r($user->errors,true)];
                }
            }
        }
    }

    public function actionOptions(){
        return ['code'=>200];
    }

}


