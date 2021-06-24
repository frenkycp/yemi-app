<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use kartik\export\ExportMenu;

$this->title = [
    'page_title' => 'E-Faktur Data Table <span class="japanesse text-green"></span>',
    'tab_title' => 'E-Faktur Data Table',
    'breadcrumbs_title' => 'E-Faktur Data Table'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');

$gridColumns = [
    [
        'attribute' => 'kdJenisTransaksi',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'fgPengganti',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'nomorFaktur',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'no_seri',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'tanggalFaktur',
        'value' => function($model){
            if ($model->tanggalFaktur != null) {
                return date('Y-m-d', strtotime($model->tanggalFaktur));
            }
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'period',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'npwpPenjual',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'namaPenjual',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'alamatPenjual',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'npwpLawanTransaksi',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'namaLawanTransaksi',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'alamatLawanTransaksi',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'jumlahDpp',
        'format' => 'decimal',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'jumlahPpn',
        'format' => 'decimal',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'jumlahPpnBm',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'statusApproval',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'statusFaktur',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    
];
?>
<div class="giiant-crud tax-hdr-index">

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
                Html::a('<span class="glyphicon glyphicon-search"></span> ' . 'View Detail Item', ['/tax-dtr'], ['class' => 'btn btn-primary', 'target' => '_blank']),
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


