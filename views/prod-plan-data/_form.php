<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use kartik\date\DatePicker;

/**
* @var yii\web\View $this
* @var app\models\WipEffTbl $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="wip-eff-tbl-form">

    <?php $form = ActiveForm::begin([
    'id' => 'WipEffTbl',
    //'layout' => 'horizontal',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-danger',
    'fieldConfig' => [
             'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
             'horizontalCssClasses' => [
                 'label' => 'col-sm-2',
                 #'offset' => 'col-sm-offset-4',
                 'wrapper' => 'col-sm-8',
                 'error' => '',
                 'hint' => '',
             ],
         ],
    ]
    );
    ?>
    <div class="panel panel-primary">
    	<div class="panel-body">
    		<div class="row">
    			<div class="col-md-6">
    				<div class="panel panel-success" style="margin-bottom: 0px;">
    					<div class="panel-body">
    						<?= $form->field($model, 'child_analyst_desc')->textInput(['readonly' => true]) ?>
							<?= $form->field($model, 'lot_id')->textInput(['readonly' => true]) ?>
							<?= $form->field($model, 'child_all')->textInput(['readonly' => true]) ?>
							<?= $form->field($model, 'child_desc_all')->textInput(['readonly' => true]) ?>
							<?= $form->field($model, 'qty_all')->textInput(['readonly' => true]) ?>
    					</div>
    				</div>
    			</div>
    			<div class="col-md-6">
    				<div class="panel panel-success" style="margin-bottom: 0px;">
    					<div class="panel-body">
    						<div class="form-group">
				                <label class="control-label" for="plan_date">Plan Date</label>
				                <?= DatePicker::widget([
				                    'name' => 'WipEffTbl[plan_date]',
				                    'id' => 'plan_date',
				                    'type' => DatePicker::TYPE_INPUT,
				                    'value' => date('Y-m-d'),
				                    'options' => ['placeholder' => 'Select plan date ...'],
				                    'pluginOptions' => [
				                        'format' => 'yyyy-mm-dd',
				                        'todayHighlight' => true
				                    ]
				                ]); ?>
				            </div>
    						<?= $form->field($model, 'LINE')->dropDownList([
    							'01' => '01',
    							'02' => '02'
    						])->label('Line'); ?>
    						<?= $form->field($model, 'SMT_SHIFT')->dropDownList([
    							'01-PAGI' => '01-PAGI',
		                        '02-SIANG' => '02-SIANG',
		                        '03-MALAM' => '03-MALAM',
    						])->label('Shift'); ?>
    						<?= $form->field($model, 'KELOMPOK')->dropDownList([
    							'A' => 'A',
		                        'B' => 'B',
		                        'C' => 'C',
		                        'D' => 'D',
    						])->label('Group'); ?>
    					</div>
    				</div>
    			</div>
    		</div>
    		
    	</div>
    	<div class="panel-footer">
    		<?php echo $form->errorSummary($model); ?>
    		<?= Html::submitButton(
	        '<span class="glyphicon glyphicon-check"></span> ' .
	        ($model->isNewRecord ? 'Create' : 'Save'),
	        [
	        'id' => 'save-' . $model->formName(),
	        'class' => 'btn btn-success'
	        ]
	        );
	        ?>
    	</div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

