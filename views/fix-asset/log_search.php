<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;

/**
* @var yii\web\View $this
* @var app\models\search\LiveCookingDataSearch $model
* @var yii\widgets\ActiveForm $form
*/

$this->registerCss(".form-group { margin-bottom: 0px; }");

$menu_arr = [
    'BAKSO' => 'bakso_01.jpg',
    'GADO-GADO' => 'gado_gado_01.jpg',
    'LALAPAN' => 'lalapan_01.jpg',
    'NASI-GORENG' => 'nasi_goreng_01.jpg',
    'NASI-PECEL' => 'nasi_pecel_01.jpg',
    'RAWON' => 'rawon_01.jpg',
    'SOTO-AYAM' => 'soto_ayam_01.jpg'
];
$img_filename = $menu_arr[$today_menu_txt];
?>

<div class="live-cooking-request-search">

    <?php $form = ActiveForm::begin([
    'action' => ['asset-log'],
    'method' => 'get',
    ]); ?>

    <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title">
						Filter Form
					</h3>
				</div>
		        <div class="panel-body">
		            <div class="row">
		                <div class="col-md-4">
		                	<?= $form->field($model, 'schedule_id')->dropDownList(ArrayHelper::map(app\models\AssetStockTakeSchedule::find()->orderBy('create_time DESC')->all(), 'schedule_id', 'period'), [
		                		'prompt' => 'Choose...'
		                	])->label('Stock Take Period'); ?>
		                </div>
		                <div class="col-md-4">
					        <?= $form->field($model, 'posting_date')->widget(DatePicker::classname(), [
						        'options' => [
						            'type' => DatePicker::TYPE_INPUT,
						        ],
						        'pluginOptions' => [
						            'autoclose'=>true,
						            'format' => 'yyyy-mm-dd'
						        ]
						    ])->label('Stock Taking Date'); ?>
					    </div>
					    <div class="col-md-4">
		                	<?= $form->field($model, 'cost_centre')->dropDownList(ArrayHelper::map(app\models\CostCenter::find()->orderBy('CC_DESC')->all(), 'CC_ID', 'CC_DESC'), [
		                		'prompt' => 'Choose...'
		                	])->label('Section'); ?>
		                </div>
		            </div>
		            <div class="row">
		            	<div class="col-md-3">
		                	<?= $form->field($model, 'asset_id')->textInput()->label('Asset ID'); ?>
		                </div>
		                <div class="col-md-3">
		                	<?= $form->field($model, 'computer_name')->textInput()->label('Asset Name'); ?>
		                </div>
		                <div class="col-md-3">
		                	<?= $form->field($model, 'status')->dropDownList([
		                		'OK' => 'OK',
		                		'NG' => 'NG',
		                	], ['prompt' => 'Choose...'])->label('Asset Status'); ?>
		                </div>
		                <div class="col-md-3">
		                	<?= $form->field($model, 'schedule_status')->dropDownList([
		                		'O' => 'OPEN',
		                		'C' => 'CLOSE',
		                	], ['prompt' => 'Choose...'])->label('Stock Take Status'); ?>
		                </div>
		            </div>
		            <div class="row">
		            	<div class="col-md-3">
		            		<?= $form->field($model, 'label')->dropDownList([
		                		'Y' => 'YES',
		                		'N' => 'NO',
		                	], ['prompt' => 'Choose...'])->label('Label'); ?>
		            	</div>
		            	<div class="col-md-3">
		            		<?= $form->field($model, 'propose_scrap')->dropDownList([
		                		'Y' => 'YES',
		                		'N' => 'NO',
		                	], ['prompt' => 'Choose...'])->label('Propose Scrap'); ?>
		            	</div>
		            </div>
		            <div class="row">
		                <div class="col-sm-12">
		                    <div class="form-group">
						        <?= Html::submitButton('Search', ['class' => 'btn btn-info']); ?>
						    </div>
		                </div>
		            </div>
		        </div>
		    </div>
    	</div>
    </div>
	

    

    <?php ActiveForm::end(); ?>

</div>
