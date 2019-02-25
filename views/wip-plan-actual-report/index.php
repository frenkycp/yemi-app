<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use kartik\form\ActiveForm;
use kartik\file\FileInput;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\MesinCheckNgSearch $searchModel
*/

$this->title = [
    'page_title' => 'WIP Data Record <span class="text-green japanesse">（仕掛りデーター）</span>',
    'tab_title' => 'WIP Data Record',
    'breadcrumbs_title' => 'WIP Data Record'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');

$this->registerCss(".japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

/*$this->registerJs("$(function() {
   $('.popupModal').click(function(e) {
     e.preventDefault();
     $('#modal').modal('show').find('.modal-body').load($(this).attr('href'));
   });
   $('.imageModal').click(function(e) {
     e.preventDefault();
     $('#image-modal').modal('show').find('.modal-body').load($(this).attr('href'));
   });
});");*/

//date_default_timezone_set('Asia/Jakarta');

$grid_columns = [
    /* [
        'class' => '\kartik\grid\SerialColumn',
        'width' => '30px',
    ], */
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{reason}',
        'buttons' => [
            'reason' => function($url, $model, $key){
                if ($model->stage == '00-ORDER') {
                    return null;
                }
                $wip_dtr = app\models\WipDtr::find()
                ->where([
                    'slip_id' => $model->slip_id
                ])
                ->one();
                $url = ['reason',
                    'dtr_id' => $wip_dtr->dtr_id,
                    'location' => $model->child_analyst,
                    'model_group' => $model->model_group,
                    'child' => $model->child,
                    'child_desc' => $model->child_desc,
                    'qty' => (int)$model->balance_by_day + (int)$model->act_qty,
                ];
                $options = [
                    'title' => 'Add Reason',
                    'data-pjax' => '0',
                ];
                return Html::a('<span class="fa fa-pencil"></span>', $url, $options);
            },
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
        'attribute' => 'period',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '90px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 70px; font-size:12px;'
        ],
        'pageSummary' => 'Total'
    ],
    [
        'attribute' => 'upload_id',
        'label' => 'VMS No',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '100px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 70px; font-size:12px;'
        ],
    ],
    [
        'attribute' => 'slip_id',
        'label' => 'Slip No.',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '100px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 70px; font-size:12px;'
        ],
    ],
    [
        'attribute' => 'session_id',
        'label' => 'Session<br/>No.',
        'encodeLabel' => false,
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '100px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 50px; font-size:12px;'
        ],
    ],
    [
        'attribute' => 'period_line',
        'label' => 'VMS Line',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '80px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 70px; font-size:12px;'
        ],
    ],
    [
        'attribute' => 'child_analyst',
        'label' => 'Location',
        'value' => function($model){
            return $model->child_analyst_desc;
        },
        'vAlign' => 'middle',
        'width' => '150px',
        'filter' => $location_dropdown,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 100px; font-size:12px;'
        ],
    ],
    [
        'attribute' => 'LINE',
        'label' => 'Prod. Line',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '100px',
        'filter' => ArrayHelper::map(app\models\HakAkses::find()->where(['level_akses' => '4'])->orderBy('hak_akses ASC')->all(), 'hak_akses', 'hak_akses'),
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 70px; font-size:12px;'
        ],
    ],
    [
        'attribute' => 'model_group',
        'label' => 'Model',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 90px; font-size:12px;'
        ],
    ],
    [
        'attribute' => 'child',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '100px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 70px; font-size:12px;'
        ],
    ],
    [
        'attribute' => 'child_desc',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 130px; font-size:12px;'
        ],
        //'hAlign' => 'center'
    ],
    [
        'attribute' => 'fa_lot_qty',
        'label' => 'Lot Qty',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 80px; font-size:12px; text-align:center;'
        ],
    ],
    [
        'attribute' => 'summary_qty',
        'label' => 'Actual Qty',
        'value' => function($model){
            return (int)$model->balance_by_day + (int)$model->act_qty;
        },
        'mergeHeader' => true,
        'vAlign' => 'middle',
        'width' => '70px',
        'hAlign' => 'center',
        'pageSummary' => true,
        'contentOptions' => function($model){
            if ($model->stage == '01-CREATED' && $model->child_analyst == 'WF01') {
                return [
                    'style' => 'min-width: 80px; font-size:20px; text-align:center; font-weight: bold; color: red;'
                ];
            }
            return [
                'style' => 'min-width: 80px; font-size:12px; text-align:center;'
            ];
        },
    ],
    [
        'attribute' => 'fa_lot_no',
        'label' => 'Lot Number',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 80px; font-size:12px; text-align:center;'
        ],
    ],
    [
        'attribute' => 'stage',
        'label' => 'Status',
        'value' => function($model){
            $status_arr = explode('-', $model->stage);
            return $status_arr[1] == 'HAND OVER' ? 'PULLED BY NEXT' : $status_arr[1];
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filter' => \Yii::$app->params['wip_stage_arr'],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 130px; font-size:12px;'
        ],
        'contentOptions' => function($model){
            if ($model->stage == '01-CREATED' && $model->child_analyst == 'WF01') {
                return [
                    'style' => 'font-size:20px; font-weight: bold; color: red;'
                ];
            }
            return [
                'style' => 'min-width: 80px; font-size:12px; text-align:center;'
            ];
        },
    ],
    [
        'attribute' => 'start_date',
        'label' => 'Start Date',
        'value' => function($model){
            return $model->start_date == null ? '-' : date('Y-m-d', strtotime($model->start_date));
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '100px',
        'contentOptions' => [
            'style' => 'min-width: 100px;'
        ],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size:12px;'
        ],
    ],
    [
        'attribute' => 'source_date',
        'label' => 'FA Start',
        'value' => function($model){
            return $model->source_date == null ? '-' : date('Y-m-d', strtotime($model->source_date));
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '100px',
        'contentOptions' => [
            'style' => 'min-width: 100px;'
        ],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size:12px;'
        ],
    ],
    [
        'attribute' => 'end_job',
        'label' => 'Complete Actual',
        'value' => function($model){
            return $model->end_job == null ? '-' : date('Y-m-d', strtotime($model->end_job));
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '100px',
        'contentOptions' => [
            'style' => 'min-width: 100px;'
        ],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size:12px;'
        ],
    ],
    [
        'attribute' => 'hand_over_job',
        'label' => 'Pulled by Next Actual',
        'value' => function($model){
            return $model->hand_over_job == null ? '-' : date('Y-m-d', strtotime($model->hand_over_job));
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '100px',
        'contentOptions' => [
            'style' => 'min-width: 100px;'
        ],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size:12px;'
        ],
    ],
    [
        'attribute' => 'created_user_desc',
        'label' => 'Created By',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'start_job_user_desc',
        'label' => 'Started By',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'end_job_user_desc',
        'label' => 'Completed By',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'hand_over_job_user_desc',
        'label' => 'Hand Overed By',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'delay_last_update',
        'value' => function($model){
            return $model->delay_last_update == null ? '-' : date('Y-m-d H:i:s', strtotime($model->delay_last_update));
        },
        'vAlign' => 'middle',
        'hAlign' => 'center'
    ],
    [
        'attribute' => 'delay_userid',
        'vAlign' => 'middle',
        'hAlign' => 'center'
    ],
    [
        'attribute' => 'delay_userid_desc',
        'vAlign' => 'middle',
        'hAlign' => 'center'
    ],
    [
        'attribute' => 'delay_category',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filter' => \Yii::$app->params['delay_category_arr']
    ],
    
    [
        'attribute' => 'delay_detail',
        'vAlign' => 'middle',
        'hAlign' => 'center'
    ],
]
?>
<div class="giiant-crud mesin-check-ng-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <div class="">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $grid_columns,
            'hover' => true,
            'responsive' => true,
            //'condensed' => true,
            'striped' => true,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto; font-size: 12px;'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'pjax' => true, // pjax is set to always true for this demo
            'rowOptions' => function($model){
                if ($model->delay_last_update == null) {
                    return ['class' => ''];
                } else {
                    return ['class' => 'danger'];
                }
            },
            'toolbar' =>  [
                '{export}',
                '{toggleData}',
            ],
            'showPageSummary' => true,
            // set export properties
            'export' => [
                'fontAwesome' => true
            ],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
            ],
        ]); ?>
        <?php
            /*yii\bootstrap\Modal::begin([
                'id' =>'modal',
                'header' => '<h3>Machine Spare Parts</h3>',
                'size' => 'modal-lg',
            ]);
            yii\bootstrap\Modal::end();

            yii\bootstrap\Modal::begin([
                'id' =>'image-modal',
                'header' => '<h3>NG Image</h3>',
                //'size' => 'modal-lg',
            ]);
            yii\bootstrap\Modal::end(); */

        ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


