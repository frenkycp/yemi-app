<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use app\models\SunfishViewEmp;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\CutiTblSearch $searchModel
*/

$this->title = [
    'page_title' => 'Permit Data Center <span class="japanesse text-green"></span>',
    'tab_title' => 'Permit Data Center',
    'breadcrumbs_title' => 'Permit Data Center'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');

$sunfish_department = ArrayHelper::map(SunfishViewEmp::find()->select('Department')->where(['status' => 1])->groupBy('Department')->orderBy('Department')->all(), 'Department', 'Department');
$sunfish_cost_center = ArrayHelper::map(SunfishViewEmp::find()->select('cost_center_code, cost_center_name')->where(['status' => 1])->groupBy('cost_center_code, cost_center_name')->orderBy('cost_center_name')->all(), 'cost_center_code', 'cost_center_name');

$gridColumns = [
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{close}',
        'buttons' => [
            'close' => function($url, $model, $key){
                $url = ['close', 'ID' => $model->ID];
                $options = [
                    'title' => 'Close',
                    'data-pjax' => '0',
                ];
                if ($model->STATUS == 'O') {
                    return Html::a('<button class="btn btn-success btn-sm btn-block"><i class="fa fa-check-square-o"></i></span></button>', $url, $options);
                } else {
                    return '<button class="btn btn-success btn-sm btn-block disabled"><i class="fa fa-check-square-o"></i></span></button>';
                }
                
            },
        ],
        'contentOptions' => ['nowrap'=>'nowrap', 'style' => 'width: 100px;']
    ],
    [
        'attribute' => 'PERIOD',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'POST_DATE',
        'value' => function($model){
            return date('Y-m-d', strtotime($model->POST_DATE));
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'NIK',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'NAMA_KARYAWAN',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'DEPARTMENT',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
        'filter' => $sunfish_department,
    ],
    [
        'attribute' => 'COST_CENTER_CODE',
        'value' => 'COST_CENTER_NAME',
        'label' => 'Cost Center',
        'filter' => $sunfish_cost_center,
        //'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'REASON',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'STATUS',
        'value' => function($model){
            if ($model->STATUS == 'O') {
                return '<span class="label bg-red">OPEN</span>';
            } else {
                return '<span class="label bg-green">CLOSE</span>';
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
        'attribute' => 'LAST_UPDATED',
        'label' => 'Receive Datetime',
        'mergeHeader' => true,
        'value' => function($model){
            return date('Y-m-d H:i:s', strtotime($model->LAST_UPDATED));
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
];
?>
<div class="giiant-crud emp-permit-tbl-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $gridColumns,
            //'hover' => true,
            //'condensed' => true,
            'striped' => false,
            'pager' => [
                'firstPageLabel' => 'First',
                'lastPageLabel'  => 'Last'
            ],
            'showPageSummary' => true,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto;'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'pjax' => true, // pjax is set to always true for this demo
            'toolbar' =>  [
                //Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'Add', ['set-area'], ['class' => 'btn btn-success']),
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
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


