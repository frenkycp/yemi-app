<?php

use yii\helpers\Html;
use yii\helpers\Url;
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\bootstrap\ActiveForm;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
* @var app\models\search\MenuSearch $searchModel
*/

$this->title = [
    'page_title' => 'Picking Trouble by Model GMC <span class="japanesse text-green">(製品ＧＭＣ別のピッキング問題）</span>',
    'tab_title' => 'Picking Trouble by Model GMC',
    'breadcrumbs_title' => 'Picking Trouble by Model GMC'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
date_default_timezone_set('Asia/Jakarta');

$this->registerCss("
    h1 span { 
        font-family: 'MS PGothic', Osaka, Arial, sans-serif; 
    }
    table {
        font-size: 12px;
    }
");

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
echo '</pre>';
echo $start_period . ' to ' . $end_period;*/
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    'layout' => 'horizontal',
    'action' => Url::to(['parts-picking-pts-gmc/index']),
]); ?>

<div class="row">
    <div class="col-md-3">
        <?= Html::dropDownList('period', \Yii::$app->request->get('period'), [
            1 => 'First Half Fiscal Year',
            2 => 'Second Half Fiscal Year',
        ], [
            'class' => 'form-control',
            'onchange'=>'this.form.submit()'
            ]); ?>
    </div>
</div>
<br/>

<?php ActiveForm::end(); ?>

<div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title"><?= date('F Y', strtotime($start_period . '01')) . ' to ' . date('F Y', strtotime($end_period . '01')); ?></h3>
        <span class="pull-right">Last Update : <?= date('Y-m-d H:i:s'); ?></span>
    </div>
    
    <div class="box-body">
        <?php
        echo Highcharts::widget([
            'scripts' => [
                //'modules/exporting',
                'themes/grid-light',
            ],
            'options' => [
                'chart' => [
                    'type' => 'bar',
                ],
                'title' => [
                    'text' => null
                ],
                'xAxis' => [
                    'categories' => $categories
                ],
                'yAxis' => [
                    'title' => [
                        'text' => 'Qty'
                    ],
                    'allowDecimals' => false,
                ],
                'plotOptions' => [
                    'series' => [
                        'cursor' => 'pointer',
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
                'series' => $data
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