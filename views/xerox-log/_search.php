<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\XeroxLogSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="fotocopy-log-tbl-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

		<div class="panel panel-primary">
			<div class="panel-body">
				<div class="row">
					<div class="col-md-3">
						<?= $form->field($model, 'period') ?>
					</div>
					<div class="col-md-3">
						<?= $form->field($model, 'machine') ?>
					</div>
					<div class="col-md-3">
						<?= $form->field($model, 'post_date') ?>
					</div>
					<div class="col-md-3">
						<?= $form->field($model, 'post_date') ?>
					</div>
				</div>
			</div>
		</div>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
