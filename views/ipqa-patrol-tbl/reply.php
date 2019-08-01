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
    'page_title' => 'IPQA Daily Patrol (Reply) <span class="japanesse text-green"></span>',
    'tab_title' => 'IPQA Daily Patrol (Reply)',
    'breadcrumbs_title' => 'IPQA Daily Patrol (Reply)'
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
				<?= $form->field($model, 'event_date')->textInput(['readonly' => 'readonly']); ?>
			</div>
			<div class="col-md-2">
				<?= $form->field($model, 'child')->textInput(['readonly' => 'readonly'])->label('Part/Product'); ?>
			</div>
			<div class="col-md-6">
				<?= $form->field($model, 'child_desc')->textInput(['readonly' => 'readonly'])->label('Description'); ?>
			</div>
			<div class="col-md-2">
				<?= $form->field($model, 'category')->textInput(['readonly' => 'readonly']); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<?= $form->field($model, 'problem')->textInput(['readonly' => 'readonly']); ?>
			</div>
			<div class="col-md-8">
				<?= $form->field($model, 'description')->textArea(['rows' => 5, 'readonly' => 'readonly']); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
                <?= $form->field($model_reply, 'cause')->textArea(['rows' => 4, 'placeholder' => 'Input Cause Here ...'])->label('Cause'); ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model_reply, 'countermeasure')->textArea(['rows' => 4, 'placeholder' => 'Input Countermeasure Here ...'])->label('Countermeasure'); ?>
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