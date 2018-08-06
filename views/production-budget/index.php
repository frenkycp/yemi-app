<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'Sales Budget/Forecast/Actual <span class="japanesse text-green">(売上予算・見込み・実績)</span> Monthly Period Based <span class="japanesse text-green">(月次決算基準)</span>',
    'tab_title' => 'Sales Budget/Forecast/Actual',
    'breadcrumbs_title' => 'Sales Budget/Forecast/Actual'
];
$color = 'ForestGreen';

$this->registerCss(".japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

date_default_timezone_set('Asia/Jakarta');

$script = <<< JS
    function myFunction(){
        alert("OK");
    }
JS;
$this->registerJs($script, View::POS_HEAD );

/*$script = <<< JS
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout("refreshPage();", 600000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
JS;

$script = <<< JS
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout("refreshPage();", 600000); // milliseconds
    }
    function refreshPage() {
       $("#form_index").submit();
    }
JS;
$this->registerJs($script, View::POS_HEAD );*/

/*echo '<pre>';
print_r($tmp_data_amount_budget);
echo '</pre>';*/

?>


<?php $form = ActiveForm::begin([
    'id' => 'form_index',
    'layout' => 'horizontal',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-danger',
    'fieldConfig' => [
             'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
             'horizontalCssClasses' => [
                 'label' => 'col-sm-5',
                 #'offset' => 'col-sm-offset-4',
                 'wrapper' => 'col-sm-7',
                 'error' => '',
                 'hint' => '',
             ],
         ],
    ]
    );
    ?>

    <div class="row">
        <div class="col-md-5">
            <?= $form->field($model, 'budget_type')->dropDownList(
                [
                    'ALL' => 'ALL （全て）',
                    'PRODUCT' => 'FINAL_PRODUCT  （完成品）',
                    'KD_PART' => 'KD_PARTS （ＫＤパーツ）'
                ]
            ); ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'qty_or_amount')->dropDownList(
                [
                    'QTY' => 'By Qty （数量）',
                    'AMOUNT' => 'By Amount （金額）'
                ]
            ); ?>
        </div>
        <?= Yii::$app->params['update_chart_btn']; ?>
    </div>

    <?php ActiveForm::end(); ?>
    
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Last Updated : <?= $last_update; ?></h3>
    </div>
    <div class="box-body">
        <?php
        echo Highcharts::widget([
            'scripts' => [
                //'modules/exporting',
                //'themes/grid-light',
                //'themes/sand-signika',
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
                    'text' => $title
                ],
                'subtitle' => [
                    'text' => $subtitle
                ],
                'xAxis' => [
                    'categories' => $categories,
                ],
                'yAxis' => [
                    [
                        'allowDecimals' => false,
                        'min' => 0,
                        'title' => [
                            'text' => $model->qty_or_amount == 'AMOUNT' ? $model->qty_or_amount . ' (USD)' : $model->qty_or_amount
                        ],
                        'stackLabels' => [
                            'enabled' => true,
                            'rotation' => -90,
                            'style' => [
                                'textOutline' => '0px',
                                'fontWeight' => '0',
                                'fontSize' => '10px',
                            ],
                            'allowOverlap' => true,
                            'x' => 3,
                            'y' => -30
                        ]
                    ],
                    [
                        'allowDecimals' => false,
                        'min' => 0,
                        'title' => [
                            'text' => $model->qty_or_amount == 'AMOUNT' ? $model->qty_or_amount . ' (USD)' : null
                        ],
                        'opposite' => true
                    ],
                    [
                        'allowDecimals' => false,
                        'min' => 0,
                        'title' => [
                            'text' => null
                        ],
                        'opposite' => true,
                        'labels' => [
                            'enabled' => false
                        ],
                    ],
                    /*'stackLabels' => [
                        'enabled' => true,
                        'rotation' => -90,
                        'style' => [
                            'textOutline' => '0px',
                        ],
                    ]*/
                ],
                'legend' => [
                    'enabled' => true,
                ],
                'plotOptions' => [
                    'column' => [
                        'stacking' => 'normal'
                    ],
                    'series' => [
                        
                    ]
                ],
                'series' => $series
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