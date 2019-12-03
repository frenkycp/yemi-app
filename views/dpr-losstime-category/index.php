<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'FA Loss time by Category <span class="japanesse light-green">（原因カテゴリー別総組ロースタイム）</span>',
    'tab_title' => 'FA Loss time by Category',
    'breadcrumbs_title' => 'FA Loss time by Category'
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
print_r($data);
echo '</pre>';*/

?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['dpr-losstime-category/index']),
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

<div class="panel panel-primary">
    <div class="panel-heading">Last Update : <?= date('Y-m-d H:i:s') ?></div>
    <div class="panel-body">
        <?php
        echo Highcharts::widget([
            'scripts' => [
                //'modules/exporting',
                //'themes/grid-light',
                'themes/sand-signika',
                //'themes/dark-unica',
            ],
            'options' => [
                'chart' => [
                    'type' => 'column',
                ],
                'title' => [
                    'text' => null,
                ],
                'yAxis' => [
                    'title' => [
                        'text' => 'Minutes',
                    ],
                ],
                'xAxis' => [
                    'categories' => $categories,
                ],
                'plotOptions' => [
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
                'series' => $data,
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
