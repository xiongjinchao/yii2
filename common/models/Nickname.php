<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%nickname}}".
 *
 * @property integer $id
 * @property string $nickname
 */
class Nickname extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%nickname}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nickname'], 'required'],
            [['nickname'], 'string', 'max' => 255],
            [['nickname'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nickname' => 'Nickname',
        ];
    }
}
