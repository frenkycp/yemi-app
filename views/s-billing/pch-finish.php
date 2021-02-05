<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\form\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\CutiTbl $model
*/

$this->title = [
    'page_title' => 'Edit Remark <span class="text-green japanesse"></span>',
    'tab_title' => 'Edit Remark',
    'breadcrumbs_title' => 'Edit Remark'
];
?>
<div class="giiant-crud cuti-tbl-update">

    <div class="cuti-tbl-form">

    <?php $form = ActiveForm::begin([
    'id' => 'WipPlanActualReport',
    //'layout' => 'horizontal',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-danger',
    'options' => ['enctype' => 'multipart/form-data'],
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
            <div class="col-md-12">
                <?php
                echo $form->field($model, 'attachment')->widget(\kartik\file\FileInput::className(), [
                    'options' => ['accept' => 'pdf'],
                    'pluginOptions' => [
                        'allowedFileExtensions' => ['pdf'],
                        'showPreview' => false,
                        'showCaption' => true,
                        'showRemove' => true,
                        'showUpload' => false
                    ],
                ])->label(false);
                ?>
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
