<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\SernoInputSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="serno-input-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>
    <div class="row">
    	
    	<div class="col-sm-4">
    		<div class="panel panel-primary">
    			<div class="panel-body">
    				<?= $form->field($model, 'flo') ?>

		    		<?= $form->field($model, 'sernum') ?>

		    		<?= $form->field($model, 'invoice') ?>

		    		<?= $form->field($model, 'so') ?>
    			</div>
    		</div>
    	</div>

    	<div class="col-sm-4">
    		<div class="panel panel-primary">
    			<div class="panel-body">
    				<?= $form->field($model, 'port') ?>

					<?= $form->field($model, 'status')->dropDownList([
			            'OK' => 'OK',
			            'LOT OUT' => 'Lot Out',
			            'REPAIR' => 'Repair'
			        ], ['prompt'=>'Select...']) ?>

					<?= $form->field($model, 'line') ?>

					<?= $form->field($model, 'gmc') ?>
    			</div>
    		</div>
    	</div>

    	<div class="col-sm-4">
			<div class="panel panel-primary">
				<div class="panel-body">
					<?= $form->field($model, 'proddate') ?>

		    		<?= $form->field($model, 'etd_ship') ?>

		    		<?= $form->field($model, 'vms')->label('VMS Date') ?>
				</div>
    		</div>
    	</div>

    </div>
		
    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= ''; //Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
