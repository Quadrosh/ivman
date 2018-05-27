<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_color".
 *
 * @property int $id
 * @property int $product_id
 * @property string $name
 * @property string $status
 */
class ProductColor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_color';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id','icon_img_id','main_img_id',], 'integer'],
            [['name', 'status'], 'string', 'max' => 255],
            [['name'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'name' => 'Name',
            'icon_img_id' => 'Icon Img ID',
            'main_img_id' => 'Main Img ID',
            'status' => 'Status',
        ];
    }

    /**
     * Product
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class,['id'=>'product_id']);
    }

    /**
     * Images
     */
    public function getImages()
    {
        return $this->hasMany(ProductColorImage::className(),['color_id'=>'id']);
    }

    /**
     * Icon
     */
    public function getIcon()
    {
        return $this->hasOne(Imagefiles::class,['id'=>'icon_img_id']);
    }

    /**
     * main image
     */
    public function getMainImage()
    {
        return $this->hasOne(ProductColorImage::class,['id'=>'main_img_id']);
    }

    public function getMainImageFile()
    {
        return $this->mainImage->hasOne(Imagefiles::class,['id'=>'imagefile_id']);
    }
}
