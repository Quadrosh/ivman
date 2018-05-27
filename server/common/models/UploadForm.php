<?php

namespace common\models;

use backend\controllers\ImagefilesController;
use yii\base\Action;
use yii\base\Model;
use yii\web\UploadedFile;
use Yii;
use common\models\Imagefiles;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;
    public $toModelId;
    public $toModelProperty;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, svg'],
        ];
    }

    public function upload($add1=false,$add2=false)
    {
        $imageRecord = new Imagefiles();

        if ($this->validate() && $imageRecord->addNew($add1.$this->imageFile->baseName . $add2.'.' . $this->imageFile->extension)) {
            if ($this->imageFile->saveAs('img/' . $add1 . $this->imageFile->baseName . $add2 .'.' . $this->imageFile->extension)) {
                return true;
            } else {
                return false;
            }
        }
    }
    public function uploadtmp()
    {
        if ($this->validate()) {
            if ($this->imageFile->saveAs('img/tmp-' . $this->imageFile->baseName . '.' . $this->imageFile->extension)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function change($filename)
    {
        if ($this->validate()) {
            if ($this->imageFile->saveAs(Yii::$app->basePath . '/web/img/' . $filename)) {
                return true;
            } else {
                return false;
            }
        }
    }





}