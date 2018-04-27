<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Shipping Report');
$this->params['breadcrumbs'][] = $this->title;
//$color = new JsExpression('Highcharts.getOptions().colors[7]');
$color = 'DodgerBlue';

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

?>

<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <?php
                $dailyStyle = '';
                $weeklyStyle = '';
                $monthlyStyle = '';
                if(isset($_GET['category']))
                {
                    if($_GET['category'] == 1)
                    {
                        echo 'Weekly Report';
                        $weeklyStyle = 'display: none;';
                    } else {
                        echo 'Monthly Report';
                        $monthlyStyle = 'display: none;';
                    }
                } else {
                    echo 'Daily Report';
                    $dailyStyle = 'display: none;';
                }
                ?> <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li role="presentation" style="<?= $dailyStyle ?>"><?= Html::a('Daily Report', ['index']) ?></li>
                <li role="presentation" style="<?= $weeklyStyle ?>"><?= Html::a('Weekly Report', '#') ?></li>
                <li role="presentation" style="<?= $monthlyStyle ?>"><?= Html::a('Monthly Report', ['index', 'category' => 2]) ?></li>
            </ul>
        </li>
    </ul>
    <div class="tab-content">
        <?php
        echo Highcharts::widget([
            'scripts' => [
                'modules/exporting',
                'themes/sand-signika',
            ],
            'options' => [
                'chart' => [
                    'type' => 'column',
                    'height' => 400
                ],
                'credits' => [
                    'enabled' =>false
                ],
                'title' => [
                    'text' => $title
                ],
                'subtitle' => [
                    'text' => $subtitle
                ],
                'xAxis' => [
                    'type' => 'category'
                ],
                'xAxis' => [
                    'categories' => $dataName
                ],
                'yAxis' => [
                    'min' => 0,
                    'title' => [
                        'text' => 'Total Completion'
                    ],
                    'gridLineWidth' => 0
                ],
                'tooltip' => [
                    'enabled' => false
                ],
                'plotOptions' => [
                    'column' => [
                        'stacking' => 'percent',
                        'dataLabels' => [
                            'enabled' => true,
                            'format' => '{point.percentage:.0f}%',
                            'style' => [
                                'fontSize' => '14px',
                            ],
                        ],
                        'borderWidth' => 2,
                        'borderColor' => $color,
                    ],
                    'series' => [
                        'cursor' => 'pointer',
                        'point' => [
                            'events' => [
                                //'click' => new JsExpression('function(){ location.href = "www.facebook.com"; }')
                            ]
                        ]
                    ]
                ],
                'series' => [
                    [
                        'name' => 'Outstanding',
                        'data' => $dataOpen,
                        'color' => 'FloralWhite',
                        'dataLabels' => [
                            'enabled' => false
                        ],
                        'showInLegend' => false
                    ],
                    [
                        'name' => 'Completed',
                        'data' => $dataClose,
                        'color' => $color,
                    ]
                ]
            ],
        ]);
        ?>
    </div>
    <!-- /.tab-content -->
</div>