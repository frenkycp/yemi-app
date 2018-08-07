<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;


$this->title = [
    'page_title' => 'Weekly Preventive <span class="text-green japanesse">(週次予防保全)</span>',
    'tab_title' => 'Weekly Preventive',
    'breadcrumbs_title' => 'Weekly Preventive'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');
$this->registerCss(".japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

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
//$weekToday = app\models\SernoCalendar::find()->where(['etd' => $date_today])->one()->week_ship;
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
                $year_arr
            ); ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'month')->dropDownList(
                $month_arr
            ); ?>
        </div>
        <?= Yii::$app->params['update_chart_btn']; ?>
    </div>
    

<?php ActiveForm::end(); ?>
<u><h5>Last Updated : <?= date('d-M-Y H:i:s') ?></h5></u>
<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">
        <?php
        $color = 'MediumAquamarine';
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
                'modules/exporting',
                'themes/sand-signika',
            ],
            'options' => [
                'chart' => [
                    'type' => 'column',
                    'height' => 400,
                    'width' => null
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
                    'type' => 'category'
                ],
                'xAxis' => [
                    'categories' => $value['category'],
                    'labels' => [
                        'formatter' => new JsExpression('function(){ return \'<a href="container-progress?etd=\' + this.value + \'">\' + this.value + \'</a>\'; }'),
                    ],
                ],
                'yAxis' => [
                    'min' => 0,
                    'title' => [
                        'text' => 'Total Completion'
                    ],
                    'gridLineWidth' => 0,
                ],
                'tooltip' => [
                    //'enabled' => false
                ],
                'plotOptions' => [
                    'column' => [
                        'stacking' => 'normal',
                        'dataLabels' => [
                            'enabled' => true,
                            'format' => '{point.percentage:.0f}%<br/>({point.qty})',
                            'color' => 'black',
                            //'formatter' => new JsExpression('function(){ if(this.y != 0) { return this.y; } }'),
                            'style' => [
                                'fontSize' => '14px',
                                'fontWeight' => '0',
                                'textOutline' => '0px'
                            ],
                        ],
                        //'borderWidth' => 2,
                        //'borderColor' => $color,
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
                'series' => $value['data']
                /*'series' => [
                    [
                        'name' => 'Outstanding',
                        'data' => $dataOpen,
                        'color' => 'FloralWhite',
                        'dataLabels' => [
                            'enabled' => true,
                            //'color' => 'black',
                            'format' => '{point.percentage:.0f}%<br/>({point.qty})',
                            'style' => [
                                'textOutline' => '0px'
                            ],
                        ],
                        'showInLegend' => false
                    ],
                    [
                        'name' => 'Completed',
                        'data' => $dataClose,
                        'color' => $color,
                        'dataLabels' => [
                            'enabled' => true,
                            //'color' => 'black',
                            'format' => '{point.percentage:.0f}%<br/>({point.qty})',
                            'style' => [
                                'textOutline' => '0px'
                            ],
                        ]
                    ]
                ]*/
            ],
        ]);
            echo '</div>';
        }
        ?>
    </div>
</div>