<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'GO-PALLET ACTIVITIES <span class="japanesse text-green"></span>',
    'tab_title' => 'GO-PALLET ACTIVITIES',
    'breadcrumbs_title' => 'GO-PALLET ACTIVITIES'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("h1 .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

date_default_timezone_set('Asia/Jakarta');

$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 600000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";
$this->registerJs($script, View::POS_HEAD );

/*echo '<pre>';
print_r($data);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>

<div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">Last Update : <?= date('Y-m-d H:i:s'); ?></h3>
    </div>
    <div class="box-body">
        <div class="box-group" id="accordion">
            <?php
            foreach ($data as $key => $value) {
                
                ?>
                <div class="panel box box-solid box-success">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $key; ?>">
                                <?= $key . ' - ' . $value['nama'] . ' | '; ?>
                            </a>
                            <small style="color: white;">
                                <b><?= $value['todays_point'] > 1 ? $value['todays_point'] . '</b> points' : $value['todays_point'] . '</b> point'; ?>
                            </small>
                        </h4>
                        <div class="pull-right" style="font-size: 12px;">
                            <?= ($text_status); ?>
                        </div>
                    </div>
                    <div id="collapse<?= $key; ?>" class="panel-collapse collapse<?= \Yii::$app->user->identity->username == $key ? ' in' : '' ?>">
                        <div class="box-body">
                            <?php
                            echo Highcharts::widget([
                                'scripts' => [
                                    //'modules/exporting',
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
                                        'text' => null
                                    ],
                                    'xAxis' => [
                                        'type' => 'datetime',
                                        'offset' => 10,
                                    ],
                                    'yAxis' => [
                                        'title' => [
                                            'text' => 'Total Order'
                                        ],
                                        //'max' => $max_order,
                                        'minTickInterval' => 1,
                                        'stackLabels' => [
                                            'enabled' => true,
                                            'style' => [
                                                'color' => 'red'
                                            ],
                                        ],
                                    ],
                                    'tooltip' => [
                                        //'shared' => true,
                                        'crosshairs' => true,
                                        'xDateFormat' => '%Y-%m-%d',
                                    ],
                                    'plotOptions' => [
                                        'column' => [
                                            'stacking' => 'normal',
                                            'dataLabels' => [
                                                'enabled' => true,
                                                //'formatter' => new JsExpression('function(){ if(this.y != 0) { return this.y; } }'),
                                                'style' => [
                                                    'fontSize' => '14px',
                                                    'fontWeight' => '0'
                                                ],
                                            ],
                                            'borderWidth' => 1,
                                            //'borderColor' => $color,
                                        ],
                                        'series' => [
                                            'cursor' => 'pointer',
                                            'point' => [
                                                'events' => [
                                                    'click' => new JsExpression("
                                                        function(e){
                                                            e.preventDefault();
                                                            $('#modal').modal('show').find('.modal-body').html('<div class=\"text-center\">" . Html::img('@web/loading-01.gif', ['alt'=>'some', 'class'=>'thing']) . "</div>').load(this.options.url);
                                                        }
                                                    "),
                                                ]
                                            ],
                                            'maxPointWidth' => 80,
                                        ]
                                    ],
                                    'series' => $value['data']
                                ],
                            ]); ?>
                        </div>
                    </div>
                </div>
                <?php
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
</div>