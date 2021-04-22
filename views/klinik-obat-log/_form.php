<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\KlinikObatLog $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="klinik-obat-log-form">

    <?php $form = ActiveForm::begin([
    'id' => 'KlinikObatLog',
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
            

<!-- attribute klinik_input_pk -->
			<?= $form->field($model, 'klinik_input_pk')->textInput(['maxlength' => true]) ?>

<!-- attribute post_date -->
			<?= $form->field($model, 'post_date')->textInput() ?>

<!-- attribute input_datetime -->
			<?= $form->field($model, 'input_datetime')->textInput() ?>

<!-- attribute qty -->
			<?= $form->field($model, 'qty')->textInput() ?>

<!-- attribute flag -->
			<?= $form->field($model, 'flag')->textInput() ?>

<!-- attribute period -->
			<?= $form->field($model, 'period')->textInput(['maxlength' => true]) ?>

<!-- attribute user_id -->
			<?= $form->field($model, 'user_id')->textInput(['maxlength' => true]) ?>

<!-- attribute part_no -->
			<?= $form->field($model, 'part_no')->textInput(['maxlength' => true]) ?>

<!-- attribute user_name -->
			<?= $form->field($model, 'user_name')->textInput(['maxlength' => true]) ?>

<!-- attribute part_desc -->
			<?= $form->field($model, 'part_desc')->textInput(['maxlength' => true]) ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'KlinikObatLog'),
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

