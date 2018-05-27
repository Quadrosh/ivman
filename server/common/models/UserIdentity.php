<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the identity class for table "user".
 *
 * @property int $id
 * @property string $fist_name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property string $other_contacts
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $access_token
 * @property string $auth_key
 * @property string $verification_code
 * @property string $is_open_access
 * @property string $about
 * @property string $zip
 * @property string $street
 * @property string $city
 * @property string $state
 * @property string $country
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 */
class UserIdentity extends ActiveRecord implements IdentityInterface
{


    public $username;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * Дефолтное условие выборки
     *
     * @return \yii\db\ActiveQuery
     */
    public static function find()
    {
        return parent::find()->where(['deleted_at' => null]);
    }


    /**
     * Безопасные поля
     *
     * @return array
     */
    public function fields()
    {

        $fields = [
            'id',
            'email',
            'username'=> function ( $q ) {
                return $q->first_name.$q->last_name;
            },
            'first_name',
            'last_name',
            'access_token',
            'roles' => function ( $q ) {
                return $q->roles;
            }
        ];

        return $fields;
    }




    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne( (int) $id );
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne( [ 'access_token' => $token ] );
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->auth_key;
    }


    /**
     * @inheritdoc
     */
    public function validateAuthKey( $authKey ) {
        return $this->auth_key === $authKey;
    }


    public function validatePassword( $password ) {
        return Yii::$app->security->validatePassword( $password, $this->password_hash );
    }


    /**
     * @param $email
     *
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function findByEmail( $email ) {
        return static::findOne( [ 'email' => $email ] );
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoles() {
        return $this->hasMany( RolesItem::className(), [ 'name' => 'item_name' ] )
            ->viaTable( 'auth_assignment', [ 'user_id' => 'id' ] )
            ->select( 'name' )
            ->andWhere( 'type = 1' )
            ->column();
    }

}
