<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;

$this->title = [
    'page_title' => 'Monthly Stock Take Progress Data <span class="japanesse light-green"></span>',
    'tab_title' => 'Monthly Stock Take Progress Data',
    'breadcrumbs_title' => 'Monthly Stock Take Progress Data'
];

$this->registerCss("
    //.form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
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
        'attribute' => 'ITEM',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'ITEM_DESC',
        'vAlign' => 'middle',
        //'hAlign' => 'center',
    ],
    [
        'attribute' => 'UM',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'STD_PRICE',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'ONHAND_QTY',
        'label' => 'Book Qty',
        'format' => ['decimal', 0],
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'PI_VALUE',
        'label' => 'PI Qty',
        'format' => ['decimal', 0],
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'PI_VARIANCE_ABSOLUTE',
        'label' => 'Variance Qty<br/>(Absolute)',
        'encodeLabel' => false,
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'ONHAND_AMT',
        'label' => 'Book Amt.',
        'format' => ['decimal', 2],
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'PI_VALUE_AMT',
        'label' => 'PI Amt.',
        'format' => ['decimal', 2],
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'PI_VARIANCE_ABSOLUTE_AMT',
        'label' => 'Variance Amt.<br/>(Absolute)',
        'format' => ['decimal', 2],
        'encodeLabel' => false,
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'PI_RATE',
        'label' => 'Variance Ratio<br/>(%)',
        'encodeLabel' => false,
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'PI_COUNT_1',
        'label' => 'Count 1',
        'format' => ['decimal', 0],
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'PI_COUNT_2',
        'label' => 'Count 2',
        'format' => ['decimal', 0],
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'PI_AUDIT_1',
        'label' => 'Audit 1',
        'format' => ['decimal', 0],
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'PI_AUDIT_2',
        'label' => 'Audit 2',
        'format' => ['decimal', 0],
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'AREA',
        'filter' => ArrayHelper::map(app\models\StoreOnhandWsus::find()->select('AREA')->where('AREA IS NOT NULL')->andWhere(['<>', 'AREA', ''])->groupBy('AREA')->orderBy('AREA')->all(), 'AREA', 'AREA'),
        'vAlign' => 'middle',
        //'hAlign' => 'center',
    ],
    [
        'attribute' => 'PIC',
        'label' => 'PIC',
        'filter' => ArrayHelper::map(app\models\StoreOnhandWsus::find()->select('PIC')->where('PIC IS NOT NULL')->groupBy('PIC')->orderBy('PIC')->all(), 'PIC', 'PIC'),
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'PI_PERIOD',
        'label' => 'Period',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'PI_AUDIT_LAST_UPDATE',
        'label' => 'Last Update',
        'value' => function($model){
            if ($model->PI_AUDIT_LAST_UPDATE != null) {
                return date('Y-m-d H:i', strtotime($model->PI_AUDIT_LAST_UPDATE));
            } else {
                return '-';
            }
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
];
?>
<div class="giiant-crud store-onhand-wsus-index">

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
            'containerOptions' => ['style' => 'overflow: auto; font-size: 12px;'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style', 'style' => 'font-size: 12px;'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style', 'style' => 'font-size: 12px;'],
            //'toolbar' => false,
            'toolbar' =>  [
                '{export}',
                '{toggleData}',
            ],
            // set export properties
            'export' => [
                'fontAwesome' => true
            ],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                //'heading' => false,
                //'footer' => false,
                //'before' => false,
                //'after' => false,
            ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


