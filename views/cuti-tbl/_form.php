<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\CutiTbl $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="cuti-tbl-form">

    <?php $form = ActiveForm::begin([
    'id' => 'CutiTbl',
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
            

<!-- attribute CUTI_ID -->
			<?= ''; //$form->field($model, 'CUTI_ID')->textInput() ?>

<!-- attribute NIK -->
			<?= $form->field($model, 'NIK')->textInput(['readonly' => true])->label('NIK') ?>

<!-- attribute NAMA_KARYAWAN -->
			<?= $form->field($model, 'NAMA_KARYAWAN')->textInput(['readonly' => true])->label('Name') ?>

<!-- attribute CATEGORY -->
			<?= $form->field($model, 'CATEGORY')->textInput(['readonly' => true]) ?>

<!-- attribute TAHUN -->
			<?= $form->field($model, 'TAHUN')->textInput(['readonly' => true])->label('Year') ?>

<!-- attribute JUMLAH_CUTI -->
			<?= $form->field($model, 'JUMLAH_CUTI')->textInput()->label('Quota') ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'Form'),
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

