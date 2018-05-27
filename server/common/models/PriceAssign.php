<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "price_assign".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $color_id
 * @property integer $size_id
 * @property integer $price_id
 * @property double $value
 * @property string $comment
 * @property integer $updated_at
 * @property integer $created_at
 */
class PriceAssign extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
//                'updatedAtAttribute' => false,
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'price_assign';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'value'], 'required'],
            [['product_id', 'color_id', 'size_id', 'price_id', 'updated_at', 'created_at'], 'integer'],
            [['value'], 'number'],
            [['comment'], 'string', 'max' => 255],
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
            'color_id' => 'Color ID',
            'size_id' => 'Size ID',
            'price_id' => 'Price ID',
            'value' => 'руб',
            'comment' => 'Комментарий',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * size
     */
    public function getSize()
    {
        return $this->hasOne(ProductSize::class,['product_id'=>'id']);
    }

    /**
     * size
     */
    public function getPriceType()
    {
        return $this->hasOne(Price::class,['id'=>'price_id']);
    }
}
