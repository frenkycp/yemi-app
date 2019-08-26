<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\web\View;

/**
* @var yii\web\View $this
* @var app\models\HrComplaint $model
*/

$this->title = 'Form Input Pesan';
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Hr Complaints'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS
    $(document).on('beforeSubmit', 'form', function(event) {
        $(this).find('[type=submit]').attr('disabled', true).addClass('disabled');
    });
JS;
$this->registerJs($script, View::POS_HEAD);
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

            <?= $form->field($model, 'category')->textInput(['readonly' => true])->label('To') ?>
            <?= $form->field($model, 'remark')->textarea(['rows' => 6, 'style' => 'resize: none;']) ?>

            <hr/>

            <?php echo $form->errorSummary($model); ?>

            <div class="pull-right">
                <?= Html::a('Cancel', Url::previous(), ['class' => 'btn btn-danger']) ?>

            <?= Html::submitButton('Submit',
            [
                'id' => 'save-' . $model->formName(),
                'class' => 'btn btn-success',
            ]
            );
            ?>
            </div>
            

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
