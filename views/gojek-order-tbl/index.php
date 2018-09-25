<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\GojekOrderTblSearch $searchModel
*/

$this->title = Yii::t('models', 'Order Data List');
$this->params['breadcrumbs'][] = $this->title;

if (isset($actionColumnTemplates)) {
$actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']);
    $actionColumnTemplateString = "{view} {update} {delete}";
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';

$gridColumns = [
    /*[
        'class' => 'yii\grid\ActionColumn',
        'template' => $actionColumnTemplateString,
        'buttons' => [
            'view' => function ($url, $model, $key) {
                $options = [
                    'title' => Yii::t('cruds', 'View'),
                    'aria-label' => Yii::t('cruds', 'View'),
                    'data-pjax' => '0',
                ];
                return Html::a('<span class="glyphicon glyphicon-file"></span>', $url, $options);
            }
        ],
        'urlCreator' => function($action, $model, $key, $index) {
            // using the column name as key, not mapping to 'id' like the standard generator
            $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
            $params[0] = \Yii::$app->controller->id ? \Yii::$app->controller->id . '/' . $action : $action;
            return Url::toRoute($params);
        },
        'contentOptions' => ['nowrap'=>'nowrap']
    ],*/
    [
        'attribute' => 'slip_id',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'item',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'item_desc',
        'vAlign' => 'middle',
        //'hAlign' => 'center',
    ],
    [
        'attribute' => 'from_loc',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'to_loc',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    /*[
        'attribute' => 'source',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'GOJEK_ID',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],*/
    [
        'attribute' => 'GOJEK_DESC',
        'vAlign' => 'middle',
        //'hAlign' => 'center',
    ],
    [
        'attribute' => 'STAT',
        'value' => function($model){
            if ($model->STAT == 'O') {
                return '<span class="label label-danger">OPEN</span>';
            } else {
                return '<span class="label label-success">CLOSE</span>';
            }
        },
        'format' => 'raw',
        'filter' => [
            'O' => 'OPEN',
            'C' => 'CLOSE',
        ],
        'contentOptions' => [
            'style' => 'min-width: 100px;'
        ],
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'issued_date',
        'value' => function($model){
            return $model->issued_date == null ? '-' : date('Y-m-d H:i:s', strtotime($model->issued_date));
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'daparture_date',
        'value' => function($model){
            return $model->daparture_date == null ? '-' : date('Y-m-d H:i:s', strtotime($model->daparture_date));
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'arrival_date',
        'value' => function($model){
            return $model->arrival_date == null ? '-' : date('Y-m-d H:i:s', strtotime($model->arrival_date));
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    /*'GOJEK_DESC',*/
    /*'NIK_REQUEST',*/
    /*'NAMA_KARYAWAN',*/
    /*'STAT',*/
    /*'issued_date',*/
    /*'daparture_date',*/
    /*'arrival_date',*/
    /*'GOJEK_VALUE',*/
];
?>
<div class="giiant-crud gojek-order-tbl-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $gridColumns,
            'hover' => true,
            //'condensed' => true,
            'striped' => true,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
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
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


