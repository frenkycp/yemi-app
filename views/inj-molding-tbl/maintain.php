<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\date\DatePicker;

$this->title = [
    'page_title' => 'Molding Maintenance <span class="japanesse light-green"></span>',
    'tab_title' => 'Molding Maintenance',
    'breadcrumbs_title' => 'Molding Maintenance'
];

$css_string = "
    #total-time {font-size: 30px;}";
$this->registerCss($css_string);

$this->registerJs("
    function update_data(){
        $.ajax({
            type: 'POST',
            url: '" . Url::to(['maintain-get-time', 'MOLDING_ID' => $model->MOLDING_ID]) . "',
            success: function(data){
                $('#total-time').html(data.time_txt);
                check_overlay();
            },
            complete: function(){
                setTimeout(function(){update_data();}, 1000);
            }
        });
    }

    function check_overlay(){
        if($('#pause-txt').text() == 'CONTINUE'){
            $('#overlay-animation').show();
        } else {
            $('#overlay-animation').hide();
        }
    }

    $(document).ready(function() {
        update_data();

        $('#btn-pause').click(function(){
            var IS_PAUSE;
            if($('#pause-txt').text() == 'PAUSE'){
                $('#overlay-animation').show();
                $('#pause-txt').text('CONTINUE');
                $('#total-time-container').attr('class', 'box box-danger box-solid');
                $.ajax({
                    type: 'POST',
                    url: '" . Url::to(['maintain-pause', 'MOLDING_ID' => $model->MOLDING_ID, 'IS_PAUSE' => 1]) . "',
                    success: function(data){
                        
                    },
                });
            } else {
                $('#overlay-animation').hide();
                $('#pause-txt').text('PAUSE');
                $('#total-time-container').attr('class', 'box box-success box-solid');
                IS_PAUSE = 0;
                $.ajax({
                    type: 'POST',
                    url: '" . Url::to(['maintain-pause', 'MOLDING_ID' => $model->MOLDING_ID, 'IS_PAUSE' => 0]) . "',
                    success: function(data){
                        
                    },
                });
            }
        });
    });
");
?>

<?php $form = ActiveForm::begin([
	'id' => 'AssetTbl',
	//'layout' => 'horizontal',
	'enableClientValidation' => true,
	'errorSummaryCssClass' => 'error-summary alert alert-danger',
]
);

$pause_txt = $model->IS_PAUSE == 0 ? 'PAUSE' : 'CONTINUE';
?>

<div class="row">
    <div class="col-sm-6">
        <div id="total-time-container" class="box <?= $model->IS_PAUSE == 0 ? 'box-success' : 'box-danger'; ?> box-solid">
            <div class="box-header text-center">
                <h3 class="box-title">
                    <span id="total-time">
                        Calculating...
                    </span>
                </h3>
            </div>
            <div class="box-body">
                <?= $form->field($model, 'MOLDING_ID')->textInput(['readonly' => true]) ?>
                <?= $form->field($model, 'MOLDING_NAME')->textInput(['readonly' => true]) ?>
                <?= $form->field($model, 'NOTE')->textInput(['placeholder' => 'Insert remark here...']) ?>
                <?= Html::submitButton(
                '<span class="glyphicon glyphicon-check"></span> FINISH',
                [
                'id' => 'save-' . $model->formName(),
                'class' => 'btn btn-success btn-block',
                'style' => 'font-size: 30px;'
                ]
                );
                ?>
            </div>
            <div class="overlay" id="overlay-animation">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
        <?= Html::a('<span id="pause-txt">' . $pause_txt . '</span>', '#', ['class' => 'btn btn-warning btn-block', 'style' => 'font-size: 30px;', 'id' => 'btn-pause']); ?>
        <?= Html::a('BACK', Url::previous(), ['class' => 'btn btn-default btn-block', 'style' => 'font-size: 30px;']); ?>

        
    </div>
</div>
		

<?php ActiveForm::end(); ?>