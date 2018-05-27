<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_size".
 *
 * @property int $id
 * @property int $product_id
 * @property string $name
 * @property string $description
 * @property int $case_qnt
 * @property string $status
 */
class ProductSize extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_size';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'case_qnt'], 'integer'],
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
            'name' => 'Name',
            'description' => 'Description',
            'case_qnt' => 'Case Qnt',
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
}
