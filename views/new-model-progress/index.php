<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;

$this->title = [
    'page_title' => 'Model Progress <span class="japanesse text-green"></span>',
    'tab_title' => 'Model Progress',
    'breadcrumbs_title' => 'Model Progress'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$color = 'ForestGreen';

$this->registerCss("h1 .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }
	#main-tbl{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    #main-tbl > thead > tr > th{
        border:1px solid #8b8c8d;
        background-color: #858689;
        color: white;
        font-size: 26px;
        border-bottom: 7px solid #ddd;
        vertical-align: middle;
    }
    #main-tbl > tbody > tr > td{
        //border:1px solid #29B6F6;
        font-size: 24px;
        background-color: #B3E5FC;
        font-weight: 1000;
        color: #555;
        vertical-align: middle;
    }
    tr .text-red{font-weight: 1000;}
	");

date_default_timezone_set('Asia/Jakarta');

/*$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 600000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";
$this->registerJs($script, View::POS_HEAD );*/

/*echo '<pre>';
print_r($model->gmc);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;

$this->registerJs("$(function() {
   $('.popupModal').click(function(e) {
        e.preventDefault();
        $('#modal').modal('show').find('.modal-body').html('<div class=\"text-center\">" . Html::img('@web/loading-01.gif', ['alt'=>'some', 'class'=>'thing']) . "</div>').load($(this).attr('href'));
   });
});");
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['new-model-progress/index']),
]); ?>

<div class="row">
    <div class="col-md-6">
    <?= $form->field($model, 'gmc')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(app\models\SernoMaster::find()->orderBy('model, color, dest')->all(), 'gmc', 'description'),
        'options' => [
            'placeholder' => 'Select model ...',
            'multiple' => true
        ],
    ]); ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'year')->dropDownList(\Yii::$app->params['year_arr']); ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'month')->dropDownList([
            '01' => 'Jan',
            '02' => 'Feb',
            '03' => 'Mar',
            '04' => 'Apr',
            '05' => 'May',
            '06' => 'Jun',
            '07' => 'Jul',
            '08' => 'Aug',
            '09' => 'Sep',
            '10' => 'Oct',
            '11' => 'Nov',
            '12' => 'Dec',
        ]); ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'daily_qty')->textInput(['type' => 'number'])->label('Estimated Qty/day'); ?>
    </div>
</div>
<div class="form-group">
    <?= Html::submitButton('GENERATE', ['class' => 'btn btn-success', 'style' => 'margin-top: 5px;']); ?>
</div>

<?php ActiveForm::end(); ?>

<div class="box">
	<!--<div class="box-header">
		<h3 class="box-title">Progress</h3>
    </div>-->
    <div class="box-body no-padding">
    	<table class="table table-bordered table-striped" id="main-tbl">
			<thead>
				<tr>
					<th class="text-center">GMC</th>
					<th>Description</th>
					<th class="text-center">Plan Qty</th>
					<th class="text-center">Act. Qty</th>
					<th class="text-center">FA</th>
					<th class="text-center">Est. Finish (Days)</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if (!isset($model->gmc)) {
					echo '<tr><td colspan="6">No data selected ...</td></tr>';
				} else {
					foreach ($data as $key => $value) {
						$total_minus = (int)$value['total_plan'] - (int)$value['total_actual'];
						$est_day = round($total_minus / $model->daily_qty);
						if ($total_minus == 0) {
							$link_minus = $total_minus;
						} else {
							$link_minus = Html::a(((int)$total_minus * -1), ['get-wip-progress', 'parent' => $value['parent'], 'period' => $model->year . $model->month], [
								'class' => 'popupModal text-red',
							]);
						}
						?>
						<tr>
							<td class="text-center"><?= $value['parent']; ?></td>
							<td><?= $value['parent_desc']; ?></td>
							<td class="text-center"><?= (int)$value['total_plan']; ?></td>
							<td class="text-center"><?= (int)$value['total_actual']; ?></td>
							<td class="text-center"><?= $link_minus; ?></td>
							<td class="text-center"><?= (int)$est_day; ?></td>
						</tr>
					<?php }
				}
				?>
			</tbody>
		</table>
    </div>
</div>

<?php
    yii\bootstrap\Modal::begin([
        'id' =>'modal',
        'header' => '<h3>Detail Information</h3>',
        'size' => 'modal-lg',
    ]);
    yii\bootstrap\Modal::end();
?>