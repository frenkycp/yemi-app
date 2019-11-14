<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\select2\Select2;
use kartik\date\DatePicker;

$this->title = [
    'page_title' => 'Kanban Confirmation',
    'tab_title' => 'Kanban Confirmation',
    'breadcrumbs_title' => 'Kanban Confirmation'
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
        <?= $form->field($model, 'request_date')->textInput([
            'readonly' => true
        ]); ?>

        <?= $form->field($input_model, 'confirm_schedule_date')->widget(DatePicker::classname(), [
            'options' => [
                'type' => DatePicker::TYPE_INPUT,
            ],
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd'
            ],
            'pickerButton' => false,
        ]); ?>
	</div>
	<div class="panel-footer">
        <?= Html::submitButton('Submit', [
        	'id' => 'btn-submit',
        	'class' => 'btn btn-success'
        ]); ?>
        
        
        <?= Html::a(
        'Cancel',
        \yii\helpers\Url::previous(),
        ['class' => 'btn btn-warning', 'id' => 'btn-cancel']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>