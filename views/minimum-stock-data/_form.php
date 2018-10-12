<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\MinimumStock $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="minimum-stock-form">

    <?php $form = ActiveForm::begin([
    'id' => 'MinimumStock',
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
            

<!-- attribute ID_ITEM_LOC -->
			<?= $form->field($model, 'ID_ITEM_LOC')->textInput() ?>

<!-- attribute LOC -->
			<?= $form->field($model, 'LOC')->textInput() ?>

<!-- attribute ITEM -->
			<?= $form->field($model, 'ITEM')->textInput() ?>

<!-- attribute ITEM_EQ_DESC_01 -->
			<?= $form->field($model, 'ITEM_EQ_DESC_01')->textInput() ?>

<!-- attribute ITEM_EQ_UM -->
			<?= $form->field($model, 'ITEM_EQ_UM')->textInput() ?>

<!-- attribute LOC_DESC -->
			<?= $form->field($model, 'LOC_DESC')->textInput() ?>

<!-- attribute PIC -->
			<?= $form->field($model, 'PIC')->textInput() ?>

<!-- attribute PIC_DESC -->
			<?= $form->field($model, 'PIC_DESC')->textInput() ?>

<!-- attribute DEP -->
			<?= $form->field($model, 'DEP')->textInput() ?>

<!-- attribute DEP_DESC -->
			<?= $form->field($model, 'DEP_DESC')->textInput() ?>

<!-- attribute HIGH_RISK -->
			<?= $form->field($model, 'HIGH_RISK')->textInput() ?>

<!-- attribute CATEGORY -->
			<?= $form->field($model, 'CATEGORY')->textInput() ?>

<!-- attribute USER_ID -->
			<?= $form->field($model, 'USER_ID')->textInput() ?>

<!-- attribute USER_DESC -->
			<?= $form->field($model, 'USER_DESC')->textInput() ?>

<!-- attribute MACHINE -->
			<?= $form->field($model, 'MACHINE')->textInput() ?>

<!-- attribute MACHINE_NAME -->
			<?= $form->field($model, 'MACHINE_NAME')->textInput() ?>

<!-- attribute MIN_STOCK_QTY -->
			<?= $form->field($model, 'MIN_STOCK_QTY')->textInput() ?>

<!-- attribute LAST_UPDATE -->
			<?= $form->field($model, 'LAST_UPDATE')->textInput() ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'MinimumStock'),
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

