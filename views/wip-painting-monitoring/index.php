<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\web\View;
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'E-WIP Monitor <span class="japanesse text-green">（E-WIP モニター）</span> - Completion Target Based <span class="japanesse text-green">(完成目標基準）</span>',
    'tab_title' => 'E-WIP Monitor',
    'breadcrumbs_title' => 'E-WIP Monitor'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss(".japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

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

date_default_timezone_set('Asia/Jakarta');

/*echo '<pre>';
print_r($data);
echo '</pre>';*/
?>

<?php $form = ActiveForm::begin([
    'method' => 'get'
]); ?>

	<div class="row">
		<div class="col-sm-2">
			<?= $form->field($model, 'loc')->dropDownList(
				$dropdown_loc,
				[
					'prompt'=>'Select Location...',
					'onchange'=>'this.form.submit()',
                    'style' => 'font-size: 12px;'
				]
			) ?>
		</div>
		<div class="col-sm-1">
			<?= $form->field($model, 'year')->dropDownList(
				$year_arr,
				[
					'onchange'=>'this.form.submit()',
                    'style' => 'font-size: 12px;'
				]
			) ?>
		</div>
		<div class="col-sm-2">
			<?= $form->field($model, 'month')->dropDownList(
				$month_arr,
				[
					'onchange'=>'this.form.submit()',
                    'style' => 'font-size: 12px;'
				]
			) ?>
		</div>
	</div>

    <div class="form-group">
        <?= '';Html::submitButton('Update Chart', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>
<p><b>Last Update : <?= date('Y-m-d H:i:s'); ?></b></p>
<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">
		<?php
		
        foreach ($data as $key => $value) {
            if($key == $this_week)
            {
                echo '<li class="active"><a href="#tab_1_' . $key . '" data-toggle="tab">Week ' . $key . '</a></li>';
            }
            else
            {
                echo '<li><a href="#tab_1_' . $key . '" data-toggle="tab">Week ' . $key . '</a></li>';
            }
        }
        ?>
	</ul>
	<div class="tab-content">
		<?php
		if (count($data) === 0) {
			echo 'No data found...';
		}
        foreach ($data as $key => $value) {
            if($key == $this_week)
            {
                echo '<div class="tab-pane active" id="tab_1_' . $key .'">';
            }
            else
            {
                echo '<div class="tab-pane" id="tab_1_' . $key .'">';
            }

            echo Highcharts::widget([
                'scripts' => [
                    'modules/exporting',
                    //'themes/sand-signika',
                    'themes/grid-light',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'column',
                        'style' => [
                            'fontFamily' => 'Source Sans Pro'
                        ],
                    ],
                    'credits' => [
                        'enabled' =>false
                    ],
                    'title' => [
                        'text' => ''
                    ],
                    'subtitle' => [
                        'text' => ''
                    ],
                    'xAxis' => [
                        'type' => 'category',
                        'categories' => $value['category'],
                    ],
                    'yAxis' => [
                        //'min' => 0,
                        'title' => [
                            'text' => 'Total Completion'
                        ],
                        //'gridLineWidth' => 0,
                    ],
                    'tooltip' => [
                        'enabled' => true,
                        'formatter' => new JsExpression('function(){ return "Percentage : " + this.y + "%<br/>" + "Qty : " + Math.round(this.point.qty) + " pcs"; }'),
                    ],
                    'plotOptions' => [
                        'column' => [
                            'stacking' => 'percent',
                            'dataLabels' => [
                                'enabled' => true,
                                'format' => '{point.percentage:.0f}% ({point.qty:.0f})',
                                'color' => 'black',
                                //'formatter' => new JsExpression('function(){ if(this.y != 0) { return this.y; } }'),
                                'style' => [
                                    //'fontSize' => '14px',
                                    'textOutline' => '0px',
                                    'fontWeight' => '0'
                                ],
                            ],
                            //'borderWidth' => 1,
                            //'borderColor' => $color,
                        ],
                        'series' => [
                            'cursor' => 'pointer',
                            'dataLabels' => [
                                'allowOverlap' => true
                            ],
                            'point' => [
                                'events' => [
                                    'click' => new JsExpression("
                                        function(e){
                                            e.preventDefault();
                                            $('#modal').modal('show').find('.modal-body').html('<div class=\"text-center\">" . Html::img('@web/loading-01.gif', ['alt'=>'some', 'class'=>'thing']) . "</div>').load(this.options.url);
                                        }
                                    "),
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
            'size' => 'modal-lg',
        ]);
        yii\bootstrap\Modal::end();
        ?>
	</div>
</div>