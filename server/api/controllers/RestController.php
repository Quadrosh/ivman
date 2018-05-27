<?php
namespace api\controllers;

use yii\rest\Controller;

class RestController extends Controller
{
    public static function allowedDomains()
    {
        return [
            // '*',                  // allows all domains
            'http://localhost:4200',
        ];
    }
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'corsFilter'  => [
                'class' => \yii\filters\Cors::class,
                'cors'  => [
                    'Origin'                           => static::allowedDomains(),
                    'Access-Control-Request-Method'    => ['POST','GET','OPTIONS'],
                    'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Max-Age'           => 3600,
                    'Access-Control-Request-Headers' => ['*'],
                ],
            ],
        ]);
    }

//    public function beforeAction($action)
//    {
//        if (\Yii::$app->getRequest()->getMethod() == 'OPTIONS') {
//            return ['code'=>200];
//        } else {
//            return parent::beforeAction($action);
//        }
//    }



//    public function beforeAction($action)
//    {
//        $this->enableCsrfValidation = false;
//        return parent::beforeAction($action);
//    }
}



//                'cors' => [
//                    // restrict access to
//                    'Origin' => ['http://localhost:4200', 'https://www.myserver.com'],
////                    'Access-Control-Request-Method' => ['POST', 'PUT'],
//                    // Allow only POST and PUT methods
////                    'Access-Control-Request-Headers' => ['X-Wsse'],
//                    // Allow only headers 'X-Wsse'
////                    'Access-Control-Allow-Credentials' => true,
//                    // Allow OPTIONS caching
////                    'Access-Control-Max-Age' => 3600,
//                    // Allow the X-Pagination-Current-Page header to be exposed to the browser.
////                    'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
//                ],