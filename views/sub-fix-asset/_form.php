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
* @var app\models\AssetDtrTbl $model
* @var yii\widgets\ActiveForm $form
*/

$this->registerCss("
    .panel-body-mod {
        background-color: #eaeaea;
    }
");

?>

<div class="ship-reservation-dtr-form">

    <?php $form = ActiveForm::begin([
    'id' => 'AssetDtrTbl',
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

    <div class="panel panel-primary">
        <div class="panel-body panel-body-mod">
            <div class="row">
                <div class="col-sm-3">
                    <?= $form->field($model, 'dateacqledger')->widget(DatePicker::classname(), [
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
                    <?= $form->field($model, 'faid')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'subexp')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'fixed_asset_subid')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <?= $form->field($model, 'voucher_number')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'deliveryorder')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'invoice')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <?= $form->field($model, 'partnumberfa')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'kategori')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'date_of_payment')->widget(DatePicker::classname(), [
                        'options' => [
                            'type' => DatePicker::TYPE_INPUT,
                        ],
                        'removeButton' => false,
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'dd-M-yyyy',
                            'todayHighlight' => true,
                            'todayBtn' => true,
                        ]
                    ]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <?= $form->field($model, 'vendorid')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'vendor')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'currency')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'qty')->textInput() ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <?= $form->field($model, 'price_unit')->textInput() ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'rate')->textInput() ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'at_cost')->textInput() ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'depr_date')->widget(DatePicker::classname(), [
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
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <?= $form->field($model, 'order_numb')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'proposalnumb')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'budgetnumber')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'docbc')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <?= $form->field($model, 'vouhpayment')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'proposalno')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'invoicescan')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'smartid')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <?= Html::a('Cancel', \yii\helpers\Url::previous(), ['class' => 'btn btn-warning']); ?>
            &nbsp;&nbsp;
            <?= Html::submitButton('<span class="glyphicon glyphicon-check"></span> ' . ($model->isNewRecord ? 'Create' : 'Save'),
            [
            'id' => 'save-' . $model->formName(),
            'class' => 'btn btn-success'
            ]
            );
            ?>
        </div>
    </div>

        <?php echo $form->errorSummary($model); ?>

        

        <?php ActiveForm::end(); ?>

</div>

