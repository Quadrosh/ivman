<?php
namespace api\controllers;

use yii\rest\ActiveController;

class RestActiveController extends ActiveController
{
    public static function allowedDomains()
    {
        return [
            // '*',                        // star allows all domains
            'http://localhost:4200',
        ];
    }
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [

            'corsFilter'  => [
                'class' => \yii\filters\Cors::class,
                'cors'  => [
                    // restrict access to domains:
                    'Origin'                           => static::allowedDomains(),
                    'Access-Control-Request-Method'    => ['POST','GET'],
                    'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Max-Age'           => 3600,                 // Cache (seconds)
                    'Access-Control-Request-Headers' => ['*'],

                ],
            ],
        ]);
    }
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