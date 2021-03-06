<?php

namespace app\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $name_ca
 * @property string $name_es
 * @property string $name_en
 * @property string $description_ca
 * @property string $description_es
 * @property string $description_en
 * @property ActiveQuery $articles
 * @property int $priority
 */
class Category extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'code',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_ca', 'name_es', 'name_en', 'code'], 'required'],
            [['code'], 'unique'],
            [['priority'], 'integer'],
            [['name_ca', 'name_es', 'name_en', 'color_hex', 'slug'], 'string', 'max' => 30],
            [['description_ca', 'description_es', 'description_en'], 'string', 'max' => 220],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'code' => Yii::t('app', 'code'),
            'name_ca' => Yii::t('app', 'name'),
            'name_es' => Yii::t('app', 'name'),
            'name_en' => Yii::t('app', 'name'),
            'description_ca' => Yii::t('app', 'description'),
            'description_es' => Yii::t('app', 'description'),
            'description_en' => Yii::t('app', 'description'),
            'priority' => Yii::t('app', 'priority'),
            'color_hex' => Yii::t('app', 'color'),
        ];
    }

    /**
     * @return ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['category_id' => 'id']);
    }
}
