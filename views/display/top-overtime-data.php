<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;

$this->title = [
    'page_title' => 'OT Management by NIK <span class="japanesse light-green">(社員別残業管理）</span>',
    'tab_title' => 'OT Management by NIK',
    'breadcrumbs_title' => 'OT Management by NIK'
];

if (\Yii::$app->request->get('section_id') == 1) {
    $this->title['page_title'] .= ' - PRODUCTION';
} elseif (\Yii::$app->request->get('section_id') == 2) {
    $this->title['page_title'] .= ' - NON PRODUCTION';
}
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
    //.form-control, .control-label {background-color: #000; color: white; border-color: white;}
    .form-control {font-size: 30px; height: 52px;}
    .content-header {color: white;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    .box-header .box-title, .control-label{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .active a {background-color: #3c8dbc !important; font-size: 18px; color: white !important;}
");

date_default_timezone_set('Asia/Jakarta');

$gridColumns = [
    [
        'class' => 'kartik\grid\SerialColumn',
        'contentOptions' => ['class' => 'kartik-sheet-style'],
        'width' => '36px',
        'header' => '',
        'headerOptions' => ['class' => 'kartik-sheet-style']
    ],
    [
        'attribute' => 'period',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'cost_center',
        'label' => 'Section',
        'vAlign' => 'middle',
        //'hAlign' => 'center',
        'filter' => \Yii::$app->params['sunfish_cost_center'],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'emp_no',
        'label' => 'NIK',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'format' => 'html',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'full_name',
        'label' => 'Name',
        'vAlign' => 'middle',
        //'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'total_ot',
        'label' => 'Overtime Total',
        'value' => function($model){
            return round($model->total_ot/60, 1);
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 80px;'
        ],
    ],
    /*[
        'class' => 'kartik\grid\ActionColumn',
        //'template' => "{check_sheet} {history}",
        'template' => "{view_period}",
        'buttons' => [
            'view_period' => function ($url, $model, $key) {
                $options = [
                    'title' => 'View Monthly Overtime (in a year)',
                ];
                $url = ['/emp-overtime-monthly/index', 'year' => substr($model->PERIOD, 0, 4), 'nik' => $model->NIK];
                return Html::a('<span class="glyphicon glyphicon-calendar"></span>', $url, $options);
            },
        ],
        'urlCreator' => function($action, $model, $key, $index) {
            // using the column name as key, not mapping to 'id' like the standard generator
            $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
            $params[0] = \Yii::$app->controller->id ? \Yii::$app->controller->id . '/' . $action : $action;
            return Url::toRoute($params);
        },
        'contentOptions' => ['nowrap'=>'nowrap']
    ],*/
    
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
            //'filterModel' => $searchModel,
            'columns' => $gridColumns,
            'hover' => true,
            'condensed' => true,
            'striped' => true,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto; font-size: 20px; font-weight: bold;'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style info'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            //'toolbar' => false,
            'toolbar' =>  [
                //'{export}',
                //'{toggleData}',
            ],
            // set export properties
            'export' => [
                'fontAwesome' => true
            ],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                //'heading' => false,
                //'footer' => false,
                //'before' => false,
                //'after' => false,
            ],
        ]); ?>
    </div>

</div>