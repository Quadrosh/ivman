<?php

namespace backend\controllers;

use common\models\UploadForm;
use Yii;
use common\models\Imagefiles;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ImagefilesController implements the CRUD actions for Imagefiles model.
 */
class ImagefilesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Imagefiles models.
     * @return mixed
     */
    public function actionIndex()
    {
        Url::remember();
        $uploadmodel = new UploadForm();
        $dataProvider = new ActiveDataProvider([
            'query' => Imagefiles::find(),
            'pagination'=> [
                'pageSize' => 100,
            ],
            'sort' =>[
                'defaultOrder'=> [
                    'id' => SORT_DESC
                ]
            ]
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'uploadmodel' => $uploadmodel,
        ]);
    }

    /**
     * Displays a single Imagefiles model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        Url::remember();
        $uploadmodel = new UploadForm();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'uploadmodel' => $uploadmodel,
        ]);
    }

    /**
     * Creates a new Imagefiles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Imagefiles();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Imagefiles model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(Url::previous());
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Imagefiles model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if(!$model['cloudname']){
            if(file_exists(Yii::$app->basePath.'/web/img/'.$model->name)){
                if(!unlink(Yii::$app->basePath.'/web/img/'.$model->name)) {
                    Yii::$app->session->setFlash('error', 'неполучается удалить файл');
                }
            }
            if(!$model->delete()) {
                Yii::$app->session->setFlash('error', 'неполучается удалить запись');
            }
        } else {

            if(!$model->delete()) {
                Yii::$app->session->setFlash('error', 'неполучается удалить запись из базы');
            }

        }
        return $this->redirect(Url::previous());
    }

    /**
     * Finds the Imagefiles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Imagefiles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Imagefiles::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     * Change existing image file with keeping file name
     */
    public function actionChange($id)
    {
        $uploadmodel = new UploadForm();


        $mImageFile = Imagefiles::find()->where(['id'=>$id])->one();
        if (Yii::$app->request->isPost) {
            $uploadmodel->imageFile = UploadedFile::getInstance($uploadmodel, 'imageFile');

            $fileName = $uploadmodel->imageFile->baseName.'.'.$uploadmodel->imageFile->extension;
            if ($uploadmodel->uploadtmp()) {
                $cloud = \Cloudinary\Uploader::upload(Yii::getAlias('@webroot/img/tmp-'. $fileName),
                    [
                        "public_id" => $mImageFile['cloudname'],
                        "invalidate" => true,
                    ]);

                $mImageFile['cloudname'] = $cloud['public_id'];
                if($mImageFile->save()){
                    unlink(Yii::getAlias('@webroot/img/tmp-' . $fileName));
                    Yii::$app->session->setFlash('success', 'Файл загружен успешно');
                    return $this->redirect(Url::previous());
                } else {
                    Yii::$app->session->setFlash('error', 'Ошибка сохранения');
                }
            }
        }





    }
    /**
     * Upload images
     */
    public function actionUpload()
    {
        $uploadmodel = new UploadForm();
        if (Yii::$app->request->isPost) {
            $uploadmodel->imageFile = UploadedFile::getInstance($uploadmodel, 'imageFile');
            if ($uploadmodel->upload()) {
                Yii::$app->session->setFlash('success', 'Файл загружен успешно');
            }
            return $this->redirect(Url::previous());
        }
    }

    public function actionCloud()
    {
        $uploadmodel = new UploadForm();
        if (Yii::$app->request->isPost) {
            $uploadmodel->imageFile = UploadedFile::getInstance($uploadmodel, 'imageFile');
            $fileName = $uploadmodel->imageFile->baseName.'.'.$uploadmodel->imageFile->extension;
            if ($uploadmodel->uploadtmp()) {
                $cloud = \Cloudinary\Uploader::upload(Yii::getAlias('@webroot/img/tmp-'. $fileName));
                $imageListItem = new Imagefiles();
                $imageListItem['name'] = $fileName;
                $imageListItem['cloudname'] = $cloud['public_id'];
                if($imageListItem->save()){
                    unlink(Yii::getAlias('@webroot/img/tmp-' . $fileName));
                    Yii::$app->session->setFlash('success', 'Файл загружен успешно');
                    return $this->redirect(Url::previous());
                } else {
                    Yii::$app->session->setFlash('error', 'Ошибка сохранения');
                }
            }
        }

    }










}



//Квадрат и прямоугольник  GA
//200 x 200	Малый квадрат
//240 x 400	Вертикальный прямоугольник
//250 x 250	Квадрат
//250 x 360	Тройное широкоэкранное объявление
//300 x 250	Встраиваемый прямоугольник
//336 x 280	Большой прямоугольник
//580 x 400	Netboard

//1,25:1 (5:4)
//1,33:1 (4:3)    18×24
//1,5:1 (3:2)

