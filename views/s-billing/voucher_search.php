<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\SBillingSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="supplier-billing-search">

    <?php $form = ActiveForm::begin([
    'action' => ['waiting-payment'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'voucher_no') ?>

		<?= $form->field($model, 'supplier_name') ?>

		<?= $form->field($model, 'id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
