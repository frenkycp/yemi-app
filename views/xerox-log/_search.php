<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
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
					<div class="col-md-2">
						<?= $form->field($model, 'period'); ?>
					</div>
					<div class="col-md-2">
						<?= $form->field($model, 'machine')->dropDownList(ArrayHelper::map(app\models\FotocopyLogTbl::find()->select('machine')->groupBy('machine')->orderBy('machine')->all(), 'machine', 'machine'), [
							'prompt' => '- ALL -'
						]); ?>
					</div>
					<div class="col-md-2">
						<?= $form->field($model, 'post_date'); ?>
					</div>
					<div class="col-md-3">
						<?= $form->field($model, 'COST_CENTER')->dropDownList(ArrayHelper::map(app\models\FotocopyUserTbl::find()->select('COST_CENTER, COST_CENTER_DESC')->where([
							'<>', 'COST_CENTER_DESC', 'WAIT'
						])->groupBy('COST_CENTER, COST_CENTER_DESC')->orderBy('COST_CENTER_DESC')->all(), 'COST_CENTER', 'COST_CENTER_DESC'), [
							'prompt' => '- ALL -'
						])->label('Department'); ?>
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
