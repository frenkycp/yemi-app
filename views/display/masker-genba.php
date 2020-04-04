<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;

$this->title = [
    'page_title' => 'Mask (GENBA) Stock & Using',
    'tab_title' => 'Mask (GENBA) Stock & Using',
    'breadcrumbs_title' => 'Mask (GENBA) Stock & Using'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$color = 'ForestGreen';

$this->registerCss("
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 20px; height: 40px;}
    .content-header {color: white; text-align: center; font-size: 0.5em; display: none;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    .box-header .box-title{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .panel-body {background-color: #2a2a2b;}

    .table {font-size: 1em; letter-spacing: 1px; color: white;}
    .table > tbody > tr:nth-child(odd) > td {background-color: #2f2f2f; color: white;}
    .table > tbody > tr:nth-child(even) > td {background-color: #121213; color: white;}
    .table > thead > tr > th {background-color: #61258e; color: #ffeb3b;}
    .dataTables_wrapper {color: white;}
    td {border-top: unset !important;}
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
print_r($tmp_data);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>
<div class="row">
    <div class="col-md-6">
        <div class="pull-left" id="my-header">
            <span style="font-size: 2.5em; color: white;"><u>MASK (GENBA) STOCK & USING</u></span><br/>
            <span style="font-size: 1em; color: grey;">Last Update : <?= date('Y-m-d H:i:s'); ?>
        </div>
    </div>
    <div class="col-md-6">
        <div class="pull-right" style="margin-top: 10px;">
            <span style="color: white; font-size: 3em; border: 1px solid white; border-radius: 5px; padding: 10px;">Stock : <span style="color: yellow;"><?= number_format($stock); ?></span><br/></span></span>
        </div>
    </div>
</div>
<br/>
<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['masker-genba']),
]); ?>

<div class="row">
    <div class="col-md-5">
        <?= $form->field($model, 'item')->dropDownList($item_dropdownlist, [
            'prompt' => 'Choose item...'
        ]); ?>
    </div>
    <div class="col-md-4">
        <?php echo '<label class="control-label">Select date range</label>';
        echo DatePicker::widget([
            'model' => $model,
            'attribute' => 'from_date',
            'attribute2' => 'to_date',
            'options' => ['placeholder' => 'Start date'],
            'options2' => ['placeholder' => 'End date'],
            'type' => DatePicker::TYPE_RANGE,
            'form' => $form,
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'autoclose' => true,
            ]
        ]);?>
    </div>
    <div class="form-group">
        <br/>
        <?= Html::submitButton('GENERATE DATA', ['class' => 'btn btn-primary', 'style' => 'margin-top: 5px;']); ?>
    </div>
    
</div>

<?php ActiveForm::end(); ?>


<br/>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">IN-OUT DAILY</h3>
    </div>
    <div class="panel-body">
        <div class="row" style="padding: 15px;">
            <div class="col-md-12">
            <?php
            echo !$model->load($_GET) ? '<span style="color: white;">No item selected...</span>' : Highcharts::widget([
                'scripts' => [
                    'themes/dark-unica',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'column',
                        'style' => [
                            'fontFamily' => 'sans-serif',
                        ],
                        //'height' => 500
                    ],
                    'title' => [
                        'text' => null
                    ],
                    'subtitle' => [
                        'text' => ''
                    ],
                    'xAxis' => [
                        'type' => 'datetime',
                    ],
                    'yAxis' => [
                        'stackLabels' => [
                            'enabled' => true,
                        ],
                    ],
                    'credits' => [
                        'enabled' =>false
                    ],
                    'tooltip' => [
                        'enabled' => true,
                    ],
                    'plotOptions' => [
                        'column' => [
                            //'stacking' => 'normal',
                            'dataLabels' => [
                                'enabled' => true,
                                'allowOverlap' => true
                            ],
                            'maxPointWidth' => 50,
                        ],
                        /*'series' => [
                            'cursor' => 'pointer',
                            'dataLabels' => [
                                'enabled' => false
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
                        ]*/
                    ],
                    'series' => $data
                ],
            ]);
            ?>
            </div>
        </div>
    </div>
</div>