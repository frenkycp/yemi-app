<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\form\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\CutiTbl $model
*/

$this->title = [
    'page_title' => 'Create Scrap Request <span class="text-green japanesse"></span>',
    'tab_title' => 'Create Scrap Request',
    'breadcrumbs_title' => 'Create Scrap Request'
];
?>
<div class="live-cooking-request-form">

    <?php $form = ActiveForm::begin([
    'id' => 'LiveCookingRequest',
    //'layout' => 'horizontal',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-danger',
    ]
    );
    ?>
    <div class="panel panel-primary">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-3">
                    <?= $form->field($model, 'SERIAL_NO')->textInput(['readonly' => true]); ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'ITEM')->textInput(['readonly' => true]); ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'ITEM_DESC')->textInput(['readonly' => true]); ?>
                </div>
            </div>
            
            

            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'SUPPLIER_DESC')->textInput(['readonly' => true]); ?>
                </div>
                <div class="col-sm-2">
                    <?= $form->field($model, 'QTY')->textInput(['readonly' => true]); ?>
                </div>
                <div class="col-sm-2">
                    <?= $form->field($model, 'UM')->textInput(['readonly' => true]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <?= $form->field($model, 'EXPIRED_DATE')->textInput(['readonly' => true]); ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'LATEST_EXPIRED_DATE')->textInput(['readonly' => true]); ?>
                </div>
            </div>
            
            
            

            <?php echo $form->errorSummary($model); ?>
        </div>
        <div class="panel-footer">
            <?= Html::submitButton(
            '<span class="glyphicon glyphicon-check"></span> ' .
            ($model->isNewRecord ? 'Submit' : 'Save'),
            [
            'id' => 'btn-submit',
            'class' => 'btn btn-success'
            ]
            );
            ?>
            <?= Html::a(
            'Cancel',
            \yii\helpers\Url::previous(),
            ['class' => 'btn btn-warning']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>