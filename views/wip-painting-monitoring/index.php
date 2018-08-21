<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\web\View;
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'Kanban Monitor <span class="japanesse text-green">（かんばんモニター）</span>',
    'tab_title' => 'Kanban Monitor',
    'breadcrumbs_title' => 'Kanban Monitor'
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

/*echo '<pre>';
print_r($data);
echo '</pre>';*/
?>

<?php $form = ActiveForm::begin(); ?>

	<div class="row">
		<div class="col-sm-2">
			<?= $form->field($model, 'loc')->dropDownList(
				$dropdown_loc,
				[
					'prompt'=>'Select Location...',
					'onchange'=>'this.form.submit()'
				]
			) ?>
		</div>
		<div class="col-sm-1">
			<?= $form->field($model, 'year')->dropDownList(
				$year_arr,
				[
					'onchange'=>'this.form.submit()'
				]
			) ?>
		</div>
		<div class="col-sm-2">
			<?= $form->field($model, 'month')->dropDownList(
				$month_arr,
				[
					'onchange'=>'this.form.submit()'
				]
			) ?>
		</div>
	</div>

    <div class="form-group">
        <?= '';Html::submitButton('Update Chart', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>

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
                        'formatter' => new JsExpression('function(){ return "Percentage : " + this.y + "%"; }'),
                    ],
                    'plotOptions' => [
                        'column' => [
                            'stacking' => 'normal',
                            'dataLabels' => [
                                'enabled' => true,
                                'format' => '{point.percentage:.0f}%',
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
                            'point' => [
                                'events' => [
                                    'click' => new JsExpression('
                                        function(){
                                            $("#modal").modal("show").find(".modal-body").html(this.options.remark);
                                        }
                                    '),
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