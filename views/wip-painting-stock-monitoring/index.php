<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\web\View;
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'Stock WIP Monitor <span class="japanesse text-green">（仕掛在庫モニター）</span> - Started + Completed qty <span class="japanesse text-green">(加工中 +完成台数)</span>',
    'tab_title' => 'Stock WIP Monitor',
    'breadcrumbs_title' => 'Stock WIP Monitor'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss(".japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

/*$js = <<< SCRIPT
	$(document).ready(function() { 
	    $.ajax({ 
	        url: 'wip-painting-stock-monitoring/ajax-example', 
	        type: 'post',
	        data: {nilai1: 2, nilai2:4},
	        success: function(data) { 
	            console.log(data); 
	        }, 
	    }); 
	});
SCRIPT
; 
$this->registerJs($js, View::POS_END);
*/
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

$data_painting = $data['PAINTING'];
$data_cab_assy = $data['CAB ASSY'];
$data_final_assy = $data['FINAL ASSY'];

$height = 250;
$title_y = -100;
$stops_arr = [
    [0.75, '#55BF3B'], // green
    [0.85, '#DDDF0D'], // yellow
    [1, '#DF5353'] // red
];

/*echo '<pre>';
print_r($data_painting);
echo '</pre>';*/
?>
<h5 class="box-title"><i class="fa fa-tag"></i> Last Update : <?= date('Y-m-d H:i:s') ?></h5>
<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">
		<!--<li class="active"><a href="#tab_1" data-toggle="tab">LINE-X</a></li>
		<li><a href="#tab_2" data-toggle="tab">ALL</a></li>-->
		<li class="active"><a href="#tab_1" data-toggle="tab">WIP Factory 1</a></li>
		<li><a href="#tab_2" data-toggle="tab">WIP Factory 2</a></li>
		<li><a href="#tab_3" data-toggle="tab">KD</a></li>
	</ul>
	<div class="tab-content">
		<?php
		foreach ($category_area_arr as $key => $value) {
			if ($key == 1) {
				echo '<div class="tab-pane active" id="tab_' . $key . '">';
			} else {
				echo '<div class="tab-pane" id="tab_' . $key . '">';
			}
			echo Highcharts::widget([
	            'scripts' => [
	                'modules/exporting',
	                'themes/sand-signika',
	            ],
	            'options' => [
	                'chart' => [
	                    'type' => 'column',
	                    'height' => 450,
	                    'width' => null
	                ],
	                'title' => [
	                    'text' => null
	                ],
	                'xAxis' => [
	                    'type' => 'category'
	                ],
	                'xAxis' => [
	                    'categories' => $categories[$value],
	                ],
	                'yAxis' => [
	                    'min' => 0,
	                    'title' => [
	                        'text' => 'Percentage'
	                    ],
	                    'gridLineWidth' => 0,
	                    'plotLines' => [
                            [
                                'value' => 100,
                                'color' =>  '#D3D3D3',
                                'width' => 1,
                                'zIndex' => 0,
                                'label' => ['text' => '']
                            ]
                        ],
	                ],
	                'tooltip' => [
	                    'enabled' => true,
	                    //'shared' => true,
	                    'formatter' => new JsExpression('function(){ return "Percentage : " + this.y + "%<br/>" + "Qty : " + this.point.qty + " pcs"; }'),
	                ],
	                'plotOptions' => [
	                    'column' => [
	                        'stacking' => 'normal',
	                        /*'dataLabels' => [
	                            'enabled' => true,
	                            'format' => '{point.qty} pcs',
	                        ],*/
	                    ],
	                    'series' => [
	                    	'pointWidth' => 100
	                    ],
	                ],
	                'series' => $data2[$value]
	            ],
            ]);
			echo '</div>';
		}
		?>
	</div>
</div>
