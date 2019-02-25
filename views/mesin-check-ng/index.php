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
    'page_title' => 'Corrective Data <span class="text-green japanesse">(修繕データ)</span>',
    'tab_title' => 'Corrective Data',
    'breadcrumbs_title' => 'Corrective Data'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss(".japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

if (isset($actionColumnTemplates)) {
$actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']);
$actionColumnTemplateString = "{update} {upload} {delete} {change_color}";    
/*if (Yii::$app->user->identity->role->id == 1) {
        $actionColumnTemplateString = "{update} {delete} {change_color}";
    } else {
        $actionColumnTemplateString = "{update} {change_color}";
    }
 */   
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';

$this->registerJs("$(function() {
   $('.popupModal').click(function(e) {
     e.preventDefault();
     $('#modal').modal('show').find('.modal-body').load($(this).attr('href'));
   });
   $('.imageModal').click(function(e) {
     e.preventDefault();
     $('#image-modal').modal('show').find('.modal-body').load($(this).attr('href'));
   });
});");

//date_default_timezone_set('Asia/Jakarta');

$grid_columns = [
    /* [
        'class' => '\kartik\grid\SerialColumn',
        'width' => '30px',
    ], */
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
                $url = ['mesin-check-ng-dtr/create', 'urutan' => $model->urutan];
                $options = [
                    'title' => 'Update Machine Status',
                    'data-pjax' => '0',
                ];
                return Html::a('<span class="glyphicon glyphicon-refresh"></span>', $url, $options);
            }, 'upload' => function($url, $model, $key){
                $url = ['upload-image', 'urutan' => $model->urutan];
                $options = [
                    'title' => 'Upload Image',
                    'data-pjax' => '0',
                ];
                return Html::a('<span class="glyphicon glyphicon-cloud-upload"></span>', $url, $options);
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
        'attribute' => 'urutan',
        'label' => 'Ticket<br/>No',
        'value' => function($model){
            if (($model->prepare_time != null && $model->prepare_time != 0)
                || ($model->repair_time != null && $model->repair_time != 0)
                || ($model->spare_part_time != null && $model->spare_part_time != 0)
                || ($model->install_time != null && $model->install_time != 0)
            ) {
                return '<span class="badge bg-green">' . $model->urutan . '</span>';
            } else {
                return $model->urutan;
            }
            
        },
        'format' => 'raw',
        'vAlign' => 'middle',
        'encodeLabel' => false,
        'width' => '50px',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'class' => 'kartik\grid\ExpandRowColumn',
        'width' => '50px',
        'value' => function ($model, $key, $index, $column) {
            return GridView::ROW_COLLAPSED;
        },
        'detail' => function ($model, $key, $index, $column) {
            return Yii::$app->controller->renderPartial('_expand-row-details', ['model' => $model]);
        },
        'headerOptions' => ['class' => 'kartik-sheet-style'],
        'expandOneOnly' => true
    ],
    [
        'attribute' => 'location',
        'vAlign' => 'middle',
        'hidden' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'area',
        'vAlign' => 'middle',
        'width' => '150px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'mesin_id',
        'format' => 'raw',
        'label' => 'Machine ID',
        'vAlign' => 'middle',
        'hidden' => true,
        'hAlign' => 'center'
    ],
    [
        'attribute' => 'mesin_id',
        'value'=> function($data)
        { 
            return  Html::a($data->mesin_id, ['get-spare-part','mesin_id'=>$data->mesin_id], ['class' => 'btn btn-primary popupModal']);
        },
        'format' => 'raw',
        'label' => 'Machine ID',
        'vAlign' => 'middle',
        'hiddenFromExport' => true,
        'width' => '100px',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'mesin_nama',
        'label' => 'Machine Name',
        'vAlign' => 'middle',
        'width' => '160px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
        //'hAlign' => 'center'
    ],
    [
        'attribute' => 'mesin_no',
        'label' => 'Seq',
        'vAlign' => 'middle',
        'width' => '50px',
        'hAlign' => 'center',
        'hidden' => true
    ],
    [
        'attribute' => 'mesin_bagian',
        'label' => 'Parts',
        'filter' => false,
        'vAlign' => 'middle',
        'width' => '100px',
        'hidden' => true,
        //'hAlign' => 'center'
    ],
    [
        'attribute' => 'mesin_bagian_ket',
        'label' => 'Parts Info',
        'filter' => false,
        'vAlign' => 'middle',
        'hidden' => true,
        //'width' => '150px',
        //'hAlign' => 'center'
    ],
    [
        'attribute' => 'mesin_catatan',
        'label' => 'Parts Remarks',
        'filter' => false,
        'vAlign' => 'middle',
        'hidden' => true,
        //'width' => '150px',
        //'hAlign' => 'center'
    ],
    [
        'attribute' => 'mesin_periode',
        'label' => 'Periode',
        'filter' => false,
        'vAlign' => 'middle',
        'width' => '80px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
        //'hAlign' => 'center'
    ],
    [
        'attribute' => 'repair_note',
        'label' => 'Repair Note',
        'filter' => false,
        'vAlign' => 'middle',
        'hidden' => true,
        //'width' => '150px',
        //'hAlign' => 'center'
    ],
    [
        'attribute' => 'repair_status',
        'label' => 'Status',
        //'width' => '100px',
        'value' => function($model){
            if ($model->repair_status == 'O') {
                return 'OPEN';
            }else {
                return 'CLOSED';
            }
        },
        'vAlign' => 'middle',
        'filter' => [
            'O' => 'OPEN',
            'C' => 'CLOSED'
        ],
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'mesin_last_update',
        'label' => 'Start Trouble',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->mesin_last_update == null ? '-' : date('d-M-Y H:i:s', strtotime($model->mesin_last_update));
        },
        //'format' => ['date', 'php:d-M-Y H:i:s'],
        'width' => '120px',
        'contentOptions' => [
            'style' => 'min-width: 120px;'
        ],
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'repair_aktual',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->repair_aktual == null ? '-' : date('d-M-Y H:i:s', strtotime($model->repair_aktual));
        },
        //'format' => ['date', 'php:d-M-Y H:i:s'],
        'width' => '120px',
        'contentOptions' => [
            'style' => 'min-width: 120px;'
        ],
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'prepare_time',
        'label' => 'Prepare<br/>Time<br/>(minutes)',
        'encodeLabel' => false,
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
        'contentOptions' => [
            'style' => 'min-width: 60px;'
        ],
        'hidden' => true,
    ],
    [
        'attribute' => 'repair_time',
        'label' => 'Repair<br/>Time<br/>(minutes)',
        'encodeLabel' => false,
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
        'contentOptions' => [
            'style' => 'min-width: 60px;'
        ],
        'hidden' => true,
    ],
    [
        'attribute' => 'spare_part_time',
        'label' => 'Sparepart<br/>Time<br/>(minutes)',
        'encodeLabel' => false,
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
        'contentOptions' => [
            'style' => 'min-width: 60px;'
        ],
        'hidden' => true,
    ],
    [
        'attribute' => 'install_time',
        'label' => 'Install<br/>Time<br/>(minutes)',
        'encodeLabel' => false,
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
        'contentOptions' => [
            'style' => 'min-width: 60px;'
        ],
        'hidden' => true,
    ],
    [
        'attribute' => 'closing_day_total',
        'label' => 'Total Time<br/>(minutes)',
        'encodeLabel' => false,
        'vAlign' => 'middle',
        'value' => 'closingDayTotal',
        'hAlign' => 'center',
        'mergeHeader' => true,
        'contentOptions' => [
            'style' => 'min-width: 60px;'
        ],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'repair_plan',
        'label' => 'Repair Plan',
        'vAlign' => 'middle',
        'format' => ['date', 'php:d-M-Y'],
        'width' => '120px',
        'hAlign' => 'center',
        'contentOptions' => [
            'style' => 'min-width: 120px;'
        ],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
        //'hidden' => true
    ],
    [
        'attribute' => 'down_time_stat',
        'label' => 'Down Time/<br/>Non Down Time',
        'value' => function($model){
            $downtime = '-';
            if ($model->down_time_stat == 0) {
                $downtime = '???';
            } elseif ($model->down_time_stat == 1) {
                $downtime = 'Down Time';
            } elseif ($model->down_time_stat == 2) {
                $downtime = 'Non Down Time';
            }
            return $downtime;
        },
        'encodeLabel' => false,
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filter' => [
            0 => '???',
            1 => 'Down Time',
            2 => 'Non Down Time'
        ],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
        //'hidden' => true
    ],
]
?>
<div class="giiant-crud mesin-check-ng-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php //\yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <h1 style="display: none;">
        <?= Yii::t('app', 'Mesin Check Ngs') ?>
        <small>
            List
        </small>
    </h1>
    <div class="clearfix crud-navigation" style="display: none;">
        <div class="pull-left">
            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']) ?>
        </div>

        <div class="pull-right">

                        
            <?= 
            \yii\bootstrap\ButtonDropdown::widget(
            [
            'id' => 'giiant-relations',
            'encodeLabel' => false,
            'label' => '<span class="glyphicon glyphicon-paperclip"></span> ' . 'Relations',
            'dropdown' => [
            'options' => [
            'class' => 'dropdown-menu-right'
            ],
            'encodeLabels' => false,
            'items' => [

]
            ],
            'options' => [
            'class' => 'btn-default'
            ]
            ]
            );
            ?>
        </div>
    </div>

    <!-- <hr /> -->

    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $grid_columns,
            'hover' => true,
            //'condensed' => true,
            'striped' => true,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto; font-size: 12px;'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'rowOptions' => function($model){
                if ($model->repair_status == 'O') {
                    if ($model->color_stat == 1) {
                        return ['class' => 'warning'];
                    } else {
                        return ['class' => 'danger'];
                    }
                }
            },
            //'pjax' => true, // pjax is set to always true for this demo
            'toolbar' =>  [
                ['content' => 
                    Html::a('View Chart', ['/mnt-progress/index'], ['data-pjax' => 0, 'class' => 'btn btn-warning', 'title' => Yii::t('kvgrid', 'View Chart')])
                ],
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
        <?php
            yii\bootstrap\Modal::begin([
                'id' =>'modal',
                'header' => '<h3>Machine Spare Parts</h3>',
                'size' => 'modal-lg',
            ]);
            yii\bootstrap\Modal::end();

            yii\bootstrap\Modal::begin([
                'id' =>'image-modal',
                'header' => '<h3>NG Image</h3>',
                'size' => 'modal-lg',
            ]);
            yii\bootstrap\Modal::end();

        ?>
    </div>

</div>


<?php //\yii\widgets\Pjax::end() ?>


