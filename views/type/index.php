<?php

use yii\bootstrap5\LinkPager;
use yii\grid\ActionColumn;
use yii\grid\CheckboxColumn;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TypeSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Типы товаров';
$this->params['breadcrumbs'][] = $this->title;

$pages = $dataProvider->getPagination();
?>
<div class="type-index">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h1 class="mb-0"><?= Html::encode($this->title) ?></h1>
		<?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </div>
	<?php echo $this->render('_search', ['model' => $searchModel]); ?>
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
            'name',
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
