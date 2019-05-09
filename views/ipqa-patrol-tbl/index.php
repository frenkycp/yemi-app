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
    'page_title' => 'IPQA Daily Patrol <span class="japanesse text-green"></span>',
    'tab_title' => 'IPQA Daily Patrol',
    'breadcrumbs_title' => 'IPQA Daily Patrol'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("h1 .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }
    .disabled-link {color: DarkGrey; cursor: not-allowed;}");

date_default_timezone_set('Asia/Jakarta');

$this->registerJs("$(function() {
   $('.btn-reject').click(function(e) {
     e.preventDefault();
     $('#common-modal').modal('show');
   });
   $('.btn-answer').click(function(e) {
     e.preventDefault();
     $('#common-modal').modal('show');
   });
});");

$columns = [
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{update}&nbsp;&nbsp;&nbsp;{delete}&nbsp;&nbsp;&nbsp;{reject}&nbsp;&nbsp;&nbsp;{close}<hr/>{reply}&nbsp;&nbsp;&nbsp;{answer}',
        'buttons' => [
            'view' => function ($url, $model, $key) {
                $options = [
                    'title' => Yii::t('cruds', 'View'),
                    'aria-label' => Yii::t('cruds', 'View'),
                    'data-pjax' => '0',
                ];
                return Html::a('<span class="glyphicon glyphicon-file"></span>', $url, $options);
            }, 'reply' => function($url, $model, $key){
                $url = ['reply', 'id' => $model->id];
                $options = [
                    'title' => 'Edit Cause & Countermeasure',
                    'data-pjax' => '0',
                ];
                $karyawan = app\models\Karyawan::find()->where(['NIK' => \Yii::$app->user->identity->username])->one();
                if ($karyawan->DEPARTEMEN == $model->CC_GROUP) {
                    return Html::a('<i class="fa fa-fw fa-edit"></i>', $url, $options);
                } else {
                    return '<i class="fa fa-fw fa-edit disabled-link"></i>';
                }
                
            }, 'close' => function($url, $model, $key){
                $url = ['close', 'id' => $model->id];
                $options = [
                    'title' => 'Close',
                    'data-pjax' => '0',
                    'data-confirm' => 'Are yout sure to close this problem ?'
                ];
                
                if ($model->status == 2) {
                    return Html::a('<i class="fa fa-fw fa-check"></i>', $url, $options);
                } else {
                    return '<i class="fa fa-fw fa-check disabled-link"></i>';
                }
            }, 'reject' => function($url, $model, $key){
                $options = [
                    'data-pjax' => '0',
                    'id' => 'btn-reject',
                    'value' => Url::to(['reject','id' => $model->id]),
                    'title' => 'Reject Data',
                    'class' => 'showModalButton'
                ];
                if ($model->status == 2) {
                    return Html::a('<i class="fa fa-fw fa-ban"></i>', '#', $options);
                } else {
                    return '<i class="fa fa-fw fa-ban disabled-link"></i>';
                }
                
            }, 'answer' => function($url, $model, $key){
                $options = [
                    'data-pjax' => '0',
                    'id' => 'btn-answer',
                    'value' => Url::to(['answer','id' => $model->id]),
                    'title' => 'Reject Answer',
                    'class' => 'showModalButton'
                ];
                $karyawan = app\models\Karyawan::find()->where(['NIK' => \Yii::$app->user->identity->username])->one();
                if ($model->status == 3 && $karyawan->DEPARTEMEN == $model->CC_GROUP) {
                    return Html::a('<i class="fa fa-fw fa-commenting"></i>', '#', $options);
                } else {
                    return '<i class="fa fa-fw fa-commenting disabled-link"></i>';
                }
                
            },
        ],
        'urlCreator' => function($action, $model, $key, $index) {
            // using the column name as key, not mapping to 'id' like the standard generator
            $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
            $params[0] = \Yii::$app->controller->id ? \Yii::$app->controller->id . '/' . $action : $action;
            return Url::toRoute($params);
        },
        'contentOptions' => ['nowrap'=>'nowrap', 'style' => 'min-width: 100px;'],
    ],
    [
        'attribute' => 'filename1',
        'label' => 'Attch.',
        'mergeHeader' => true,
        'value' => function($model){
            if ($model->filename1 == null) {
                return '-';
            } else {
                return Html::a('<i class="fa fa-fw fa-file-image-o"></i>', Url::to('@web/uploads/IPQA_PATROL/' . $model->filename1), ['target' => '_blank', 'data-pjax' => '0',]);
            }
        },
        'format' => 'raw',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'hiddenFromExport' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 50px; font-size: 12px;',
        ],
    ],
    /**/[
        'attribute' => 'period',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '70px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 70px; font-size: 12px; text-align: center;',
        ],
    ],
    [
        'attribute' => 'event_date',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '100px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 70px; font-size: 12px; text-align: center;',
        ],
    ],
    [
        'attribute' => 'child',
        'label' => 'Part Numb.',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '90px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 70px; font-size: 12px; text-align: center;',
        ],
    ],
    [
        'attribute' => 'child_desc',
        'label' => 'Description',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 110px; font-size: 12px; text-align: center;',
        ],
    ],
    /*[
        'attribute' => 'color',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '50px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 50px; font-size: 12px; text-align: center;',
        ],
    ],
    [
        'attribute' => 'destination',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '40px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 40px; font-size: 12px; text-align: center;',
        ],
    ],*/
    [
        'attribute' => 'category',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '120px',
        'filter' => ArrayHelper::map(app\models\IpqaCategoryTbl::find()->select('category')->groupBy('category')->orderBy('category')->all(), 'category', 'category'),
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 70px; font-size: 12px; text-align: center;',
        ],
    ],
    [
        'attribute' => 'problem',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 120px; font-size: 12px;',
        ],
    ],
    [
        'attribute' => 'description',
        'vAlign' => 'middle',
        //'format' => 'ntext',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 170px; font-size: 12px;',
        ],
    ],
    [
        'attribute' => 'CC_ID',
        'label' => 'Section',
        'value' => function($model){
            if ($model->CC_ID != null) {
                return $model->costCenter->CC_DESC;
            } else {
                return '-';
            }
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '100px',
        'filter' => ArrayHelper::map(app\models\CostCenter::find()->select('CC_ID, CC_DESC')->groupBy('CC_ID, CC_DESC')->orderBy('CC_DESC')->all(), 'CC_ID', 'CC_DESC'),
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 80px; font-size: 12px; text-align: center;',
        ],
    ],
    [
        'attribute' => 'inspector_name',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 60px; font-size: 12px;',
        ],
    ],
    [
        'attribute' => 'status',
        'value' => function($model){
            return $model->statusTbl->status_desc;
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filter' => ArrayHelper::map(app\models\IpqaStatusTbl::find()->orderBy('status_order ASC')->all(), 'status_id', 'status_desc'),
        'width' => '110px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 80px; font-size: 12px; text-align: center;',
        ],
    ],
    [
        'attribute' => 'cause',
        'vAlign' => 'middle',
        'format' => 'ntext',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 170px; font-size: 12px;',
        ],
    ],
    [
        'attribute' => 'countermeasure',
        'vAlign' => 'middle',
        'format' => 'ntext',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 170px; font-size: 12px;',
        ],
    ],
    [
        'attribute' => 'reject_remark',
        'vAlign' => 'middle',
        'format' => 'ntext',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 170px; font-size: 12px;',
        ],
    ],
    [
        'attribute' => 'reject_answer',
        'vAlign' => 'middle',
        'format' => 'ntext',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 170px; font-size: 12px;',
        ],
    ],
    [
        'attribute' => 'input_datetime',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 70px; font-size: 12px;',
        ],
    ],
    [
        'attribute' => 'close_datetime',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 70px; font-size: 12px;',
        ],
    ],
    [
        'attribute' => 'line_pic',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 60px; font-size: 12px;',
        ],
    ],
];
?>

<div class="giiant-crud ipqa-patrol-tbl-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <div class="">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $columns,
            'hover' => true,
            //'condensed' => true,
            'striped' => true,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto; font-size: 12px;'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'pjax' => false, // pjax is set to always true for this demo
            'toolbar' =>  [
                Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'Add', ['create'], ['class' => 'btn btn-success']),
                '{export}',
                '{toggleData}',
            ],
            'rowOptions' => function($model){
                if ($model->status == 0) {
                    return ['class' => 'danger'];
                } elseif ($model->status == 2) {
                    return ['class' => 'warning'];
                } elseif ($model->status == 3) {
                    return ['class' => 'danger text-red'];
                } else {
                    return ['class' => ''];
                }
            },
            // set export properties
            'export' => [
                'fontAwesome' => true
            ],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => $heading,
                'before' => Html::a('READ ME FIRST ...!', Url::to('@web/uploads/daily_patrol_readme.pdf'), [
                    'target' => '_blank',
                    'class' => 'btn btn-danger'
                ]),
                //'footer' => false,
            ],
        ]); 
        ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


