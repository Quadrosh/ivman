<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order_item".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $product_id
 * @property integer $product_size_id
 * @property integer $product_color_id
 * @property string $product_name
 * @property double $price
 * @property integer $qnt
 * @property double $sum_item
 * @property string $comment
 */
class OrderItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'product_id', 'price', 'qnt',], 'required'],
            [['order_id', 'product_id', 'product_size_id', 'product_color_id', 'qnt'], 'integer'],
            [['price', 'sum_item'], 'number'],
            [['product_name','price_type'], 'string', 'max' => 255],
            [['comment'], 'string', 'max' => 510],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'product_id' => 'Product ID',
            'product_size_id' => 'Product Size ID',
            'product_color_id' => 'Product Color ID',
            'product_name' => 'Product Name',
            'price' => 'Price',
            'qnt' => 'Qnt',
            'sum_item' => 'Sum Item',
            'comment' => 'Comment',
        ];
    }
}
