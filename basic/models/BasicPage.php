<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "basic_page".
 *
 * @property integer $id
 * @property string $title
 * @property string $text
 * @property string $alias
 * @property integer $publish
 */
class BasicPage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'basic_page';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'alias'], 'required'],
            [['text'], 'string'],
            [['publish'], 'integer'],
            [['title'], 'string', 'max' => 300],
            [['alias'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'text' => 'Text',
            'alias' => 'Alias',
            'publish' => 'Publish',
        ];
    }

    /**
     * @inheritdoc
     * @return BasicPageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BasicPageQuery(get_called_class());
    }
}
