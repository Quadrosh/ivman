<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_detail_icon".
 *
 * @property integer $id
 * @property string $name
 * @property string $type
 * @property integer $imagefile_id
 */
class ProductDetailIcon extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_detail_icon';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['imagefile_id'], 'integer'],
            [['name'], 'required'],
            [['name', 'type'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'type' => 'Type',
            'imagefile_id' => 'Imagefile ID',
        ];
    }

    public function getImagefile()
    {
        return $this->hasOne(Imagefiles::class,['id'=>'imagefile_id']);
    }
}
