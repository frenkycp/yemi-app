<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;

$this->title = [
    'page_title' => 'PTS Data <span class="japanesse light-green"></span>',
    'tab_title' => 'PTS Data',
    'breadcrumbs_title' => 'PTS Data'
];

date_default_timezone_set('Asia/Jakarta');

$css_string = "
    .content-header {color: white; font-size: 0.7em; text-align: center; display: none;}
    ";
$this->registerCss($css_string);

$gridColumns = [
    [
        'attribute' => 'req_date',
        'value' => function($model){
            return date('Y-m-d', strtotime($model->req_date));
        },
        'label' => 'Req. Date',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'analyst_desc',
        'label' => 'Location',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'barcode',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'child',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'child_desc',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'req_qty',
        'label' => 'Req. Qty',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'parent',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'parent_desc',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'PUR_LOC',
        'label' => 'Vendor Code',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'PUR_LOC_DESC',
        'label' => 'Vendor Name',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'eta_desc',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'eta_qty',
        'value' => function($model){
            return is_numeric($model->eta_qty) ? number_format($model->eta_qty) : $model->eta_qty;
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'trans_mthd',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'pch_note',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'stat_ok_ng',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
];
?>
<div class="giiant-crud sap-picking-list-index">
    <div style="font-size: 30px;">PTS Data Table</div>
    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <div class="table-responsive">
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


