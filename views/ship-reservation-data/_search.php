<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;

/**
* @var yii\web\View $this
* @var app\models\search\ShipReservationDataSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="ship-reservation-dtr-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>
    <div class="panel panel-default">
    	<div class="panel-body">
    		<div class="row">
    			<div class="col-sm-3">
    				<?= $form->field($model, 'YCJ_REF_NO') ?>
    			</div>
    			<div class="col-sm-3">
    				<?= $form->field($model, 'RESERVATION_NO') ?>
    			</div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'DO_NO') ?>
                </div>
    			<div class="col-sm-3">
    				<?= $form->field($model, 'BL_NO') ?>
    			</div>
    		</div>
    		<div class="row">
    			<div class="col-sm-3">
                    <?= $form->field($model, 'STATUS')->dropDownList(\Yii::$app->params['ship_reservation_status_arr'], [
                        'prompt' => 'Choose...',
                    ]); ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'HELP')->dropDownList([
                        'N' => 'No',
                        'Y' => 'Yes',
                    ], [                        
                        'prompt' => 'Choose...',
                    ]); ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'POL')->textInput([
                        'onkeyup' => 'this.value=this.value.toUpperCase()',
                        'onfocusout' => 'this.value=this.value.toUpperCase()'
                    ]) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'POD')->dropDownList(ArrayHelper::map(app\models\ShipLiner::find()->select('POD')->groupBy('POD')->orderBy('POD')->all(), 'POD', 'POD'), [
                        'id' => 'pod-id',
                        'prompt' => 'Choose...',
                    ]); ?>
                </div>
    		</div>
    		<div class="row">
    			<div class="col-sm-3">
    				<?= $form->field($model, 'NOTE') ?>
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
                    <?= $form->field($model, 'CARRIER')->dropDownList(ArrayHelper::map(app\models\ShipLiner::find()->select('CARRIER')->groupBy('CARRIER')->orderBy('CARRIER')->all(), 'CARRIER', 'CARRIER'), [
                        'prompt' => 'Choose...',
                    ]); ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'FLAG_DESC')->dropDownList([
                        'MAIN' => 'MAIN',
                        'SUB' => 'SUB',
                        'BACK UP' => 'BACK UP',
                    ], [
                        'prompt' => 'Choose...'
                    ])->label('Category') ?>
                </div>
    		</div>
            <div class="row">
                <div class="col-sm-3">
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
                    <?= $form->field($model, 'INVOICE') ?>
                </div>
            </div>
    	</div>
    	<div class="panel-footer">
    		<div class="form-group">
		        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
		    </div>
    	</div>
    </div>

    		

		<?php // echo $form->field($model, 'POL') ?>

		<?php // echo $form->field($model, 'POD') ?>

		<?php // echo $form->field($model, 'CNT_40HC') ?>

		<?php // echo $form->field($model, 'CNT_40') ?>

		<?php // echo $form->field($model, 'CNT_20') ?>

		<?php // echo $form->field($model, 'CARRIER') ?>

		<?php // echo $form->field($model, 'FLAG_PRIORTY') ?>

		<?php // echo $form->field($model, 'FLAG_DESC') ?>

		<?php // echo $form->field($model, 'ETD') ?>

		<?php // echo $form->field($model, 'APPLIED_RATE') ?>

		<?php // echo $form->field($model, 'INVOICE') ?>

		<?php // echo $form->field($model, 'NOTE') ?>

    

    <?php ActiveForm::end(); ?>

</div>
