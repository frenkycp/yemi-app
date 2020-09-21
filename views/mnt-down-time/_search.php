<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/**
* @var yii\web\View $this
* @var app\models\search\LiveCookingDataSearch $model
* @var yii\widgets\ActiveForm $form
*/

$this->registerCss(".form-group { margin-bottom: 0px; }");

?>

<div class="live-cooking-request-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
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
		            	<div class="col-sm-3">
		            		<?= $form->field($model, 'period'); ?>
		            	</div>
		            	<div class="col-sm-3">
		            		<?= $form->field($model, 'location')->dropDownList(ArrayHelper::map(app\models\AssetTbl::find()->select('location')->where('PATINDEX(\'%MNT%\', asset_id) > 0')->andWhere('location IS NOT NULL')->groupBy('location')->orderBy('location')->all(), 'location', 'location')); ?>
		            	</div>
		            	<div class="col-sm-3">
		            		<?= $form->field($model, 'area')->dropDownList(ArrayHelper::map(app\models\AssetTbl::find()->select('area')->where('PATINDEX(\'%MNT%\', asset_id) > 0')->andWhere('area IS NOT NULL')->groupBy('area')->orderBy('area')->all(), 'area', 'area')); ?>
		            	</div>
		            </div>
		            <div class="row">
		                <div class="col-sm-12">
							<?= $form->field($model, 'mesin_id')->widget(Select2::classname(), [
			                    'data' => $mesin_dropdown,
			                    'options' => [
			                        'placeholder' => 'Choose...',
			                        'multiple' => true,
			                    ],
			                    'pluginOptions' => [
			                        'allowClear' => true,
			                    ],
			                ])->label('Machine'); ?>
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
