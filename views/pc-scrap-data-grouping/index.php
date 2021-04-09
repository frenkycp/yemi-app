<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\form\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\MesinCheckNgSearch $searchModel
*/

$this->title = [
    'page_title' => 'Scrap Data',
    'tab_title' => 'Scrap Data',
    'breadcrumbs_title' => 'Scrap Data'
];

$grid_columns = [
    [
        'attribute' => 'period',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'contentOptions' => [
            'style' => 'min-width: 100px;'
        ],
    ],
    [
        'attribute' => 'storage_loc_new',
        'label' => 'Loc.',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filter' => ArrayHelper::map(app\models\ScrapSummaryView01::find()->select('storage_loc_new')->groupBy('storage_loc_new')->orderBy('storage_loc_new')->all(), 'storage_loc_new', 'storage_loc_new'),
        'contentOptions' => [
            'style' => 'min-width: 100px;'
        ],
    ],
    [
        'attribute' => 'storage_loc_desc_new',
        'label' => 'Loc. Description',
        'vAlign' => 'middle',
        //'hAlign' => 'center',
    ],
    [
        'attribute' => 'material',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'contentOptions' => [
            'style' => 'min-width: 100px;'
        ],
    ],
    [
        'attribute' => 'descriptions',
        'vAlign' => 'middle',
        //'hAlign' => 'center',
    ],
    [
        'attribute' => 'in_amt',
        'label' => 'Total Amt.<br/>(USD)',
        'encodeLabel' => false,
        'mergeHeader' => true,
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'contentOptions' => [
            'style' => 'min-width: 100px;'
        ],
    ],
    [
        'attribute' => 'model',
        'vAlign' => 'middle',
        //'hAlign' => 'center',
    ],
];
?>
<div class="giiant-crud sap-gr-gi-by-loc-log-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <div class="table-responsive">
        <?= GridView::widget([
            'id' => 'grid',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $grid_columns,
            'hover' => false,
            'responsive' => true,
            //'condensed' => true,
            'striped' => false,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            //'containerOptions' => ['style' => 'overflow: auto; font-size: 12px;'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'pjax' => true, // pjax is set to always true for this demo
            /*'rowOptions' => function($model){
                $find_slip = app\models\GojekOrderTbl::find()
                ->where([
                    'slip_id' => $model->slip_id
                ])
                ->one();
                if ($find_slip->slip_id == null) {
                    return ['class' => ''];
                } else {
                    return ['class' => 'bg-success'];
                }
            },*/
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
                //'heading' => 'Last Update : ' . date('Y-m-d H:i:s')
            ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


