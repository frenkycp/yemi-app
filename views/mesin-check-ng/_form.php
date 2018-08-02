<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\MesinCheckNg $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="mesin-check-ng-form">

    <?php $form = ActiveForm::begin([
    'id' => 'MesinCheckNg',
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

<!-- attribute mesin_id -->
            <?= $form->field($model, 'mesin_id')->textInput(['readonly' => Yii::$app->user->identity->role->id == 1 ? false : true]) ?>

<!-- attribute mesin_nama -->
            <?= $form->field($model, 'mesin_nama')->textInput(['readonly' => Yii::$app->user->identity->role->id == 1 ? false : true]) ?>

<!-- attribute mesin_catatan -->
            <?= $form->field($model, 'mesin_catatan')->textArea(['rows' => 5, 'style' => 'resize: none;'])->label('Parts Remarks') ?>
            
<!-- attribute repair_note -->
            <?= $form->field($model, 'repair_note')->textInput() ?>

            <!-- attribute color_stat -->
            <?= ''; //$form->field($model, 'color_stat')->textInput() ?>

<!-- attribute repair_plan -->
            <?= $form->field($model, 'repair_plan')->widget(\yii\jui\DatePicker::class, [
                'dateFormat' => 'yyyy-MM-dd',
                'options' => [
                    'class' => 'form-control'
                ]
            ]) ?>

            <?= $form->field($model, 'prepare_time')->textInput(['type' => 'number'])->label('Prepare Time (minutes)') ?>
            <?= $form->field($model, 'repair_time')->textInput(['type' => 'number'])->label('Repair Time (minutes)') ?>
            <?= $form->field($model, 'spare_part_time')->textInput(['type' => 'number'])->label('Spare Part Time (minutes)') ?>
            <?= $form->field($model, 'install_time')->textInput(['type' => 'number'])->label('Install Time (minutes)') ?>

<!-- attribute location -->
			<?= $form->field($model, 'location')->textInput(['readonly' => Yii::$app->user->identity->role->id == 1 ? false : true]) ?>

<!-- attribute area -->
			<?= $form->field($model, 'area')->textInput(['readonly' => Yii::$app->user->identity->role->id == 1 ? false : true]) ?>

<!-- attribute mesin_no -->
			<?= $form->field($model, 'mesin_no')->textInput(['readonly' => Yii::$app->user->identity->role->id == 1 ? false : true]) ?>

<!-- attribute mesin_bagian -->
			<?= $form->field($model, 'mesin_bagian')->textInput(['readonly' => Yii::$app->user->identity->role->id == 1 ? false : true]) ?>

<!-- attribute mesin_bagian_ket -->
			<?= $form->field($model, 'mesin_bagian_ket')->textInput(['readonly' => Yii::$app->user->identity->role->id == 1 ? false : true]) ?>

<!-- attribute mesin_status -->
			<?= $form->field($model, 'mesin_status')->textInput(['readonly' => Yii::$app->user->identity->role->id == 1 ? false : true]) ?>

<!-- attribute mesin_periode -->
			<?= $form->field($model, 'mesin_periode')->textInput(['readonly' => Yii::$app->user->identity->role->id == 1 ? false : true]) ?>

<!-- attribute user_id -->
			<?= $form->field($model, 'user_id')->textInput(['readonly' => Yii::$app->user->identity->role->id == 1 ? false : true]) ?>

<!-- attribute user_desc -->
			<?= $form->field($model, 'user_desc')->textInput(['readonly' => Yii::$app->user->identity->role->id == 1 ? false : true]) ?>

<!-- attribute repair_user_id -->
			<?= $form->field($model, 'repair_user_id')->textInput(['readonly' => Yii::$app->user->identity->role->id == 1 ? false : true]) ?>

<!-- attribute repair_user_desc -->
			<?= $form->field($model, 'repair_user_desc')->textInput(['readonly' => Yii::$app->user->identity->role->id == 1 ? false : true]) ?>

<!-- attribute repair_status -->
			<?= $form->field($model, 'repair_status')->textInput(['readonly' => Yii::$app->user->identity->role->id == 1 ? false : true]) ?>

<!-- attribute repair_pic -->
			<?= $form->field($model, 'repair_pic')->textInput(['readonly' => Yii::$app->user->identity->role->id == 1 ? false : true]) ?>

<!-- attribute mesin_last_update -->
			<?= $form->field($model, 'mesin_last_update')->textInput(['readonly' => Yii::$app->user->identity->role->id == 1 ? false : true]) ?>

<!-- attribute repair_aktual -->
			<?= $form->field($model, 'repair_aktual')->textInput(['readonly' => Yii::$app->user->identity->role->id == 1 ? false : true]) ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('app', 'MesinCheckNg'),
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

