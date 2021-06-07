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
    'page_title' => 'Fixed  & MIS Assets Management <span class="japanesse light-green">(固定・MIS資産管理)</span>',
    'tab_title' => 'Fixed  & MIS Assets Management',
    'breadcrumbs_title' => 'Fixed  & MIS Assets Management'
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


