<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\TraceItemScrap $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="trace-item-scrap-form">

    <?php $form = ActiveForm::begin([
    'id' => 'TraceItemScrap',
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
            

<!-- attribute SERIAL_NO -->
			<?= $form->field($model, 'SERIAL_NO')->textInput(['maxlength' => true]) ?>

<!-- attribute ITEM_DESC -->
			<?= $form->field($model, 'ITEM_DESC')->textInput() ?>

<!-- attribute SUPPLIER_DESC -->
			<?= $form->field($model, 'SUPPLIER_DESC')->textInput() ?>

<!-- attribute USER_DESC -->
			<?= $form->field($model, 'USER_DESC')->textInput() ?>

<!-- attribute CLOSE_BY_NAME -->
			<?= $form->field($model, 'CLOSE_BY_NAME')->textInput() ?>

<!-- attribute REMARK -->
			<?= $form->field($model, 'REMARK')->textInput() ?>

<!-- attribute QTY -->
			<?= $form->field($model, 'QTY')->textInput() ?>

<!-- attribute EXPIRED_DATE -->
			<?= $form->field($model, 'EXPIRED_DATE')->textInput() ?>

<!-- attribute LATEST_EXPIRED_DATE -->
			<?= $form->field($model, 'LATEST_EXPIRED_DATE')->textInput() ?>

<!-- attribute USER_LAST_UPDATE -->
			<?= $form->field($model, 'USER_LAST_UPDATE')->textInput() ?>

<!-- attribute CLOSE_DATETIME -->
			<?= $form->field($model, 'CLOSE_DATETIME')->textInput() ?>

<!-- attribute ITEM -->
			<?= $form->field($model, 'ITEM')->textInput(['maxlength' => true]) ?>

<!-- attribute SUPPLIER -->
			<?= $form->field($model, 'SUPPLIER')->textInput(['maxlength' => true]) ?>

<!-- attribute USER_ID -->
			<?= $form->field($model, 'USER_ID')->textInput(['maxlength' => true]) ?>

<!-- attribute CLOSE_BY_ID -->
			<?= $form->field($model, 'CLOSE_BY_ID')->textInput(['maxlength' => true]) ?>

<!-- attribute UM -->
			<?= $form->field($model, 'UM')->textInput(['maxlength' => true]) ?>

<!-- attribute STATUS -->
			<?= $form->field($model, 'STATUS')->textInput(['maxlength' => true]) ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'TraceItemScrap'),
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

