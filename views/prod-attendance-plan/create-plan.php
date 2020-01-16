<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\date\DatePicker;

$this->title = [
    'page_title' => 'Create MP Plan <span class="japanesse text-green"></span>',
    'tab_title' => 'Create MP Plan',
    'breadcrumbs_title' => 'Create MP Plan'
];

$this->registerCss("
    .form-group {
        margin-bottom: 0px;
    }
");

?>

<div class="klinik-input-form">

    <?php $form = ActiveForm::begin([
    'id' => 'KlinikInput',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-danger',
    ]
    );
    ?>

    <div class="panel panel-primary">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'manpower')->textArea(['style' => 'resize: none;', 'rows' => 20]); ?>
                </div>
                <div class="col-md-6">

                    <?= $form->field($model, 'location')->dropDownList($location_arr, [
                        'prompt' => 'Choose location...'
                    ]); ?>

                    <?= $form->field($model, 'shift')->dropDownList([
                        1 => 1,
                        2 => 2,
                        3 => 3,
                    ]); ?>
                    
                    <div class="form-group">
                        <?php echo '<label class="control-label">Select date range</label>';
                        echo DatePicker::widget([
                            'model' => $model,
                            'attribute' => 'from_date',
                            'attribute2' => 'to_date',
                            'options' => ['placeholder' => 'Start date'],
                            'options2' => ['placeholder' => 'End date'],
                            'type' => DatePicker::TYPE_RANGE,
                            'form' => $form,
                            'pluginOptions' => [
                                'format' => 'yyyy-mm-dd',
                                'autoclose' => true,
                            ]
                        ]);?>
                    </div>
                </div>
                
            </div>
            

            <?php echo $form->errorSummary($model); ?>
        </div>
        <div class="panel-footer">
            <?= Html::submitButton(
            '<span class="glyphicon glyphicon-check"></span> Create',
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

