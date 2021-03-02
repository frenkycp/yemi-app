<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\EmpInterviewYubisashi $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="emp-interview-yubisashi-form">

    <?php $form = ActiveForm::begin([
    'id' => 'EmpInterviewYubisashi',
    //'layout' => 'horizontal',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-danger',
    /*'fieldConfig' => [
             'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
             'horizontalCssClasses' => [
                 'label' => 'col-sm-2',
                 #'offset' => 'col-sm-offset-4',
                 'wrapper' => 'col-sm-8',
                 'error' => '',
                 'hint' => '',
             ],
         ],*/
    ]
    );
    ?>

    <div class="">
        <div class="row">
            <div class="col-sm-2">
                <?= $form->field($model, 'FISCAL_YEAR')->textInput(['readonly' => true]) ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($model, 'EMP_NAME')->textInput(['readonly' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <?= $form->field($model, 'YAMAHA_DIAMOND')->dropDownList(\Yii::$app->params['interview_yubisashi_value_arr']) ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($model, 'K3')->dropDownList(\Yii::$app->params['interview_yubisashi_value_arr']) ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($model, 'SLOGAN_KUALITAS')->dropDownList(\Yii::$app->params['interview_yubisashi_value_arr']) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <?= $form->field($model, 'KESELAMATAN_LALU_LINTAS')->dropDownList(\Yii::$app->params['interview_yubisashi_value_arr']) ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($model, 'KOMITMENT_BERKENDARA')->dropDownList(\Yii::$app->params['interview_yubisashi_value_arr']) ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($model, 'BUDAYA_KERJA')->dropDownList(\Yii::$app->params['interview_yubisashi_value_arr']) ?>
            </div>
        </div>
        
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
        &nbsp;
        <?=             Html::a(
            'Cancel',
            \yii\helpers\Url::previous(),
            ['class' => 'btn btn-warning']) ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>

