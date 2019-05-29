<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\CutiTblSearch $searchModel
*/

$this->title = [
    'page_title' => 'Reject Data <span class="japanesse text-green"></span>',
    'tab_title' => 'Reject Data',
    'breadcrumbs_title' => 'Reject Data'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("h1 .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

date_default_timezone_set('Asia/Jakarta');

?>

<?php $form = ActiveForm::begin([
	'id' => 'IpqaPatrolTbl',
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
]);
?>

<div class="box box-primary">
	<div class="box-body">
		<div class="row">
			<div class="col-md-2">
				<?= $form->field($model, 'patrol_time')->textInput(['readonly' => 'readonly']); ?>
			</div>
			<div class="col-md-2">
				<?= $form->field($model, 'categoryDetail')->textInput(['readonly' => 'readonly'])->label('Topik'); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<?= $form->field($model, 'description')->textInput(['readonly' => 'readonly']); ?>
			</div>
			<div class="col-md-6">
				<?= $form->field($model, 'action')->textInput(['readonly' => 'readonly']); ?>
			</div>
		</div>
		<div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'cause')->textArea(['rows' => 2, 'style' => 'resize: none;', 'placeholder' => 'Input Cause Here ...', 'readonly' => 'readonly'])->label('Cause'); ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'countermeasure')->textArea(['rows' => 2, 'style' => 'resize: none;', 'placeholder' => 'Input Countermeasure Here ...', 'readonly' => 'readonly'])->label('Countermeasure'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'reject_remark')->textArea(['rows' => 2, 'style' => 'resize: none;'])->label('Reject Remark'); ?>
            </div>
        </div>
	</div>
	<div class="panel-footer">
        <?= Html::submitButton(
        '<span class="glyphicon glyphicon-check"></span> Submit',
        [
        'id' => 'save-' . $model->formName(),
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