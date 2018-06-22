<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\SernoInput $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="serno-input-form">

    <?php $form = ActiveForm::begin([
    'id' => 'SernoInput',
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
            

<!-- attribute num -->
			<?= $form->field($model, 'num')->textInput() ?>

<!-- attribute pk -->
			<?= $form->field($model, 'pk')->textInput(['maxlength' => true]) ?>

<!-- attribute gmc -->
			<?= $form->field($model, 'gmc')->textInput(['maxlength' => true]) ?>

<!-- attribute line -->
			<?= $form->field($model, 'line')->textInput(['maxlength' => true]) ?>

<!-- attribute proddate -->
			<?= $form->field($model, 'proddate')->textInput(['maxlength' => true]) ?>

<!-- attribute sernum -->
			<?= $form->field($model, 'sernum')->textInput(['maxlength' => true]) ?>

<!-- attribute flo -->
			<?= $form->field($model, 'flo')->textInput() ?>

<!-- attribute palletnum -->
			<?= $form->field($model, 'palletnum')->textInput() ?>

<!-- attribute qa_ng -->
			<?= $form->field($model, 'qa_ng')->textarea(['rows' => 6]) ?>

<!-- attribute model -->

<!-- attribute color -->

<!-- attribute qa_ok -->
			<?= $form->field($model, 'qa_ok')->textInput(['maxlength' => true]) ?>

<!-- attribute dest -->

<!-- attribute fg_storage -->

<!-- attribute qa_ng_date -->
			<?= $form->field($model, 'qa_ng_date')->textInput(['maxlength' => true]) ?>

<!-- attribute qa_ok_date -->
			<?= $form->field($model, 'qa_ok_date')->textInput(['maxlength' => true]) ?>

<!-- attribute fg_invoice -->

<!-- attribute fg_invoice_date -->

<!-- attribute fg_invoice_ship -->
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'SernoInput'),
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

