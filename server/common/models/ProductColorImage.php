<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_color_image".
 *
 * @property integer $id
 * @property integer $color_id
 * @property integer $imagefile_id
 * @property string $status
 */
class ProductColorImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_color_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['color_id', 'imagefile_id'], 'integer'],
            [['status'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'color_id' => 'Color ID',
            'imagefile_id' => 'Imagefile ID',
            'status' => 'Status',
        ];
    }

    /**
     * Image file
     */
    public function getImagefile()
    {
        return $this->hasOne(Imagefiles::class,['id'=>'imagefile_id']);
    }

    /**
     * Color
     */
    public function getColor()
    {
        return $this->hasOne(ProductColor::class,['id'=>'color_id']);
    }
}
