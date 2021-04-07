<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\ExpiredItemIssuedPoSearch $searchModel
*/

$this->title = [
    'page_title' => 'PO Issued for Expired Item <span class="japanesse text-green"></span>',
    'tab_title' => 'PO Issued for Expired Item',
    'breadcrumbs_title' => 'PO Issued for Expired Item'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$columns = [
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{scrap}',
        'buttons' => [
            'scrap' => function($url, $model, $key){
                $url = ['scrap', 'REQUEST_ID' => $model->REQUEST_ID];
                $options = [
                    'title' => 'Scrap',
                    'data-pjax' => '0',
                    //'data-confirm' => 'Are you sure to scrap this item?',
                ];
                return '<button class="btn btn-danger disabled" title="Scraped"><span class="fa fa-trash"></span></button>';
                if ($model->STATUS != 0) {
                    return '<button class="btn btn-danger disabled" title="Scraped"><span class="fa fa-trash"></span></button>';
                }
                return Html::a('<button class="btn btn-danger"><span class="fa fa-trash"></span></button>', $url, $options);
            },
            
        ],
        'urlCreator' => function($action, $model, $key, $index) {
            $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
            $params[0] = \Yii::$app->controller->id ? \Yii::$app->controller->id . '/' . $action : $action;
            return Url::toRoute($params);
        },
        'contentOptions' => ['nowrap'=>'nowrap', 'style' => 'min-width: 70px;']
    ],
    [
        'attribute' => 'PO_NO',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'LOT_NO',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'CREATE_DATETIME',
        'value' => function($model){
            if ($model->CREATE_DATETIME != null) {
                return date('Y-m-d', strtotime($model->CREATE_DATETIME));
            }
        },
        'label' => 'Date Created',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'ITEM',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'ITEM_DESC',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'SUPPLIER_DESC',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'UM',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'PLAN_QTY',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'TOTAL_QTY',
        'label' => 'Actual Qty',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'SCRAP_QTY',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'STATUS',
        'hAlign' => 'center',
        'value' => function($model){
            if ($model->STATUS == 0) {
                return 'WAITING SCRAP';
            } elseif ($model->STATUS == 1) {
                return 'SCRAPED';
            }
        },
        'filter' => [
            0 => 'WAITING SCRAP',
            1 => 'SCRAPED'
        ],
        'vAlign' => 'middle',
    ],
];
?>
<div class="giiant-crud trace-item-request-pc-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <div class="table-responsive">
        <?= GridView::widget([
            'id' => 'grid',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $columns,
            'hover' => true,
            //'condensed' => true,
            'striped' => true,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto;'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            
            //'pjax' => false, // pjax is set to always true for this demo
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
            ],
        ]); 
        ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


