<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\typeahead\TypeaheadBasic;
use yii\helpers\ArrayHelper;

/**
* @var yii\web\View $this
* @var app\models\search\SernoInputSearch $model
* @var yii\widgets\ActiveForm $form
*/


/*echo '<pre>';
print_r($data);
echo '</pre>';*/
?>

<div class="serno-input-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    //'layout' => 'horizontal',
    'fieldConfig' => [
        'horizontalCssClasses' => [
            'label' => 'col-sm-4',
            //'offset' => 'col-sm-offset-2',
            'wrapper' => 'col-sm-7',
        ],
    ],
    //'options' => ['class' => 'form-horizontal'],
    ]); ?>
    <div class="row">

        <div class="col-sm-3">
            <div class="panel panel-primary">
                <div class="panel-body">
                    
                    <?= $form->field($model, 'vms')->widget(\yii\jui\DatePicker::class, [
                        //'language' => 'ru',
                        'dateFormat' => 'yyyy-MM-dd',
                        'options' => [
                            'class' => 'form-control',
                            'placeholder' => 'e.g. ' . date('Y-m-d')
                        ]
                    ])->label('Prod. Plan Date (VMS)') ?>

                    <?= $form->field($model, 'proddate')->widget(\yii\jui\DatePicker::class, [
                        //'language' => 'ru',
                        'dateFormat' => 'yyyy-MM-dd',
                        'options' => [
                            'class' => 'form-control',
                            'placeholder' => 'e.g. ' . date('Y-m-d')
                        ]
                    ])->label('Prod. Actual Date'); ?>

                    <?= $form->field($model, 'etd_ship')->widget(\yii\jui\DatePicker::class, [
                        //'language' => 'ru',
                        'dateFormat' => 'yyyy-MM-dd',
                        'options' => [
                            'class' => 'form-control',
                            'placeholder' => 'e.g. ' . date('Y-m-d')
                        ]
                    ])->label('ETD YEMI'); ?>
                </div>
            </div>
        </div>
    	
    	<div class="col-sm-3">
    		<div class="panel panel-primary">
    			<div class="panel-body">
                    <?= $form->field($model, 'gmc')->widget(TypeaheadBasic::classname(), [
                        'data' => $data_gmc,
                        'options' => ['placeholder' => 'Input GMC ...'],
                        'pluginOptions' => ['highlight'=>true],
                    ]); ?>

                    <?= $form->field($model, 'sernum')->textInput(['placeholder' => 'Input Serial Number'])->label('Serial Number') ?>

    				<?= $form->field($model, 'flo')->widget(TypeaheadBasic::classname(), [
                        'data' => $data_flo,
                        'options' => ['placeholder' => 'Input FLO ...'],
                        'pluginOptions' => ['highlight'=>true],
                    ])->label('FLO Number'); ?>
    			</div>
    		</div>
    	</div>

    	<div class="col-sm-3">
    		<div class="panel panel-primary">
    			<div class="panel-body">
    				<?= $form->field($model, 'port')->dropDownList(ArrayHelper::map(app\models\SernoOutput::find()->orderBy('dst')->all(), 'dst', 'dst'), [
                        'prompt' => 'Select port ...'
                    ]) ?>

                    <?= $form->field($model, 'invoice')->widget(TypeaheadBasic::classname(), [
                        'data' => $data_invoice,
                        'options' => ['placeholder' => 'Input Invoice ...'],
                        'pluginOptions' => ['highlight'=>true],
                    ]); ?>
    			</div>
    		</div>
    	</div>

    	<div class="col-sm-3">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <?= $form->field($model, 'status')->dropDownList([
                        'OK' => 'OK',
                        'LOT OUT' => 'Lot Out',
                        'REPAIR' => 'Repair'
                    ], ['prompt'=>'Select...'])->label('Quality Status') ?>
                    
                    <?= $form->field($model, 'line')->dropDownList(ArrayHelper::map(app\models\SernoInput::find()->select('distinct(line)')->orderBy('line')->all(), 'line', 'line'), [
                        'prompt' => 'Select line ...'
                    ]) ?>

                    <?= ''; //$form->field($model, 'so') ?>
                </div>
            </div>
        </div>

    </div>
		
    <div class="row">
        <div class="col-sm-12">
            
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            <?= ''; //Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
        
        </div>
        
    </div>
    

    <?php ActiveForm::end(); ?>

</div>
