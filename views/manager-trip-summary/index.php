<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\ManagerTripSummarySearch $searchModel
*/

$this->title = [
    'page_title' => 'Trip Summary Report <span class="japanesse light-green"></span>',
    'tab_title' => 'Trip Summary Report',
    'breadcrumbs_title' => 'Trip Summary Report'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');

$css_string = "
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; font-size: 0.7em; text-align: center; display: none;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    //.box-header .box-title{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .content {padding-top: 0px;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .active a {background-color: #3c8dbc !important; font-size: 18px; color: white !important;}";
$this->registerCss($css_string);

$gridColumns = [
    [
        'attribute' => 'period',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'post_date',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'emp_id',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'emp_name',
        'vAlign' => 'middle',
        //'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            //'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'account_type',
        'value' => function($model){
            if ($model->account_type == 'COORDINATOR') {
                return 'NON-MANAGER';
            } else {
                return $model->account_type;
            }
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filter' => [
            'MANAGER' => 'MANAGER',
            'COORDINATOR' => 'NON-MANAGER'
        ],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'start_status',
        'label' => 'Go To Office',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'value' => function($model){
            if ($model->start_status == 0) {
                return '<span class="badge bg-red" style="font-weight: normal;">OPEN</span>';
            } else {
                return '<span class="badge bg-green" style="font-weight: normal;">CLOSE</span>';
            }
        },
        'format' => 'html',
        'filter' => [
            0 => 'OPEN',
            1 => 'CLOSE'
        ],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'end_status',
        'label' => 'Back Home',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'value' => function($model){
            if ($model->end_status == 0) {
                return '<span class="badge bg-red" style="font-weight: normal;">OPEN</span>';
            } else {
                return '<span class="badge bg-green" style="font-weight: normal;">CLOSE</span>';
            }
        },
        'format' => 'html',
        'filter' => [
            0 => 'OPEN',
            1 => 'CLOSE'
        ],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'start_validation',
        'label' => 'Go To Office<br/>(Validation)',
        'encodeLabel' => false,
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'value' => function($model){
            if ($model->start_validation == 0) {
                return '<span class="badge bg-red" style="font-weight: normal;">OPEN</span>';
            } else {
                return '<span class="badge bg-green" style="font-weight: normal;">CLOSE</span>';
            }
        },
        'format' => 'html',
        'filter' => [
            0 => 'OPEN',
            1 => 'CLOSE'
        ],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'end_validation',
        'label' => 'Back Home<br/>(Validation)',
        'encodeLabel' => false,
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'value' => function($model){
            if ($model->end_validation == 0) {
                return '<span class="badge bg-red" style="font-weight: normal;">OPEN</span>';
            } else {
                return '<span class="badge bg-green" style="font-weight: normal;">CLOSE</span>';
            }
        },
        'format' => 'html',
        'filter' => [
            0 => 'OPEN',
            1 => 'CLOSE'
        ],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'in_datetime',
        'value' => function($model){
            $tmp_rfid_scan = app\models\RfidCarScan::find()->where([
                'post_date' => $model->post_date,
                'nik' => $model->emp_id
            ])->one();
            if ($tmp_rfid_scan->in_datetime != null) {
                return date('H:i', strtotime($tmp_rfid_scan->in_datetime));
            } else {
                return null;
            }
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            //'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'out_datetime',
        'value' => function($model){
            $tmp_rfid_scan = app\models\RfidCarScan::find()->where([
                'post_date' => $model->post_date,
                'nik' => $model->emp_id
            ])->one();
            if ($tmp_rfid_scan->out_datetime != null) {
                return date('H:i', strtotime($tmp_rfid_scan->out_datetime));
            } else {
                return null;
            }
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            //'style' => 'text-align: center;'
        ],
    ],
];
?>
<div class="giiant-crud bentol-manager-trip-summary-index">

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
            'containerOptions' => ['style' => 'overflow: auto;'], // only set when $responsive = false
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
                'type' => GridView::TYPE_PRIMARY,
                'heading' => 'Trip Summary Report',
                //'footer' => false,
            ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


