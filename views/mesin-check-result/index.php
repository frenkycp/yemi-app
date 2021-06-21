<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use kartik\export\ExportMenu;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\CutiTblSearch $searchModel
*/

$this->title = [
    'page_title' => 'Preventive Result Data <span class="japanesse text-green"></span>',
    'tab_title' => 'Preventive Result Data',
    'breadcrumbs_title' => 'Preventive Result Data'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$mesin_periode_arr = [
    '1-HARI' => '1-HARI',
    '1-BULAN' => '1-BULAN',
    '2-BULAN' => '2-BULAN',
    '3-BULAN' => '3-BULAN',
    '6-BULAN' => '6-BULAN',
    '12-BULAN' => '12-BULAN',
];

$gridColumns = [
    [
        'attribute' => 'post_date',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'mesin_id',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'mesin_nama',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'mesin_periode',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filter' => $mesin_periode_arr,
    ],
    [
        'attribute' => 'mesin_no',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'mesin_bagian',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'mesin_bagian_ket',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'mesin_status',
        'value' => function($model){
            if ($model->mesin_status == 'OK') {
                return '<span class="label bg-green">OK</span>';
            } else {
                return '<span class="label bg-red">NG</span>';
            }
        },
        'format' => 'html',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filter' => [
            'OK' => 'OK',
            'NG' => 'NG',
        ],
    ],
    [
        'attribute' => 'mesin_catatan',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'user_id',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'user_desc',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'mesin_last_update',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
];
?>
<div class="giiant-crud mesin-check-result-index">

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
                //Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'Add', ['set-area'], ['class' => 'btn btn-success']),
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


