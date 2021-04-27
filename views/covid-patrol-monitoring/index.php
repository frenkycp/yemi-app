<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;

$this->title = [
    'page_title' => 'Covid Patrol Monitoring <span class="japanesse light-green"></span>',
    'tab_title' => 'Covid Patrol Monitoring',
    'breadcrumbs_title' => 'Covid Patrol Monitoring'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title']; #3c3c3c
$this->registerCss("
    body, .content-wrapper {background-color: #3c3c3c;}
");

date_default_timezone_set('Asia/Jakarta');

$this->registerCssFile('@web/css/dataTables.bootstrap.css');
$this->registerJsFile('@web/js/jquery.dataTables.min.js');
$this->registerJsFile('@web/js/dataTables.bootstrap.min.js');

$this->registerJs("$(document).ready(function() {
    $('#outstanding').DataTable({
        'pageLength': 10,
        'order': [[ 0, 'desc' ]]
    });
});");

?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['index']),
]); ?>

<div class="row" style="color: white;">
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
        <?= Html::submitButton('GENERATE', ['class' => 'btn btn-primary', 'style' => 'margin-top: 5px;']); ?>
    </div>
    
</div>

<?php ActiveForm::end(); ?>

<?=
Highcharts::widget([
    'scripts' => [
        'highcharts-more',
        //'modules/exporting',
        //'themes/grid-light',
        'modules/pattern-fill',
        //'themes/dark-unica',
    ],
    'options' => [
        'chart' => [
            'type' => 'column',
            'backgroundColor' => null,
            'height' => '300',
            'style' => [
                'fontFamily' => 'sans-serif',
            ],
            'zoomType' => 'x'
        ],
        'title' => [
            'text' => null,
        ],
        'xAxis' => [
            'categories' => $categories,
            'lineWidth' => 2,
            'lineColor' => '#9e9e9e',
            'gridLineWidth' => 1,
            'labels' => [
                'style' => [
                    'color' => 'white',
                ],
            ],
            //'lineWidth' => 1,
        ],
        'yAxis' => [
            'title' => [
                'text' => 'Total Temuan',
                'style' => [
                    'color' => 'white',
                ],
            ],
            'lineWidth' => 2,
            'lineColor' => '#fff',
            'type' => 'linear',
            'stackLabels' => [
                'enabled' => true,
                'style' => [
                    'color' => new JsExpression("(Highcharts.theme && Highcharts.theme.textColor)")
                ],
            ],
            'labels' => [
                'style' => [
                    'color' => 'white',
                ],
            ],
            'allowDecimals' => false,
        ],
        'legend' => [
            'enabled' => true,
            'align' => 'right',
            'verticalAlign' => 'top',
            'floating' => false,
            'borderWidth' => 1,
            'shadow' => false,
            'reverse' => true,
            //'x' => -30,
            //'y' => 10,
            'itemStyle' => [
                'color' => 'white',
                'fontSize' => '12px',
                'fontWeight' => 'bold'
            ],
        ],
        'credits' => [
            'enabled' => false
        ],
        'tooltip' => [
            'enabled' => true,
            //'valueSuffix' => ' ' . $um,
            'shared' => true,
            //'formatter' => new JsExpression('function(){ return "Percentage : " + this.y + "%<br/>" + "Qty : " + Math.round(this.point.qty) + " item"; }'),
        ],
        'plotOptions' => [
            'column' => [
                'stacking' => 'normal',
                'maxPointWidth' => 100,
                'pointPadding' => 0.93,
                'groupPadding' => 0.93,
                'borderWidth' => 1,
                'marker' => [
                    'enabled' => false
                ],
                'dataLabels' => [
                    'enabled' => true,
                ],
            ],
            
        ],
        'series' => $data,
    ],
]);
?>

<div class="panel panel-primary">
    <div class="panel-body">
        <table class="table table-bordered dataTable" id="outstanding" style="font-size: 0.83vw;">
            <thead style="font-size: 12px;">
                <tr><th class="text-center">Tanggal</th>
                    <th class="">Kategori</th>
                    <th class="">Lokasi</th>
                    <th class="">Auditor</th>
                    <th class="">PIC</th>
                    <th class="">Note</th>
                    <th class="text-center" style="min-width: 150px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($outstanding_data as $value): ?>
                    <tr>
                        <td class="text-center"><?= $value->PATROL_DATE; ?></td>
                        <td><?= $value->TOPIC; ?></td>
                        
                        <td><?= $value->LOC_DETAIL; ?></td>
                        <td><?= $value->AUDITOR; ?></td>
                        <td><?= $value->PIC_NAME; ?></td>
                        <td><?= $value->DESCRIPTION; ?></td>
                        <td class="text-center">
                            <?= Html::a('<i class="fa fa-pencil-square-o"></i> Edit', ['/covid-patrol/update', 'ID' => $value->ID], ['class' => 'btn btn-primary']); ?>&nbsp;
                            <?= Html::a('<i class="fa fa-thumbs-o-up"></i> Penaganan', ['/covid-patrol/solve', 'ID' => $value->ID], ['class' => 'btn btn-warning']); ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>