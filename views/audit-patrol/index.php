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
    'page_title' => 'Audit Patrol Data <span class="japanesse text-green"></span>',
    'tab_title' => 'Audit Patrol Data',
    'breadcrumbs_title' => 'Audit Patrol Data'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$gridColumns = [
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{update} {action}',
        'buttons' => [
            'update' => function($url, $model, $key){
                $url = ['update', 'ID' => $model->ID];
                $options = [
                    'title' => 'Edit',
                    'data-pjax' => '0',
                ];
                return Html::a('<button class="btn btn-success btn-sm"><i class="fa fa-edit"></i> EDIT</span></button>', $url, $options);
            },
            'action' => function($url, $model, $key){
                $url = ['solve', 'ID' => $model->ID];
                $options = [
                    'title' => 'Action',
                    'data-pjax' => '0',
                ];
                return Html::a('<button class="btn btn-warning btn-sm"><i class="fa fa-thumbs-o-up"></i> ACTION</span></button>', $url, $options);
            },
            'view' => function ($url, $model, $key) {
                $options = [
                    'title' => Yii::t('cruds', 'View'),
                    'aria-label' => Yii::t('cruds', 'View'),
                    'data-pjax' => '0',
                ];
                return Html::a('<span class="glyphicon glyphicon-file"></span>', $url, $options);
            }
        ],
        'contentOptions' => ['nowrap'=>'nowrap', 'style' => 'min-width: 160px;']
    ],
    /*[
        'attribute' => 'CATEGORY',
        'value' => function($model){
            return \Yii::$app->params['audit_patrol_category'][$model->CATEGORY];
        },
        'label' => 'Patrol Type',
        'filter' => \Yii::$app->params['audit_patrol_category'],
        //'hAlign' => 'center',
        'vAlign' => 'middle',
    ],*/
    [
        'attribute' => 'TOPIC',
        'value' => function($model){
            return \Yii::$app->params['audit_patrol_topic'][$model->TOPIC];
        },
        'label' => 'Patrol Category',
        'filter' => \Yii::$app->params['audit_patrol_topic'],
        //'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'PATROL_DATE',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'LOC_ID',
        'value' => 'LOC_DESC',
        'label' => 'Location',
        'filter' => \Yii::$app->params['wip_location_arr'],
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'LOC_DESC',
        'label' => 'Location Detail',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'AUDITOR',
        'hidden' => true,
        //'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'PIC_NAME',
        'label' => 'Auditee',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'STATUS',
        'value' => function($model){
            if ($model->STATUS == 'O') {
                return '<span class="text-red">OPEN</span>';
            } else {
                return '<span class="text-green">CLOSE</span>';
            }
        },
        'format' => 'html',
        'filter' => [
            'O' => 'OPEN',
            'C' => 'CLOSE',
        ],
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    /*[
        'attribute' => 'TOPIC',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],*/
    [
        'attribute' => 'DESCRIPTION',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'contentOptions' => [
            'style' => 'min-width: 100px;'
        ],
    ],
    [
        'attribute' => 'ACTION',
        /*'value' => function($model){
            $return_val = $model->ACTION;
            if ($model->IMAGE_AFTER_1 != null) {
                $return_val .= '<br/>' . Html::img('@web/uploads/AUDIT_PATROL/' . $model->IMAGE_AFTER_1, ['width'=>'250']);
            }
            return $return_val;
        },
        'mergeHeader' => true,*/
        'format' => 'html',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'contentOptions' => [
            'style' => 'min-width: 100px;'
        ],
    ],
    [
        'attribute' => 'IMAGE_BEFORE_1',
        'value' => function($model){
            if ($model->IMAGE_BEFORE_1 != null) {
                return Html::img('@web/uploads/AUDIT_PATROL/' . $model->IMAGE_BEFORE_1, ['width'=>'250']);
            }
        },
        'width' => '250',
        'mergeHeader' => true,
        'format' => 'html',
        'label' => 'Image Before',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'contentOptions' => [
            'style' => 'min-width: 250px;'
        ],
    ],
    
    [
        'attribute' => 'IMAGE_AFTER_1',
        'value' => function($model){
            if ($model->IMAGE_AFTER_1 != null) {
                return Html::img('@web/uploads/AUDIT_PATROL/' . $model->IMAGE_AFTER_1, ['width'=>'250']);
            }
        },
        'width' => '250',
        'mergeHeader' => true,
        'format' => 'html',
        'label' => 'Image After',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'contentOptions' => [
            'style' => 'min-width: 250px;'
        ],
    ],

];
?>
<div class="giiant-crud audit-patrol-tbl-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>


    <div class="">
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
                Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'Add', ['create'], ['class' => 'btn btn-success']),
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


