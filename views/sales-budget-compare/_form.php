<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\SalesBudgetCompare $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="sales-budget-compare-form">

    <?php $form = ActiveForm::begin([
    'id' => 'SalesBudgetCompare',
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
            

<!-- attribute ITEM_INDEX -->
			<?= $form->field($model, 'ITEM_INDEX')->textInput() ?>

<!-- attribute ITEM -->
			<?= $form->field($model, 'ITEM')->textInput() ?>

<!-- attribute DESC -->
			<?= $form->field($model, 'DESC')->textInput() ?>

<!-- attribute NO -->
			<?= $form->field($model, 'NO')->textInput() ?>

<!-- attribute MODEL -->
			<?= $form->field($model, 'MODEL')->textInput() ?>

<!-- attribute MODEL_GROUP -->
			<?= $form->field($model, 'MODEL_GROUP')->textInput() ?>

<!-- attribute BU -->
			<?= $form->field($model, 'BU')->textInput() ?>

<!-- attribute TYPE -->
			<?= $form->field($model, 'TYPE')->textInput() ?>

<!-- attribute FISCAL -->
			<?= $form->field($model, 'FISCAL')->textInput() ?>

<!-- attribute PERIOD -->
			<?= $form->field($model, 'PERIOD')->textInput() ?>

<!-- attribute QTY_BGT -->
			<?= $form->field($model, 'QTY_BGT')->textInput() ?>

<!-- attribute AMOUNT_BGT -->
			<?= $form->field($model, 'AMOUNT_BGT')->textInput() ?>

<!-- attribute QTY_ACT_FOR -->
			<?= $form->field($model, 'QTY_ACT_FOR')->textInput() ?>

<!-- attribute AMOUNT_ACT_FOR -->
			<?= $form->field($model, 'AMOUNT_ACT_FOR')->textInput() ?>

<!-- attribute QTY_BALANCE -->
			<?= $form->field($model, 'QTY_BALANCE')->textInput() ?>

<!-- attribute AMOUNT_BALANCE -->
			<?= $form->field($model, 'AMOUNT_BALANCE')->textInput() ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'SalesBudgetCompare'),
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

