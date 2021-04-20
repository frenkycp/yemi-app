<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\InjMoldingTbl $model
* @var yii\widgets\ActiveForm $form
*/

$css_string = "
    .content-header {display: none;}";
$this->registerCss($css_string);

?>

<div class="inj-molding-tbl-form">

    <?php $form = ActiveForm::begin([
    'id' => 'InjMoldingTbl',
    //'layout' => 'horizontal',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-danger',
    
    ]
    );
    ?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Molding Data (<?= ($model->isNewRecord ? 'Create' : 'Update') ?>)</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-3">
                <?= $form->field($model, 'MOLDING_ID')->textInput(['readonly' => $model->isNewRecord ? false : true]) ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'MOLDING_NAME')->textInput(['readonly' => $model->isNewRecord ? false : true]) ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'TOTAL_COUNT')->textInput(['type' => 'number']) ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'TARGET_COUNT')->textInput(['type' => 'number']) ?>
            </div>
        </div>
    </div>
    <div class="panel-footer">
        <?php echo $form->errorSummary($model); ?>

        <?=             Html::a(
            'Cancel',
            \yii\helpers\Url::previous(),
            ['class' => 'btn btn-default']) ?>

        <?= Html::submitButton(
        '<span class="glyphicon glyphicon-check"></span> ' .
        ($model->isNewRecord ? 'Create' : 'Save'),
        [
        'id' => 'save-' . $model->formName(),
        'class' => 'btn btn-success'
        ]
        );
        ?>
    </div>
</div>

        



        <?php ActiveForm::end(); ?>

    </div>

</div>

