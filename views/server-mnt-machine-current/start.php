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
    'page_title' => 'Start Machine Process <span class="text-green japanesse"></span>',
    'tab_title' => 'Start Machine Process',
    'breadcrumbs_title' => 'Start Machine Process'
];

$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; color: #82b964;}
    //.form-control, .control-label {background-color: #33383D; color: white; border-color: white;}
    //.form-control {font-size: 20px; height: 40px;}
    .content-header {color: white;}
    //.box-body {background-color: #33383D;}
    .box-title {font-weight: bold;}
    .box-header .box-title{font-size: 2em;}
    //.container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold; text-align: center;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #33383D;}
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

<?php $form = ActiveForm::begin([
	'id' => 'ServerMntMachineCurrent',
	//'layout' => 'horizontal',
	'enableClientValidation' => true,
	'errorSummaryCssClass' => 'error-summary alert alert-danger',
]);
?>

<div class="panel panel-primary">
	<div class="panel-body">
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'username')->textInput(); ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'password')->passwordInput(); ?>
            </div>
        </div>
		<div>
			<?= $form->field($model, 'man_power')->widget(Select2::classname(), [
			    'data' => ArrayHelper::map(app\models\Karyawan::find()->select(['NIK', 'NAMA_KARYAWAN'])->orderBy('NAMA_KARYAWAN')->all(), 'nikNama', 'nikNama'),
			    'options' => ['placeholder' => 'Select operator ...'],
			    'pluginOptions' => [
			        'allowClear' => true,
			        'multiple' => true
			    ],
			]); ?>
		</div>
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
        &nbsp;&nbsp;
        <?= Html::a('<span class="glyphicon glyphicon-remove"></span> CANCEL', Url::previous(), ['class' => 'btn btn-warning']) ?>
	</div>
</div>

<?php ActiveForm::end(); ?>