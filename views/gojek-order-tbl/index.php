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
    'page_title' => 'TRANSPORT DATA <span class="japanesse text-green">(配達データー)</span>',
    'tab_title' => 'TRANSPORT DATA',
    'breadcrumbs_title' => 'TRANSPORT DATA'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("h1 .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

date_default_timezone_set('Asia/Jakarta');

if (isset($actionColumnTemplates)) {
$actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']);
    $actionColumnTemplateString = "{view} {update} {delete}";
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';

$tmp_location = ArrayHelper::map(app\models\WipPlanActualReport::find()->select('child_analyst, child_analyst_desc')->groupBy('child_analyst, child_analyst_desc')->all(), 'child_analyst_desc', 'child_analyst_desc');

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
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'session_no',
        'value' => 'wipPlanActualReport.session_id',
        'label' => 'Session No.',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'model_group',
        'label' => 'Model',
        'value' => function($model){
            return $model->wipPlanActualReport->model_group;
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 90px; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'period_line',
        'label' => 'Line',
        'value' => function($model){
            return $model->wipPlanActualReport->period_line;
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 60px; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'item',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 80px; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'item_desc',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
        //'hAlign' => 'center',
    ],
    [
        'attribute' => 'quantity',
        'label' => 'Qty',
        'value' => function($model){
            return $model->quantity_original !== null ? $model->quantity . ' of ' . $model->quantity_original : $model->quantity;
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filter' => $tmp_location,
    ],
    [
        'attribute' => 'from_loc',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filter' => $tmp_location,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px; min-width: 130px;'
        ],
    ],
    [
        'attribute' => 'to_loc',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filter' => $tmp_location,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px; min-width: 130px;'
        ],
    ],
    /*[
        'attribute' => 'source',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],*/
    [
        'attribute' => 'GOJEK_ID',
        'label' => 'Driver NIK',
        'vAlign' => 'middle',
        'hAlign' => 'center',
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
        'attribute' => 'issued_date',
        'value' => function($model){
            return $model->issued_date == null ? '-' : date('Y-m-d H:i:s', strtotime($model->issued_date));
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'request_date',
        'label' => 'Request For',
        'value' => function($model){
            return $model->request_date == null ? '-' : date('Y-m-d H:i:s', strtotime($model->request_date));
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'daparture_date',
        'value' => function($model){
            return $model->daparture_date == null ? '-' : date('Y-m-d H:i:s', strtotime($model->daparture_date));
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'arrival_date',
        'value' => function($model){
            return $model->arrival_date == null ? '-' : date('Y-m-d H:i:s', strtotime($model->arrival_date));
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
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
            'rowOptions' => function($model){
                if ($model->quantity_original !== null) {
                    return ['class' => 'danger'];
                }
            },
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


