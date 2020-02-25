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

?>

<div class="live-cooking-request-search">

    <?php $form = ActiveForm::begin([
    'action' => ['data'],
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
					    <div class="col-md-3">
		                	<?= $form->field($model, 'cost_centre')->dropDownList(ArrayHelper::map(app\models\CostCenter::find()->orderBy('CC_DESC')->all(), 'CC_ID', 'CC_DESC'), [
		                		'prompt' => 'Choose...'
		                	])->label('Section'); ?>
		                </div>
		                <div class="col-md-3">
		                	<?= $form->field($model, 'asset_id')->textInput()->label('Asset ID'); ?>
		                </div>
		                <div class="col-md-3">
		                	<?= $form->field($model, 'computer_name')->textInput()->label('Asset Name'); ?>
		                </div>
		                <div class="col-md-3">
		                	<?= $form->field($model, 'location')->textInput(); ?>
		                </div>
		            </div>
		            <div class="row">
		                <div class="col-md-3">
		                	<?= $form->field($model, 'status')->dropDownList([
		                		'OK' => 'OK',
		                		'NG' => 'NG',
		                	], ['prompt' => 'Choose...'])->label('Asset Status'); ?>
		                </div>
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
		            	<div class="col-md-3">
		            		<?= $form->field($model, 'Discontinue')->dropDownList([
		                		'Y' => 'YES',
		                		'N' => 'NO',
		                	], ['prompt' => 'Choose...']); ?>
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
