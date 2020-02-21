<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;

/**
* @var yii\web\View $this
* @var app\models\search\LiveCookingDataSearch $model
* @var yii\widgets\ActiveForm $form
*/

$this->registerCss(".form-group { margin-bottom: 0px; }");

$menu_arr = [
    'BAKSO' => 'bakso_01.jpg',
    'GADO-GADO' => 'gado_gado_01.jpg',
    'LALAPAN' => 'lalapan_01.jpg',
    'NASI-GORENG' => 'nasi_goreng_01.jpg',
    'NASI-PECEL' => 'nasi_pecel_01.jpg',
    'RAWON' => 'rawon_01.jpg',
    'SOTO-AYAM' => 'soto_ayam_01.jpg'
];
$img_filename = $menu_arr[$today_menu_txt];
?>

<div class="live-cooking-request-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    <div class="row">
    	<div class="col-md-9">
    		<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">
						Filter Data
					</h3>
				</div>
		        <div class="panel-body">
		            <div class="row">
		                <div class="col-md-5">
		                	<div class="form-group">
		                		<?php echo '<label class="control-label">Select date range</label>';
						        echo DatePicker::widget([
						            'model' => $model,
						            'attribute' => 'from_date',
						            'attribute2' => 'to_date',
						            'options' => ['placeholder' => 'Start date'],
						            'options2' => ['placeholder' => 'End date'],
						            'type' => DatePicker::TYPE_RANGE,
						            'form' => $form,
						            'pluginOptions' => [
						                'format' => 'yyyy-mm-dd',
						                'autoclose' => true,
						            ]
						        ]);?>
		                	</div>
		                </div>
		                <div class="col-md-4">
		                	<?= $form->field($model, 'cc')->dropDownList(ArrayHelper::map(app\models\LiveCookingList::find()->orderBy('cc_desc')->all(), 'cc', 'cc_desc'), [
		                		'prompt' => 'Choose...'
		                	])->label('Department/Section'); ?>
		                </div>
		                <div class="col-md-3">
		                	<?= $form->field($model, 'close_open')->dropDownList([
		                		'O' => 'OPEN',
		                		'C' => 'CLOSE',
		                	], [
		                		'prompt' => 'Choose...'
		                	])->label('Order Status'); ?>
		                </div>
		            </div>
		            <div class="row">
		                <div class="col-sm-12">
		                    <div class="form-group">
						        <?= Html::submitButton('Search', ['class' => 'btn btn-info']); ?>
						    </div>
		                </div>
		            </div>
		        </div>
		    </div>
    	</div>
    	<div class="col-md-3">
    		<div class="panel panel-warning">
    			<div class="panel-heading">
    				<h3 class="panel-title">
    					Today Menu (<?= date('Y-m-d'); ?>) | <span style="font-weight: bold;"><?= $today_menu_txt; ?></span>
    				</h3>
    			</div>
    			<div class="panel-body">
    				<?= Html::img('@web/uploads/IMAGES/' . $menu_arr[$today_menu_txt], [
	                    'class' => '',
	                    //'height' => '500px',
	                    'height' => '103px',
	                    'style' => 'border-radius: 10px; border: 5px solid white;'
	                ]) ?>
    			</div>
    		</div>
    	</div>
    </div>
	

    

    <?php ActiveForm::end(); ?>

</div>
