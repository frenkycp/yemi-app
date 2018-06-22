<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\MesinCheckNgSearch $searchModel
*/

$this->title = Yii::t('app', 'Machine Check Data');
$this->params['breadcrumbs'][] = $this->title;

if (isset($actionColumnTemplates)) {
$actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']);
    $actionColumnTemplateString = "{view} {update} {delete}";
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';

$this->registerJs("$(function() {
   $('.popupModal').click(function(e) {
     e.preventDefault();
     $('#modal').modal('show').find('.modal-body').load($(this).attr('href'));
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
            }
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
        'vAlign' => 'middle',
        'encodeLabel' => false,
        'width' => '50px',
        'hAlign' => 'center'
    ],
    [
        'attribute' => 'location',
        'vAlign' => 'middle',
        //'width' => '100px',
        'hidden' => true,
        //'hAlign' => 'center'
    ],
    [
        'attribute' => 'area',
        'vAlign' => 'middle',
        //'width' => '150px',
        //'hAlign' => 'center'
    ],
    [
        'attribute' => 'mesin_id',
        'format' => 'raw',
        'label' => 'Machine ID',
        'vAlign' => 'middle',
        'hidden' => true,
        //'width' => '100px',
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
        //'width' => '100px',
        'hAlign' => 'center'
    ],
    [
        'attribute' => 'mesin_nama',
        'label' => 'Machine Name',
        'vAlign' => 'middle',
        'width' => '100px',
        //'hAlign' => 'center'
    ],
    [
        'attribute' => 'mesin_no',
        'label' => 'Seq',
        'vAlign' => 'middle',
        'width' => '50px',
        'hAlign' => 'center'
    ],
    [
        'attribute' => 'mesin_bagian',
        'label' => 'Parts',
        'filter' => false,
        'vAlign' => 'middle',
        'width' => '100px',
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
        //'width' => '150px',
        //'hAlign' => 'center'
    ],
    [
        'attribute' => 'mesin_periode',
        'label' => 'Periode',
        'filter' => false,
        'vAlign' => 'middle',
        'width' => '80px',
        //'hAlign' => 'center'
    ],
    [
        'attribute' => 'repair_note',
        'label' => 'Repair Note',
        'filter' => false,
        'vAlign' => 'middle',
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
        'hAlign' => 'center'
    ],
    [
        'attribute' => 'mesin_last_update',
        'label' => 'Last Update',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->mesin_last_update == null ? '-' : date('d-M-Y H:i:s', strtotime($model->mesin_last_update));
        },
        //'format' => ['date', 'php:d-M-Y H:i:s'],
        'width' => '120px',
        'hAlign' => 'center'
    ],
    [
        'attribute' => 'repair_aktual',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->repair_aktual == null ? '-' : date('d-M-Y H:i:s', strtotime($model->repair_aktual));
        },
        //'format' => ['date', 'php:d-M-Y H:i:s'],
        'width' => '120px',
        'hAlign' => 'center'
    ],
    [
        'attribute' => 'closing_day_total',
        'label' => 'Days',
        'vAlign' => 'middle',
        'value' => 'closingDayTotal',
        'hAlign' => 'center',
        'contentOptions' => [
            'style' => 'min-width: 60px;'
        ],
    ],
    [
        'attribute' => 'repair_plan',
        'label' => 'Repair Plan',
        'vAlign' => 'middle',
        'format' => ['date', 'php:d-M-Y'],
        'width' => '120px',
        'hAlign' => 'center',
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
            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
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
        ?>
    </div>

</div>


<?php //\yii\widgets\Pjax::end() ?>


