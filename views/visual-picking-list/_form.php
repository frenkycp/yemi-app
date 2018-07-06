<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\VisualPickingList $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="visual-picking-list-form">

    <?php $form = ActiveForm::begin([
    'id' => 'VisualPickingList',
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
            

<!-- attribute set_list_no -->
			<?= $form->field($model, 'set_list_no')->textInput() ?>

<!-- attribute parent -->
			<?= $form->field($model, 'parent')->textInput() ?>

<!-- attribute parent_desc -->
			<?= $form->field($model, 'parent_desc')->textInput() ?>

<!-- attribute parent_um -->
			<?= $form->field($model, 'parent_um')->textInput() ?>

<!-- attribute analyst -->
			<?= $form->field($model, 'analyst')->textInput() ?>

<!-- attribute analyst_desc -->
			<?= $form->field($model, 'analyst_desc')->textInput() ?>

<!-- attribute create_user_id -->
			<?= $form->field($model, 'create_user_id')->textInput() ?>

<!-- attribute create_user_desc -->
			<?= $form->field($model, 'create_user_desc')->textInput() ?>

<!-- attribute confirm_user_id -->
			<?= $form->field($model, 'confirm_user_id')->textInput() ?>

<!-- attribute confirm_user_desc -->
			<?= $form->field($model, 'confirm_user_desc')->textInput() ?>

<!-- attribute start_user_id -->
			<?= $form->field($model, 'start_user_id')->textInput() ?>

<!-- attribute start_user_desc -->
			<?= $form->field($model, 'start_user_desc')->textInput() ?>

<!-- attribute completed_user_id -->
			<?= $form->field($model, 'completed_user_id')->textInput() ?>

<!-- attribute completed_user_desc -->
			<?= $form->field($model, 'completed_user_desc')->textInput() ?>

<!-- attribute hand_over_user_id -->
			<?= $form->field($model, 'hand_over_user_id')->textInput() ?>

<!-- attribute hand_over_user_desc -->
			<?= $form->field($model, 'hand_over_user_desc')->textInput() ?>

<!-- attribute stage_desc -->
			<?= $form->field($model, 'stage_desc')->textInput() ?>

<!-- attribute condition_desc -->
			<?= $form->field($model, 'condition_desc')->textInput() ?>

<!-- attribute stat -->
			<?= $form->field($model, 'stat')->textInput() ?>

<!-- attribute catatan -->
			<?= $form->field($model, 'catatan')->textInput() ?>

<!-- attribute pts_stat -->
			<?= $form->field($model, 'pts_stat')->textInput() ?>

<!-- attribute set_list_type -->
			<?= $form->field($model, 'set_list_type')->textInput() ?>

<!-- attribute id_01 -->
			<?= $form->field($model, 'id_01')->textInput() ?>

<!-- attribute id_01_desc -->
			<?= $form->field($model, 'id_01_desc')->textInput() ?>

<!-- attribute id_02 -->
			<?= $form->field($model, 'id_02')->textInput() ?>

<!-- attribute id_02_desc -->
			<?= $form->field($model, 'id_02_desc')->textInput() ?>

<!-- attribute id_03 -->
			<?= $form->field($model, 'id_03')->textInput() ?>

<!-- attribute id_03_desc -->
			<?= $form->field($model, 'id_03_desc')->textInput() ?>

<!-- attribute id_04 -->
			<?= $form->field($model, 'id_04')->textInput() ?>

<!-- attribute id_04_desc -->
			<?= $form->field($model, 'id_04_desc')->textInput() ?>

<!-- attribute id_05 -->
			<?= $form->field($model, 'id_05')->textInput() ?>

<!-- attribute id_05_desc -->
			<?= $form->field($model, 'id_05_desc')->textInput() ?>

<!-- attribute id_06 -->
			<?= $form->field($model, 'id_06')->textInput() ?>

<!-- attribute id_06_desc -->
			<?= $form->field($model, 'id_06_desc')->textInput() ?>

<!-- attribute id_07 -->
			<?= $form->field($model, 'id_07')->textInput() ?>

<!-- attribute id_07_desc -->
			<?= $form->field($model, 'id_07_desc')->textInput() ?>

<!-- attribute id_08 -->
			<?= $form->field($model, 'id_08')->textInput() ?>

<!-- attribute id_08_desc -->
			<?= $form->field($model, 'id_08_desc')->textInput() ?>

<!-- attribute id_09 -->
			<?= $form->field($model, 'id_09')->textInput() ?>

<!-- attribute id_09_desc -->
			<?= $form->field($model, 'id_09_desc')->textInput() ?>

<!-- attribute id_10 -->
			<?= $form->field($model, 'id_10')->textInput() ?>

<!-- attribute id_10_desc -->
			<?= $form->field($model, 'id_10_desc')->textInput() ?>

<!-- attribute id_update -->
			<?= $form->field($model, 'id_update')->textInput() ?>

<!-- attribute id_update_desc -->
			<?= $form->field($model, 'id_update_desc')->textInput() ?>

<!-- attribute sudah_cetak -->
			<?= $form->field($model, 'sudah_cetak')->textInput() ?>

<!-- attribute id_prioty -->
			<?= $form->field($model, 'id_prioty')->textInput() ?>

<!-- attribute id_prioty_desc -->
			<?= $form->field($model, 'id_prioty_desc')->textInput() ?>

<!-- attribute id_hc -->
			<?= $form->field($model, 'id_hc')->textInput() ?>

<!-- attribute id_hc_desc -->
			<?= $form->field($model, 'id_hc_desc')->textInput() ?>

<!-- attribute id_hc_stat -->
			<?= $form->field($model, 'id_hc_stat')->textInput() ?>

<!-- attribute id_hc_open -->
			<?= $form->field($model, 'id_hc_open')->textInput() ?>

<!-- attribute id_hc_open_desc -->
			<?= $form->field($model, 'id_hc_open_desc')->textInput() ?>

<!-- attribute id_hc_open_stat -->
			<?= $form->field($model, 'id_hc_open_stat')->textInput() ?>

<!-- attribute pts_note -->
			<?= $form->field($model, 'pts_note')->textInput() ?>

<!-- attribute show -->
			<?= $form->field($model, 'show')->textInput() ?>

<!-- attribute back_up_period -->
			<?= $form->field($model, 'back_up_period')->textInput() ?>

<!-- attribute back_up -->
			<?= $form->field($model, 'back_up')->textInput() ?>

<!-- attribute req_date -->
			<?= $form->field($model, 'req_date')->textInput() ?>

<!-- attribute req_date_original -->
			<?= $form->field($model, 'req_date_original')->textInput() ?>

<!-- attribute create_date -->
			<?= $form->field($model, 'create_date')->textInput() ?>

<!-- attribute confirm_date -->
			<?= $form->field($model, 'confirm_date')->textInput() ?>

<!-- attribute start_date -->
			<?= $form->field($model, 'start_date')->textInput() ?>

<!-- attribute completed_date -->
			<?= $form->field($model, 'completed_date')->textInput() ?>

<!-- attribute hand_over_date -->
			<?= $form->field($model, 'hand_over_date')->textInput() ?>

<!-- attribute id_update_date -->
			<?= $form->field($model, 'id_update_date')->textInput() ?>

<!-- attribute id_prioty_date -->
			<?= $form->field($model, 'id_prioty_date')->textInput() ?>

<!-- attribute id_hc_date -->
			<?= $form->field($model, 'id_hc_date')->textInput() ?>

<!-- attribute id_hc_open_date -->
			<?= $form->field($model, 'id_hc_open_date')->textInput() ?>

<!-- attribute closing_date -->
			<?= $form->field($model, 'closing_date')->textInput() ?>

<!-- attribute plan_qty -->
			<?= $form->field($model, 'plan_qty')->textInput() ?>

<!-- attribute progress_pct -->
			<?= $form->field($model, 'progress_pct')->textInput() ?>

<!-- attribute pick_lt -->
			<?= $form->field($model, 'pick_lt')->textInput() ?>

<!-- attribute part_count -->
			<?= $form->field($model, 'part_count')->textInput() ?>

<!-- attribute part_count_fix -->
			<?= $form->field($model, 'part_count_fix')->textInput() ?>

<!-- attribute man_power -->
			<?= $form->field($model, 'man_power')->textInput() ?>

<!-- attribute priority -->
			<?= $form->field($model, 'priority')->textInput() ?>

<!-- attribute stage_id -->
			<?= $form->field($model, 'stage_id')->textInput() ?>

<!-- attribute pts_part -->
			<?= $form->field($model, 'pts_part')->textInput() ?>

<!-- attribute delay_days -->
			<?= $form->field($model, 'delay_days')->textInput() ?>

<!-- attribute slip_count -->
			<?= $form->field($model, 'slip_count')->textInput() ?>

<!-- attribute slip_open -->
			<?= $form->field($model, 'slip_open')->textInput() ?>

<!-- attribute slip_close -->
			<?= $form->field($model, 'slip_close')->textInput() ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'VisualPickingList'),
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

