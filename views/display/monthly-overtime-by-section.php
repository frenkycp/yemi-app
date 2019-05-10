<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'OT Management by Section <span class="japanesse text-green">(部門別残業管理）</span>',
    'tab_title' => 'OT Management by Section',
    'breadcrumbs_title' => 'OT Management by Section'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif;}
    .form-control, .control-label {background-color: #33383D; color: white; border-color: white;}
    .form-control {font-size: 30px; height: 52px;}
    .content-header {color: white;}
    //.box-body {background-color: #33383D;}
    .box-title {font-weight: bold;}
    .box-header .box-title, .control-label{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #33383D;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .active a {background-color: #3c8dbc !important; font-size: 18px; color: white !important;}
");

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
$section_data = app\models\CostCenter::find()
->where(['CC_ID' => $section])
->one();
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['monthly-overtime-by-section/index']),
]); ?>

<div class="row">
    <div class="col-md-2">
        <?= Html::label('Fiscal'); ?>
        <?= Html::dropDownList('fiscal', $fiscal, ArrayHelper::map(app\models\FiscalTbl::find()->select('FISCAL')->groupBy('FISCAL')->orderBy('FISCAL DESC')->limit(10)->all(), 'FISCAL', 'FISCAL'), [
            'class' => 'form-control',
            'onchange'=>'this.form.submit()'
        ]); ?>
    </div>
    <div class="col-md-2">
        <?= Html::label('SECTION'); ?>
        <?= Html::dropDownList('section', $section, $section_arr, [
            'class' => 'form-control',
            'onchange'=>'this.form.submit()',
            'prompt' => 'Select a section...'
        ]); ?>
    </div>
</div>
<br/>

<?php ActiveForm::end(); ?>

<div class="box box-primary box-solid">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-user"></i> Last Update : <?= date('Y-m-d H:i:s'); ?></h3>
    </div>
    <div class="box-body">
        <?php
        if (isset($section) && $section != '') {
            echo Highcharts::widget([
                'scripts' => [
                    //'modules/exporting',
                    'themes/grid-light',
                    //'themes/dark-unica',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'spline',
                        'style' => [
                            'fontFamily' => 'sans-serif',
                        ],
                        'height' => 600
                    ],
                    'credits' => [
                        'enabled' => false
                    ],
                    'title' => [
                        'text' => $section == 'ALL' ? 'OT Management by Section (ALL SECTIONS)' : 'OT Management by Section (' . $section_data->CC_DESC . ')',
                        'style' => [
                            'fontSize' => '30px',
                        ],
                    ],
                    'subtitle' => [
                        'text' => 'FISCAL YEAR ' . $fiscal,
                        'style' => [
                            'fontSize' => '22px',
                        ],
                    ],
                    'xAxis' => [
                        'categories' => $categories,
                        'labels' => [
                            'style' => [
                                'fontSize' => '20px',
                                'fontWeight' => 'bold'
                            ],
                        ],
                    ],
                    'yAxis' => [
                        'title' => [
                            'text' => 'HOURS'
                        ],
                        'min' => 0,
                        'max' => 100,
                        'plotLines' => [
                            [
                                'value' => 10,
                                'color' => 'orange',
                                'dashStyle' => 'shortdash',
                                'width' => 2,
                                'label' => [
                                    'text' => 'NORMAL (10)',
                                    'align' => 'left',
                                ],
                                //'zIndex' => 5
                            ], [
                                'value' => 20,
                                'color' => 'red',
                                'dashStyle' => 'shortdash',
                                'width' => 2,
                                'label' => [
                                    'text' => 'MAXIMUM (20)',
                                    'align' => 'left',
                                ],
                                //'zIndex' => 5
                            ]
                        ]
                    ],
                    'plotOptions' => [
                        'spline' => [
                            'dataLabels' => [
                                'enabled' => true,
                            ],
                        ],
                        'series' => [
                            'cursor' => 'pointer',
                            'marker' => [
                                'enabled' => false
                            ],
                            'dataLabels' => [
                                //'allowOverlap' => true
                                //'enabled' => true
                            ],
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
                    'series' => $data,
                ],
            ]);
        } else {
            echo 'Please select a section...';
        }
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