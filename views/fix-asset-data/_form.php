<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\AssetTbl $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="asset-tbl-form">

    <?php $form = ActiveForm::begin([
    'id' => 'AssetTbl',
    //'layout' => 'horizontal',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-danger',
    /*'fieldConfig' => [
             'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
             'horizontalCssClasses' => [
                 'label' => 'col-sm-2',
                 #'offset' => 'col-sm-offset-4',
                 'wrapper' => 'col-sm-8',
                 'error' => '',
                 'hint' => '',
             ],
         ],*/
    ]
    );
    ?>
    <div class="box-body">
            
<!-- attribute asset_id -->
			<?= $form->field($model, 'asset_id')->textInput(['placeholder' => 'Enter fixed asset ID', 'readonly' => !$model->isNewRecord ? true : false]) ?>

<!-- attribute qr -->
			<?= $form->field($model, 'qr')->textInput(['placeholder' => 'Enter QR Code']) ?>

<!-- attribute computer_name -->
			<?= $form->field($model, 'computer_name')->textInput(['placeholder' => 'Enter description'])->label('Fix Asset Description') ?>

<!-- attribute jenis -->
			<?= $form->field($model, 'jenis')->dropDownList(ArrayHelper::map(app\models\AssetTbl::find()
            ->select([
                'jenis'
            ])
            ->where([
                'FINANCE_ASSET' => 'Y'
            ])
            ->andWhere('jenis IS NOT NULL')
            ->groupBy('jenis')
            ->orderBy('jenis')
            ->all(), 'jenis', 'jenis'), [
                'prompt' => 'Select type or category'
            ])->label('Type') ?>

<!-- attribute fixed_asst_account -->
			<?= $form->field($model, 'fixed_asst_account')->textInput() ?>

<!-- attribute location -->
			<?= $form->field($model, 'location')->textInput() ?>

<!-- attribute area -->
			<?= $form->field($model, 'area')->textInput() ?>

<!-- attribute cur -->
			<?= $form->field($model, 'cur')->textInput() ?>

<!-- attribute manager_name -->
			<?= $form->field($model, 'manager_name')->textInput() ?>

<!-- attribute department_pic -->
			<?= $form->field($model, 'department_pic')->textInput() ?>

<!-- attribute cost_centre -->
			<?= $form->field($model, 'cost_centre')->textInput() ?>

<!-- attribute department_name -->
			<?= $form->field($model, 'department_name')->textInput() ?>

<!-- attribute section_name -->
			<?= $form->field($model, 'section_name')->textInput() ?>

<!-- attribute nik -->
			<?= $form->field($model, 'nik')->textInput() ?>

<!-- attribute NAMA_KARYAWAN -->
			<?= $form->field($model, 'NAMA_KARYAWAN')->textInput() ?>

<!-- attribute primary_picture -->
			<?= $form->field($model, 'primary_picture')->textInput() ?>

<!-- attribute FINANCE_ASSET -->
			<?= $form->field($model, 'FINANCE_ASSET')->dropDownList([
                'Y' => 'Y',
                'N' => 'N',
            ]) ?>

<!-- attribute Discontinue -->
			<?= $form->field($model, 'Discontinue')->dropDownList([
                'Y' => 'Y',
                'N' => 'N',
            ]) ?>

<!-- attribute status -->
			<?= $form->field($model, 'status')->dropDownList(\Yii::$app->params['fixed_asset_status'], [
                'prompt' => '>> Select a status <<'
            ]) ?>

<!-- attribute label -->
			<?= $form->field($model, 'label')->textInput() ?>

<!-- attribute purchase_date -->
			<?= $form->field($model, 'purchase_date')->textInput() ?>

<!-- attribute DateDisc -->
			<?= $form->field($model, 'DateDisc')->textInput() ?>

<!-- attribute report_type -->
			<?= $form->field($model, 'report_type')->textInput() ?>

<!-- attribute price -->
			<?= $form->field($model, 'price')->textInput() ?>

<!-- attribute price_usd -->
			<?= $form->field($model, 'price_usd')->textInput() ?>

<!-- attribute qty -->
			<?= $form->field($model, 'qty')->textInput() ?>

<!-- attribute AtCost -->
			<?= $form->field($model, 'AtCost')->textInput() ?>
        

        <?php echo $form->errorSummary($model); ?>

        </div>
        <div class="box-footer">
            <?= Html::submitButton(
            '<span class="glyphicon glyphicon-check"></span> ' .
            ($model->isNewRecord ? 'Create' : 'Save'),
            [
            'id' => 'save-' . $model->formName(),
            'class' => 'btn btn-success'
            ]
            );
            ?>
            &nbsp;&nbsp;
            <?=             Html::a(
            '<span class="fa fa-undo"></span> Cancel',
            \yii\helpers\Url::previous(),
            ['class' => 'btn btn-warning']) ?>
        </div>
        

        <?php ActiveForm::end(); ?>

    </div>

</div>

