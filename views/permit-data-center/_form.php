<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\EmpPermitTbl $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="emp-permit-tbl-form">

    <?php $form = ActiveForm::begin([
    'id' => 'EmpPermitTbl',
    'layout' => 'horizontal',
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

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>
            

<!-- attribute POST_DATE -->
			<?= $form->field($model, 'POST_DATE')->textInput() ?>

<!-- attribute LAST_UPDATED -->
			<?= $form->field($model, 'LAST_UPDATED')->textInput() ?>

<!-- attribute REASON -->
			<?= $form->field($model, 'REASON')->textInput() ?>

<!-- attribute FLAG -->
			<?= $form->field($model, 'FLAG')->textInput() ?>

<!-- attribute NIK -->
			<?= $form->field($model, 'NIK')->textInput(['maxlength' => true]) ?>

<!-- attribute DIVISION -->
			<?= $form->field($model, 'DIVISION')->textInput(['maxlength' => true]) ?>

<!-- attribute DEPARTMENT -->
			<?= $form->field($model, 'DEPARTMENT')->textInput(['maxlength' => true]) ?>

<!-- attribute SECTION -->
			<?= $form->field($model, 'SECTION')->textInput(['maxlength' => true]) ?>

<!-- attribute COST_CENTER_CODE -->
			<?= $form->field($model, 'COST_CENTER_CODE')->textInput(['maxlength' => true]) ?>

<!-- attribute COST_CENTER_NAME -->
			<?= $form->field($model, 'COST_CENTER_NAME')->textInput(['maxlength' => true]) ?>

<!-- attribute EMPLOY_CODE -->
			<?= $form->field($model, 'EMPLOY_CODE')->textInput(['maxlength' => true]) ?>

<!-- attribute NAMA_KARYAWAN -->
			<?= $form->field($model, 'NAMA_KARYAWAN')->textInput(['maxlength' => true]) ?>

<!-- attribute PERIOD -->
			<?= $form->field($model, 'PERIOD')->textInput(['maxlength' => true]) ?>

<!-- attribute STATUS -->
			<?= $form->field($model, 'STATUS')->textInput(['maxlength' => true]) ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'EmpPermitTbl'),
    'content' => $this->blocks['main'],
    'active'  => true,
],
                    ]
                 ]
    );
    ?>
        <hr/>

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

        <?php ActiveForm::end(); ?>

    </div>

</div>

