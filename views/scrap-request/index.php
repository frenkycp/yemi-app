<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\ScrapRequestSearch $searchModel
*/

$this->title = [
    'page_title' => 'Scrap Request Data <span class="japanesse text-green"></span>',
    'tab_title' => 'Scrap Request Data',
    'breadcrumbs_title' => 'Scrap Request Data'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$columns = [
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{confirm}',
        'buttons' => [
            'confirm' => function($url, $model, $key){
                $url = ['confirm', 'SERIAL_NO' => $model->SERIAL_NO];
                $options = [
                    'title' => 'Confirm',
                    'data-pjax' => '0',
                    'data-confirm' => 'Are you sure to confirm this request?',
                ];
                if ($model->STATUS == 'C') {
                    return '<button class="btn btn-danger disabled" title="Confirm"><span class="fa fa-check-square-o"></span></button>';
                }
                return Html::a('<button class="btn btn-success"><span class="fa fa-check-square-o"></span></button>', $url, $options);
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
        'attribute' => 'QTY',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'UM',
        'hAlign' => 'center',
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
        'attribute' => 'LATEST_EXPIRED_DATE',
        'label' => 'Request Expired Data<br/>(Minimum)',
        'encodeLabel' => false,
        'value' => function($model){
            return date('Y-m-d', strtotime($model->LATEST_EXPIRED_DATE));
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'STATUS',
        'value' => function($model){
            if ($model->STATUS == 'O') {
                return '<span class="text-red">OPEN</span>';
            } else {
                return '<span class="text-green">CLOSE</span>';
            }
        },
        'format' => 'html',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filter' => [
            'O' => 'OPEN',
            'C' => 'CLOSE',
        ],
    ],
    [
        'attribute' => 'USER_ID',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'USER_DESC',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'USER_LAST_UPDATE',
        'value' => function($model){
            return date('Y-m-d H:i:s', strtotime($model->USER_LAST_UPDATE));
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
];

?>
<div class="giiant-crud trace-item-scrap-index">

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


