<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\HrComplaint $model
*/

$this->title = 'Form Input Pesan';
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Hr Complaints'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud hr-complaint-create">
    <div class="panel panel-primary">
        <div class="panel-body">
            <?php $form = ActiveForm::begin([
                'id' => 'HrComplaint',
            //'layout' => 'horizontal',
                'enableClientValidation' => true,
                'errorSummaryCssClass' => 'error-summary alert alert-danger',
                /*'fieldConfig' => [
                     'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                     'horizontalCssClasses' => [
                         'label' => 'col-sm-2',
                         'wrapper' => 'col-sm-9',
                         'error' => '',
                         'hint' => '',
                     ],
                ],*/
            ]
            );
            ?>

            <?= $form->field($model, 'remark')->textarea(['rows' => 6, 'style' => 'resize: none;']) ?>

            <hr/>

            <?php echo $form->errorSummary($model); ?>

            <div class="pull-right">
                <?= Html::a('Cancel', ['index-laporan'], ['class' => 'btn btn-danger']) ?>

            <?= Html::submitButton('Submit',
            [
            'id' => 'save-' . $model->formName(),
            'class' => 'btn btn-success'
            ]
            );
            ?>
            </div>
            

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
