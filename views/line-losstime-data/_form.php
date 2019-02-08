<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\SernoLosstime $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="serno-losstime-form">

    <?php $form = ActiveForm::begin([
    'id' => 'SernoLosstime',
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
            

<!-- attribute pk -->
			<?= $form->field($model, 'pk')->textInput(['maxlength' => true]) ?>

<!-- attribute mp -->
			<?= $form->field($model, 'mp')->textInput() ?>

<!-- attribute start_time -->
			<?= $form->field($model, 'start_time')->textInput() ?>

<!-- attribute end_time -->
			<?= $form->field($model, 'end_time')->textInput() ?>

<!-- attribute losstime -->
			<?= $form->field($model, 'losstime')->textInput() ?>

<!-- attribute line -->
			<?= $form->field($model, 'line')->textInput(['maxlength' => true]) ?>

<!-- attribute proddate -->
			<?= $form->field($model, 'proddate')->textInput(['maxlength' => true]) ?>

<!-- attribute category -->
			<?= $form->field($model, 'category')->textInput(['maxlength' => true]) ?>

<!-- attribute model -->
			<?= $form->field($model, 'model')->textInput(['maxlength' => true]) ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'SernoLosstime'),
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

