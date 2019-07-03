<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;

$this->title = [
    'page_title' => 'TRANSPORT UTILIZATION <span class="japanesse text-green">[ 切替段取り ]</span> | GO-MACHINE',
    'tab_title' => 'TRANSPORT UTILIZATION',
    'breadcrumbs_title' => 'TRANSPORT UTILIZATION'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
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

$driver_arr = \Yii::$app->request->get('driver_nik');

/*echo '<pre>';
print_r($driver_arr);
echo '</pre>';*/

?>
<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['gojek-driver-utility/index']),
]); ?>
    <div class="form-group">
        <?php
        echo '<label class="control-label">Driver</label>';
        echo Select2::widget([
            'name' => 'driver_nik',
            'value' => $driver_arr,
            'data' => ArrayHelper::map(app\models\GojekTbl::find()->select('GOJEK_ID, GOJEK_DESC')->groupBy('GOJEK_ID, GOJEK_DESC')->orderBy('GOJEK_DESC')->all(), 'GOJEK_ID', 'GOJEK_DESC'),
            'options' => [
                'placeholder' => 'Select driver ...',
                'multiple' => true
            ],
        ]);
        ?>
    </div>
    <?php
    echo Html::submitButton('Update Driver', [
        'class' => 'btn btn-primary'
    ]);
    ?>

<?php ActiveForm::end(); ?>
<br>
<div class="box box-default box-solid">
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
                            'themes/grid-light',
                            //'themes/sand-signika',
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
                            'themes/grid-light',
                            //'themes/sand-signika',
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