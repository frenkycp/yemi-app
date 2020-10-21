<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\SubFixAssetSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="asset-dtr-tbl-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'dateacqledger') ?>

		<?= $form->field($model, 'faid') ?>

		<?= $form->field($model, 'subexp') ?>

		<?= $form->field($model, 'fixed_asset_subid') ?>

		<?= $form->field($model, 'voucher_number') ?>

		<?php // echo $form->field($model, 'deliveryorder') ?>

		<?php // echo $form->field($model, 'invoice') ?>

		<?php // echo $form->field($model, 'type') ?>

		<?php // echo $form->field($model, 'partnumberfa') ?>

		<?php // echo $form->field($model, 'kategori') ?>

		<?php // echo $form->field($model, 'description') ?>

		<?php // echo $form->field($model, 'date_of_payment') ?>

		<?php // echo $form->field($model, 'vendorid') ?>

		<?php // echo $form->field($model, 'vendor') ?>

		<?php // echo $form->field($model, 'currency') ?>

		<?php // echo $form->field($model, 'qty') ?>

		<?php // echo $form->field($model, 'price_unit') ?>

		<?php // echo $form->field($model, 'rate') ?>

		<?php // echo $form->field($model, 'at_cost') ?>

		<?php // echo $form->field($model, 'depr_date') ?>

		<?php // echo $form->field($model, 'order_numb') ?>

		<?php // echo $form->field($model, 'proposalnumb') ?>

		<?php // echo $form->field($model, 'budgetnumber') ?>

		<?php // echo $form->field($model, 'docbc') ?>

		<?php // echo $form->field($model, 'vouhpayment') ?>

		<?php // echo $form->field($model, 'proposalno') ?>

		<?php // echo $form->field($model, 'invoicescan') ?>

		<?php // echo $form->field($model, 'smartid') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
