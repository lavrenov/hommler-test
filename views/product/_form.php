<?php

use app\models\Type;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Product $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="product-form">
	<?php $form = ActiveForm::begin(); ?>
	<?php
	if (!empty($model->image)) {
		?>
        <div class="d-flex align-items-center">
			<?php
			$img = Yii::getAlias('@webroot') . $model->image;
			if (is_file($img)) {
				$url = Yii::getAlias('@web') . $model->image;
				echo Html::img($url, ['class' => 'mb-3', 'width' => 50, 'alt' => $model->name]);
			}
			?>
			<?= $form->field($model, 'removeImage')->checkbox(['label' => 'Удалить изображение', 'class' => 'ms-3']) ?>
        </div>
		<?php
	}
	?>
	<?= $form->field($model, 'image')->fileInput() ?>
	<?= $form->field($model, 'sku')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'stock_units')->textInput() ?>
	<?= $form->field($model, 'type_id')->dropDownList(ArrayHelper::map(Type::find()->all(), 'id', 'name')) ?>
    <div class="form-group">
		<?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
	<?php ActiveForm::end(); ?>
</div>
