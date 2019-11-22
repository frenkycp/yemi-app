<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\select2\Select2;
use kartik\date\DatePicker;

$this->title = [
    'page_title' => 'Dandori Start',
    'tab_title' => 'Dandori Start',
    'breadcrumbs_title' => 'Dandori Start'
];

?>
<?php $form = ActiveForm::begin([
'id' => 'IpqaPatrolTbl',
'enableClientValidation' => true,
'errorSummaryCssClass' => 'error-summary alert alert-danger',
'options' => ['enctype' => 'multipart/form-data']
]
);
?>

<div class="panel panel-primary">
	<div class="panel panel-body">

        <?= $form->field($input_model, 'carriage_qty')->textInput(['type' => 'number']); ?>
	</div>
	<div class="panel-footer">
        <?= Html::submitButton('Submit', [
        	'id' => 'btn-submit',
        	'class' => 'btn btn-success'
        ]); ?>
        
        <button type="button" class="btn btn-warning" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
    </div>
</div>

<?php ActiveForm::end(); ?>