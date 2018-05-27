<?php
namespace api\controllers;

use common\models\Order;
use common\models\OrderItem;
use common\models\Product;
use common\models\User;
use common\models\UserIdentity;
use yii\rest\ActiveController;
use Yii;
use yii\helpers\Json;

use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\filters\RateLimiter;
use yii\web\Response;


//class OrderController extends RestActiveController
class OrderController extends RestController
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
                    [
                        'actions' => [ 'add-items' ],
                        'allow'   => '@'
                    ],
//                    [
//                        'allow' => true,
//                        'roles' => ['Admin'],
//                    ],
                    [
                        'actions' => [ 'orders','options'],
                        'allow'   => true
                    ],
//                    [
//                        'actions' => [ 'logout' ],
//                        'allow'   => '@'
//                    ],

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

    public function actionOrders()
    {
        Yii::info([
            'action'=>'OrderController  orders',
            'input_post'=>Yii::$app->request->post(),
            'input_get'=>Yii::$app->request->get(),
        ], 'api');
        $headers = Yii::$app->request->headers;
        $bearer = $headers->get('authorization');
        $authToken = substr($bearer,7);
        $user = UserIdentity::findIdentityByAccessToken($authToken);
        $orders = Order::find()->where(['user_id'=>$user['id']])->all();
        if ($orders) {
            return $orders; //  ['orders'=> $orders];
        } else {
            return 'заказов не найдено';
        }



    }
    public function actionAddItems()
    {
        Yii::info([
            'action'=>'OrderController add items',
            'input_post'=>Yii::$app->request->post(),
        ], 'api');

        $clientOrder = Yii::$app->request->post();
        $sOrder = new Order();
        $headers = Yii::$app->request->headers;
        $bearer = $headers->get('authorization');
        $authToken = substr($bearer,7);

        $user = UserIdentity::findIdentityByAccessToken($authToken);

        $sOrder['user_id']=$user['id'];

        $sOrder->save();

        $res='';
        if ($clientOrder['items']) {
            foreach ($clientOrder['items'] as $item) {
                $orderItem = new OrderItem();
                $orderItem['order_id'] = $sOrder['id'];
                $orderItem['qnt']=$item['qnt'];
                $orderItem['product_id']=$item['product_id'];
                $orderItem['product_size_id']=$item['size_id'];
                $orderItem['product_color_id']=$item['color_id'];
                $orderItem['price'] = $item['price'];
                $orderItem['price_type'] = $item['priceTypeCode'];
                $orderItem['sum_item'] = $item['sum_item'];
                if ($orderItem->save()) {
                    $res='Все добавилось удачно';
                } else {
                    $res='Что-то не получилось. '.PHP_EOL.print_r($orderItem->errors,true);
                    Yii::info([
                        'action'=>' $orderItem->save() failed',
                        'errors'=>$orderItem->errors,
                    ], 'api');
                }


            }
        }

        return $res ;
    }


    public function actionCreate()
    {
        Yii::info([
            'action'=>'OrderController create',
            'input_post'=>Yii::$app->request->post(),
        ], 'api');

        $clientOrder = Yii::$app->request->post();
        $sOrder = new Order();
        $headers = Yii::$app->request->headers;
        $bearer = $headers->get('authorization');
        $authToken = substr($bearer,7);

        $user = UserIdentity::findIdentityByAccessToken($authToken);


        $sOrder['user_id']=$user['id'];


        $sOrder->save();

        if ($clientOrder['items']) {
            foreach ($clientOrder['items'] as $item) {
                $orderItem = new OrderItem();
                $orderItem['order_id'] = $sOrder['id'];
                $orderItem['qnt']=$item['qnt'];
                $orderItem['product_id']=$item['product_id'];
                $orderItem['product_size_id']=$item['size_id'];
                $orderItem['product_color_id']=$item['color_id'];
                $orderItem['price'] = $item['price'];
                $orderItem['price_type'] = $item['priceTypeCode'];
                $orderItem['sum_item'] = $item['sum_item'];
                $orderItem->save();

            }
        }


        return 'its cool, all created, man)';
    }

    public function actionOptions(){
        return ['code'=>200];
    }

}

