<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_detail_icon_type".
 *
 * @property integer $id
 * @property string $name
 */
class ProductDetailIconType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_detail_icon_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
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
        ];
    }
}
