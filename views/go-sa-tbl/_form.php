<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use kartik\select2\Select2;

/**
* @var yii\web\View $this
* @var app\models\GoSaTbl $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="go-sa-tbl-form">

    <?php $form = ActiveForm::begin([
    'id' => 'GoSaTbl',
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
            

<!-- attribute REQUESTOR_NIK -->
			<?= $form->field($model, 'REQUESTOR_NIK')->textInput(['readonly' => true]) ?>

<!-- attribute REQUESTOR_NAME -->
			<?= $form->field($model, 'REQUESTOR_NAME')->textInput(['readonly' => true]) ?>

<!-- attribute REMARK -->
			<?= $form->field($model, 'REMARK')->textarea(['rows' => 6]) ?>

            <?= $form->field($model, 'EMP')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(app\models\GojekTbl::find()->where(['source' => 'SUB'])->all(), 'nikName', 'nikName'),
                'options' => ['placeholder' => 'Select operator ...'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'multiple' => true
                ],
            ])->label('Operator'); ?>
        

        <?php echo $form->errorSummary($model); ?>

        <?= Html::submitButton(
        '<span class="glyphicon glyphicon-check"></span> Create',
        [
        'id' => 'save-' . $model->formName(),
        'class' => 'btn btn-success'
        ]
        );
        ?>

        <?=  Html::a(
                    'Cancel',
                    \yii\helpers\Url::previous(),
                    ['class' => 'btn btn-warning']); ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>

