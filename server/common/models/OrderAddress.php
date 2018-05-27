<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order_address".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $street
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $country
 * @property string $admin_comment
 * @property integer $created_at
 * @property integer $updated_at
 */
class OrderAddress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['admin_comment'], 'string'],
            [['name', 'street', 'city', 'state', 'zip', 'country'], 'string', 'max' => 255],
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
            'name' => 'Name',
            'street' => 'Street',
            'city' => 'City',
            'state' => 'State',
            'zip' => 'Zip',
            'country' => 'Country',
            'admin_comment' => 'Admin Comment',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
