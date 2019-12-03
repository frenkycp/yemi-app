<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'DPR Line Efficiency (Target v.s Actual) <span class="japanesse light-green"></span>',
    'tab_title' => 'DPR Line Efficiency (Target v.s Actual)',
    'breadcrumbs_title' => 'DPR Line Efficiency (Target v.s Actual)'
];
$color = 'ForestGreen';

$this->registerCss("");

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
print_r(\Yii::$app->params['year_arr']);
echo '</pre>';*/

?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['dpr-line-eff-target-actual/index']),
]); ?>

<div class="row">
    <div class="col-md-2">
        <?= Html::label('Date'); ?>
        <?= Html::textInput('tanggal', $tanggal, [
            'class' => 'form-control',
            'onchange'=>'this.form.submit()'
        ]); ?>
    </div>
</div>
<br/>

<?php ActiveForm::end(); ?>

<div class="panel panel-primary">
    <div class="panel-heading">Last Update : <?= date('Y-m-d H:i:s') ?></div>
    <div class="panel-body">
        <?php
        echo Highcharts::widget([
            'scripts' => [
                //'modules/exporting',
                'themes/grid-light',
                //'themes/sand-signika',
                //'themes/dark-unica',
            ],
            'options' => [
                'chart' => [
                    'type' => 'column',
                    'style' => [
                        'fontFamily' => 'Source Sans Pro'
                    ],
                ],
                'title' => [
                    'text' => null,
                ],
                'yAxis' => [
                    'title' => [
                        'text' => 'Percentage (%)',
                    ],
                ],
                'xAxis' => [
                    'categories' => $daily_categories,
                ],
                'plotOptions' => [
                    'series' => [
                        //'cursor' => 'pointer',
                        'dataLabels' => [
                            'allowOverlap' => true,
                            'enabled' => true,
                        ],
                    ]
                ],
                'series' => $daily_data,
            ],
        ]);
        yii\bootstrap\Modal::begin([
            'id' =>'modal',
            'header' => '<h3>Detail Information</h3>',
            'size' => 'modal-lg',
        ]);
        yii\bootstrap\Modal::end();
        ?>
    </div>
</div>