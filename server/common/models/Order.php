<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "orders".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $address_id
 * @property string $wrap
 * @property string $shipping_type
 * @property string $user_comment
 * @property string $admin_comment
 * @property string $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Order extends \yii\db\ActiveRecord
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
        return 'orders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'address_id', 'created_at', 'updated_at'], 'integer'],
            [['user_comment', 'admin_comment'], 'string'],
            [['wrap', 'shipping_type', 'status'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'address_id' => 'Address ID',
            'wrap' => 'Wrap',
            'shipping_type' => 'Shipping Type',
            'user_comment' => 'User Comment',
            'admin_comment' => 'Admin Comment',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    /**
     * Sizes
     */
    public function getItems()
    {
        return $this->hasMany(OrderItem::className(),['order_id'=>'id']);
    }

    /**
     * Sizes
     */
    public function getUser()
    {
        return $this->hasOne(User::className(),['id'=>'user_id']);
    }
}
