<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_sales_point".
 *
 * @property int $id
 * @property int $product_id
 * @property int $sort_order
 * @property string $name
 * @property string $description
 * @property string $status
 */
class ProductSalesPoint extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_sales_point';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'sort_order'], 'integer'],
            [['description'], 'string'],
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
            'sort_order' => 'Sort Order',
            'name' => 'Name',
            'description' => 'Description',
            'status' => 'Status',
        ];
    }
}
