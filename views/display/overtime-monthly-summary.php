<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;

$this->title = [
    'page_title' => 'Monthly Overtime Summary <span class="japanesse text-green">課別残業時間平均</span>',
    'tab_title' => 'Monthly Overtime Summary',
    'breadcrumbs_title' => 'Monthly Overtime Summary'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif;}
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    .form-control {font-size: 30px; height: 52px;}
    .content-header {color: white;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    .box-header .box-title, .control-label{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .active a {background-color: #3c8dbc !important; font-size: 18px; color: white !important;}
");

date_default_timezone_set('Asia/Jakarta');

$gridColumns = [
    [
        'class' => 'kartik\grid\SerialColumn',
        'contentOptions' => ['class' => 'kartik-sheet-style'],
        'width' => '36px',
        'header' => '',
        'headerOptions' => ['class' => 'kartik-sheet-style']
    ],
    [
        'attribute' => 'PERIOD',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'CC_GROUP',
        'label' => 'Department',
        'vAlign' => 'middle',
        //'hAlign' => 'center',
        'mergeHeader' => true,
        'filter' => ArrayHelper::map(app\models\CostCenter::find()->select('CC_GROUP')->groupBy('CC_GROUP')->orderBy('CC_GROUP')->all(), 'CC_GROUP', 'CC_GROUP'),
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'CC_DESC',
        'label' => 'Section',
        'vAlign' => 'middle',
        //'hAlign' => 'center',
        'mergeHeader' => true,
        'filter' => ArrayHelper::map(app\models\CostCenter::find()->select('CC_DESC')->groupBy('CC_DESC')->orderBy('CC_DESC')->all(), 'CC_DESC', 'CC_DESC'),
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'lembur_total',
        'label' => 'Overtime Total<br/>(A)',
        'encodeLabel' => false,
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'total_karyawan',
        'label' => 'Emp. Total<br/>(B)',
        'encodeLabel' => false,
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'lembur_avg',
        'label' => 'OT (AVG)<br/>(A / B)',
        'encodeLabel' => false,
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'lembur_min',
        'label' => 'OT (MIN)',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'lembur_max',
        'label' => 'OT (MAX)',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 80px;'
        ],
    ],
];
?>
<div class="giiant-crud gojek-order-tbl-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <div class="">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $gridColumns,
            'hover' => true,
            'condensed' => true,
            'striped' => true,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto; font-size: 20px; font-weight: bold;'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style info'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'toolbar' =>  false,
            // set export properties
            'export' => [
                'fontAwesome' => true
            ],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => false,
                'footer' => false,
                'before' => false,
                'after' => false,
            ],
        ]); ?>
    </div>

</div>