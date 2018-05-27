<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "menu_item".
 *
 * @property int $id
 * @property int $menu_id
 * @property int $parent_id
 * @property string $icon
 * @property string $name
 * @property string $link
 * @property int $num_order
 */
class MenuItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_id', 'parent_id', 'num_order'], 'integer'],
            [['name'], 'required'],
            [['icon', 'name', 'link'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'menu_id' => 'Menu ID',
            'parent_id' => 'Parent ID',
            'icon' => 'Icon',
            'name' => 'Name',
            'link' => 'Link',
            'num_order' => 'Num Order',
        ];
    }
}
