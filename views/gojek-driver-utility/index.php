<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'Material Handle Utilization <span class="japanesse text-green">(マテハン稼働率）</span>',
    'tab_title' => 'Material Handle Utilization',
    'breadcrumbs_title' => 'Material Handle Utilization'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$color = 'ForestGreen';

$this->registerCss("h1 .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

date_default_timezone_set('Asia/Jakarta');

$script = <<< JS
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout("refreshPage();", 600000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
JS;
$this->registerJs($script, View::POS_HEAD );

/*echo '<pre>';
print_r($data2);
echo '</pre>';*/
?>

<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-tag"></i> Last Update : <?= date('Y-m-d H:i:s') ?></h3>
    </div>
    <div class="box-body">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">Utilization (稼働率）</a></li>
                <li><a href="#tab_2" data-toggle="tab">Workload (作業負荷）</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <?php
                    echo Highcharts::widget([
                        'scripts' => [
                            //'modules/exporting',
                            //'themes/grid-light',
                            'themes/sand-signika',
                        ],
                        'options' => [
                            'chart' => [
                                'zoomType' => 'x',
                                'type' => 'spline'
                            ],
                            'credits' => [
                                'enabled' =>false
                            ],
                            'title' => [
                                'text' => null
                            ],
                            'legend' => [
                                'layout' => 'vertical',
                                'align' => 'left',
                                'verticalAlign' => 'middle'
                            ],
                            'xAxis' => [
                                'type' => 'datetime',
                                'offset' => 10,
                                //'categories' => $value['categories']
                            ],
                            'yAxis' => [
                                'title' => [
                                    'enabled' => true,
                                    'text' => 'Percentage (%)',
                                ],

                                //'plotBands' => $plotBands,
                            ],
                            'tooltip' => [
                                'shared' => true,
                                'crosshairs' => true,
                                'xDateFormat' => '%Y-%m-%d',
                                'valueSuffix' => '%',
                            ],
                            'series' => $data
                        ],
                    ]);
                    ?>
                </div>
                <div class="tab-pane" id="tab_2">
                    <?php
                    echo Highcharts::widget([
                        'scripts' => [
                            //'modules/exporting',
                            //'themes/grid-light',
                            'themes/sand-signika',
                        ],
                        'options' => [
                            'chart' => [
                                'zoomType' => 'x',
                                'type' => 'column'
                            ],
                            'credits' => [
                                'enabled' =>false
                            ],
                            'title' => [
                                'text' => null
                            ],
                            'legend' => [
                                'layout' => 'vertical',
                                'align' => 'left',
                                'verticalAlign' => 'middle'
                            ],
                            'xAxis' => [
                                'type' => 'datetime',
                                //'offset' => 10,
                                //'categories' => $value['categories']
                            ],
                            'yAxis' => [
                                'title' => [
                                    'enabled' => true,
                                    'text' => 'Minute',
                                ],

                                //'plotBands' => $plotBands,
                            ],
                            'tooltip' => [
                                'shared' => true,
                                'crosshairs' => true,
                                'xDateFormat' => '%Y-%m-%d',
                            ],
                            'series' => $data2
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
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