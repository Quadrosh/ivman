<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pages".
 *
 * @property int $id
 * @property string $site
 * @property string $hrurl
 * @property string $seo_logo
 * @property string $title
 * @property string $description
 * @property string $keywords
 * @property string $pagehead
 * @property string $pagedescription
 * @property string $text
 * @property string $imagelink
 * @property string $imagelink_alt
 * @property string $sendtopage
 * @property string $promolink
 * @property string $promoname
 * @property string $view
 * @property string $layout
 */
class Pages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hrurl', 'seo_logo', 'title', 'description', 'keywords', 'pagehead', 'pagedescription', 'imagelink_alt', 'sendtopage', 'promolink', 'promoname'], 'required'],
            [['seo_logo', 'description', 'keywords', 'pagedescription', 'text'], 'string'],
            [['site', 'hrurl', 'title', 'pagehead', 'imagelink', 'imagelink_alt', 'sendtopage', 'promolink', 'promoname', 'view', 'layout'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'site' => 'Site',
            'hrurl' => 'Hrurl',
            'seo_logo' => 'Seo Logo',
            'title' => 'Title',
            'description' => 'Description',
            'keywords' => 'Keywords',
            'pagehead' => 'Pagehead',
            'pagedescription' => 'Pagedescription',
            'text' => 'Text',
            'imagelink' => 'Imagelink',
            'imagelink_alt' => 'Imagelink Alt',
            'sendtopage' => 'Sendtopage',
            'promolink' => 'Promolink',
            'promoname' => 'Promoname',
            'view' => 'View',
            'layout' => 'Layout',
        ];
    }
}
