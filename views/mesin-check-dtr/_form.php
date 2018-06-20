<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\MesinCheckDtr $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="mesin-check-dtr-form">

    <?php $form = ActiveForm::begin([
    'id' => 'MesinCheckDtr',
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
            

<!-- attribute master_id -->
			<?= $form->field($model, 'master_id')->textInput() ?>

<!-- attribute mesin_id -->
			<?= $form->field($model, 'mesin_id')->textInput() ?>

<!-- attribute machine_desc -->
			<?= $form->field($model, 'machine_desc')->textInput() ?>

<!-- attribute location -->
			<?= $form->field($model, 'location')->textInput() ?>

<!-- attribute area -->
			<?= $form->field($model, 'area')->textInput() ?>

<!-- attribute mesin_periode -->
			<?= $form->field($model, 'mesin_periode')->textInput() ?>

<!-- attribute user_id -->
			<?= $form->field($model, 'user_id')->textInput() ?>

<!-- attribute user_desc -->
			<?= $form->field($model, 'user_desc')->textInput() ?>

<!-- attribute master_plan_maintenance -->
			<?= $form->field($model, 'master_plan_maintenance')->textInput() ?>

<!-- attribute mesin_last_update -->
			<?= $form->field($model, 'mesin_last_update')->textInput() ?>

<!-- attribute mesin_next_schedule -->
			<?= $form->field($model, 'mesin_next_schedule')->textInput() ?>

<!-- attribute sisa_waktu -->
			<?= $form->field($model, 'sisa_waktu')->textInput() ?>

<!-- attribute count_list -->
			<?= $form->field($model, 'count_list')->textInput() ?>

<!-- attribute count_update -->
			<?= $form->field($model, 'count_update')->textInput() ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('app', 'MesinCheckDtr'),
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

