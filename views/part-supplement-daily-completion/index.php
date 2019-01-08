<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'Part Supplement Status Monitoring <span class="text-green japanesse">(補充部品依頼のモニタリング）</span>',
    'tab_title' => 'Part Supplement Status Monitoring',
    'breadcrumbs_title' => 'Part Supplement Status Monitoring'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$color = 'ForestGreen';

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

/*echo '<pre>';
print_r($data);
echo '</pre>';*/
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['part-supplement-daily-completion/index']),
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
    <div class="panel-body">
        <?php
        echo Highcharts::widget([
            'scripts' => [
                //'modules/exporting',
                //'themes/sand-signika',
                'themes/grid-light',
            ],
            'options' => [
                'chart' => [
                    'type' => 'column',
                ],
                'title' => [
                    'text' => ''
                ],
                'subtitle' => [
                    'text' => ''
                ],
                'xAxis' => [
                    'type' => 'datetime',
                    //'categories' => $value['category'],
                ],
                'yAxis' => [
                    //'min' => 0,
                    'title' => [
                        'text' => 'Total Completion'
                    ],
                    //'gridLineWidth' => 0,
                ],
                'credits' => [
                    'enabled' =>false
                ],
                'tooltip' => [
                    'enabled' => true,
                    'xDateFormat' => '%A, %b %e %Y',
                    //'formatter' => new JsExpression('function(){ return "Percentage : " + this.y + "%<br/>" + "Qty : " + Math.round(this.point.qty) + " item"; }'),
                ],
                'plotOptions' => [
                    'column' => [
                        'stacking' => 'percent',
                        'dataLabels' => [
                            'enabled' => true,
                            //'format' => '{point.percentage:.0f}% ({point.qty:.0f})',
                            //'color' => 'black',
                            //'formatter' => new JsExpression('function(){ if(this.y != 0) { return this.y; } }'),
                            /*'style' => [
                                'textOutline' => '0px',
                                'fontWeight' => '0'
                            ],*/
                        ],
                        //'borderWidth' => 1,
                        //'borderColor' => $color,
                    ],
                    'series' => [
                        'cursor' => 'pointer',
                        'point' => [
                            'events' => [
                                'click' => new JsExpression("
                                    function(e){
                                        e.preventDefault();
                                        $('#modal').modal('show').find('.modal-content').html('<div class=\"text-center\">" . Html::img('@web/loading-01.gif', ['alt'=>'some', 'class'=>'thing']) . "</div>').load(this.options.url);
                                    }
                                "),
                            ]
                        ]
                    ]
                ],
                'series' => $data
            ],
        ]);
        ?>
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