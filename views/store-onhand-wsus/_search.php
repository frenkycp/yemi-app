<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\StoreOnhandWsusSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="store-onhand-wsus-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'ITEM') ?>

		<?= $form->field($model, 'ITEM_DESC') ?>

		<?= $form->field($model, 'UM') ?>

		<?= $form->field($model, 'ONHAND_QTY') ?>

		<?= $form->field($model, 'PI_DUMMY') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
