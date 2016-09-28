<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%golos_result}}".
 *
 * @property integer $id
 * @property integer $golos_id
 * @property string $result
 *
 * @property Golos $golos
 */
class GolosResult extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%golos_result}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['golos_id'], 'integer'],
            [['result'], 'string'],
            [['golos_id'], 'exist', 'skipOnError' => true, 'targetClass' => Golos::className(), 'targetAttribute' => ['golos_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'golos_id' => 'Golos ID',
            'result' => 'Result',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGolos()
    {
        return $this->hasOne(Golos::className(), ['id' => 'golos_id']);
    }
}
