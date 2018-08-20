<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\WeeklyPlan $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="weekly-plan-form">

    <?php $form = ActiveForm::begin([
    'id' => 'WeeklyPlan',
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
            
<!-- attribute period -->
            <?= $form->field($model, 'period')->textInput(['maxlength' => true]) ?>

<!-- attribute week -->
			<?= $form->field($model, 'week')->textInput(); ?>

<!-- attribute category -->
            <?= $form->field($model, 'category')->textInput(['maxlength' => true]) ?>

<!-- attribute plan_qty -->
			<?= $form->field($model, 'plan_qty')->textInput(['type' => 'number']) ?>

<!-- attribute actual_qty -->
			<?= $form->field($model, 'actual_qty')->textInput(['type' => 'number']) ?>

<!-- attribute balance_qty -->
			<?= $form->field($model, 'balance_qty')->textInput(['type' => 'number']) ?>

<!-- attribute plan_export -->
            <?= $form->field($model, 'plan_export')->textInput(['type' => 'number']) ?>

<!-- attribute actual_export -->
            <?= $form->field($model, 'actual_export')->textInput(['type' => 'number']) ?>

<!-- attribute balance_export -->
            <?= $form->field($model, 'balance_export')->textInput(['type' => 'number']) ?>

<!-- attribute remark -->
            <?= $form->field($model, 'remark')->textArea(['rows' => 3, 'style' => 'resize : none;']) ?>



<!-- attribute percentage -->
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'WeeklyPlan'),
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

