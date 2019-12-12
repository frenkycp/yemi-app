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
    'page_title' => null,
    'tab_title' => 'IQA Daily Inspection',
    'breadcrumbs_title' => 'IQA Daily Inspection'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$color = 'ForestGreen';

$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; color: #82b964;}
");

date_default_timezone_set('Asia/Jakarta');

$this->registerCssFile('@web/css/dataTables.bootstrap.css');
$this->registerJsFile('@web/js/jquery.dataTables.min.js');
$this->registerJsFile('@web/js/dataTables.bootstrap.min.js');

$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 300000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";
$this->registerJs($script, View::POS_HEAD );

$this->registerJs("$(function() {
   $('#myTable').DataTable({
        'order': [[ 1, 'desc' ]]
        //'pageLength': 5
    });
});");

/*echo '<pre>';
print_r($fix_data);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>
<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['daily-inspection']),
]); ?>

<div style="float: right;">
    <div class="box box-warning box-solid">
        <div class="box-body no-padding">
            <span class="" style="font-size: 7em; font-family: Arial, Helvetica, sans-serif; font-weight: bold;">IQC Ratio : <span class="<?= $ng_rate > $target_ng_rate ? 'text-red' : ''; ?>"><?= $ng_rate; ?></span></span>
        </div>
    </div>
</div>
<div class="row">
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
        <?= Html::submitButton('GENERATE CHART', ['class' => 'btn btn-primary', 'style' => 'margin-top: 5px;']); ?>
    </div>
</div>
<span><i>Last Update : <?= date('d M \'Y H:i'); ?></i></span>
<div class=""></div>

<?php ActiveForm::end(); ?>

<div class="box box-primary">
    <div class="box-body">
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
                    'style' => [
                        'fontFamily' => 'sans-serif',
                    ],
                ],
                'title' => [
                    'text' => null
                ],
                'subtitle' => [
                    'text' => ''
                ],
                'xAxis' => [
                    'type' => 'datetime',
                    //'categories' => $value['category'],
                ],
                'yAxis' => [
                    /*'stackLabels' => [
                        'enabled' => true
                    ],*/
                    //'min' => 0,
                    'title' => [
                        'text' => null
                    ],
                    //'gridLineWidth' => 0,
                    'max' => 1500
                ],
                'credits' => [
                    'enabled' =>false
                ],
                'tooltip' => [
                    'enabled' => true,
                    'xDateFormat' => '%A, %b %e %Y',
                    //'valueSuffix' => ' min'
                    //'formatter' => new JsExpression('function(){ return "Percentage : " + this.y + "%<br/>" + "Qty : " + Math.round(this.point.qty) + " item"; }'),
                ],
                'plotOptions' => [
                    'column' => [
                        'stacking' => 'normal',
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
                'series' => $data
            ],
        ]);
        ?>
    </div>
</div>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">NG Data Table</h3>
    </div>
    <div class="panel-body">
        <table id="myTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Inc. Date</th>
                    <th>Last Update</th>
                    <th>Part No.</th>
                    <th>Part Name.</th>
                    <th>Qty In</th>
                    <th>Note</th>
                    <th>Remark</th>
                    <th>Vendor ID</th>
                    <th>Vendor Name</th>
                    <th>Tag Slip</th>
                    <th>Slip Reff.</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ng_data_arr as $key => $value): ?>
                    <tr>
                        <td><?= date('Y-m-d', strtotime($value['POST_DATE'])); ?></td>
                        <td><?= date('Y-m-d H:i:s', strtotime($value['LAST_UPDATE'])); ?></td>
                        <td><?= $value['ITEM']; ?></td>
                        <td><?= $value['ITEM_DESC']; ?></td>
                        <td><?= number_format($value['QTY_IN']); ?></td>
                        <td><?= $value['NOTE']; ?></td>
                        <td><?= $value['Remark']; ?></td>
                        <td><?= $value['LOC']; ?></td>
                        <td><?= $value['LOC_DESC']; ?></td>
                        <td><?= $value['TAG_SLIP']; ?></td>
                        <td><?= $value['SLIP_REF']; ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        
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