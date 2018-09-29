<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'DPR Line Efficiency <span class="japanesse text-green"></span>',
    'tab_title' => 'DPR Line Efficiency',
    'breadcrumbs_title' => 'DPR Line Efficiency'
];
$color = 'ForestGreen';

$this->registerCss(".japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

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

<div class="row">
    <div class="col-md-4">
        <div class="form">
            <?php $form = ActiveForm::begin([
                'method' => 'get',
            ]); ?>
            <?= $form->field($model, 'proddate')->widget(\yii\jui\DatePicker::class, [
                'dateFormat' => 'yyyy-MM-dd',
                'options' => [
                    'class' => 'form-control',
                    'onchange'=>'this.form.submit()'
                ]
            ])->label('Prod. Date') ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<div class="box box-primary">
    <div class="box-body">
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
                'credits' => [
                    'enabled' => false
                ],
                'title' => [
                    'text' => null
                ],
                'legend' => [
                    'enabled' => false,
                ],
                'xAxis' => [
                    'categories' => $categories,
                ],
                'yAxis' => [
                    'title' => [
                        'text' => 'Percentage (%)'
                    ],
                    'max' => 100,
                ],
                'tooltip' => [
                    'valueSuffix' => '%',
                ],
                'plotOptions' => [
                    /*'series' => [
                        'cursor' => 'pointer',
                        'point' => [
                            'events' => [
                                'click' => new JsExpression('
                                    function(){
                                        $("#modal").modal("show").find(".modal-body").html(this.options.remark);
                                    }
                                '),
                            ]
                        ]
                    ],*/
                    'series' => [
                        'cursor' => 'pointer',
                        'point' => [
                            'events' => [
                                'click' => new JsExpression('function(){ location.href = this.options.url; }'),
                                //'click' => new JsExpression('function(){ window.open(this.options.url); }')
                            ]
                        ]
                    ],
                    'column' => [
                        'dataLabels' => [
                            'enabled' => true
                        ],
                    ],
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