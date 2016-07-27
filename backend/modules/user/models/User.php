<?php

namespace backend\modules\user\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use backend\models\Picture;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class User extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    public $password;
    public $user_face;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }


    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email'], 'required'],
            [['status', 'picture_id', 'created_at', 'updated_at'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['user_face'], 'file'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'username' => '用户名',
            'password' => '密码',
            'auth_key' => '认证码',
            'password_hash' => '密码',
            'password_reset_token' => '密码重置校验',
            'email' => '邮箱',
            'picture_id' => '头像',
            'user_face' => '头像',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    public function getStatusOptions($status = null)
    {
        $arr = [
            self::STATUS_ACTIVE => '正常',
            self::STATUS_DELETED => '删除',
        ];
        if( $status === null ){
            return $arr;
        }else{
            return isset($arr[$status]) ? $arr[$status] : $status;
        }
    }

    public function getPicture()
    {
        return $this->hasOne(Picture::className(), ['id' => 'picture_id']);
    }
}
