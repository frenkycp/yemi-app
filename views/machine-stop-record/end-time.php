<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use kartik\widgets\DateTimePicker;

$this->title = Yii::t('models', 'Machine Stop Record (End Time)');

?>

<?php $form = ActiveForm::begin([
'id' => 'Menu',
//'layout' => 'horizontal',
'enableClientValidation' => true,
'errorSummaryCssClass' => 'error-summary alert alert-error'
]
);
?>

<div class="row">
	<div class="col-sm-3">
		<?= $form->field($model, 'MESIN_ID')->textInput(['readonly' => true]); ?>
	</div>
	<div class="col-sm-9">
		<?= $form->field($model, 'MESIN_DESC')->textInput(['readonly' => true]); ?>
	</div>
</div>
<div class="row">
	<div class="col-sm-3">
		<?= $form->field($model, 'START_TIME')->textInput(['readonly' => true]); ?>

		<?= $form->field($model, 'END_TIME')->widget(DateTimePicker::classname(), [
            'options' => ['placeholder' => 'Enter end time ...'],
            'pluginOptions' => [
                'autoclose' => true
            ]
        ]); ?>
	</div>
</div>

<?= Html::a(
'Cancel',
\yii\helpers\Url::previous(),
['class' => 'btn btn-warning']) ?>

<?= Html::submitButton(
'<span class="glyphicon glyphicon-check"></span> ' .
($model->isNewRecord ? 'Create' : 'Submit'),
[
'id' => 'save-' . $model->formName(),
'class' => 'btn btn-success'
]
);
?>

<?php ActiveForm::end(); ?>