<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Type $model */

$this->title = 'Редактировать';
$this->params['breadcrumbs'][] = ['label' => 'Типы товаров', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="type-update">
    <h1 class="mb-3"><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
