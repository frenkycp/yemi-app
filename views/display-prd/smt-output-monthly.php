<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\AssetTblSearch $searchModel
*/

$this->title = [
    'page_title' => 'SMT Mount Point <span class="japanesse light-green"></span>',
    'tab_title' => 'SMT Mount Point',
    'breadcrumbs_title' => 'SMT Mount Point'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$gridColumns = [
    [
        'attribute' => 'period',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'child_all',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'child_desc_all',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'total_qty',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'mergeHeader' => true,
        'encodeLabel' => false,
    ],
    [
        'attribute' => 'planed_loss_minute',
        'label' => 'Loss Time<br/>(Planned Loss)<br/>E',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'mergeHeader' => true,
        'encodeLabel' => false,
    ],
    [
        'attribute' => 'out_section_minute',
        'label' => 'Loss Time<br/>(Out Section)<br/>F',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'mergeHeader' => true,
        'encodeLabel' => false,
    ],
    [
        'attribute' => 'working_time',
        'value' => function($model)
        {
            return round($model->working_time, 2);
        },
        'label' => 'Working Time<br/>(G)',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'mergeHeader' => true,
        'encodeLabel' => false,
    ],
    [
        'attribute' => 'POINT_SMT',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'mergeHeader' => true,
        'encodeLabel' => false,
    ],
    [
        'attribute' => 'POINT_FCA',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'mergeHeader' => true,
        'encodeLabel' => false,
    ],
    [
        'attribute' => 'TOTAL_POINT_ALL',
        'label' => 'Total Point<br/>(H)',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'mergeHeader' => true,
        'encodeLabel' => false,
    ],
    [
        'attribute' => 'MOUNTING_RATIO',
        'value' => function($model){
            $tmp_ratio = 0;
            if ($model->TOTAL_POINT_ALL > 0) {
                $tmp_ratio = round(($model->working_time - $model->planed_loss_minute - $model->out_section_minute) / $model->TOTAL_POINT_ALL, 3);
            }
            return $tmp_ratio;
        },
        'label' => '(G-E-F) / H',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'mergeHeader' => true,
        'encodeLabel' => false,
    ],
];
?>
<div class="giiant-crud asset-tbl-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <div class="">
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
            'containerOptions' => ['style' => 'overflow: auto; font-size: 12px;'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'pjax' => true, // pjax is set to always true for this demo
            'toolbar' =>  [
                '{export}',
                '{toggleData}',
            ],
            // set export properties
            'export' => [
                'fontAwesome' => true
            ],
            'panel' => [
                'type' => GridView::TYPE_INFO,
            ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


