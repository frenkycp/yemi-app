<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\HrgaAttendanceDataSearch $searchModel
*/

$this->title = [
    'page_title' => 'Attendance Data (Sunfish) <span class="japanesse light-green"></span>',
    'tab_title' => 'Attendance Data (Sunfish)',
    'breadcrumbs_title' => 'Attendance Data (Sunfish)'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');

$gridColumns = [
    [
        'attribute' => 'period',
        'value' => function($model){
            return date('Ym', strtotime($model->shiftstarttime));
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'post_date',
        'value' => function($model){
            return date('Y-m-d', strtotime($model->shiftstarttime));
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'shiftdaily_code',
        'label' => 'Shift Code',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px; min-width: 110px; text-align: center;'
        ],
    ],
    [
        'attribute' => 'emp_no',
        'label' => 'NIK',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px; min-width: 110px; text-align: center;'
        ],
    ],
    [
        'attribute' => 'name',
        'label' => 'Name',
        'mergeHeader' => true,
        'value' => function($model){
            return $model->empData->Full_name;
        },
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px; min-width: 110px;'
        ],
    ],
    [
        'attribute' => 'starttime',
        'label' => 'Start Time',
        'mergeHeader' => true,
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px; min-width: 110px;'
        ],
    ],
    [
        'attribute' => 'endtime',
        'label' => 'End Time',
        'mergeHeader' => true,
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px; min-width: 110px;'
        ],
    ],
    [
        'attribute' => 'present',
        'value' => function($model){
            return $model->getPresent();
        },
        'label' => 'Present',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px; min-width: 110px; text-align: center;'
        ],
    ],
];
?>
<div class="giiant-crud absensi-tbl-index">

    <?php
            echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <div class="">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'columns' => $gridColumns,
            'hover' => true,
            //'condensed' => true,
            'striped' => true,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto; font-size: 12px;'], // only set when $responsive = false
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
                'heading' => $heading,
                //'footer' => false,
            ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


