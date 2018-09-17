<?php

use yii\helpers\Html;
use yii\helpers\Url;
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

$this->registerCss(".japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

if (isset($actionColumnTemplates)) {
$actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']);
    if (Yii::$app->user->identity->role->id == 1) {
        $actionColumnTemplateString = "{update} {delete} {change_color}";
    } else {
        $actionColumnTemplateString = "{update} {change_color}";
    }
    
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';

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
    ], 
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => $actionColumnTemplateString,
        'buttons' => [
            'view' => function ($url, $model, $key) {
                $options = [
                    'title' => Yii::t('cruds', 'View'),
                    'aria-label' => Yii::t('cruds', 'View'),
                    'data-pjax' => '0',
                ];
                return Html::a('<span class="glyphicon glyphicon-file"></span>', $url, $options);
            }, 'change_color' => function($url, $model, $key){
                $url = ['change-color', 'urutan' => $model->urutan];
                $options = [
                    'title' => 'Change Machine Status',
                    'data-pjax' => '0',
                ];
                return Html::a('<span class="glyphicon glyphicon-refresh"></span>', $url, $options);
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
    [
        'attribute' => 'period',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '90px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 70px; font-size:10px;'
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
            'style' => 'text-align: center; min-width: 70px; font-size:10px;'
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
            'style' => 'text-align: center; min-width: 70px; font-size:10px;'
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
            'style' => 'text-align: center; min-width: 50px; font-size:10px;'
        ],
    ],
    [
        'attribute' => 'period_line',
        'label' => 'line',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '80px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 70px; font-size:10px;'
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
            'style' => 'min-width: 150px; font-size:10px;'
        ],
    ],
    [
        'attribute' => 'model_group',
        'label' => 'Model',
        'vAlign' => 'middle',
        'contentOptions' => [
            'style' => 'min-width: 100px;'
        ],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 120px; font-size:10px;'
        ],
    ],
    [
        'attribute' => 'child',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '100px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 70px; font-size:10px;'
        ],
    ],
    [
        'attribute' => 'child_desc',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 170px; font-size:10px;'
        ],
        //'hAlign' => 'center'
    ],
    [
        'attribute' => 'summary_qty',
        'label' => 'Qty',
        'vAlign' => 'middle',
        'width' => '70px',
        'hAlign' => 'center',
        'pageSummary' => true
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
        'filter' => $status_dropdown,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 130px; font-size:10px;'
        ],
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
            'style' => 'text-align: center;'
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
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'end_job',
        'label' => 'End Actual',
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
            'style' => 'text-align: center;'
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
            'containerOptions' => ['style' => 'overflow: auto; font-size: 10px;'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'pjax' => true, // pjax is set to always true for this demo
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


