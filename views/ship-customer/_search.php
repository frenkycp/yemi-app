<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\ShipCustomerSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="ship-customer-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'customer_code') ?>

		<?= $form->field($model, 'customer_desc') ?>

		<?= $form->field($model, 'port_name') ?>

		<?= $form->field($model, 'country_name') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
