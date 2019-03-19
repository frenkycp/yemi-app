<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\GojekOrderTblSearch $searchModel
*/

$this->title = [
    'page_title' => 'TRANSPORT DATA <span class="japanesse text-green">(配達データー)</span> | GO-MACHINE ',
    'tab_title' => 'TRANSPORT DATA',
    'breadcrumbs_title' => 'TRANSPORT DATA'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("h1 .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

date_default_timezone_set('Asia/Jakarta');

$tmp_location = ArrayHelper::map(app\models\WipPlanActualReport::find()->select('child_analyst, child_analyst_desc')->groupBy('child_analyst, child_analyst_desc')->all(), 'child_analyst_desc', 'child_analyst_desc');

$gridColumns = [
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{delete}',
        'buttons' => [
            'delete' => function ($url, $model, $key) {
                $url = ['delete', 'slip_id' => $model->slip_id];
                $options = [
                    'title' => 'Delete',
                    'data-pjax' => '0',
                    'data-confirm' => 'Are you sure to delete this item?'
                ];
                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
            }
        ],
        'urlCreator' => function($action, $model, $key, $index) {
            // using the column name as key, not mapping to 'id' like the standard generator
            $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
            $params[0] = \Yii::$app->controller->id ? \Yii::$app->controller->id . '/' . $action : $action;
            return Url::toRoute($params);
        },
        'contentOptions' => ['nowrap'=>'nowrap']
    ],
    [
        'attribute' => 'slip_id',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '100px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'to_loc',
        'label' => 'Location',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px; min-width: 130px;'
        ],
    ],
    [
        'attribute' => 'item',
        'label' => 'Machine ID',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '100px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 80px; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'item_desc',
        'label' => 'Machine Name',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
        //'hAlign' => 'center',
    ],
    [
        'attribute' => 'model',
        'vAlign' => 'middle',
        'width' => '100px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 70px; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'GOJEK_ID',
        'label' => 'Driver NIK',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '100px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 70px; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'GOJEK_DESC',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
        //'hAlign' => 'center',
    ],
    [
        'attribute' => 'NIK_REQUEST',
        'label' => 'Requestor NIK',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '100px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 70px; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'NAMA_KARYAWAN',
        'label' => 'Requestor Name',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
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
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'issued_date_ori',
        'value' => function($model){
            return $model->issued_date_ori == null ? '-' : date('Y-m-d H:i:s', strtotime($model->issued_date_ori));
        },
        'label' => 'Issued Date',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '105px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'request_date',
        'value' => function($model){
            return $model->request_date == null ? '-' : date('Y-m-d H:i:s', strtotime($model->request_date));
        },
        'label' => 'Request For',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '105px',
        'contentOptions' => [
            'style' => 'min-width: 90px;'
        ],
    ],
    [
        'attribute' => 'daparture_date',
        'value' => function($model){
            return $model->daparture_date == null ? '-' : date('Y-m-d H:i:s', strtotime($model->daparture_date));
        },
        'label' => 'START',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '105px',
        'contentOptions' => [
            'style' => 'min-width: 90px;'
        ],
    ],
    [
        'attribute' => 'arrival_date',
        'value' => function($model){
            return $model->arrival_date == null ? '-' : date('Y-m-d H:i:s', strtotime($model->arrival_date));
        },
        'label' => 'END',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '105px',
        'contentOptions' => [
            'style' => 'min-width: 90px;'
        ],
    ],
    [
        'attribute' => 'total_minutes',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '105px',
        'contentOptions' => [
            'style' => 'min-width: 90px;'
        ],
    ],
];
?>
<div class="giiant-crud gojek-order-tbl-index">

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
            'containerOptions' => ['style' => 'overflow: auto; font-size: 12px;'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
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
                'heading' => 'Last Update : ' . date('Y-m-d H:i:s')
                //'footer' => false,
            ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


