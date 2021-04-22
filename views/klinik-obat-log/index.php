<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

$this->title = [
    'page_title' => 'Log Penggunaan Obat <span class="japanesse light-green"></span>',
    'tab_title' => 'Log Penggunaan Obat',
    'breadcrumbs_title' => 'Log Penggunaan Obat'
];

$gridColumns = [
    [
        'attribute' => 'period',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'post_date',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'input_datetime',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'user_id',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'user_name',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'part_no',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'part_desc',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'qty',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
];
?>
<div class="giiant-crud klinik-obat-log-index">

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
            //'condensed' => true,
            'striped' => true,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto; font-size: 12px;'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'toolbar' => $toolbar,
            // set export properties
            'export' => [
                'fontAwesome' => true
            ],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => 'Last Update : ' . date('Y-m-d H:i:s')
                //'footer' => false,
            ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


