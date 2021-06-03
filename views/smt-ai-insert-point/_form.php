<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\SmtAiInsertPoint $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="smt-ai-insert-point-form">

    <?php $form = ActiveForm::begin([
    'id' => 'SmtAiInsertPoint',
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
            

<!-- attribute PART_NO -->
			<?= $form->field($model, 'PART_NO')->textInput(['maxlength' => true]) ?>

<!-- attribute POINT_SMT -->
			<?= $form->field($model, 'POINT_SMT')->textInput() ?>

<!-- attribute POINT_RG -->
			<?= $form->field($model, 'POINT_RG')->textInput() ?>

<!-- attribute POINT_AV -->
			<?= $form->field($model, 'POINT_AV')->textInput() ?>

<!-- attribute POINT_JV -->
			<?= $form->field($model, 'POINT_JV')->textInput() ?>

<!-- attribute POINT_TOTAL -->
			<?= $form->field($model, 'POINT_TOTAL')->textInput() ?>

<!-- attribute FLAG -->
			<?= $form->field($model, 'FLAG')->textInput() ?>

<!-- attribute LAST_UPDATE -->
			<?= $form->field($model, 'LAST_UPDATE')->textInput() ?>

<!-- attribute PARENT_PART_NO -->
			<?= $form->field($model, 'PARENT_PART_NO')->textInput(['maxlength' => true]) ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'SmtAiInsertPoint'),
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

