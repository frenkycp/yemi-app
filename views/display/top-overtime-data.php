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
        'attribute' => 'PERIOD',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 18px; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'CC_GROUP',
        'label' => 'Department',
        'vAlign' => 'middle',
        //'hAlign' => 'center',
        'filter' => ArrayHelper::map(app\models\CostCenter::find()->select('CC_GROUP')->groupBy('CC_GROUP')->orderBy('CC_GROUP')->all(), 'CC_GROUP', 'CC_GROUP'),
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 18px; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'CC_DESC',
        'label' => 'Section',
        'vAlign' => 'middle',
        //'hAlign' => 'center',
        'filter' => ArrayHelper::map(app\models\CostCenter::find()->select('CC_DESC')->groupBy('CC_DESC')->orderBy('CC_DESC')->all(), 'CC_DESC', 'CC_DESC'),
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 18px; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'NIK',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'format' => 'html',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 18px; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'NAMA_KARYAWAN',
        'label' => 'Name',
        'vAlign' => 'middle',
        //'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 18px; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'GRADE',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filter' => \Yii::$app->params['grade_arr'],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 18px; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'NILAI_LEMBUR_ACTUAL',
        'label' => 'Overtime Total',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 18px; min-width: 80px;'
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
                '{toggleData}',
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