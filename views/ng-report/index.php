<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'Weekly Corrective <span class="text-green">(週次修繕)',
    'tab_title' => 'Weekly Corrective',
    'breadcrumbs_title' => 'Weekly Corrective'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$color = 'ForestGreen';

date_default_timezone_set('Asia/Jakarta');
$this->registerCss("h1 span { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

$this->registerCss(".tab-content > .tab-pane,
.pill-content > .pill-pane {
    display: block;     
    height: 0;          
    overflow-y: hidden; 
}

.tab-content > .active,
.pill-content > .active {
    height: auto;       
} ");

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

$startDate = date('Y-06-01');
$endDate = date('Y-m-t');
$startWeek = app\models\SernoCalendar::find()->where(['ship' => $startDate])->one()->week_ship;
$endWeek = app\models\SernoCalendar::find()->where(['ship' => $endDate])->one()->week_ship;
$date_today = date('Y-m-d');
$startWeek = 42;
$endWeek = 52;

$today = new \DateTime(date('Y-m-d'));
$weekToday = $today->format("W");

$week_is_found = false;
$tmp_week;
foreach ($data as $key => $value) {
    if ($key == $weekToday) {
        $week_is_found = true;
    }
    $tmp_week = $key;
}

if (!$week_is_found) {
    $weekToday = $tmp_week;
}

/*echo '<pre>';
print_r($data);
echo '</pre>';*/
?>
<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['ng-report/index']),
]); ?>

<div class="row">
    <div class="col-md-2">
        <?= Html::label('Year'); ?>
        <?= Html::dropDownList('year', $year, \Yii::$app->params['year_arr'], [
            'class' => 'form-control',
            'onchange'=>'this.form.submit()'
        ]); ?>
    </div>
    <div class="col-md-2">
        <?= Html::label('Month'); ?>
        <?= Html::dropDownList('month', $month, [
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
        ], [
            'class' => 'form-control',
            'onchange'=>'this.form.submit()'
        ]); ?>
    </div>
</div>
<br/>

<?php ActiveForm::end(); ?>

<u><h5>Last Updated : <?= date('d-M-Y H:i:s') ?></h5></u>
<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">
        <?php
        foreach ($data as $key => $value) {
            if($key == $weekToday)
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
        foreach ($data as $key => $value) {
            if($key == $weekToday)
            {
                echo '<div class="tab-pane active" id="tab_1_' . $key .'">';
            }
            else
            {
                echo '<div class="tab-pane" id="tab_1_' . $key .'">';
            }

            echo Highcharts::widget([
                'scripts' => [
                    //'modules/exporting',
                    'themes/grid-light',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'column',
                        'style' => [
                            'fontFamily' => 'Source Sans Pro'
                        ],
                    ],
                    'title' => [
                        'text' => null
                    ],
                    'subtitle' => [
                        'text' => null
                    ],
                    'credits' => [
                        'enabled' => false
                    ],
                    'xAxis' => [
                        'type' => 'datetime'
                    ],
                    /*'xAxis' => [
                        'categories' => $dataName,
                        'labels' => [
                            'formatter' => new JsExpression('function(){ return \'<a href="container-progress?etd=\' + this.value + \'">\' + this.value + \'</a>\'; }'),
                        ],
                    ],*/
                    'yAxis' => [
                        'min' => 0,
                        'title' => [
                            'text' => 'Total Completion'
                        ],
                        'gridLineWidth' => 0,
                    ],
                    'tooltip' => [
                        'enabled' => true,
                        'xDateFormat' => '%A, %b %e %Y',
                    ],
                    'plotOptions' => [
                        'column' => [
                            'stacking' => 'percent',
                            'dataLabels' => [
                                'enabled' => true,
                                'format' => '{point.percentage:.0f}% ({point.qty:.0f})',
                                //'color' => 'black',
                                //'formatter' => new JsExpression('function(){ if(this.y != 0) { return this.y; } }'),
                                /*'style' => [
                                    'textOutline' => '0px',
                                    'fontWeight' => '0'
                                ],*/
                            ],
                        ],
                        'series' => [
                            'cursor' => 'pointer',
                            'point' => [
                                'events' => [
                                    'click' => new JsExpression('function(){ location.href = this.options.url; }'),
                                    //'click' => new JsExpression('function(){ window.open(this.options.url); }')
                                ]
                            ]
                        ]
                    ],
                    'series' => $value
                ],
            ]);

            echo '</div>';
        }
        ?>
    </div>
</div>