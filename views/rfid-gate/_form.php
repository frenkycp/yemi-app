<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\RfidGate $model
* @var yii\widgets\ActiveForm $form
*/

?>
<?php $form = ActiveForm::begin([
    'id' => 'RfidGate',
    //'layout' => 'horizontal',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-danger',
]
);
?>
<div class="panel panel-warning">
    <div class="panel-body">
        

        <?= $form->field($model, 'gate')->textInput(['readonly' => true]) ?>
        <?= $form->field($model, 'port')->dropDownList(ArrayHelper::map(app\models\RfidPort::find()->orderBy('port')->all(), 'port', 'port')) ?>
        <hr/>

        <?php echo $form->errorSummary($model); ?>

        
    </div>
    <div class="panel-footer">
        <?= Html::submitButton(
        '<span class="glyphicon glyphicon-check"></span> Update',
        [
        'id' => 'save-' . $model->formName(),
        'class' => 'btn btn-success'
        ]
        );
        ?>
        <?= Html::a('Cancel', ['index'], ['class'=>'btn btn-warning']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

