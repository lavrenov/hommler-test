<?php

use yii\bootstrap5\LinkPager;
use yii\grid\ActionColumn;
use yii\grid\CheckboxColumn;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ProductSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var array $columnSet */

$this->title = 'Товары';
$this->params['breadcrumbs'][] = $this->title;

$pages = $dataProvider->getPagination();
?>
<div class="product-index">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h1 class="mb-0"><?= Html::encode($this->title) ?></h1>
		<?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </div>
	<?= $this->render('_search', ['model' => $searchModel]) ?>
    <?= $this->render('_column', ['columnSet' => $columnSet]) ?>
	<?php $form = ActiveForm::begin([
		'action' => ['delete']
	]); ?>
	<?= GridView::widget([
		'id' => 'grid-view',
		'dataProvider' => $dataProvider,
		'layout' => "{summary}\n{items}",
		'columns' => [
			[
				'class' => SerialColumn::class
			],
			[
				'attribute' => 'image',
				'format' => 'raw',
				'value' => function ($model) {
					return $model->image ? Html::img($model->image, ['width' => 50, 'alt' => $model->name]) : '';
				},
				'visible' => ArrayHelper::isIn('image', $columnSet),
			],
			[
				'attribute' => 'sku',
				'visible' => ArrayHelper::isIn('sku', $columnSet),
			],
			[
				'attribute' => 'name',
				'visible' => ArrayHelper::isIn('name', $columnSet),
			],
			[
				'attribute' => 'stock_units',
				'visible' => ArrayHelper::isIn('stock_units', $columnSet),
			],
			[
				'attribute' => 'type.name',
				'visible' => ArrayHelper::isIn('type', $columnSet),
			],
			[
				'class' => ActionColumn::class,
				'template' => '{update}'
			],
			[
				'class' => CheckboxColumn::class,
				'name' => 'id',
				'checkboxOptions' => function ($model) {
					return [
						'value' => $model->id
					];
				}
			],
		],
	]); ?>
    <div class="form-group text-end">
		<?= Html::submitButton('Удалить выбранные', ['data-confirm' => 'Вы действительно хотите удалить выбранные элементы', 'class' => 'btn btn-danger', 'id' => 'btn-remove', 'disabled' => true]) ?>
    </div>
	<?= LinkPager::widget(['pagination' => $pages, 'options' => ['class' => 'pagination justify-content-center'], 'maxButtonCount' => 7]) ?>
	<?php ActiveForm::end(); ?>
</div>
