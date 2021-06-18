<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use app\models\ShipLiner;
use kartik\typeahead\TypeaheadBasic;

/**
* @var yii\web\View $this
* @var app\models\ShipLiner $model
* @var yii\widgets\ActiveForm $form
*/

$tmp_country_arr = ShipLiner::find()->select('COUNTRY')->groupBy('COUNTRY')->orderBy('COUNTRY')->asArray()->all();
$country_arr = [];
foreach ($tmp_country_arr as $key => $value) {
    $country_arr[] = $value['COUNTRY'];
}

$tmp_pod_arr = ShipLiner::find()->select('POD')->groupBy('POD')->orderBy('POD')->asArray()->all();
$pod_arr = [];
foreach ($tmp_pod_arr as $key => $value) {
    $pod_arr[] = $value['POD'];
}

$carrier_arr = ArrayHelper::map(ShipLiner::find()->select('CARRIER')->groupBy('CARRIER')->orderBy('CARRIER')->all(), 'CARRIER', 'CARRIER');
?>

<div class="ship-liner-form">

    <?php $form = ActiveForm::begin([
    'id' => 'ShipLiner',
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
        <div class="panel-body">
            <?= $form->field($model, 'COUNTRY')->widget(TypeaheadBasic::classname(), [
                'data' => $country_arr,
                'options' => [
                    'onkeyup' => 'this.value=this.value.toUpperCase()',
                    'onfocusout' => 'this.value=this.value.toUpperCase()',
                    'placeholder' => 'Input Country Here...',
                ],
                'pluginOptions' => ['highlight'=>true],
            ]); ?>
            <?= $form->field($model, 'POD')->widget(TypeaheadBasic::classname(), [
                'data' => $pod_arr,
                'options' => [
                    'onkeyup' => 'this.value=this.value.toUpperCase()',
                    'onfocusout' => 'this.value=this.value.toUpperCase()',
                    'placeholder' => 'Input Country Here...',
                ],
                'pluginOptions' => ['highlight'=>true],
            ]); ?>
            <?= $form->field($model, 'FLAG_DESC')->dropDownList([
                'MAIN' => 'MAIN',
                'SUB' => 'SUB',
                'BACK-UP' => 'BACK-UP',
                'OTHER' => 'OTHER',
            ])->label('Nomination') ?>
            <?= $form->field($model, 'CARRIER')->dropDownList($carrier_arr) ?>
        </div>
    </div>

<!-- attribute COUNTRY -->
			

<!-- attribute POD -->
			

<!-- attribute FLAG_DESC -->
			

<!-- attribute CARRIER -->
			

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

        <?=             Html::a(
            'Cancel',
            \yii\helpers\Url::previous(),
            ['class' => 'btn btn-default']) ?>

        <?php ActiveForm::end(); ?>

</div>

