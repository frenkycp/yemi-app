<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\JobOrder $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="job-order-form">

    <?php $form = ActiveForm::begin([
    'id' => 'JobOrder',
    'layout' => 'horizontal',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-danger'
    ]
    );
    ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>
            

<!-- attribute JOB_ORDER_NO -->
			<?= $form->field($model, 'JOB_ORDER_NO')->textInput() ?>

<!-- attribute JOB_ORDER_BARCODE -->
			<?= $form->field($model, 'JOB_ORDER_BARCODE')->textInput() ?>

<!-- attribute LOC -->
			<?= $form->field($model, 'LOC')->textInput() ?>

<!-- attribute LOC_DESC -->
			<?= $form->field($model, 'LOC_DESC')->textInput() ?>

<!-- attribute LINE -->
			<?= $form->field($model, 'LINE')->textInput() ?>

<!-- attribute NIK -->
			<?= $form->field($model, 'NIK')->textInput() ?>

<!-- attribute NAMA_KARYAWAN -->
			<?= $form->field($model, 'NAMA_KARYAWAN')->textInput() ?>

<!-- attribute SMT_SHIFT -->
			<?= $form->field($model, 'SMT_SHIFT')->textInput() ?>

<!-- attribute KELOMPOK -->
			<?= $form->field($model, 'KELOMPOK')->textInput() ?>

<!-- attribute ITEM -->
			<?= $form->field($model, 'ITEM')->textInput() ?>

<!-- attribute ITEM_DESC -->
			<?= $form->field($model, 'ITEM_DESC')->textInput() ?>

<!-- attribute UM -->
			<?= $form->field($model, 'UM')->textInput() ?>

<!-- attribute MODEL -->
			<?= $form->field($model, 'MODEL')->textInput() ?>

<!-- attribute DESTINATION -->
			<?= $form->field($model, 'DESTINATION')->textInput() ?>

<!-- attribute USER_ID -->
			<?= $form->field($model, 'USER_ID')->textInput() ?>

<!-- attribute USER_DESC -->
			<?= $form->field($model, 'USER_DESC')->textInput() ?>

<!-- attribute STAGE -->
			<?= $form->field($model, 'STAGE')->textInput() ?>

<!-- attribute STATUS -->
			<?= $form->field($model, 'STATUS')->textInput() ?>

<!-- attribute JOB_ORDER_LOT_NO -->
			<?= $form->field($model, 'JOB_ORDER_LOT_NO')->textInput() ?>

<!-- attribute USER_ID_START -->
			<?= $form->field($model, 'USER_ID_START')->textInput() ?>

<!-- attribute USER_DESC_START -->
			<?= $form->field($model, 'USER_DESC_START')->textInput() ?>

<!-- attribute USER_ID_PAUSE -->
			<?= $form->field($model, 'USER_ID_PAUSE')->textInput() ?>

<!-- attribute USER_DESC_PAUSE -->
			<?= $form->field($model, 'USER_DESC_PAUSE')->textInput() ?>

<!-- attribute USER_ID_CONTINUED -->
			<?= $form->field($model, 'USER_ID_CONTINUED')->textInput() ?>

<!-- attribute USER_DESC_CONTINUED -->
			<?= $form->field($model, 'USER_DESC_CONTINUED')->textInput() ?>

<!-- attribute USER_ID_ENDED -->
			<?= $form->field($model, 'USER_ID_ENDED')->textInput() ?>

<!-- attribute USER_DESC_ENDED -->
			<?= $form->field($model, 'USER_DESC_ENDED')->textInput() ?>

<!-- attribute NOTE -->
			<?= $form->field($model, 'NOTE')->textInput() ?>

<!-- attribute NOTE2 -->
			<?= $form->field($model, 'NOTE2')->textInput() ?>

<!-- attribute CONFORWARD -->
			<?= $form->field($model, 'CONFORWARD')->textInput() ?>

<!-- attribute CONFORWARD_PRINT -->
			<?= $form->field($model, 'CONFORWARD_PRINT')->textInput() ?>

<!-- attribute SCH_DATE -->
			<?= $form->field($model, 'SCH_DATE')->textInput() ?>

<!-- attribute START_DATE -->
			<?= $form->field($model, 'START_DATE')->textInput() ?>

<!-- attribute PAUSE_DATE -->
			<?= $form->field($model, 'PAUSE_DATE')->textInput() ?>

<!-- attribute CONTINUED_DATE -->
			<?= $form->field($model, 'CONTINUED_DATE')->textInput() ?>

<!-- attribute END_DATE -->
			<?= $form->field($model, 'END_DATE')->textInput() ?>

<!-- attribute LAST_UPDATE -->
			<?= $form->field($model, 'LAST_UPDATE')->textInput() ?>

<!-- attribute MAN_POWER -->
			<?= $form->field($model, 'MAN_POWER')->textInput() ?>

<!-- attribute LOT_QTY -->
			<?= $form->field($model, 'LOT_QTY')->textInput() ?>

<!-- attribute ORDER_QTY -->
			<?= $form->field($model, 'ORDER_QTY')->textInput() ?>

<!-- attribute COMMIT_QTY -->
			<?= $form->field($model, 'COMMIT_QTY')->textInput() ?>

<!-- attribute OPEN_QTY -->
			<?= $form->field($model, 'OPEN_QTY')->textInput() ?>

<!-- attribute STD_TIME_VAR -->
			<?= $form->field($model, 'STD_TIME_VAR')->textInput() ?>

<!-- attribute STD_TIME -->
			<?= $form->field($model, 'STD_TIME')->textInput() ?>

<!-- attribute INSERT_POINT_VAR -->
			<?= $form->field($model, 'INSERT_POINT_VAR')->textInput() ?>

<!-- attribute INSERT_POINT -->
			<?= $form->field($model, 'INSERT_POINT')->textInput() ?>

<!-- attribute LOST_TIME -->
			<?= $form->field($model, 'LOST_TIME')->textInput() ?>

<!-- attribute DANDORI -->
			<?= $form->field($model, 'DANDORI')->textInput() ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('app', 'JobOrder'),
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

