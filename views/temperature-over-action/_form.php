<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\TemperatureOverAction $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="temperature-over-action-form">

    <?php $form = ActiveForm::begin([
    'id' => 'TemperatureOverAction',
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

<!-- attribute LAST_CHECK -->
			<?= $form->field($model, 'LAST_CHECK')->textInput() ?>

<!-- attribute SHIFT -->
			<?= $form->field($model, 'SHIFT')->textInput() ?>

<!-- attribute NEXT_ACTION -->
			<?= $form->field($model, 'NEXT_ACTION')->textInput() ?>

<!-- attribute OLD_TEMPERATURE -->
			<?= $form->field($model, 'OLD_TEMPERATURE')->textInput() ?>

<!-- attribute NEW_TEMPERATURE -->
			<?= $form->field($model, 'NEW_TEMPERATURE')->textInput() ?>

<!-- attribute ID -->
			<?= $form->field($model, 'ID')->textInput(['maxlength' => true]) ?>

<!-- attribute EMP_ID -->
			<?= $form->field($model, 'EMP_ID')->textInput(['maxlength' => true]) ?>

<!-- attribute EMP_NAME -->
			<?= $form->field($model, 'EMP_NAME')->textInput(['maxlength' => true]) ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'TemperatureOverAction'),
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

