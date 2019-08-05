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
    ]
    );
    ?>
    <div class="panel panel-primary">
        <div class="panel-body">

            <?= $form->field($model, 'period')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'week')->textInput() ?>

            <?= $form->field($model, 'plan_export')->textInput() ?>

            <?= $form->field($model, 'actual_export')->textInput() ?>

            <?= $form->field($model, 'remark')->textArea(['rows' => 3]) ?>

            <?= $form->field($model, 'category')->hiddenInput(['maxlength' => true]) ?>

            <?php echo $form->errorSummary($model); ?>
        </div>
        <div class="panel-footer">
            <?= Html::submitButton('<span class="glyphicon glyphicon-check"></span> ' . ($model->isNewRecord ? 'Create' : 'Save'),
            [
            'id' => 'save-' . $model->formName(),
            'class' => 'btn btn-success'
            ]
            );
            ?>
            &nbsp;&nbsp;
            <?= Html::a('Cancel', \yii\helpers\Url::previous(), ['class' => 'btn btn-default']); ?>
        </div>
    </div>
            

			

        

        

        <?php ActiveForm::end(); ?>

</div>

