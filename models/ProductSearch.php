<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Product;
use yii\data\Sort;

/**
 * ProductSearch represents the model behind the search form of `app\models\Product`.
 */
class ProductSearch extends Product
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Product::find()->joinWith(['type']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort' => new Sort([
				'attributes' => [
					'sku',
					'name',
					'stock_units',
					'type.name'
				],
			]),
			'pagination' => [
				'pageSize' => 10
			]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->filterWhere(['like', Product::tableName() . '.name', $this->name])
            ->orFilterWhere(['like', Product::tableName() . '.sku', $this->name]);

        return $dataProvider;
    }
}
