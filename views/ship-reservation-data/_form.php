<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\depdrop\DepDrop;
use kartik\date\DatePicker;
use yii\web\View;
use app\models\ShipReservationDtr;
/**
* @var yii\web\View $this
* @var app\models\ShipReservationDtr $model
* @var yii\widgets\ActiveForm $form
*/

if (!$model->isNewRecord) {
    $script = "
        $(document).ready(function() {
            $('#pod-id').trigger('change');
        });
    ";
    $this->registerJs($script, View::POS_READY );
}

$this->registerCss("
    .panel-body-mod {
        background-color: #eaeaea;
        border: 1px solid grey;
        border-radius: 5px;
    }
");

?>

<div class="ship-reservation-dtr-form">

    <?php $form = ActiveForm::begin([
    'id' => 'ShipReservationDtr',
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
<div class="panel panel-default">
    <div class="panel-body panel-body-mod">
        <div class="">
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'YCJ_REF_NO')->textInput([
                        'onkeyup' => 'this.value=this.value.toUpperCase()',
                        'onfocusout' => 'this.value=this.value.toUpperCase()'
                    ]); ?>
                </div>
            </div>
                <div class="row">
                    <div class="col-sm-4">
                        <?= $form->field($model, 'RESERVATION_NO')->textInput([
                            'onkeyup' => 'this.value=this.value.toUpperCase()',
                            'onfocusout' => 'this.value=this.value.toUpperCase()'
                        ]); ?>
                    </div>
                    <div class="col-sm-2">
                        <?= $form->field($model, 'HELP')->dropDownList([
                            'N' => 'No',
                            'Y' => 'Yes',
                        ]); ?>
                    </div>
                    <div class="col-sm-3">
                        <?= $form->field($model, 'STATUS')->dropDownList(\Yii::$app->params['ship_reservation_status_arr']); ?>
                    </div>
                    <div class="col-sm-3">
                        <?= $form->field($model, 'SHIPPER')->textInput([
                            'onkeyup' => 'this.value=this.value.toUpperCase()',
                            'onfocusout' => 'this.value=this.value.toUpperCase()'
                        ]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <?= $form->field($model, 'POL')->textInput([
                            'onkeyup' => 'this.value=this.value.toUpperCase()',
                            'onfocusout' => 'this.value=this.value.toUpperCase()'
                        ]) ?>
                    </div>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'POD')->dropDownList(ArrayHelper::map(app\models\ShipLiner::find()->select('POD')->groupBy('POD')->orderBy('POD')->all(), 'POD', 'POD'), [
                            'id' => 'pod-id',
                            'prompt' => 'Choose...',
                        ]); ?>
                    </div>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'CARRIER')->widget(DepDrop::classname(), [
                            'options' => ['id' => 'carrier-id'],
                            'pluginOptions'=>[
                                'depends'=>['pod-id'],
                                'url' => $model->isNewRecord ? Url::to(['/ship-reservation-data/carrier']) : Url::to(['/ship-reservation-data/carrier', 'POD_VAL' => $model->POD, 'CARRIER_VAL' => $model->CARRIER, 'FLAG_DESC_VAL' => $model->FLAG_DESC])
                            ]
                        ]); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3">
                        <?= $form->field($model, 'CNT_40HC')->textInput(['type' => 'number']) ?>
                    </div>
                    <div class="col-sm-3">
                        <?= $form->field($model, 'CNT_40')->textInput(['type' => 'number']) ?>
                    </div>
                    <div class="col-sm-3">
                        <?= $form->field($model, 'CNT_20')->textInput(['type' => 'number']) ?>
                    </div>
                    <div class="col-sm-3">
                        <?= $form->field($model, 'BL_NO')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-2">
                        <?= $form->field($model, 'ETD')->widget(DatePicker::classname(), [
                            'options' => [
                                'type' => DatePicker::TYPE_INPUT,
                            ],
                            'removeButton' => false,
                            'pluginOptions' => [
                                'autoclose'=>true,
                                'format' => 'yyyy-mm-dd',
                                'todayHighlight' => true,
                                'todayBtn' => true,
                            ]
                        ]); ?>
                    </div>
                    <div class="col-sm-3">
                        <?= $form->field($model, 'APPLIED_RATE')->dropDownList([
                            'Contracted Rate' => 'Contracted Rate',
                            'Spot/Extra Rate' => 'Spot/Extra Rate',
                        ], [
                            'prompt' => 'Choose...'
                        ]) ?>
                    </div>
                    <div class="col-sm-3">
                        <?= $form->field($model, 'INVOICE')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'NOTE')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            <?php echo $form->errorSummary($model); ?>
    <hr>
            <?= Html::a('Cancel', \yii\helpers\Url::previous(), [
                'class' => 'btn btn-warning'
            ]); ?>
            &nbsp;&nbsp;&nbsp;
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
</div>

</div>
<?php
$tmp_detail_ref = [];
if (isset($_GET['YCJ_REF_NO'])) {
    $tmp_detail_ref = ShipReservationDtr::find()
    ->where(['YCJ_REF_NO' => $_GET['YCJ_REF_NO']])
    ->all();
}

?>
<div class="panel panel-primary" style="<?= $tmp_detail_ref == null ? 'display: none;' : ''; ?>">
    <div class="panel-heading">
        <h3 class="panel-title">Detail for YCJ Ref. No. <?= $_GET['YCJ_REF_NO']; ?></h3>
    </div>
    <div class="panel-body no-padding">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="text-center"></th>
                    <th class="text-center">Reservation No.</th>
                    <th class="text-center">Help</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Shipper</th>
                    <th class="text-center">POL</th>
                    <th class="text-center">POD</th>
                    <th class="text-center">40 HC</th>
                    <th class="text-center">40</th>
                    <th class="text-center">20</th>
                    <th class="text-center">BL No.</th>
                    <th class="text-center">Carrier</th>
                    <th class="text-center">ETD</th>
                    <th class="text-center">Applied Rate</th>
                    <th class="text-center">Invoice</th>
                    <th class="text-center">Note</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tmp_detail_ref as $key => $value): ?>
                    <tr>
                        <td>
                            <?= Html::a('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>', ['update', 'SEQ' => $value->SEQ]); ?>
                        </td>
                        <td class="text-center"><?= $value->RESERVATION_NO; ?></td>
                        <td class="text-center"><?= $value->HELP; ?></td>
                        <td class="text-center"><?= $value->STATUS; ?></td>
                        <td class="text-center"><?= $value->SHIPPER; ?></td>
                        <td class="text-center"><?= $value->POL; ?></td>
                        <td class="text-center"><?= $value->POD; ?></td>
                        <td class="text-center"><?= $value->CNT_40HC; ?></td>
                        <td class="text-center"><?= $value->CNT_40; ?></td>
                        <td class="text-center"><?= $value->CNT_20; ?></td>
                        <td class="text-center"><?= $value->BL_NO; ?></td>
                        <td class="text-center"><?= $value->CARRIER; ?></td>
                        <td class="text-center"><?= $value->ETD; ?></td>
                        <td class="text-center"><?= $value->APPLIED_RATE; ?></td>
                        <td class="text-center"><?= $value->INVOICE; ?></td>
                        <td class="text-center"><?= $value->NOTE; ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>