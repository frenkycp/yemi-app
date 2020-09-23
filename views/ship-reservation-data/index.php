<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;

$this->title = [
    'page_title' => 'Ship Reservation Data <span class="japanesse light-green"></span>',
    'tab_title' => 'Ship Reservation Data',
    'breadcrumbs_title' => 'Ship Reservation Data'
];

date_default_timezone_set('Asia/Jakarta');

$gridColumns = [
    [
        'attribute' => 'RESERVATION_NO',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'HELP',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'STATUS',
        'vAlign' => 'middle',
        //'hAlign' => 'center',
    ],
    [
        'attribute' => 'SHIPPER',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'POL',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'POD',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'CNT_40HC',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'CNT_40',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'CNT_20',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'BL_NO',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'CARRIER',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'ETD',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'APPLIED_RATE',
        'vAlign' => 'middle',
        //'hAlign' => 'center',
    ],
    [
        'attribute' => 'shipReservationHdr.RESERVATION_REMARK',
        'label' => 'Remark',
        'vAlign' => 'middle',
        //'hAlign' => 'center',
    ],
    [
        'attribute' => 'INVOICE',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'NOTE',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
];
?>
<div class="giiant-crud ship-reservation-dtr-index">

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
                Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'Add', ['create'], ['class' => 'btn btn-success']),
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


