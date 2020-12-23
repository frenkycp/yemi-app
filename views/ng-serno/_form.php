<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\ProdNgDetailSerno $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="prod-ng-detail-serno-form">

    <?php $form = ActiveForm::begin([
    'id' => 'ProdNgDetailSerno',
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
            

<!-- attribute post_date -->
			<?= $form->field($model, 'post_date')->textInput() ?>

<!-- attribute create_date -->
			<?= $form->field($model, 'create_date')->textInput() ?>

<!-- attribute last_update -->
			<?= $form->field($model, 'last_update')->textInput() ?>

<!-- attribute img_before -->
			<?= $form->field($model, 'img_before')->textInput() ?>

<!-- attribute img_after -->
			<?= $form->field($model, 'img_after')->textInput() ?>

<!-- attribute flag -->
			<?= $form->field($model, 'flag')->textInput() ?>

<!-- attribute loc_id -->
			<?= $form->field($model, 'loc_id')->textInput(['maxlength' => true]) ?>

<!-- attribute document_no -->
			<?= $form->field($model, 'document_no')->textInput(['maxlength' => true]) ?>

<!-- attribute serial_no -->
			<?= $form->field($model, 'serial_no')->textInput(['maxlength' => true]) ?>

<!-- attribute repair_id -->
			<?= $form->field($model, 'repair_id')->textInput(['maxlength' => true]) ?>

<!-- attribute repair_name -->
			<?= $form->field($model, 'repair_name')->textInput(['maxlength' => true]) ?>

<!-- attribute user_id -->
			<?= $form->field($model, 'user_id')->textInput(['maxlength' => true]) ?>

<!-- attribute period -->
			<?= $form->field($model, 'period')->textInput(['maxlength' => true]) ?>

<!-- attribute user_name -->
			<?= $form->field($model, 'user_name')->textInput(['maxlength' => true]) ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'ProdNgDetailSerno'),
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

