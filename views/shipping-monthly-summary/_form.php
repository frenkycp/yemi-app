<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\ShippingMonthlySummary $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="shipping-monthly-summary-form">

    <?php $form = ActiveForm::begin([
    'id' => 'ShippingMonthlySummary',
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

<!-- attribute final_product_so -->
			<?= $form->field($model, 'final_product_so')->textInput() ?>

<!-- attribute final_product_act -->
			<?= $form->field($model, 'final_product_act')->textInput() ?>

<!-- attribute kd_so -->
			<?= $form->field($model, 'kd_so')->textInput() ?>

<!-- attribute kd_act -->
			<?= $form->field($model, 'kd_act')->textInput() ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'ShippingMonthlySummary'),
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

