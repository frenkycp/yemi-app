<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\SapPoRcvSearch $searchModel
*/

$this->title = [
    'page_title' => 'Kanban Office Data Table <span class="text-green japanesse"></span>',
    'tab_title' => 'Kanban Office Data Table',
    'breadcrumbs_title' => 'Kanban Office Data Table'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss(".japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }
    .container {width: 100% !important;}
    .disabled-link {color: DarkGrey; cursor: not-allowed;}
    ");



$gridColumns = [
	[
		'class' => 'kartik\grid\ActionColumn',
		'template' => '{confirm}',
		'buttons' => [
			'confirm' => function($url, $model, $key){
                $url = ['confirm', 'job_hdr_no' => $model->job_hdr_no];
                $options = [
                    'title' => 'Confirm',
                    'data-pjax' => '0',
                ];
                if($model->job_stage == 1){
                    return Html::a('<i class="glyphicon glyphicon-copy" style="font-size: 1.5em;"></i>', $url, $options);
                } else {
                    return '<i class="glyphicon glyphicon-copy disabled-link" style="font-size: 1.5em;"></i>';
                }
                
            }
		],
	],
    [
        'class' => 'kartik\grid\EnumColumn',
        'attribute' => 'job_stage',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'enum' => [
            1 => '<span class="badge bg-light-blue">REQUEST</span>',
            2 => '<span class="badge bg-yellow">IN-PROGRESS</span>',
            3 => '<span class="badge bg-green">DONE</span>',
        ],
        'filter' => [
            1 => 'REQUEST',
            2 => 'IN-PROGRESS',
            3 => 'DONE',
        ],
        'format' => 'html',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'job_hdr_no',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'job_flow_id',
        'value' => function($model){
            return $model->kanbanFlowHdr->job_flow_desc;
        },
        //'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'job_desc',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'job_issued_nik_name',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'request_to_nik_name',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'request_date',
        'value' => function($model){
            if ($model->request_date == null) {
                return '-';
            } else {
                return date('Y-m-d', strtotime($model->request_date));
            }
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'job_issued_date',
        'value' => function($model){
            if ($model->job_issued_date == null) {
                return '-';
            } else {
                return date('Y-m-d H:i', strtotime($model->job_issued_date));
            }
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'confirm_schedule_date',
        'value' => function($model){
            if ($model->confirm_schedule_date == null) {
                return '-';
            } else {
                return date('Y-m-d', strtotime($model->confirm_schedule_date));
            }
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'confirm_to_nik_name',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'confirm_department',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'confirm_cost_center_desc',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'job_source',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'job_priority',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filter' => [
            'NORMAL' => 'NORMAL',
            'URGENT' => 'URGENT'
        ],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'job_close_date',
        'value' => function($model){
            if ($model->job_close_date == null) {
                return '-';
            } else {
                return date('Y-m-d', strtotime($model->job_close_date));
            }
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
];
?>
<div class="giiant-crud sap-po-rcv-index">

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
            'bordered' => true,
            //'condensed' => true,
            'striped' => true,
            'pager' => [
                'firstPageLabel' => 'First',
                'lastPageLabel'  => 'Last'
            ],
            'showPageSummary' => true,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto; font-size: 12px;'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'pjax' => true, // pjax is set to always true for this demo
            'toolbar' =>  [
                //Html::a('Judge W/I to "OK"', ['judge-wi'], ['class' => 'btn btn-primary']),
                Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'Add New', ['create'], ['class' => 'btn btn-success']),
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


