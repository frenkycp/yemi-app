<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\date\DatePicker;

$this->title = [
	    'page_title' => 'Delete Covid Patrol Data <span class="japanesse light-green"></span>',
	    'tab_title' => 'Delete Covid Patrol Data',
	    'breadcrumbs_title' => 'Delete Covid Patrol Data'
	];

?>

<?php $form = ActiveForm::begin([
	'id' => 'AssetTbl',
	//'layout' => 'horizontal',
	'enableClientValidation' => true,
	'errorSummaryCssClass' => 'error-summary alert alert-danger',
]
);
?>

<div class="panel panel-primary">
	<div class="panel-body">
		<?= $form->field($model, 'DELETE_REMARK')->textInput(['maxlength' => true, 'placeholder' => 'Input remark here...'])->label('Remark'); ?>
	</div>
	<div class="panel-footer">
        <?php echo $form->errorSummary($model); ?>

        <?= Html::submitButton(
        '<span class="glyphicon glyphicon-check"></span> Delete',
        [
        'id' => 'save-' . $model->formName(),
        'class' => 'btn btn-danger'
        ]
        );
        ?>

        <?=             Html::a(
            'Cancel',
            \yii\helpers\Url::previous(),
            ['class' => 'btn btn-warning']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>