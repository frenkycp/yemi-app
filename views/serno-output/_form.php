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
			<?= $form->field($model, 'pk')->textInput(['maxlength' => true]) ?>

<!-- attribute id -->
			<?= $form->field($model, 'id')->textInput() ?>

<!-- attribute num -->
			<?= $form->field($model, 'num')->textInput() ?>

<!-- attribute qty -->
			<?= $form->field($model, 'qty')->textInput() ?>

<!-- attribute output -->
			<?= $form->field($model, 'output')->textInput() ?>

<!-- attribute adv -->
			<?= $form->field($model, 'adv')->textInput() ?>

<!-- attribute cntr -->
			<?= $form->field($model, 'cntr')->textInput() ?>

<!-- attribute dst -->
			<?= $form->field($model, 'dst')->textarea(['rows' => 6]) ?>

<!-- attribute etd -->
			<?= $form->field($model, 'etd')->textInput() ?>

<!-- attribute stc -->
			<?= $form->field($model, 'stc')->textInput(['maxlength' => true]) ?>

<!-- attribute gmc -->
			<?= $form->field($model, 'gmc')->textInput(['maxlength' => true]) ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('app', 'SernoOutput'),
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

