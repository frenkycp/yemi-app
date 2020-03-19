<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\FlexiStorageSearch $searchModel
*/

$this->title = [
    'page_title' => 'Flexi Storage Data <span class="japanesse light-green"></span>',
    'tab_title' => 'Flexi Storage Data',
    'breadcrumbs_title' => 'Flexi Storage Data'
];

$this->registerCss("
    .content-header {color: white; margin: 0px 15px !important; text-align: center;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold; color: white;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
");

$gridColumns = [
    [
        'attribute' => 'kode_area',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 70px;'
        ],
    ],
    [
        'attribute' => 'area',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 70px;'
        ],
    ],
    [
        'attribute' => 'rack',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 70px;'
        ],
    ],
    [
        'attribute' => 'kolom_level',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 70px;'
        ],
    ],
    [
        'attribute' => 'posisi',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 70px;'
        ],
    ],
    [
        'attribute' => 'storage_status',
        'label' => 'Status',
        'value' => function($model){
            if ($model->percent_used == 0) {
                return '<span class="badge bg-green" style="font-weight: normal; letter-spacing: 1px; color: rgb(124, 181, 236);">KOSONG</span>';
            } else {
                return '<span class="badge bg-orange" style="font-weight: normal; letter-spacing: 1px; color: rgb(255, 188, 117);">TERPAKAI</span>';
            }
        },
        'format' => 'html',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 70px;'
        ],
    ],
    // [
    //     'attribute' => 'panjang_cm',
    //     'vAlign' => 'middle',
    //     'hAlign' => 'center',
    //     'filterInputOptions' => [
    //         'class' => 'form-control',
    //         'style' => 'text-align: center; font-size: 12px; min-width: 70px;'
    //     ],
    // ],
    // [
    //     'attribute' => 'lebar_cm',
    //     'vAlign' => 'middle',
    //     'hAlign' => 'center',
    //     'filterInputOptions' => [
    //         'class' => 'form-control',
    //         'style' => 'text-align: center; font-size: 12px; min-width: 70px;'
    //     ],
    // ],
    // [
    //     'attribute' => 'tinggi_cm',
    //     'vAlign' => 'middle',
    //     'hAlign' => 'center',
    //     'filterInputOptions' => [
    //         'class' => 'form-control',
    //         'style' => 'text-align: center; font-size: 12px; min-width: 70px;'
    //     ],
    // ],
    // [
    //     'attribute' => 'kubikasi_m3',
    //     'vAlign' => 'middle',
    //     'hAlign' => 'center',
    //     'filterInputOptions' => [
    //         'class' => 'form-control',
    //         'style' => 'text-align: center; font-size: 12px; min-width: 70px;'
    //     ],
    // ],
    // [
    //     'attribute' => 'kubikasi_m3_act',
    //     'vAlign' => 'middle',
    //     'hAlign' => 'center',
    //     'format'=> ['decimal', 2],
    //     'filterInputOptions' => [
    //         'class' => 'form-control',
    //         'style' => 'text-align: center; font-size: 12px; min-width: 70px;'
    //     ],
    // ],
    // [
    //     'attribute' => 'kubikasi_m3_balance',
    //     'vAlign' => 'middle',
    //     'hAlign' => 'center',
    //     'format'=> ['decimal', 2],
    //     'filterInputOptions' => [
    //         'class' => 'form-control',
    //         'style' => 'text-align: center; font-size: 12px; min-width: 70px;'
    //     ],
    // ],
    [
        'attribute' => 'percent_used',
        // 'value' => function($model){
        //     if ($model->percent_used < 30) {
        //         return '<span class="badge bg-green" style="font-weight: normal; letter-spacing: 1px;">' . $model->percent_used .'</span>';
        //     }
        //     if ($model->percent_used < 80) {
        //         return '<span class="badge bg-orange" style="font-weight: normal; letter-spacing: 1px;">' . $model->percent_used .'</span>';
        //     }
        //     return '<span class="badge bg-red" style="font-weight: normal; letter-spacing: 1px;">' . $model->percent_used .'</span>';
        // },
        // 'format' => 'html',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 70px;'
        ],
    ],
    // [
    //     'attribute' => 'storage_type',
    //     'vAlign' => 'middle',
    //     'hAlign' => 'center',
    //     'filterInputOptions' => [
    //         'class' => 'form-control',
    //         'style' => 'text-align: center; font-size: 12px; min-width: 70px;'
    //     ],
    // ],
];
?>
<div class="giiant-crud flexi-storage-index">

    <?php
             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <div class="">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'columns' => $gridColumns,
            'hover' => true,
            //'condensed' => true,
            'striped' => true,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto;'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
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
                //'footer' => false,
            ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


