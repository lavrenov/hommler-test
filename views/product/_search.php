<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ProductSearch $model */
?>

<div class="product-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
		'fieldConfig' => [
			'template' => "{input}\n{hint}\n{error}",
			'options' => [
				'tag' => false
			],
		],
    ]); ?>
    <div class="d-flex form-group">
		<?= $form->field($model, 'name')->textInput(['placeholder' => 'Название или SKU']) ?>
		<?= Html::submitButton('Найти', ['class' => 'btn btn-primary ms-2']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
