<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\ShipCarrierDataSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="ship-liner-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'SEQ') ?>

		<?= $form->field($model, 'COUNTRY') ?>

		<?= $form->field($model, 'POD') ?>

		<?= $form->field($model, 'FLAG_PRIORITY') ?>

		<?= $form->field($model, 'FLAG_DESC') ?>

		<?php // echo $form->field($model, 'CARRIER') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
