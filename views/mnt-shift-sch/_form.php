<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use yii\jui\DatePicker;

/**
* @var yii\web\View $this
* @var app\models\MntShiftSch $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="mnt-shift-sch-form">

    <?php $form = ActiveForm::begin([
    'id' => 'MntShiftSch',
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
            

<!-- attribute shift_emp_id -->
			<?= $form->field($model, 'shift_emp_id')->dropDownList(\yii\helpers\ArrayHelper::map(app\models\MntShiftEmp::find()->orderBy('name')->all(), 'id', 'name'),
    ['prompt' => 'Select'])->label('Employee Name') ?>

<!-- attribute shift_code -->
			<?= $form->field($model, 'shift_code')->dropDownList([
                1 => 'Morning Shift',
                2 => 'Day Shift',
                3 => 'Night Shift',
                4 => 'Day Off',
                5 => 'Absent',
            ], ['prompt' => 'Select'])->label('Shift') ?>

<!-- attribute shift_date -->
            <?= $form->field($model, 'shift_date')->widget(DatePicker::className(), [
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => [
                        'class' => 'form-control'
                    ]
            ]) ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'Input Form'),
    'content' => $this->blocks['main'],
    'active'  => true,
],
                    ]
                 ]
    );
    ?>
        <hr/>

        <?php echo $form->errorSummary($model); ?>
        
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <div class="pull-right">
                <?= Html::submitButton(
                '<span class="glyphicon glyphicon-check"></span> ' .
                ($model->isNewRecord ? 'Create' : 'Save'),
                [
                'id' => 'save-' . $model->formName(),
                'class' => 'btn btn-success'
                ]
                );
                ?>
                &nbsp;
                <?=  Html::a(
                    'Cancel',
                    \yii\helpers\Url::previous(),
                    ['class' => 'btn btn-warning']); ?>
                </div>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>

