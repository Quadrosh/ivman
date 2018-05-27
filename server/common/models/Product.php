<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $code
 * @property string $vendor_code
 * @property string $name
 * @property string $description
 * @property string $category
 * @property int $case_qnt
 * @property string $status
 * @property int $created_at
 * @property int $updated_at
 */
class Product extends \yii\db\ActiveRecord
{
    public $allColors = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

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
    public function rules()
    {
        return [
            [[
                'description',
                'material',
                'details',
                'category',
                'detail_icons',
                'attention'
            ], 'string'],
            [['default_color_id','case_qnt', 'created_at', 'updated_at'], 'integer'],
            [['code', 'vendor_code', 'name',  'made_in', 'status'], 'string', 'max' => 255],
            [['default_image',], 'string', 'max' => 510],
            [['code',], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'vendor_code' => 'Vendor Code',
            'name' => 'Name',
            'description' => 'Description',
            'category' => 'Category',
            'material' => 'Материал',
            'details' => 'Подробнее',
            'attention' => 'Обратите внимание',
            'case_qnt' => 'Case Qnt',
            'status' => 'Status',
            'default_color_id' => 'Default color id',
            'default_image' => 'Default Image',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    /**
     * Безопасные поля
     *
     * @return array
     */
    public function fields()
    {
        if(Yii::$app->controller->action->uniqueId == 'product/index' ||
            Yii::$app->controller->action->uniqueId == 'by/category'){
            return [
                'id',
                'code',
                'name',
                'default_image',
                'retail' => function ($q) {
                    $price = PriceAssign::find()
                        ->where(['product_id'=>$q['id']])
                        ->andWhere(['size_id'=>null])
                        ->andWhere(['color_id'=>null])
                        ->one();

                    return $price['value'];
                },
                'colors' => function ($q) {
                    $r = [];
                    foreach ($q->colors as $index=>$color) {
                        $r[$index]['icon'] = $color->icon['cloudname'];
                        $r[$index]['id'] = $color['id'];
                        $r[$index]['image'] = $color->mainImageFile['cloudname'];
                    }
                    return $r;
                },
            ];
        }
        elseif (Yii::$app->controller->action->uniqueId == 'product/view'){
            return [
                'id',
                'code',
                'vendor_code',
                'name',
                'default_image',
                'default_color_id',
                'material',
                'details',
                'attention',
                'made_in',
                'sales_points'=> function ($q) {
                    $r = [];
                    foreach ($q->salesPoints as $index=>$point) {
                        $r[$index] = $point['name'];
                    }
                    return $r;
                },
                'category',
                'case_qnt',
                'colors' => function ($q) {
                    $r = [];
                    foreach ($q->colors as $index=>$color) {
                        $r[$index]['icon'] = $color->icon['cloudname'];
                        $r[$index]['name'] = $color['name'];
                        $r[$index]['id'] = $color['id'];
                        $r[$index]['image'] = $color->mainImageFile['cloudname'];
                        foreach ($color->images as $imageIndex=>$image) {
                            $r[$index]['images'][$imageIndex]=$image->imagefile['cloudname'];
                        }
                    }
                    return $r;
                },
                'detail_icons' => function ($q) {
                    $r = [];
                    $arrDirty = explode('/',$q['detail_icons']);
                    foreach ($arrDirty as $index=>$iconDirty) {
                        $id = str_replace('-','',$iconDirty);
                        if ($id == null) {
                            break;
                        }
                        $icon = ProductDetailIcon::find()->where(['id'=>$id])->one();
                        $r[$index]['icon'] = $icon->imagefile['cloudname'];
                        $r[$index]['name'] = $icon['name'];
                    }
                    return $r;

                },
                'price_types' => function ($q) {
                    return $this->priceTypes;
                },
                'prices' => function ($q) {
                    return $this->priceTable();
                },
                'sizes' => function ($q) {
                    $r = [];
                    $sizes = $q->sizes;
                    if ($sizes) {
                        foreach ($sizes as $index=>$size) {
                            $r[$index]['id'] = $size['id'];
                            $r[$index]['name'] = $size['name'];
                            $r[$index]['box_qnt'] = $size['case_qnt'];
                        }
                    }

                    return $r;
                },
            ];
        } else {
            return
                [
                    'id',
                    'code',
                    'vendor_code',
                    'name',
                    'description',
                    'category',
                    'case_qnt',
                    'status'

                ];
        }


    }






    /**
     * Images
     */
    public function getColors()
    {
        return $this->hasMany(ProductColor::className(),['product_id'=>'id']);
    }

    /**
     * Color
     */
    public function getDefaultColor()
    {
        return $this->hasOne(ProductColor::class,['id'=>'default_color_id']);
    }

    /**
     * Color
     */
    public function getDefaultImage()
    {
        return $this->hasOne(Imagefiles::class,['cloudname'=>'default_image']);
    }

    /**
     * sales points
     */
    public function getSalesPoints()
    {
        return $this->hasMany(ProductSalesPoint::className(),['product_id'=>'id']);
    }

    /**
     * Price types
     */
    public function getPriceTypes()
    {
        return $this->hasMany(Price::className(),['id'=>'price_id'])
            ->viaTable('price_assign',['product_id'=>'id']);

    }

    /**
     * Price assign
     */
    public function getPriceAssigns()
    {
        return $this->hasMany(PriceAssign::className(),['product_id'=>'id']);
    }

    /**
     * Sizes
     */
    public function getSizes()
    {
        return $this->hasMany(ProductSize::className(),['product_id'=>'id']);
    }

    public function priceTable()
    {
        $q = $this;
        $r = [];
        $prices = $q->priceAssigns;
        $defaultPrice = [];
        $allSizes = [];
        if ($prices) {
            foreach ($prices as $price) {
                if (!$price['color_id'] && !$price['size_id']) {
                    $defaultPrice[$price['price_id']] = $price['value'];
                }
            }
            foreach ($q->sizes as $sizeName) {
                $allSizes[]=$sizeName['name'];
            }

            foreach ($q->colors as $colorIndex => $color) {         //    цвет
                $defaultColorPrice = [];
                $r[$colorIndex]['color_name'] =  $color['name'];
                $r[$colorIndex]['sizes'] = $allSizes;
                foreach ($prices as $priceIndex => $price) {
                    if ($price['color_id'] == $color['id']  && !$price['size_id']) {
                        $defaultColorPrice[$price['price_id']] = $price['value'];
                    }
                }

                foreach ($prices as $priceIndex => $price) {
                    foreach ($q->sizes as $sizeIndex => $size) {


                        if ($price['color_id'] == $color['id'] && $price['size_id'] == $size['id']) {  // заполнен размер и это он
                            $r[$colorIndex]['color_prices'][$price->priceType['name']][$size['name']] =  $price['value'];
                        } else {
                            if (isset($defaultColorPrice[$price['price_id']])) {
                                $r[$colorIndex]['color_prices'][$price->priceType['name']][$size['name']] =
                                    $defaultColorPrice[$price['price_id']];
                            } else {
                                $r[$colorIndex]['color_prices'][$price->priceType['name']][$size['name']] =
                                    $defaultPrice[$price['price_id']];

                            }
                        }

                    }
                }
            }


        }
        return $r;
    }
}
