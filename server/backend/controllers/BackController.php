<?php


namespace backend\controllers;


use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class BackController extends Controller
{

    public function behaviors()
    {
//        \Yii::$app->user->loginUrl = ['/admin/default/login'];
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'except' => ['login', 'error'],
                'rules' => [
                    // allow authenticated users
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    // everything else is denied
                    [
                        'allow' => false,
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
}