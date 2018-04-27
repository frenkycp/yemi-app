<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\TpPartList $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="tp-part-list-form">

    <?php $form = ActiveForm::begin([
    'id' => 'TpPartList',
    'layout' => 'horizontal',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-danger'
    ]
    );
    ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>
            

<!-- attribute rev_no -->
			<?= $form->field($model, 'rev_no')->textInput() ?>

<!-- attribute total_product -->
			<?= $form->field($model, 'total_product')->textInput() ?>

<!-- attribute total_assy -->
			<?= $form->field($model, 'total_assy')->textInput() ?>

<!-- attribute total_spare_part -->
			<?= $form->field($model, 'total_spare_part')->textInput() ?>

<!-- attribute total_requirement -->
			<?= $form->field($model, 'total_requirement')->textInput() ?>

<!-- attribute present_qty -->
			<?= $form->field($model, 'present_qty')->textInput() ?>

<!-- attribute qty -->
			<?= $form->field($model, 'qty')->textInput() ?>

<!-- attribute transportation_cost -->
			<?= $form->field($model, 'transportation_cost')->textInput() ?>

<!-- attribute present_due_date -->
			<?= $form->field($model, 'present_due_date')->textInput() ?>

<!-- attribute last_modified -->
			<?= $form->field($model, 'last_modified')->textInput() ?>

<!-- attribute speaker_model -->
			<?= $form->field($model, 'speaker_model')->textInput(['maxlength' => true]) ?>

<!-- attribute present_po -->
			<?= $form->field($model, 'present_po')->textInput(['maxlength' => true]) ?>

<!-- attribute dcn_no -->
			<?= $form->field($model, 'dcn_no')->textInput(['maxlength' => true]) ?>

<!-- attribute direct_po_trf -->
			<?= $form->field($model, 'direct_po_trf')->textInput(['maxlength' => true]) ?>

<!-- attribute delivery_conf_etd -->
			<?= $form->field($model, 'delivery_conf_etd')->textInput(['maxlength' => true]) ?>

<!-- attribute delivery_conf_eta -->
			<?= $form->field($model, 'delivery_conf_eta')->textInput(['maxlength' => true]) ?>

<!-- attribute act_delivery_etd -->
			<?= $form->field($model, 'act_delivery_etd')->textInput(['maxlength' => true]) ?>

<!-- attribute act_delivery_eta -->
			<?= $form->field($model, 'act_delivery_eta')->textInput(['maxlength' => true]) ?>

<!-- attribute transport_by -->
			<?= $form->field($model, 'transport_by')->textInput(['maxlength' => true]) ?>

<!-- attribute part_no -->
			<?= $form->field($model, 'part_no')->textInput(['maxlength' => true]) ?>

<!-- attribute part_type -->
			<?= $form->field($model, 'part_type')->textInput(['maxlength' => true]) ?>

<!-- attribute part_status -->
			<?= $form->field($model, 'part_status')->textInput(['maxlength' => true]) ?>

<!-- attribute caf_no -->
			<?= $form->field($model, 'caf_no')->textInput(['maxlength' => true]) ?>

<!-- attribute purch_status -->
			<?= $form->field($model, 'purch_status')->textInput(['maxlength' => true]) ?>

<!-- attribute pc_status -->
			<?= $form->field($model, 'pc_status')->textInput(['maxlength' => true]) ?>

<!-- attribute pe_confirm -->
			<?= $form->field($model, 'pe_confirm')->textInput(['maxlength' => true]) ?>

<!-- attribute status -->
			<?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

<!-- attribute qa_judgement -->
			<?= $form->field($model, 'qa_judgement')->textInput(['maxlength' => true]) ?>

<!-- attribute qa_remark -->
			<?= $form->field($model, 'qa_remark')->textInput(['maxlength' => true]) ?>

<!-- attribute part_name -->
			<?= $form->field($model, 'part_name')->textInput(['maxlength' => true]) ?>

<!-- attribute pc_remarks -->
			<?= $form->field($model, 'pc_remarks')->textInput(['maxlength' => true]) ?>

<!-- attribute invoice -->
			<?= $form->field($model, 'invoice')->textInput(['maxlength' => true]) ?>

<!-- attribute last_modified_by -->
			<?= $form->field($model, 'last_modified_by')->textInput(['maxlength' => true]) ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('app', 'TpPartList'),
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

