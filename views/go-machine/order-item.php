<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\form\ActiveForm;
use kartik\datetime\DateTimePicker;

/**
* @var yii\web\View $this
* @var app\models\CutiTbl $model
*/

$this->title = [
    'page_title' => 'GO-MACHINE Order Item <span class="text-green japanesse"></span>',
    'tab_title' => 'GO-MACHINE Order Item',
    'breadcrumbs_title' => 'GO-MACHINE Order Item'
];

date_default_timezone_set('Asia/Jakarta');

$this->registerJs("
    $(document).ready(function() {
        $('#request_time').change(function(){
            if(this.value != ''){
                $('#order-btn').removeAttr('disabled');
            } else {
                $('#order-btn').attr('disabled', 'disabled');
            }
        });
    });
");
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
        <div class="panel panel-primary">
            <div class="panel panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'mesin_id')->textInput(['readonly' => true])->label('Machine ID') ?>
                        <?= $form->field($model, 'mesin_group')->textInput(['readonly' => true])->label('Machine Group') ?>
                        <?= $form->field($model, 'machine_desc')->textInput(['readonly' => true])->label('Machine Name') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'model')->textInput(['readonly' => true])->label('Model') ?>
                        <div class="form-group">
                            <label for="color">Color</label>
                            <?= Html::textInput('model_color', null, [
                                'class' => 'form-control',
                                'onkeyup' => "this.value = this.value.toUpperCase();",
                                'maxlength' => 10
                            ]); ?>
                        </div>
                        <div class="form-group">
                            <label for="request_time">Request For</label>
                            <?= DateTimePicker::widget([
                                'name' => 'dp_1',
                                'id' => 'request_time',
                                'readonly' => true,
                                //'value' => date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:00') . ' + 1 hour')),
                                'type' => DateTimePicker::TYPE_COMPONENT_PREPEND,
                                'pluginOptions' => [
                                    'autoclose'=>true,
                                    'format' => 'yyyy-mm-dd hh:ii:ss',
                                    'startDate' => date('Y-m-d 00:00:01'),
                                    'endDate' => date('Y-m-d 23:59:59')
                                ],
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php echo $form->errorSummary($model); ?>

        <?= Html::submitButton(
        '<span class="glyphicon glyphicon-check"></span> ORDER',
        [
        'id' => 'order-btn',
        'class' => 'btn btn-success',
        'disabled' => true
        ]
        );
        ?>

        <?php ActiveForm::end(); ?>
        <button type="button" class="btn btn-warning" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove"></span> Cancel</button>

    </div>

</div>

</div>
