<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use kartik\export\ExportMenu;

$this->title = [
    'page_title' => 'Tax Detail Item <span class="japanesse text-green"></span>',
    'tab_title' => 'Tax Detail Item',
    'breadcrumbs_title' => 'Tax Detail Item'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');

$gridColumns = [
    [
        'attribute' => 'period',
        'value' => 'taxHdr.period',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'no_seri',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'no',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'nama',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'hargaSatuan',
        'hAlign' => 'center',
        'format' => 'decimal',
        'vAlign' => 'middle',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'jumlahBarang',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'format' => 'decimal',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'hargaTotal',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'format' => 'decimal',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'diskon',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'format' => 'decimal',
        'mergeHeader' => true,
    ],
];
?>
<div class="giiant-crud tax-dtr-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $gridColumns,
            //'hover' => true,
            //'condensed' => true,
            'striped' => false,
            'pager' => [
                'firstPageLabel' => 'First',
                'lastPageLabel'  => 'Last'
            ],
            'showPageSummary' => true,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto;'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'pjax' => true, // pjax is set to always true for this demo
            'toolbar' =>  [
                //Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'Add', ['create'], ['class' => 'btn btn-success']),
                '{export}',
                '{toggleData}',
            ],
            // set export properties
            'export' => [
                'fontAwesome' => true
            ],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
            ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


