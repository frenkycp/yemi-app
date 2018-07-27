<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\PlanReceiving;
use yii\bootstrap\ActiveForm;
use yii\web\View;
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\PlanReceivingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Plan Receiving Visual';
$this->params['breadcrumbs'][] = $this->title;

$selected_month = date('n');
if(!empty($_POST))
{
    $selected_month = $_POST['month'];
}
$js = <<<SCRIPT
/* To initialize BS3 tooltips set this below */
$(function () { 
    $("[data-toggle='tooltip']").tooltip(); 
});;
/* To initialize BS3 popovers set this below */
$(function () { 
    $("[data-toggle='popover']").popover(); 
});
SCRIPT;

$script = <<< JS
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout("refreshPage();", 300000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
JS;
$this->registerJs($script, View::POS_HEAD );
// Register tooltip/popover initialization javascript
$this->registerJs($js);

?>
<div class="plan-receiving-index">

    <!--<h1><?= Html::encode($this->title) ?> <small><?= date('F Y'); ?></small></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= ''; //Html::a('Create Plan Receiving', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php $form = ActiveForm::begin([
    'id' => 'form_index',
    'layout' => 'horizontal',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-danger',
    'fieldConfig' => [
             'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
             'horizontalCssClasses' => [
                 //'label' => 'col-sm-2',
                 #'offset' => 'col-sm-offset-4',
                 'wrapper' => 'col-sm-7',
                 'error' => '',
                 'hint' => '',
             ],
         ],
    ]
    );
    ?>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'year')->dropDownList(
                $year_arr,
                ['prompt' => 'Select']
            ); ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'month')->dropDownList(
                $month_arr,
                [
                    'prompt' => 'Select',
                    'onchange'=>'this.form.submit()'
                ]
            ); ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <?php
            foreach ($data as $week_no => $value) {
                if($week_no == $week_today)
                {
                    echo '<li class="active"><a href="#tab_1_' . $week_no . '" data-toggle="tab">Week ' . $week_no . '</a></li>';
                }
                else
                {
                    echo '<li><a href="#tab_1_' . $week_no . '" data-toggle="tab">Week ' . $week_no . '</a></li>';
                }
            }
            ?>
        </ul>
        <div class="tab-content">
            <?php
            foreach ($data as $week_no => $value) {
                if($week_no == $week_today)
                {
                    echo '<div class="tab-pane active" id="tab_1_' . $week_no .'">';
                }
                else
                {
                    echo '<div class="tab-pane" id="tab_1_' . $week_no .'">';
                }

                echo Highcharts::widget([
                    'scripts' => [
                        'modules/exporting',
                        'themes/grid-light',
                        //'themes/sand-signika',
                    ],
                    'options' => [
                        'chart' => [
                            'type' => 'column',
                            //'height' => 300,
                        ],
                        'credits' => [
                            'enabled' =>false
                        ],
                        'title' => [
                            'text' => null
                        ],
                        'subtitle' => [
                            'text' => null
                        ],
                        'xAxis' => [
                            'categories' => $value['category'],
                            'title' => [
                                'text' => 'Date'
                            ],
                        ],
                        'yAxis' => [
                            'min' => 0,
                            'allowDecimals' => false,
                            //'minorTickInterval' => 1,
                            'title' => [
                                'text' => 'Total Qty'
                            ],
                            'stackLabels' => [
                                'enabled' => true,
                                'style' => [
                                    'fontWeight' => 'bold',
                                ]
                            ]
                        ],
                        'plotOptions' => [
                            'column' => [
                                'dataLabels' => [
                                    'enabled' => true,
                                    'style' => [
                                        'textOutline' => '0px',
                                        'fontWeight' => '0'
                                    ],
                                ]
                            ],
                            'series' => [
                                'cursor' => 'pointer',
                                'point' => [
                                    'events' => [
                                        'click' => new JsExpression('
                                            function(){
                                                $("#modal").modal("show").find(".modal-body").html(this.options.remark);
                                            }
                                        '),
                                        //'click' => new JsExpression('function(){ window.open(this.options.url); }')
                                    ]
                                ]
                            ]
                        ],
                        'series' => $value['data']
                    ],
                ]);

                echo '</div>';
            }
            yii\bootstrap\Modal::begin([
                'id' =>'modal',
                'header' => '<h3>Detail Information</h3>',
                //'size' => 'modal-lg',
            ]);
            yii\bootstrap\Modal::end();
            ?>
        </div>
    </div>

    <div class="box box-info" style="display: none;">
        <div class="box-header with-border">
            <h3 class="box-title"><?= date('F Y', strtotime($model->year . '-' . $model->month)); ?></h3>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table no-margin table-bordered table-hover">
                    <tr class="warning">
                        <th style="vertical-align: middle;">Vendor Name</th>
                        <th style="vertical-align: middle;">Vehicle</th>
                        <th style="vertical-align: middle;">Item Type</th>
                    <?php
                    $days_in_month = cal_days_in_month(CAL_GREGORIAN, $model->month, $model->year);
                    for ($i = 1; $i <= $days_in_month; $i++) {
                        ?>
                        <th style="min-width: 30px; text-align: center; vertical-align: middle;"><?=  $i?></th>
                    <?php }
                    ?>
                    </tr>
                    
                        <?php
                        $data = PlanReceiving::find()
                        ->select('vendor_name, vehicle, item_type')
                        ->where(['month_periode' => $model->year . $model->month])
                        ->groupBy('vendor_name, vehicle, item_type')
                        ->orderBy('vendor_name ASC, vehicle ASC, item_type ASC')
                        ->all();
                        $qty_in_day = [];
                        if (count($data) > 0) {
                            foreach ($data as $value) {

                                ?>
                            <tr valign="middle">
                                <td  style="vertical-align: middle;"><?= $value->vendor_name ?></td>
                                <td  style="vertical-align: middle;"><?= $value->vehicle ?></td>
                                <td  style="vertical-align: middle;"><?= $value->item_type ?></td>
                                <?php
                                
                                for($j = 1; $j <= $days_in_month; $j++)
                                {
                                    if (!isset($qty_in_day[$j-1])) {
                                        $qty_in_day[$j-1] = 0;
                                    }
                                    $data_by_date = PlanReceiving::find()
                                    ->select('vendor_name, vehicle, item_type, receiving_date, SUM(qty) as total_qty')
                                    ->where([
                                        'vendor_name' => $value->vendor_name,
                                        'vehicle' => $value->vehicle,
                                        'item_type' => $value->item_type,
                                        'receiving_date' => date('Y-m-d', strtotime(date($model->year . '-' . $model->month . '-' . $j))),
                                    ])
                                    ->groupBy('vendor_name, vehicle, item_type, receiving_date')->one();
                                    $tmp_total = 0;
                                    if (count($data_by_date) > 0) {
                                        $tmp_total = $data_by_date->total_qty;
                                        $qty_in_day[$j-1] += $data_by_date->total_qty;
                                    }
                                    ?>
                                    <td class="text-center <?= $tmp_total > 0 ? 'bg-info' : '' ?>" style="vertical-align: middle;">
                                        <?= count($data_by_date) != 0 ? '<span data-toggle="tooltip" title="' . date('d M Y', strtotime($data_by_date->receiving_date)) . '" class="">' . $data_by_date->total_qty . '</span>' : '' ?>
                                    </td>
                                <?php }
                                ?>
                            </tr>
                            <?php }

                        }
                        ?>
                    <tr class="success" style="display: <?= count($qty_in_day) > 0 ? '' : 'none'; ?>">
                        <td colspan="3" class="text-center">Total</td>
                        <?php
                        for($k = 1; $k <= $days_in_month; $k++)
                        {
                            if (isset($qty_in_day[$k-1])) {
                                echo '<td class="text-center">
                                <span data-toggle="tooltip" title="' . date('d M Y', strtotime($model->year . '-' . $model->month . '-' . $k)) . '">
                                ' . $qty_in_day[$k-1] . '
                                </span>
                                </td>';
                            }
                            
                        }
                        ?>
                    </tr>
                    <tr class="active" style="display: <?= count($qty_in_day) == 0 ? '' : 'none'; ?>">
                        <td colspan="<?= 3 + $days_in_month ?>">No results found.</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
</div>
