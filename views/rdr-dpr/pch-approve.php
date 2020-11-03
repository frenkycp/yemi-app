<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;

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
			<div class="col-sm-6">
				<?= $form->field($model, 'discrepancy_treatment')->dropDownList([
					'Replacement for shortage qty' => 'Replacement for shortage qty',
					'No Need replacement for shortage qty' => 'No Need replacement for shortage qty',
					'Over qty return supplier' => 'Over qty return supplier',
					'No Need return over qty, Issue additional P/O' => 'No Need return over qty, Issue additional P/O',
				]); ?>
			</div>
			<div class="col-sm-6">
				<?= $form->field($model, 'payment_treatment')->dropDownList([
					'Debit Note' => 'Debit Note',
					'Replacement' => 'Replacement',
				], [
					'prompt' => 'Choose...',
				]); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-8">
				<?= $form->field($model, 'purc_approve_remark')->textInput()->label('Remark'); ?>
			</div>
			<div class="col-sm-4">
				<?= $form->field($model, 'eta_yemi')->widget(DatePicker::classname(), [
                    'options' => [
                        'type' => DatePicker::TYPE_INPUT,
                    ],
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ])->label('ETA YEMI'); ?>
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
        <button type="button" class="btn btn-warning" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
    </div>
</div>

<?php ActiveForm::end(); ?>
