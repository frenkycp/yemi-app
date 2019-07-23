<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\form\ActiveForm;
use kartik\select2\Select2;

/**
* @var yii\web\View $this
* @var app\models\CutiTbl $model
*/

$this->title = [
    'page_title' => 'Finish Machine Process <span class="text-green japanesse"></span>',
    'tab_title' => 'Finish Machine Process',
    'breadcrumbs_title' => 'Finish Machine Process'
];
?>
<div class="giiant-crud cuti-tbl-update">

    <div class="cuti-tbl-form">

    <?php $form = ActiveForm::begin([
    'id' => 'ServerMntMachineCurrent',
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
            <div class="col-md-12">
                <?= $form->field($model, 'next_process_id')->dropDownList(
                    ArrayHelper::map(app\models\MachineIotCurrent::find()->select(['kelompok'])->groupBy('kelompok')->orderBy('kelompok')->all(), 'kelompok', 'kelompok'),           // Flat array ('id'=>'label')
                    [
                        'prompt' => '-- Select a group --'
                    ]    // options
                )->label('Next Process (Leave empty if there is no next process)'); ?>
            </div>
        </div>
			
        <hr/>

        <?php echo $form->errorSummary($model); ?>

        <?= Html::submitButton(
        '<span class="glyphicon glyphicon-check"></span> SUBMIT',
        [
        'id' => 'save-' . $model->formName(),
        'class' => 'btn btn-success'
        ]
        );
        ?>

        <?php ActiveForm::end(); ?>
        <button type="button" class="btn btn-warning" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove"></span> Cancel</button>

    </div>

</div>

</div>
