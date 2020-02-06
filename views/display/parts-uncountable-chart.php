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
    'page_title' => 'Parts (Uncountable) Stock Take <span class="japanesse light-green"></span>',
    'tab_title' => 'Parts (Uncountable) Stock Take',
    'breadcrumbs_title' => 'Parts (Uncountable) Stock Take'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
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
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['parts-uncountable-chart']),
]); ?>

<div class="row">
    <div class="col-md-2">
        <?= $form->field($model, 'type')->dropDownList(ArrayHelper::map(app\models\ItemUncounttableList::find()->select('TIPE')->where('TIPE IS NOT NULL')->groupBy('TIPE')->orderBy('TIPE')->all(), 'TIPE', 'TIPE'), [
            'prompt' => 'Choose...',
            'onchange'=>'
                $.post( "'.Yii::$app->urlManager->createUrl('display/uncountable-by-type?type=').'"+$(this).val(), function( data ) {
                  $( "select#part_no" ).html( data );
                });
            '
        ]) ?>
    </div>
    <div class="col-md-4" style="display: none;">
        <?= $form->field($model, 'part_no')->dropDownList([], [
            'id' => 'part_no'
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
        <?= Html::submitButton('GENERATE CHART', ['class' => 'btn btn-primary', 'style' => 'margin-top: 5px;']); ?>
    </div>
    
</div>

<?php ActiveForm::end(); ?>
<div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">Stock Take Monitoring</h3>
    </div>
    <div class="box-body">
        <div class="box-group" id="accordion">
            <?php foreach ($data as $key => $value): ?>
                <div class="panel box box-solid box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $key; ?>">
                                <?= $key . ' - ' . $list_item_arr[$key]; ?>
                            </a>
                        </h4>
                    </div>
                    <div id="collapse<?= $key; ?>" class="panel-collapse collapse">
                        <div class="box-body">
                            <?php
                            echo Highcharts::widget([
                                'scripts' => [
                                    //'modules/exporting',
                                    //'themes/sand-signika',
                                ],
                                'options' => [
                                    'chart' => [
                                        'zoomType' => 'x',
                                        //'height' => $height,
                                        'style' => [
                                            'fontFamily' => 'Source Sans Pro'
                                        ],
                                    ],
                                    'title' => [
                                        'text' => null,
                                    ],
                                    'credits' => [
                                        'enabled' => false
                                    ],
                                    'xAxis' => [
                                        'type' => 'datetime',
                                        //'categories' => $value['categories']
                                    ],
                                    'yAxis' => [
                                        'title' => [
                                            'enabled' => true,
                                            //'text' => $value['uom'],
                                        ],
                                        //'plotBands' => $plotBands,
                                    ],
                                    'tooltip' => [
                                        'shared' => true,
                                        'crosshairs' => true,
                                        'xDateFormat' => '%Y-%m-%d',
                                        //'valueSuffix' => ' ' . $value['uom'],
                                    ],
                                    /**/'plotOptions' => [
                                        'areaspline' => [
                                            'fillOpacity' => 0.2
                                        ],
                                    ],
                                    'series' => $value,
                                ],
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    
    </div>
</div>