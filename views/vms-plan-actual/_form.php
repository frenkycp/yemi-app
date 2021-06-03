<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\VmsPlanActual $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="vms-plan-actual-form">

    <?php $form = ActiveForm::begin([
    'id' => 'VmsPlanActual',
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
            

<!-- attribute ID -->
			<?= $form->field($model, 'ID')->textInput(['maxlength' => true]) ?>

<!-- attribute VMS_DATE -->
			<?= $form->field($model, 'VMS_DATE')->textInput() ?>

<!-- attribute SESSION_DATE -->
			<?= $form->field($model, 'SESSION_DATE')->textInput() ?>

<!-- attribute ACT_QTY_LAST_UPDATE -->
			<?= $form->field($model, 'ACT_QTY_LAST_UPDATE')->textInput() ?>

<!-- attribute PLAN_QTY -->
			<?= $form->field($model, 'PLAN_QTY')->textInput() ?>

<!-- attribute ACTUAL_QTY -->
			<?= $form->field($model, 'ACTUAL_QTY')->textInput() ?>

<!-- attribute BALANCE_QTY -->
			<?= $form->field($model, 'BALANCE_QTY')->textInput() ?>

<!-- attribute SEESION_NO -->
			<?= $form->field($model, 'SEESION_NO')->textInput() ?>

<!-- attribute ID_PERIOD -->
			<?= $form->field($model, 'ID_PERIOD')->textInput(['maxlength' => true]) ?>

<!-- attribute PRODUCT_TYPE -->
			<?= $form->field($model, 'PRODUCT_TYPE')->textInput(['maxlength' => true]) ?>

<!-- attribute BU -->
			<?= $form->field($model, 'BU')->textInput(['maxlength' => true]) ?>

<!-- attribute MODEL -->
			<?= $form->field($model, 'MODEL')->textInput(['maxlength' => true]) ?>

<!-- attribute FG_KD -->
			<?= $form->field($model, 'FG_KD')->textInput(['maxlength' => true]) ?>

<!-- attribute ITEM_DESC -->
			<?= $form->field($model, 'ITEM_DESC')->textInput(['maxlength' => true]) ?>

<!-- attribute DESTINATION -->
			<?= $form->field($model, 'DESTINATION')->textInput(['maxlength' => true]) ?>

<!-- attribute VMS_PERIOD -->
			<?= $form->field($model, 'VMS_PERIOD')->textInput(['maxlength' => true]) ?>

<!-- attribute VMS_DAY -->
			<?= $form->field($model, 'VMS_DAY')->textInput(['maxlength' => true]) ?>

<!-- attribute VMS_VERSION -->
			<?= $form->field($model, 'VMS_VERSION')->textInput(['maxlength' => true]) ?>

<!-- attribute ITEM -->
			<?= $form->field($model, 'ITEM')->textInput(['maxlength' => true]) ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'VmsPlanActual'),
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

