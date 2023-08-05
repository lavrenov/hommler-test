<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var array $columnSet */
?>

<div class="product-column">
	<?php $form = ActiveForm::begin([
		'action' => ['column-set']
	]); ?>
    <div class="d-flex align-items-center form-group">
        <div class="me-3">
			<?= Html::checkbox('columnSet[]', ArrayHelper::isIn('image', $columnSet), ['label' => 'Изображение', 'value' => 'image']) ?>
        </div>
        <div class="me-3">
			<?= Html::checkbox('columnSet[]', ArrayHelper::isIn('sku', $columnSet), ['label' => 'SKU', 'value' => 'sku']) ?>
        </div>
        <div class="me-3">
			<?= Html::checkbox('columnSet[]', ArrayHelper::isIn('name', $columnSet), ['label' => 'Название', 'value' => 'name']) ?>
        </div>
        <div class="me-3">
			<?= Html::checkbox('columnSet[]', ArrayHelper::isIn('stock_units', $columnSet), ['label' => 'Кол-во на складе', 'value' => 'stock_units']) ?>
        </div>
        <div class="me-3">
			<?= Html::checkbox('columnSet[]', ArrayHelper::isIn('type', $columnSet), ['label' => 'Тип товара', 'value' => 'type']) ?>
        </div>
		<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary ms-2']) ?>
    </div>
	<?php ActiveForm::end(); ?>
</div>
