<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\GojekOrderTbl $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="gojek-order-tbl-form">

    <?php $form = ActiveForm::begin([
    'id' => 'GojekOrderTbl',
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
            

<!-- attribute slip_id -->
			<?= $form->field($model, 'slip_id')->textInput() ?>

<!-- attribute item -->
			<?= $form->field($model, 'item')->textInput() ?>

<!-- attribute item_desc -->
			<?= $form->field($model, 'item_desc')->textInput() ?>

<!-- attribute from_loc -->
			<?= $form->field($model, 'from_loc')->textInput() ?>

<!-- attribute to_loc -->
			<?= $form->field($model, 'to_loc')->textInput() ?>

<!-- attribute source -->
			<?= $form->field($model, 'source')->textInput() ?>

<!-- attribute GOJEK_ID -->
			<?= $form->field($model, 'GOJEK_ID')->textInput() ?>

<!-- attribute GOJEK_DESC -->
			<?= $form->field($model, 'GOJEK_DESC')->textInput() ?>

<!-- attribute NIK_REQUEST -->
			<?= $form->field($model, 'NIK_REQUEST')->textInput() ?>

<!-- attribute NAMA_KARYAWAN -->
			<?= $form->field($model, 'NAMA_KARYAWAN')->textInput() ?>

<!-- attribute STAT -->
			<?= $form->field($model, 'STAT')->textInput() ?>

<!-- attribute issued_date -->
			<?= $form->field($model, 'issued_date')->textInput() ?>

<!-- attribute daparture_date -->
			<?= $form->field($model, 'daparture_date')->textInput() ?>

<!-- attribute arrival_date -->
			<?= $form->field($model, 'arrival_date')->textInput() ?>

<!-- attribute GOJEK_VALUE -->
			<?= $form->field($model, 'GOJEK_VALUE')->textInput() ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'GojekOrderTbl'),
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

