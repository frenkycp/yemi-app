<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;

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
			<div class="col-sm-3">
				<?= $form->field($model, 'POST_DATE')->textInput(['readonly' => 'readonly']); ?>
			</div>
			<div class="col-sm-9">
				<?= $form->field($model, 'inspect_by_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\KARYAWAN::find()->select([
                        'NIK_SUN_FISH', 'NAMA_KARYAWAN'
                    ])
                    ->where([
                    	'AKTIF' => 'Y'
                    ])
                    ->andWhere(['NOT IN', 'CC_ID', ['110X', '110D', '110C', '110B']])
                    ->all(), 'NIK_SUN_FISH', 'nikSunfishNama'),
                    'options' => [
                        'placeholder' => 'Choose...',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Inspector'); ?>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-3">
				<?= $form->field($model, 'ITEM')->textInput(['readonly' => 'readonly']); ?>
			</div>
			<div class="col-sm-6">
				<?= $form->field($model, 'ITEM_DESC')->textInput(['readonly' => 'readonly']); ?>
			</div>
			<div class="col-sm-3">
				<?= $form->field($model, 'QTY_IN')->textInput(['readonly' => 'readonly']); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-3">
				<?= $form->field($model, 'LOC')->textInput(['readonly' => 'readonly']); ?>
			</div>
			<div class="col-sm-9">
				<?= $form->field($model, 'LOC_DESC')->textInput(['readonly' => 'readonly']); ?>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-3">
                <?= $form->field($model_judgement, 'judgement')->dropDownList([
                	'OK' => 'OK',
                	'NG' => 'NG',
                ]); ?>
            </div>
            <div class="col-md-9">
                <?= $form->field($model_judgement, 'remark')->textInput(['placeholder' => 'Input Remark Here ...']); ?>
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
