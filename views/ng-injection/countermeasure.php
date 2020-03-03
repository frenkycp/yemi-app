<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\web\View;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\CutiTblSearch $searchModel
*/

$this->title = [
    'page_title' => 'Action / countermeasure <span class="japanesse text-green"></span>',
    'tab_title' => 'Action / countermeasure',
    'breadcrumbs_title' => 'Action / countermeasure'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
	h1 .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }
	.form-group {margin-bottom: unset;}
	");

date_default_timezone_set('Asia/Jakarta');

$script = <<< JS
    $(document).ready(function() {
        $('#skill_0').trigger('change');
    });

JS;
$this->registerJs($script, View::POS_HEAD );

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
<div class="box box-danger box-solid" style="<?= $model == null ? 'display: none;' : ''; ?>">
	<div class="box-header">
		<h3 class="box-title">NG Information</h3>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-3">
				<?= $model == null ? '' : $form->field($model, 'document_no')->textInput(['readonly' => true]); ?>
			</div>
			<div class="col-md-2">
				<?= $model == null ? '' : $form->field($model, 'emp_id')->textInput(['readonly' => true])->label('PIC NG (NIK)'); ?>
			</div>
			<div class="col-md-4">
				<?= $model == null ? '' : $form->field($model, 'emp_name')->textInput(['readonly' => true])->label('PIC NG (Name)'); ?>
			</div>
			<div class="col-md-3">
				<?= $model == null ? '' : $form->field($model, 'ngCategory')->textInput(['readonly' => true])->label('NG Category'); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-2">
				<?= $model == null ? '' : $form->field($model, 'gmc_no')->textInput(['readonly' => true])->label('GMC No.'); ?>
			</div>
			<div class="col-md-3">
				<?= $model == null ? '' : $form->field($model, 'gmc_desc')->textInput(['readonly' => true])->label('GMC Desc.'); ?>
			</div>
			<div class="col-md-2">
				<?= $model == null ? '' : $form->field($model, 'pcb_id')->textInput(['readonly' => true])->label('Assy No.'); ?>
			</div>
			<div class="col-md-5">
				<?= $model == null ? '' : $form->field($model, 'pcb_name')->textInput(['readonly' => true])->label('Assy Desc.'); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<?= $model == null ? '' : $form->field($model, 'ng_detail')->textInput(['readonly' => true])->label('NG Detail'); ?>
			</div>
		</div>
		
	</div>
</div>

<div class="box box-primary box-solid">
	<div class="box-body">
		<div class="row">
			<div class="col-md-12">
				<?= $form->field($model_action, 'nik')->hiddenInput(['id' => 'nik_value']); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<?= $form->field($model_action, 'action')->dropDownList(\Yii::$app->params['ng_next_action_dropdown'], [
					'prompt' => 'Choose...',
					'onchange' => '
						if($(this).val() == \'TRAINING\'){
							$("#skill_container").show();
						} else {
							$("#skill_container").hide();
						}
					',
				]); ?>
			</div>
			<div class="col-md-9">
				<?= $form->field($model_action, 'remark')->textInput(); ?>
			</div>
		</div>
		<div class="box box-success box-solid" id="skill_container" style="display: none;">
			<div class="box-header">
				<h3 class="box-title">
					Skill Update
				</h3>
			</div>
			<div class="box-body">
				<table class="table table-responsive table-striped table-bordered table-primary">
					<thead>
						<tr>
							<th width="75%">Skill Name</th>
							<th width="25%">Skill Value</th>
						</tr>
					</thead>
					<tbody>
						<?php
						echo '<tr>
							<td>' . $form->field($model_action, 'skill_name[]')->widget(Select2::classname(), [
				                'data' => $skill_dropdown_arr,
				                'options' => [
				                    'placeholder' => 'Choose...',
				                    'id' => 'skill_0',
				                    'value' => $model->gmc_no,
				                    'onchange' => '
				                    	$(":submit").attr("disabled", true);
		                                $.post( "' . Yii::$app->urlManager->createUrl('ng-fa/get-skill-value?nik=') . '" + $("#nik_value").val() + "&skill_id=" + $(this).val(), function( data ) {
		                                    $( "#skill_value_' . $i . '" ).val(data);
		                                    $(":submit").removeAttr("disabled");
		                                });
		                            ',
				                ],
				                'pluginOptions' => [
				                    'allowClear' => true
				                ],
				            ])->label(false) . '</td>
				            <td>' . $form->field($model_action, 'skill_value[]')->textInput(['type' => 'number', 'id' => 'skill_value_' . $i])->label(false) . '</td>
						</tr>';
						for ($i=1; $i < 5; $i++) { 
							echo '<tr>
								<td>' . $form->field($model_action, 'skill_name[]')->widget(Select2::classname(), [
					                'data' => $skill_dropdown_arr,
					                'options' => [
					                    'placeholder' => 'Choose...',
					                    'id' => 'skill_' . $i,
					                    'onchange' => '
					                    	$(":submit").attr("disabled", true);
			                                $.post( "' . Yii::$app->urlManager->createUrl('ng-fa/get-skill-value?nik=') . '" + $("#nik_value").val() + "&skill_id=" + $(this).val(), function( data ) {
			                                    $( "#skill_value_' . $i . '" ).val(data);
			                                    $(":submit").removeAttr("disabled");
			                                });
			                            ',
					                ],
					                'pluginOptions' => [
					                    'allowClear' => true
					                ],
					            ])->label(false) . '</td>
					            <td>' . $form->field($model_action, 'skill_value[]')->textInput(['type' => 'number', 'id' => 'skill_value_' . $i])->label(false) . '</td>
							</tr>';
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="panel-footer">
        <?= Html::submitButton(
        '<span class="glyphicon glyphicon-check"></span> Submit',
        [
        'id' => 'save-' . $model_action->formName(),
        'class' => 'btn btn-success'
        ]
        );
        ?>
        <button type="button" class="btn btn-warning" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
    </div>
</div>

<?php ActiveForm::end(); ?>
