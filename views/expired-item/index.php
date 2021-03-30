<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\ExpiredItemSearch $searchModel
*/

$this->title = [
    'page_title' => 'Expired Item Data <span class="japanesse text-green"></span>',
    'tab_title' => 'Expired Item Data',
    'breadcrumbs_title' => 'Expired Item Data'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$columns = [
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{scrap}',
        'buttons' => [
            'scrap' => function($url, $model, $key){
                $url = ['scrap', 'SERIAL_NO' => $model->SERIAL_NO];
                $options = [
                    'title' => 'Request Scrap',
                    'data-pjax' => '0',
                    //'data-confirm' => 'Are you sure to scrap this item?',
                ];
                if ($model->SCRAP_REQUEST_STATUS != 0) {
                    return '<button class="btn btn-danger disabled" title="Scrap request has been made..."><span class="fa fa-trash"></span></button>';
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
        'attribute' => 'SERIAL_NO',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'LOT_NO',
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
        'attribute' => 'LOC_DESC',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'NILAI_INVENTORY',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'UM',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'SUPPLIER_DESC',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'EXPIRED_DATE',
        'value' => function($model){
            return date('Y-m-d', strtotime($model->EXPIRED_DATE));
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'SCRAP_REQUEST_STATUS',
        'value' => function($model){
            if ($model->SCRAP_REQUEST_STATUS == 0) {
                return '<span class="text-red">NO REQUEST</span>';
            } elseif ($model->SCRAP_REQUEST_STATUS == 1) {
                return '<span class="text-yellow">ON PROGRESS</span>';
            } else {
                return '<span class="text-green">REQUEST CONFIRMED</span>';
            }
        },
        'filter' => [
            0 => 'NO REQUEST',
            1 => 'ON PROGRESS',
            2 => 'REQUEST CONFIRMED',
        ],
        'format' => 'html',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
];

?>
<div class="giiant-crud trace-item-dtr-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    
    <div class="table-responsive">
        <?= GridView::widget([
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
                //'footer' => false,
            ],
        ]); 
        ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


