<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\form\ActiveForm;
use kartik\select2\Select2;

/**
* @var yii\web\View $this
* @var app\models\CutiTbl $model
*/

$this->title = [
    'page_title' => 'Add Invoice Number <span class="text-green japanesse"></span>',
    'tab_title' => 'Add Invoice Number',
    'breadcrumbs_title' => 'Add Invoice Number'
];
?>
<div class="giiant-crud cuti-tbl-update">

    <div class="cuti-tbl-form">

    <?php $form = ActiveForm::begin([
    'id' => 'WipPlanActualReport',
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

    <div class="">
        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($model, 'invoice_no')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\SupplierBilling::find()->where(['stage' => 2])->andWhere('voucher_no IS NULL')->all(), 'no', 'invoice_no'),
                    'options' => ['placeholder' => 'Select invoice ...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'multiple' => true
                    ],
                ]); ?>
            </div>
        </div>

        <?php echo $form->errorSummary($model); ?>

        <?= Html::submitButton(
        '<span class="fa fa-fw fa-check"></span> SUBMIT',
        [
        'id' => 'save-' . $model->formName(),
        'class' => 'btn btn-success'
        ]
        );
        ?>

        <?php ActiveForm::end(); ?>
        <button type="button" class="btn btn-warning" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove"></span> Cancel</button>

    </div>

</div>

</div>
