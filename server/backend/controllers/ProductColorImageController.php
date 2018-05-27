<?php

namespace backend\controllers;

use common\models\Imagefiles;
use common\models\ProductColor;
use common\models\UploadForm;
use Yii;
use common\models\ProductColorImage;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ProductColorImageController implements the CRUD actions for ProductColorImage model.
 */
class ProductColorImageController extends Controller
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
     * Lists all ProductColorImage models.
     * @return mixed
     */
    public function actionIndex()
    {
        Url::remember();
        $dataProvider = new ActiveDataProvider([
            'query' => ProductColorImage::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductColorImage model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        Url::remember();
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ProductColorImage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProductColorImage();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(Url::previous());
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ProductColorImage model.
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
     * Deletes an existing ProductColorImage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $image = $this->findModel($id);
        $imageFile = $image->imagefile;

        $imageFile->delete();
        $image->delete();

        return $this->redirect(Url::previous());
    }

    /**
     * Finds the ProductColorImage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductColorImage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductColorImage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionAddColorIcon()
    {
        $uploadmodel = new UploadForm();
        $data=Yii::$app->request->post('UploadForm');
        $colorId = $data['toModelProperty'];
        $productColor = ProductColor::find()->where(['id'=>$colorId])->one();


        if (Yii::$app->request->isPost) {
            $uploadmodel->imageFile = UploadedFile::getInstance($uploadmodel, 'imageFile');
            $fileName = $uploadmodel->imageFile->baseName.'.'.$uploadmodel->imageFile->extension;
            if ($uploadmodel->uploadtmp()) {
                $cloud = \Cloudinary\Uploader::upload(Yii::getAlias('@webroot/img/tmp-'. $fileName));
                $imageListItem = new Imagefiles();
                $imageListItem['name'] = $uploadmodel->imageFile->baseName.
                    time().'.'.$uploadmodel->imageFile->extension;
                $imageListItem['cloudname'] = $cloud['public_id'];
                if($imageListItem->save()){
                    unlink(Yii::getAlias('@webroot/img/tmp-' . $fileName));
                    Yii::$app->session->setFlash('success', 'Файл загружен успешно');

                    $productColor['icon_img_id'] = $imageListItem['id'];
                    if ($productColor->save()) {
                        return $this->redirect(Url::previous());
                    } else {
                        Yii::$app->session->setFlash('error', 'ошибка добавления иконки');
                    }

                } else {
                    Yii::$app->session->setFlash('error', 'Ошибка сохранения');
                }
            }
        }

    }


    public function actionAddColorImage($colorId)
    {
        $uploadmodel = new UploadForm();
        $colorImage = new ProductColorImage();

        if (Yii::$app->request->isPost) {
            $uploadmodel->imageFile = UploadedFile::getInstance($uploadmodel, 'imageFile');
            $fileName = $uploadmodel->imageFile->baseName.'.'.$uploadmodel->imageFile->extension;
            if ($uploadmodel->uploadtmp()) {
                $cloud = \Cloudinary\Uploader::upload(Yii::getAlias('@webroot/img/tmp-'. $fileName));
                $imageListItem = new Imagefiles();
                $imageListItem['name'] = $uploadmodel->imageFile->baseName.
                    time().'.'.$uploadmodel->imageFile->extension;
                $imageListItem['cloudname'] = $cloud['public_id'];
                if($imageListItem->save()){
                    unlink(Yii::getAlias('@webroot/img/tmp-' . $fileName));
                    Yii::$app->session->setFlash('success', 'Файл загружен успешно');
                    $colorImage['color_id']=$colorId;
                    $colorImage['imagefile_id']=$imageListItem['id'];
                    if ($colorImage->save()) {
                        $color = $colorImage->color;
                        if ($color['main_img_id']==null || count($color->images)==1) {
                            $color['main_img_id'] = $colorImage['id'];
                            $color->save();
                        }
                        $product = $color->product;
                        if (!$product->defaultImage) {
                            $product['default_image'] = $imageListItem['cloudname'];
                            $product->save();
                        }
                        return $this->redirect(Url::previous());
                    } else {
                        Yii::$app->session->setFlash('error', 'ошибка добавления цвета');
                    }

                } else {
                    Yii::$app->session->setFlash('error', 'Ошибка сохранения');
                }
            }
        }

    }

    public function actionSetMain($colorId, $imageId)
    {
        $color = ProductColor::find()->where(['id'=>$colorId])->one();
        $color['main_img_id']=$imageId;
        if ($color->save()) {
            $product = $color->product;
            if ($product['default_color_id']==$color['id']) {
                $image = ProductColorImage::find()->where(['id'=>$imageId])->one();
                $product['default_image']=$image->imagefile['cloudname'];
                $product->save();
            }
            return $this->redirect(Url::previous());
        } else {
            Yii::$app->session->setFlash('error', 'ошибка назначения основного цвета');
        }

    }
}
