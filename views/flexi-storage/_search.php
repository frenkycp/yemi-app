<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\FlexiStorageSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="flexi-storage-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    <div class="panel panel-success">
    	<div class="panel-heading">
    		<h3 class="panel-title">Search Form</h3>
    	</div>
    	<div class="panel-body">
    		<div class="row">
    			<div class="col-md-2">
    				<?= $form->field($model, 'kode_area') ?>
    			</div>
    			<div class="col-md-2">
    				<?= $form->field($model, 'area')->dropDownList(ArrayHelper::map(app\models\FlexiStorage::find()->select('area')->groupBy('area')->orderBy('area')->all(), 'area', 'area'), [
    					'prompt' => 'Choose...',
    				]); ?>
    			</div>
    			<div class="col-md-2">
    				<?= $form->field($model, 'rack')->dropDownList(ArrayHelper::map(app\models\FlexiStorage::find()->select('rack')->where('rack IS NOT NULL')->groupBy('rack')->orderBy('rack')->all(), 'rack', 'rack'), [
    					'prompt' => 'Choose...',
    				]); ?>
    			</div>
    			<div class="col-md-2">
    				<?= $form->field($model, 'kolom_level')->dropDownList(ArrayHelper::map(app\models\FlexiStorage::find()->select('kolom_level')->groupBy('kolom_level')->orderBy('kolom_level')->all(), 'kolom_level', 'kolom_level'), [
    					'prompt' => 'Choose...',
    				]); ?>
    			</div>
    			<div class="col-md-2">
    				<?= $form->field($model, 'posisi')->dropDownList(ArrayHelper::map(app\models\FlexiStorage::find()->select('posisi')->where('posisi IS NOT NULL')->groupBy('posisi')->orderBy('posisi')->all(), 'posisi', 'posisi'), [
    					'prompt' => 'Choose...',
    				]); ?>
    			</div>
                <div class="col-md-2">
                    <?= $form->field($model, 'storage_status')->dropDownList([
                        0 => 'KOSONG',
                        1 => 'TERPAKAI'
                    ], [
                        'prompt' => 'Choose...',
                    ]); ?>
                </div>
    		</div>
    		

			

			

			

			

			<?php // echo $form->field($model, 'panjang_cm') ?>

			<?php // echo $form->field($model, 'lebar_cm') ?>

			<?php // echo $form->field($model, 'tinggi_cm') ?>

			<?php // echo $form->field($model, 'kubikasi_m3') ?>

			<?php // echo $form->field($model, 'kubikasi_m3_act') ?>

			<?php // echo $form->field($model, 'kubikasi_m3_balance') ?>

			<?php // echo $form->field($model, 'percent_used') ?>

			<?php // echo $form->field($model, 'storage_type') ?>
    	</div>
    	<div class="panel-footer">
    		<div class="form-group">
		        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
		    </div>
    	</div>
    </div>

    

    <?php ActiveForm::end(); ?>

</div>
