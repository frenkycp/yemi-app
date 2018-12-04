<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\HrLoginLog $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="hr-login-log-form">

    <?php $form = ActiveForm::begin([
    'id' => 'HrLoginLog',
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
            

<!-- attribute id -->
			<?= $form->field($model, 'id')->textInput() ?>

<!-- attribute nik -->
			<?= $form->field($model, 'nik')->textInput() ?>

<!-- attribute emp_name -->
			<?= $form->field($model, 'emp_name')->textInput() ?>

<!-- attribute department -->
			<?= $form->field($model, 'department')->textInput() ?>

<!-- attribute section -->
			<?= $form->field($model, 'section')->textInput() ?>

<!-- attribute sub_section -->
			<?= $form->field($model, 'sub_section')->textInput() ?>

<!-- attribute period -->
			<?= $form->field($model, 'period')->textInput() ?>

<!-- attribute login_date -->
			<?= $form->field($model, 'login_date')->textInput() ?>

<!-- attribute last_login -->
			<?= $form->field($model, 'last_login')->textInput() ?>

<!-- attribute login_count -->
			<?= $form->field($model, 'login_count')->textInput() ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'HrLoginLog'),
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

