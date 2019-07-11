<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

$this->title = Yii::t('models', 'Add Response');

?>

<div class="hr-complaint-form">

    <?php $form = ActiveForm::begin([
    'id' => 'HrComplaint',
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

<!-- attribute nik -->
			<?= $form->field($model, 'nik')->textInput(['readonly' => true]) ?>

<!-- attribute emp_name -->
			<?= $form->field($model, 'emp_name')->textInput(['readonly' => true]) ?>

<!-- attribute department -->
			<?= $form->field($model, 'dept')->textInput(['readonly' => true]) ?>

<!-- attribute remark -->
			<?= $form->field($model, 'remark')->textarea(['rows' => 6, 'readonly' => true, 'style' => 'resize : none;']) ?>

<!-- attribute respons -->
			<?= $form->field($model, 'response')->textarea(['rows' => 6, 'style' => 'resize : none;']) ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'HrComplaint'),
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

