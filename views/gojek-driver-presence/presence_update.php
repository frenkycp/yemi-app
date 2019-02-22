<?php

use yii\helpers\Html;

use kartik\form\ActiveForm;

$this->title = [
    'page_title' => 'Presence Update <span class="text-green japanesse"></span>',
    'tab_title' => 'Presence Update',
    'breadcrumbs_title' => 'Presence Update'
];
?>
<div class="giiant-crud gojek-tbl-update">

    <div class="gojek-tbl-form">

        <?php $form = ActiveForm::begin([
        'id' => 'GojekTbl',
        'enableClientValidation' => true,
        'errorSummaryCssClass' => 'error-summary alert alert-danger',
        ]);
        ?>

        <div class="">
            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'GOJEK_ID')->textInput(['readonly' => true])->label('NIK') ?>
                    <?= $form->field($model, 'GOJEK_DESC')->textInput(['readonly' => true])->label('Employe Name') ?>
                    <?= $form->field($model, 'HADIR')->dropDownList([
                        'Y' => 'YES',
                        'N' => 'NO'
                    ])->label('Attendance') ?>
                </div>
            </div>
            
            <hr/>

            <?php echo $form->errorSummary($model); ?>

            <?= Html::submitButton(
            '<span class="glyphicon glyphicon-check"></span> Submit',
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
