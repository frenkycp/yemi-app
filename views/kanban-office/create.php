<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\select2\Select2;
use kartik\date\DatePicker;

$this->title = [
    'page_title' => 'Create New Kanban',
    'tab_title' => 'Create New Kanban',
    'breadcrumbs_title' => 'Create New Kanban'
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
		<?= $form->field($model, 'job_flow_id')->widget(Select2::classname(), [
        	'data' => ArrayHelper::map(app\models\KanbanFlowHdr::find()->all(), 'job_flow_id', 'job_flow_desc')
        ]); ?>

		<?= $form->field($model, 'job_desc')->textInput([
            'style' => 'text-transform: uppercase;',
        ]); ?>

        <?= $form->field($model, 'job_source')->dropDownList(ArrayHelper::map(app\models\KanbanJobSource::find()->orderBy('JOB_SOURCE_NAME')->all(), 'JOB_SOURCE_NAME', 'JOB_SOURCE_NAME')); ?>

        <?= $form->field($model, 'job_priority')->dropDownList([
        	'NORMAL' => 'NORMAL',
        	'URGENT' => 'URGENT',
        ]); ?>

        <?= $form->field($model, 'request_to_nik')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(app\models\KARYAWAN::find()->select([
                'NIK_SUN_FISH', 'NAMA_KARYAWAN'
            ])
            ->all(), 'NIK_SUN_FISH', 'nikSunfishNama'),
            'options' => [
                'placeholder' => 'Request to ...',
                'onchange' => '
                    $("#btn-submit").attr("disabled", true);
                    $.post( "' . Yii::$app->urlManager->createUrl('kanban-office/emp-info?nik=') . '"+$(this).val(), function( data ) {
                        var data_arr = data.split("||");
                        $( "#txt_name" ).val(data_arr[0]);
                        //$( "#txt_dept" ).val(data_arr[1]);
                        //$( "#txt_section" ).val(data_arr[2]);
                        //$( "#txt_status_karyawan" ).val(data_arr[3]);
                        //$( "#cc_id" ).val(data_arr[4]);
                        $("#btn-submit").removeAttr("disabled");
                    });
                ',
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>

        <?= $form->field($model, 'request_date')->widget(DatePicker::classname(), [
            'options' => [
                'type' => DatePicker::TYPE_INPUT,
            ],
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd'
            ],
            'pickerButton' => false,
        ]); ?>

        <?= $form->field($model, 'request_to_nik_name')->hiddenInput(['id' => 'txt_name'])->label(false); ?>
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