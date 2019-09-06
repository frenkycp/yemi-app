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
    'page_title' => 'Finish Machine Process <span class="text-green japanesse"></span>',
    'tab_title' => 'Finish Machine Process',
    'breadcrumbs_title' => 'Finish Machine Process'
];

$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; color: #82b964;}
    //.form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 20px; height: 40px;}
    .content-header {color: white;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    .box-header .box-title{font-size: 2em;}
    //.container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold; text-align: center;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}

    #progress-tbl{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    #progress-tbl > thead > tr > th{
        border:1px solid #8b8c8d;
        background-color: #595F66;
        color: white;
        font-size: 20px;
        border-bottom: 7px solid #ddd;
        vertical-align: middle;
    }
    #progress-tbl > tbody > tr > td{
        border:1px solid #777474;
        font-size: 20px;
        //background-color: #B3E5FC;
        //font-weight: 1000;
        color: #FFF;
        vertical-align: middle;
    }
");
?>
<div class="giiant-crud cuti-tbl-update">

    <div class="cuti-tbl-form">

    <?php $form = ActiveForm::begin([
    'id' => 'ServerMntMachineCurrent',
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

    <div class="panel panel-primary">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'next_process_id')->dropDownList(
                        ArrayHelper::map(app\models\MachineIotCurrent::find()->select(['kelompok'])->groupBy('kelompok')->orderBy('kelompok')->all(), 'kelompok', 'kelompok'),           // Flat array ('id'=>'label')
                        [
                            'prompt' => '-- Select a group --'
                        ]    // options
                    )->label('Next Process (Leave empty if there is no next process)'); ?>
                </div>
            </div>

            <?php echo $form->errorSummary($model); ?>
        </div>
        <div class="panel-footer">
            <?= Html::submitButton(
            '<span class="glyphicon glyphicon-check"></span> SUBMIT',
            [
            'id' => 'save-' . $model->formName(),
            'class' => 'btn btn-success'
            ]
            );
            ?>

            <?php ActiveForm::end(); ?>
            <?= Html::a('<span class="glyphicon glyphicon-remove"></span> CANCEL', Url::previous(), ['class' => 'btn btn-warning']) ?>
        </div>

        
        <!--<button type="button" class="btn btn-warning" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove"></span> Cancel</button>-->

    </div>

</div>

</div>
