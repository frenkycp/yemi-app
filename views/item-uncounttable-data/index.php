<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\CrusherTblSearch $searchModel
*/

$this->title = [
    'page_title' => 'Uncountable Parts Stock',
    'tab_title' => 'Uncountable Parts Stock',
    'breadcrumbs_title' => 'Uncountable Parts Stock'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');

$gridColumns = [
    [
        'attribute' => 'POST_DATE',
        'value' => function($model){
            return date('Y-m-d', strtotime($model->POST_DATE));
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'TIPE',
        'label' => 'Type',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'ITEM',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'ITEM_DESC',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'ITEM_UM',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'MAT_SAP',
        'label' => 'Material<br/>(SAP)',
        'mergeHeader' => true,
        'encodeLabel' => false,
        'value' => function($model){
            return round($model->MAT_SAP, 4);
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'MAT_WSUS',
        'label' => 'Material<br/>(WSUS)',
        'mergeHeader' => true,
        'encodeLabel' => false,
        'value' => function($model){
            return round($model->MAT_WSUS, 4);
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'MAT_DIFF',
        'label' => 'Material<br/>(Selisih)',
        'mergeHeader' => true,
        'encodeLabel' => false,
        'value' => function($model){
            return round($model->MAT_DIFF, 4);
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'WIP_SAP',
        'label' => 'WIP<br/>(SAP)',
        'mergeHeader' => true,
        'encodeLabel' => false,
        'value' => function($model){
            return round($model->WIP_SAP, 4);
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'WIP_PI',
        'label' => 'WIP<br/>(Stocktake)',
        'mergeHeader' => true,
        'encodeLabel' => false,
        'value' => function($model){
            return round($model->WIP_PI, 4);
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'WIP_DIFF',
        'label' => 'WIP<br/>(Selisih)',
        'mergeHeader' => true,
        'encodeLabel' => false,
        'value' => function($model){
            return round($model->WIP_DIFF, 4);
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'WIP_DIFF_ABS',
        'label' => 'WIP<br/>(Selisih Abs.)',
        'mergeHeader' => true,
        'encodeLabel' => false,
        'value' => function($model){
            return round($model->WIP_DIFF_ABS, 4);
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'WIP_DIFF_ABS_AMT',
        'label' => 'WIP<br/>(Selisih Amount Abs.)',
        'mergeHeader' => true,
        'encodeLabel' => false,
        'value' => function($model){
            return number_format(round($model->WIP_DIFF_ABS_AMT, 4));
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'SHOW',
        'label' => 'Critical',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filter' => [
            'Y' => 'Yes'
        ],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
];
?>
<div class="giiant-crud item-uncounttable-index">

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
            //'condensed' => true,
            'striped' => true,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto;'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'toolbar' => [
                '{export}',
                '{toggleData}',
            ],
            // set export properties
            'export' => [
                'fontAwesome' => true
            ],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                //'heading' => '<em>Data Table</em>'
                //'footer' => false,
            ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


