<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\MesinCheckDtr $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="mesin-check-dtr-form">

    <?php $form = ActiveForm::begin([
    'id' => 'MesinCheckDtr',
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
            

<!-- attribute master_id -->
			<?= $form->field($model, 'master_id')->textInput() ?>

<!-- attribute mesin_id -->
			<?= $form->field($model, 'mesin_id')->textInput() ?>

<!-- attribute machine_desc -->
			<?= $form->field($model, 'machine_desc')->textInput() ?>

<!-- attribute location -->
			<?= $form->field($model, 'location')->textInput() ?>

<!-- attribute area -->
			<?= $form->field($model, 'area')->textInput() ?>

<!-- attribute mesin_periode -->
			<?= $form->field($model, 'mesin_periode')->textInput() ?>

<!-- attribute r01 -->
			<?= $form->field($model, 'r01')->textInput() ?>

<!-- attribute r02 -->
			<?= $form->field($model, 'r02')->textInput() ?>

<!-- attribute r03 -->
			<?= $form->field($model, 'r03')->textInput() ?>

<!-- attribute r04 -->
			<?= $form->field($model, 'r04')->textInput() ?>

<!-- attribute r05 -->
			<?= $form->field($model, 'r05')->textInput() ?>

<!-- attribute r06 -->
			<?= $form->field($model, 'r06')->textInput() ?>

<!-- attribute r07 -->
			<?= $form->field($model, 'r07')->textInput() ?>

<!-- attribute r08 -->
			<?= $form->field($model, 'r08')->textInput() ?>

<!-- attribute r09 -->
			<?= $form->field($model, 'r09')->textInput() ?>

<!-- attribute r10 -->
			<?= $form->field($model, 'r10')->textInput() ?>

<!-- attribute r11 -->
			<?= $form->field($model, 'r11')->textInput() ?>

<!-- attribute r12 -->
			<?= $form->field($model, 'r12')->textInput() ?>

<!-- attribute r13 -->
			<?= $form->field($model, 'r13')->textInput() ?>

<!-- attribute r14 -->
			<?= $form->field($model, 'r14')->textInput() ?>

<!-- attribute r15 -->
			<?= $form->field($model, 'r15')->textInput() ?>

<!-- attribute r16 -->
			<?= $form->field($model, 'r16')->textInput() ?>

<!-- attribute r17 -->
			<?= $form->field($model, 'r17')->textInput() ?>

<!-- attribute r18 -->
			<?= $form->field($model, 'r18')->textInput() ?>

<!-- attribute r19 -->
			<?= $form->field($model, 'r19')->textInput() ?>

<!-- attribute r20 -->
			<?= $form->field($model, 'r20')->textInput() ?>

<!-- attribute r21 -->
			<?= $form->field($model, 'r21')->textInput() ?>

<!-- attribute r22 -->
			<?= $form->field($model, 'r22')->textInput() ?>

<!-- attribute r23 -->
			<?= $form->field($model, 'r23')->textInput() ?>

<!-- attribute r24 -->
			<?= $form->field($model, 'r24')->textInput() ?>

<!-- attribute r25 -->
			<?= $form->field($model, 'r25')->textInput() ?>

<!-- attribute r26 -->
			<?= $form->field($model, 'r26')->textInput() ?>

<!-- attribute r27 -->
			<?= $form->field($model, 'r27')->textInput() ?>

<!-- attribute r28 -->
			<?= $form->field($model, 'r28')->textInput() ?>

<!-- attribute r29 -->
			<?= $form->field($model, 'r29')->textInput() ?>

<!-- attribute r30 -->
			<?= $form->field($model, 'r30')->textInput() ?>

<!-- attribute r31 -->
			<?= $form->field($model, 'r31')->textInput() ?>

<!-- attribute r32 -->
			<?= $form->field($model, 'r32')->textInput() ?>

<!-- attribute r33 -->
			<?= $form->field($model, 'r33')->textInput() ?>

<!-- attribute r34 -->
			<?= $form->field($model, 'r34')->textInput() ?>

<!-- attribute r35 -->
			<?= $form->field($model, 'r35')->textInput() ?>

<!-- attribute r36 -->
			<?= $form->field($model, 'r36')->textInput() ?>

<!-- attribute r37 -->
			<?= $form->field($model, 'r37')->textInput() ?>

<!-- attribute r38 -->
			<?= $form->field($model, 'r38')->textInput() ?>

<!-- attribute r39 -->
			<?= $form->field($model, 'r39')->textInput() ?>

<!-- attribute r40 -->
			<?= $form->field($model, 'r40')->textInput() ?>

<!-- attribute r41 -->
			<?= $form->field($model, 'r41')->textInput() ?>

<!-- attribute r42 -->
			<?= $form->field($model, 'r42')->textInput() ?>

<!-- attribute r43 -->
			<?= $form->field($model, 'r43')->textInput() ?>

<!-- attribute r44 -->
			<?= $form->field($model, 'r44')->textInput() ?>

<!-- attribute r45 -->
			<?= $form->field($model, 'r45')->textInput() ?>

<!-- attribute r46 -->
			<?= $form->field($model, 'r46')->textInput() ?>

<!-- attribute r47 -->
			<?= $form->field($model, 'r47')->textInput() ?>

<!-- attribute r48 -->
			<?= $form->field($model, 'r48')->textInput() ?>

<!-- attribute r49 -->
			<?= $form->field($model, 'r49')->textInput() ?>

<!-- attribute r50 -->
			<?= $form->field($model, 'r50')->textInput() ?>

<!-- attribute b01 -->
			<?= $form->field($model, 'b01')->textInput() ?>

<!-- attribute b02 -->
			<?= $form->field($model, 'b02')->textInput() ?>

<!-- attribute b03 -->
			<?= $form->field($model, 'b03')->textInput() ?>

<!-- attribute b04 -->
			<?= $form->field($model, 'b04')->textInput() ?>

<!-- attribute b05 -->
			<?= $form->field($model, 'b05')->textInput() ?>

<!-- attribute b06 -->
			<?= $form->field($model, 'b06')->textInput() ?>

<!-- attribute b07 -->
			<?= $form->field($model, 'b07')->textInput() ?>

<!-- attribute b08 -->
			<?= $form->field($model, 'b08')->textInput() ?>

<!-- attribute b09 -->
			<?= $form->field($model, 'b09')->textInput() ?>

<!-- attribute b10 -->
			<?= $form->field($model, 'b10')->textInput() ?>

<!-- attribute b11 -->
			<?= $form->field($model, 'b11')->textInput() ?>

<!-- attribute b12 -->
			<?= $form->field($model, 'b12')->textInput() ?>

<!-- attribute b13 -->
			<?= $form->field($model, 'b13')->textInput() ?>

<!-- attribute b14 -->
			<?= $form->field($model, 'b14')->textInput() ?>

<!-- attribute b15 -->
			<?= $form->field($model, 'b15')->textInput() ?>

<!-- attribute b16 -->
			<?= $form->field($model, 'b16')->textInput() ?>

<!-- attribute b17 -->
			<?= $form->field($model, 'b17')->textInput() ?>

<!-- attribute b18 -->
			<?= $form->field($model, 'b18')->textInput() ?>

<!-- attribute b19 -->
			<?= $form->field($model, 'b19')->textInput() ?>

<!-- attribute b20 -->
			<?= $form->field($model, 'b20')->textInput() ?>

<!-- attribute b21 -->
			<?= $form->field($model, 'b21')->textInput() ?>

<!-- attribute b22 -->
			<?= $form->field($model, 'b22')->textInput() ?>

<!-- attribute b23 -->
			<?= $form->field($model, 'b23')->textInput() ?>

<!-- attribute b24 -->
			<?= $form->field($model, 'b24')->textInput() ?>

<!-- attribute b25 -->
			<?= $form->field($model, 'b25')->textInput() ?>

<!-- attribute b26 -->
			<?= $form->field($model, 'b26')->textInput() ?>

<!-- attribute b27 -->
			<?= $form->field($model, 'b27')->textInput() ?>

<!-- attribute b28 -->
			<?= $form->field($model, 'b28')->textInput() ?>

<!-- attribute b29 -->
			<?= $form->field($model, 'b29')->textInput() ?>

<!-- attribute b30 -->
			<?= $form->field($model, 'b30')->textInput() ?>

<!-- attribute b31 -->
			<?= $form->field($model, 'b31')->textInput() ?>

<!-- attribute b32 -->
			<?= $form->field($model, 'b32')->textInput() ?>

<!-- attribute b33 -->
			<?= $form->field($model, 'b33')->textInput() ?>

<!-- attribute b34 -->
			<?= $form->field($model, 'b34')->textInput() ?>

<!-- attribute b35 -->
			<?= $form->field($model, 'b35')->textInput() ?>

<!-- attribute b36 -->
			<?= $form->field($model, 'b36')->textInput() ?>

<!-- attribute b37 -->
			<?= $form->field($model, 'b37')->textInput() ?>

<!-- attribute b38 -->
			<?= $form->field($model, 'b38')->textInput() ?>

<!-- attribute b39 -->
			<?= $form->field($model, 'b39')->textInput() ?>

<!-- attribute b40 -->
			<?= $form->field($model, 'b40')->textInput() ?>

<!-- attribute b41 -->
			<?= $form->field($model, 'b41')->textInput() ?>

<!-- attribute b42 -->
			<?= $form->field($model, 'b42')->textInput() ?>

<!-- attribute b43 -->
			<?= $form->field($model, 'b43')->textInput() ?>

<!-- attribute b44 -->
			<?= $form->field($model, 'b44')->textInput() ?>

<!-- attribute b45 -->
			<?= $form->field($model, 'b45')->textInput() ?>

<!-- attribute b46 -->
			<?= $form->field($model, 'b46')->textInput() ?>

<!-- attribute b47 -->
			<?= $form->field($model, 'b47')->textInput() ?>

<!-- attribute b48 -->
			<?= $form->field($model, 'b48')->textInput() ?>

<!-- attribute b49 -->
			<?= $form->field($model, 'b49')->textInput() ?>

<!-- attribute b50 -->
			<?= $form->field($model, 'b50')->textInput() ?>

<!-- attribute d01 -->
			<?= $form->field($model, 'd01')->textInput() ?>

<!-- attribute d02 -->
			<?= $form->field($model, 'd02')->textInput() ?>

<!-- attribute d03 -->
			<?= $form->field($model, 'd03')->textInput() ?>

<!-- attribute d04 -->
			<?= $form->field($model, 'd04')->textInput() ?>

<!-- attribute d05 -->
			<?= $form->field($model, 'd05')->textInput() ?>

<!-- attribute d06 -->
			<?= $form->field($model, 'd06')->textInput() ?>

<!-- attribute d07 -->
			<?= $form->field($model, 'd07')->textInput() ?>

<!-- attribute d08 -->
			<?= $form->field($model, 'd08')->textInput() ?>

<!-- attribute d09 -->
			<?= $form->field($model, 'd09')->textInput() ?>

<!-- attribute d10 -->
			<?= $form->field($model, 'd10')->textInput() ?>

<!-- attribute d11 -->
			<?= $form->field($model, 'd11')->textInput() ?>

<!-- attribute d12 -->
			<?= $form->field($model, 'd12')->textInput() ?>

<!-- attribute d13 -->
			<?= $form->field($model, 'd13')->textInput() ?>

<!-- attribute d14 -->
			<?= $form->field($model, 'd14')->textInput() ?>

<!-- attribute d15 -->
			<?= $form->field($model, 'd15')->textInput() ?>

<!-- attribute d16 -->
			<?= $form->field($model, 'd16')->textInput() ?>

<!-- attribute d17 -->
			<?= $form->field($model, 'd17')->textInput() ?>

<!-- attribute d18 -->
			<?= $form->field($model, 'd18')->textInput() ?>

<!-- attribute d19 -->
			<?= $form->field($model, 'd19')->textInput() ?>

<!-- attribute d20 -->
			<?= $form->field($model, 'd20')->textInput() ?>

<!-- attribute d21 -->
			<?= $form->field($model, 'd21')->textInput() ?>

<!-- attribute d22 -->
			<?= $form->field($model, 'd22')->textInput() ?>

<!-- attribute d23 -->
			<?= $form->field($model, 'd23')->textInput() ?>

<!-- attribute d24 -->
			<?= $form->field($model, 'd24')->textInput() ?>

<!-- attribute d25 -->
			<?= $form->field($model, 'd25')->textInput() ?>

<!-- attribute d26 -->
			<?= $form->field($model, 'd26')->textInput() ?>

<!-- attribute d27 -->
			<?= $form->field($model, 'd27')->textInput() ?>

<!-- attribute d28 -->
			<?= $form->field($model, 'd28')->textInput() ?>

<!-- attribute d29 -->
			<?= $form->field($model, 'd29')->textInput() ?>

<!-- attribute d30 -->
			<?= $form->field($model, 'd30')->textInput() ?>

<!-- attribute d31 -->
			<?= $form->field($model, 'd31')->textInput() ?>

<!-- attribute d32 -->
			<?= $form->field($model, 'd32')->textInput() ?>

<!-- attribute d33 -->
			<?= $form->field($model, 'd33')->textInput() ?>

<!-- attribute d34 -->
			<?= $form->field($model, 'd34')->textInput() ?>

<!-- attribute d35 -->
			<?= $form->field($model, 'd35')->textInput() ?>

<!-- attribute d36 -->
			<?= $form->field($model, 'd36')->textInput() ?>

<!-- attribute d37 -->
			<?= $form->field($model, 'd37')->textInput() ?>

<!-- attribute d38 -->
			<?= $form->field($model, 'd38')->textInput() ?>

<!-- attribute d39 -->
			<?= $form->field($model, 'd39')->textInput() ?>

<!-- attribute d40 -->
			<?= $form->field($model, 'd40')->textInput() ?>

<!-- attribute d41 -->
			<?= $form->field($model, 'd41')->textInput() ?>

<!-- attribute d42 -->
			<?= $form->field($model, 'd42')->textInput() ?>

<!-- attribute d43 -->
			<?= $form->field($model, 'd43')->textInput() ?>

<!-- attribute d44 -->
			<?= $form->field($model, 'd44')->textInput() ?>

<!-- attribute d45 -->
			<?= $form->field($model, 'd45')->textInput() ?>

<!-- attribute d46 -->
			<?= $form->field($model, 'd46')->textInput() ?>

<!-- attribute d47 -->
			<?= $form->field($model, 'd47')->textInput() ?>

<!-- attribute d48 -->
			<?= $form->field($model, 'd48')->textInput() ?>

<!-- attribute d49 -->
			<?= $form->field($model, 'd49')->textInput() ?>

<!-- attribute d50 -->
			<?= $form->field($model, 'd50')->textInput() ?>

<!-- attribute s01 -->
			<?= $form->field($model, 's01')->textInput() ?>

<!-- attribute s02 -->
			<?= $form->field($model, 's02')->textInput() ?>

<!-- attribute s03 -->
			<?= $form->field($model, 's03')->textInput() ?>

<!-- attribute s04 -->
			<?= $form->field($model, 's04')->textInput() ?>

<!-- attribute s05 -->
			<?= $form->field($model, 's05')->textInput() ?>

<!-- attribute s06 -->
			<?= $form->field($model, 's06')->textInput() ?>

<!-- attribute s07 -->
			<?= $form->field($model, 's07')->textInput() ?>

<!-- attribute s08 -->
			<?= $form->field($model, 's08')->textInput() ?>

<!-- attribute s09 -->
			<?= $form->field($model, 's09')->textInput() ?>

<!-- attribute s10 -->
			<?= $form->field($model, 's10')->textInput() ?>

<!-- attribute s11 -->
			<?= $form->field($model, 's11')->textInput() ?>

<!-- attribute s12 -->
			<?= $form->field($model, 's12')->textInput() ?>

<!-- attribute s13 -->
			<?= $form->field($model, 's13')->textInput() ?>

<!-- attribute s14 -->
			<?= $form->field($model, 's14')->textInput() ?>

<!-- attribute s15 -->
			<?= $form->field($model, 's15')->textInput() ?>

<!-- attribute s16 -->
			<?= $form->field($model, 's16')->textInput() ?>

<!-- attribute s17 -->
			<?= $form->field($model, 's17')->textInput() ?>

<!-- attribute s18 -->
			<?= $form->field($model, 's18')->textInput() ?>

<!-- attribute s19 -->
			<?= $form->field($model, 's19')->textInput() ?>

<!-- attribute s20 -->
			<?= $form->field($model, 's20')->textInput() ?>

<!-- attribute s21 -->
			<?= $form->field($model, 's21')->textInput() ?>

<!-- attribute s22 -->
			<?= $form->field($model, 's22')->textInput() ?>

<!-- attribute s23 -->
			<?= $form->field($model, 's23')->textInput() ?>

<!-- attribute s24 -->
			<?= $form->field($model, 's24')->textInput() ?>

<!-- attribute s25 -->
			<?= $form->field($model, 's25')->textInput() ?>

<!-- attribute s26 -->
			<?= $form->field($model, 's26')->textInput() ?>

<!-- attribute s27 -->
			<?= $form->field($model, 's27')->textInput() ?>

<!-- attribute s28 -->
			<?= $form->field($model, 's28')->textInput() ?>

<!-- attribute s29 -->
			<?= $form->field($model, 's29')->textInput() ?>

<!-- attribute s30 -->
			<?= $form->field($model, 's30')->textInput() ?>

<!-- attribute s31 -->
			<?= $form->field($model, 's31')->textInput() ?>

<!-- attribute s32 -->
			<?= $form->field($model, 's32')->textInput() ?>

<!-- attribute s33 -->
			<?= $form->field($model, 's33')->textInput() ?>

<!-- attribute s34 -->
			<?= $form->field($model, 's34')->textInput() ?>

<!-- attribute s35 -->
			<?= $form->field($model, 's35')->textInput() ?>

<!-- attribute s36 -->
			<?= $form->field($model, 's36')->textInput() ?>

<!-- attribute s37 -->
			<?= $form->field($model, 's37')->textInput() ?>

<!-- attribute s38 -->
			<?= $form->field($model, 's38')->textInput() ?>

<!-- attribute s39 -->
			<?= $form->field($model, 's39')->textInput() ?>

<!-- attribute s40 -->
			<?= $form->field($model, 's40')->textInput() ?>

<!-- attribute s41 -->
			<?= $form->field($model, 's41')->textInput() ?>

<!-- attribute s42 -->
			<?= $form->field($model, 's42')->textInput() ?>

<!-- attribute s43 -->
			<?= $form->field($model, 's43')->textInput() ?>

<!-- attribute s44 -->
			<?= $form->field($model, 's44')->textInput() ?>

<!-- attribute s45 -->
			<?= $form->field($model, 's45')->textInput() ?>

<!-- attribute s46 -->
			<?= $form->field($model, 's46')->textInput() ?>

<!-- attribute s47 -->
			<?= $form->field($model, 's47')->textInput() ?>

<!-- attribute s48 -->
			<?= $form->field($model, 's48')->textInput() ?>

<!-- attribute s49 -->
			<?= $form->field($model, 's49')->textInput() ?>

<!-- attribute s50 -->
			<?= $form->field($model, 's50')->textInput() ?>

<!-- attribute c01 -->
			<?= $form->field($model, 'c01')->textInput() ?>

<!-- attribute c02 -->
			<?= $form->field($model, 'c02')->textInput() ?>

<!-- attribute c03 -->
			<?= $form->field($model, 'c03')->textInput() ?>

<!-- attribute c04 -->
			<?= $form->field($model, 'c04')->textInput() ?>

<!-- attribute c05 -->
			<?= $form->field($model, 'c05')->textInput() ?>

<!-- attribute c06 -->
			<?= $form->field($model, 'c06')->textInput() ?>

<!-- attribute c07 -->
			<?= $form->field($model, 'c07')->textInput() ?>

<!-- attribute c08 -->
			<?= $form->field($model, 'c08')->textInput() ?>

<!-- attribute c09 -->
			<?= $form->field($model, 'c09')->textInput() ?>

<!-- attribute c10 -->
			<?= $form->field($model, 'c10')->textInput() ?>

<!-- attribute c11 -->
			<?= $form->field($model, 'c11')->textInput() ?>

<!-- attribute c12 -->
			<?= $form->field($model, 'c12')->textInput() ?>

<!-- attribute c13 -->
			<?= $form->field($model, 'c13')->textInput() ?>

<!-- attribute c14 -->
			<?= $form->field($model, 'c14')->textInput() ?>

<!-- attribute c15 -->
			<?= $form->field($model, 'c15')->textInput() ?>

<!-- attribute c16 -->
			<?= $form->field($model, 'c16')->textInput() ?>

<!-- attribute c17 -->
			<?= $form->field($model, 'c17')->textInput() ?>

<!-- attribute c18 -->
			<?= $form->field($model, 'c18')->textInput() ?>

<!-- attribute c19 -->
			<?= $form->field($model, 'c19')->textInput() ?>

<!-- attribute c20 -->
			<?= $form->field($model, 'c20')->textInput() ?>

<!-- attribute c21 -->
			<?= $form->field($model, 'c21')->textInput() ?>

<!-- attribute c22 -->
			<?= $form->field($model, 'c22')->textInput() ?>

<!-- attribute c23 -->
			<?= $form->field($model, 'c23')->textInput() ?>

<!-- attribute c24 -->
			<?= $form->field($model, 'c24')->textInput() ?>

<!-- attribute c25 -->
			<?= $form->field($model, 'c25')->textInput() ?>

<!-- attribute c26 -->
			<?= $form->field($model, 'c26')->textInput() ?>

<!-- attribute c27 -->
			<?= $form->field($model, 'c27')->textInput() ?>

<!-- attribute c28 -->
			<?= $form->field($model, 'c28')->textInput() ?>

<!-- attribute c29 -->
			<?= $form->field($model, 'c29')->textInput() ?>

<!-- attribute c30 -->
			<?= $form->field($model, 'c30')->textInput() ?>

<!-- attribute c31 -->
			<?= $form->field($model, 'c31')->textInput() ?>

<!-- attribute c32 -->
			<?= $form->field($model, 'c32')->textInput() ?>

<!-- attribute c33 -->
			<?= $form->field($model, 'c33')->textInput() ?>

<!-- attribute c34 -->
			<?= $form->field($model, 'c34')->textInput() ?>

<!-- attribute c35 -->
			<?= $form->field($model, 'c35')->textInput() ?>

<!-- attribute c36 -->
			<?= $form->field($model, 'c36')->textInput() ?>

<!-- attribute c37 -->
			<?= $form->field($model, 'c37')->textInput() ?>

<!-- attribute c38 -->
			<?= $form->field($model, 'c38')->textInput() ?>

<!-- attribute c39 -->
			<?= $form->field($model, 'c39')->textInput() ?>

<!-- attribute c40 -->
			<?= $form->field($model, 'c40')->textInput() ?>

<!-- attribute c41 -->
			<?= $form->field($model, 'c41')->textInput() ?>

<!-- attribute c42 -->
			<?= $form->field($model, 'c42')->textInput() ?>

<!-- attribute c43 -->
			<?= $form->field($model, 'c43')->textInput() ?>

<!-- attribute c44 -->
			<?= $form->field($model, 'c44')->textInput() ?>

<!-- attribute c45 -->
			<?= $form->field($model, 'c45')->textInput() ?>

<!-- attribute c46 -->
			<?= $form->field($model, 'c46')->textInput() ?>

<!-- attribute c47 -->
			<?= $form->field($model, 'c47')->textInput() ?>

<!-- attribute c48 -->
			<?= $form->field($model, 'c48')->textInput() ?>

<!-- attribute c49 -->
			<?= $form->field($model, 'c49')->textInput() ?>

<!-- attribute c50 -->
			<?= $form->field($model, 'c50')->textInput() ?>

<!-- attribute user_id -->
			<?= $form->field($model, 'user_id')->textInput() ?>

<!-- attribute user_desc -->
			<?= $form->field($model, 'user_desc')->textInput() ?>

<!-- attribute master_plan_maintenance -->
			<?= $form->field($model, 'master_plan_maintenance')->textInput() ?>

<!-- attribute mesin_last_update -->
			<?= $form->field($model, 'mesin_last_update')->textInput() ?>

<!-- attribute mesin_next_schedule -->
			<?= $form->field($model, 'mesin_next_schedule')->textInput() ?>

<!-- attribute sisa_waktu -->
			<?= $form->field($model, 'sisa_waktu')->textInput() ?>

<!-- attribute count_list -->
			<?= $form->field($model, 'count_list')->textInput() ?>

<!-- attribute count_update -->
			<?= $form->field($model, 'count_update')->textInput() ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('app', 'MesinCheckDtr'),
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

