<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\SplCode $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="spl-code-form">

    <?php $form = ActiveForm::begin([
    'id' => 'SplCode',
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
            

<!-- attribute KODE_LEMBUR -->
			<?= $form->field($model, 'KODE_LEMBUR')->textInput() ?>

<!-- attribute JENIS_LEMBUR -->
			<?= $form->field($model, 'JENIS_LEMBUR')->textInput() ?>

<!-- attribute START_LEMBUR_PLAN -->
			<?= $form->field($model, 'START_LEMBUR_PLAN')->textInput() ?>

<!-- attribute END_LEMBUR_PLAN -->
			<?= $form->field($model, 'END_LEMBUR_PLAN')->textInput() ?>

<!-- attribute NILAI_LEMBUR_PLAN -->
			<?= $form->field($model, 'NILAI_LEMBUR_PLAN')->textInput() ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'SplCode'),
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

