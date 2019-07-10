<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;

/**
* @var yii\web\View $this
* @var app\models\MntShiftSch $model
*/

$this->title = Yii::t('models', 'Create Schedule');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Create Schedule'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud mnt-shift-sch-create">

    <!--<hr />-->

    <div class="crusher-tbl-form">

        <?php $form = ActiveForm::begin([
        'id' => 'CrusherTbl',
        //'layout' => 'horizontal',
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
        <div class="row">
            <div class="col-md-3">
                <?= $form->field($model, 'shift_date')->widget(DatePicker::classname(), [
                    'options' => [
                        'type' => DatePicker::TYPE_INPUT,
                    ],
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]); ?>
            </div>
        </div>
        <div class="panel panel-primary no-padding">
            <div class="panel-body">
                <?php
                foreach ($emp_arr as $key => $value) {
                    ?>
                    <div class="col-md-3">
                        <?= $form->field($model, 'emp_id[]')->hiddenInput(['value' => $value['id']])->label(false); ?>
                        <?= $form->field($model, 'shift_code[]')->dropDownList(ArrayHelper::map(app\models\MntShiftCode::find()->where(['flag' => 1])->all(), 'id', 'shift_desc'))->label($value['name']); ?>
                    </div>
                <?php }
                ?>
                
            </div>
            <div class="panel-footer">
                <?php echo $form->errorSummary($model); ?>
                <?= Html::submitButton('<span class="glyphicon glyphicon-check"></span> Create',
                [
                'id' => 'save-' . $model->formName(),
                'class' => 'btn btn-success'
                ]
                );
                ?>
                <?= Html::a(
                'Cancel',
                \yii\helpers\Url::previous(),
                ['class' => 'btn btn-warning']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
