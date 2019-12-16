<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\CutiTblSearch $searchModel
*/

$this->title = [
    'page_title' => null,
    'tab_title' => 'Meeting Room Data',
    'breadcrumbs_title' => 'Meeting Room Data'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("h1 .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");
$this->registerCss(".content-header {text-align: center; }");

date_default_timezone_set('Asia/Jakarta');

$gridColumns = [
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{add_member}',
        'buttons' => [
            'add_member' => function ($url, $model, $key) {
                $room_tbl = app\models\RoomTbl::find()
                ->where(['room_id' => $model->room_id])
                ->one();

                $options = [
                    'title' => 'Start Meeting',
                    'data-confirm' => 'Are you sure to start this meeting?',
                    //'style' => 'padding-left: 10px;'
                ];
                $url = ['start-meeting', 'id' => $model->id];

                if ($room_tbl->room_status != null && $room_tbl->room_status == 'NOT AVAILABLE' && date('Y-m-d', strtotime($room_tbl->start_time)) == date('Y-m-d')) {
                    $options[] = ['disabled' => true];
                    return Html::a('<span class="glyphicon glyphicon-log-in text-muted" style="color: #c3c1c1; cursor: not-allowed;"></span>', null);
                }

                $room_event_tbl = app\models\RoomEventTbl::find()
                ->where([
                    'room_id' => $model->room_id,
                    'event_id' => $model->id
                ])
                ->one();

                if ($room_event_tbl->seq != null) {
                    $options[] = ['disabled' => true];
                    return Html::a('<span class="glyphicon glyphicon-log-in text-muted" style="color: #c3c1c1;"></span>', null);
                }

                return Html::a('<span class="glyphicon glyphicon-log-in"></span>', $url, $options);
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
        'attribute' => 'room_id',
        'label' => 'Room',
        'value' => function ($model) {
            if ($rel = $model->room) {
                return $rel->sort_key;
            } else {
                return '';
            }
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filter' => ArrayHelper::map(app\models\MrbsRoom::find()->orderBy('sort_key')->all(), 'id', 'sort_key'),
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 110px;'
        ],
    ],
    [
        'attribute' => 'name',
        'label' => 'Meeting Name',
        'vAlign' => 'middle',
        //'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    /*[
        'attribute' => 'description',
        'vAlign' => 'middle',
        //'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],*/
    [
        'attribute' => 'tgl_start',
        'label' => 'Start Time',
        'mergeHeader' => true,
        'value' => function ($model) {
            if ($rel = $model->start_time) {
                return date('H:i', $rel);
            } else {
                return '';
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
        'attribute' => 'tgl_end',
        'label' => 'End Time',
        'mergeHeader' => true,
        'value' => function ($model) {
            if ($rel = $model->end_time) {
                return date('H:i', $rel);
            } else {
                return '';
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
        'attribute' => 'total_member',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
        'value' => function($model){
            $total = app\models\RoomEventTbl::find()
            ->where([
                'room_id' => $model->room_id,
                'event_id' => $model->id
            ])
            ->count();

            return $total;
        },
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'started_by',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
        'value' => function($model){
            $started_by = '-';

            $room_tbl = app\models\RoomTbl::find()
            ->where([
                'room_id' => $model->room_id,
                'event_id' => $model->id,
            ])->one();
            if ($room_tbl->room_id != null) {
                $started_by = $room_tbl->user_id . ' - ' . $room_tbl->user_desc;
            } else {
                $room_event_tbl = app\models\RoomEventTbl::find()
                ->where([
                    'room_id' => $model->room_id,
                    'event_id' => $model->id,
                ])->one();

                if ($room_event_tbl->room_id != null) {
                    $started_by = $room_event_tbl->user_id . ' - ' . $room_event_tbl->user_desc;
                }
            }
            return $started_by;
        },
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    /*[
        'attribute' => 'create_by',
        'label' => 'Created By',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'modified_by',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],*/
    /*'info_time:datetime',*/
    /*'ical_sequence',*/
    /*'timestamp',*/
    /*'info_text:ntext',*/
    /*'info_user',*/
    /*'type',*/
    /*'meeting_status',*/
    /*'ical_uid',*/
    /*'ical_recur_id',*/
]
?>
<div class="giiant-crud mrbs-entry-index">

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
            'rowOptions' => function($model){
                $total = app\models\RoomEventTbl::find()
                ->where([
                    'room_id' => $model->room_id,
                    'event_id' => $model->id
                ])
                ->count();
                $room_tbl = app\models\RoomTbl::find()
                ->where([
                    'room_id' => $model->room_id,
                    'event_id' => $model->id,
                    'room_status' => 'NOT AVAILABLE'
                ])
                ->one();
                if ($room_tbl->room_id != null) {
                    return ['class' => 'warning'];
                }
                if ($total > 0) {
                    return ['class' => 'success'];
                } else {
                    return ['class' => ''];
                }
            },
            //'showPageSummary' => true,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto;'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'pjax' => true, // pjax is set to always true for this demo
            'toolbar' =>  false,
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


