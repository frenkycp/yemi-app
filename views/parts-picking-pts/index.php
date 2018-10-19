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
    'page_title' => 'Picking Trouble by Vendor <span class="japanesse text-green">(ベンダー別のピッキング問題）</span>',
    'tab_title' => ' Picking Trouble by Vendor',
    'breadcrumbs_title' => ' Picking Trouble by Vendor'
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
    'action' => Url::to(['parts-picking-pts/index']),
]); ?>

<div class="row">
    <div class="col-sm-5">
        <?= $form->field($model, 'period')->dropDownList([
            1 => 'First Half Fiscal Year',
            2 => 'Second Half Fiscal Year',
        ],
            [
                'onchange'=>'this.form.submit()'
            ]
        ) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

<div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title"><?= date('F Y', strtotime($start_period . '01')) . ' to ' . date('F Y', strtotime($end_period . '01')); ?></h3>
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
                    'type' => 'column',
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
                ],
                'series' => $data
            ],
        ]);
        ?>
    </div>
</div>