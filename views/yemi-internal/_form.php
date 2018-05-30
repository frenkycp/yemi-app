<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\SernoOutput $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="serno-output-form">

    <?php $form = ActiveForm::begin([
    'id' => 'SernoOutput',
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
            

<!-- attribute pk -->
			<?= '';//$form->field($model, 'pk')->textInput(['maxlength' => true]) ?>

<!-- attribute id -->
			<?= '';//$form->field($model, 'id')->textInput() ?>

<!-- attribute num -->
			<?= '';//$form->field($model, 'num')->textInput() ?>

            <?= $form->field($model, 'cust_desc')->textInput(['maxlength' => true, 'readonly' => true, 'value' => $model->shipCustomer->customer_desc]) ?>

<!-- attribute dst -->
            <?= $form->field($model, 'dst')->textInput(['maxlength' => true, 'readonly' => true]) ?>

<!-- attribute gmc -->
            <?= $form->field($model, 'part_full_desc')->textInput(['readonly' => true, 'value' => $model->gmc . ' (' . $model->partName . ')'])->label('Product') ?>

<!-- attribute etd -->
            <?= $form->field($model, 'etd')->textInput(['readonly' => true]) ?>

<!-- attribute qty -->
			<?= $form->field($model, 'qty')->textInput(['readonly' => Yii::$app->user->identity->username == 'admin' ? false : true]) ?>

<!-- attribute output -->
			<?= $form->field($model, 'output')->textInput(['readonly' => Yii::$app->user->identity->username == 'admin' ? false : true]) ?>

<!-- attribute ng -->
			<?= ''; //$form->field($model, 'ng')->textInput(['readonly' => Yii::$app->user->identity->username == 'admin' ? false : true]) ?>

<!-- attribute ship -->
			<?= '';//$form->field($model, 'ship')->textInput() ?>

<!-- attribute category -->
			<?= $form->field($model, 'category')->dropDownList([
                'MACHINE' => 'MACHINE', 
                'MAN' => 'MAN',
                'MATERIAL' => 'MATERIAL',
                'METHOD' => 'METHOD'
            ], ['prompt' => 'Select NG Category']) ?>

<!-- attribute remark -->
			<?= $form->field($model, 'remark')->textInput(['maxlength' => true]) ?>

<!-- attribute description -->
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('app', $model->pk),
    'content' => $this->blocks['main'],
    'active'  => true,
],
                    ]
                 ]
    );
    ?>

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

