<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[BasicPage]].
 *
 * @see BasicPage
 */
class BasicPageQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return BasicPage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return BasicPage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
