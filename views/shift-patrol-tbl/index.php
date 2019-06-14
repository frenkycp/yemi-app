<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\ShiftPatrolTblSearch $searchModel
*/

$this->title = [
    'page_title' => 'Shift 2 Daily Patrol <span class="japanesse text-green"></span>',
    'tab_title' => 'Shift 2 Daily Patrol',
    'breadcrumbs_title' => 'Shift 2 Daily Patrol'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("h1 .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }
    .disabled-link {color: DarkGrey; cursor: not-allowed;}");

$this->registerJs("$(function() {
   $('#btn-reject').click(function(e) {
     e.preventDefault();
     $('#common-modal').modal('show');
   });
   $('#btn-reply').click(function(e) {
     e.preventDefault();
     $('#common-modal').modal('show');
   });
   $('#btn-answer').click(function(e) {
     e.preventDefault();
     $('#common-modal').modal('show');
   });
   $('#btn-due-date').click(function(e) {
     e.preventDefault();
     $('#common-modal').modal('show');
   });
});");

$columns = [
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{update}&nbsp;&nbsp;{reject}&nbsp;&nbsp;{due_date}&nbsp;&nbsp;{close}<br/><span style="color: DarkGrey">------------------------</span><br/>{reply}&nbsp;&nbsp;&nbsp;{answer}',
        'buttons' => [
            'view' => function ($url, $model, $key) {
                $options = [
                    'title' => Yii::t('cruds', 'View'),
                    'aria-label' => Yii::t('cruds', 'View'),
                    'data-pjax' => '0',
                ];
                return Html::a('<span class="glyphicon glyphicon-file"></span>', $url, $options);
            }, 'update' => function ($url, $model, $key) {
                $options = [
                    'title' => Yii::t('cruds', 'Update'),
                    'aria-label' => Yii::t('cruds', 'Update'),
                    'data-pjax' => '0',
                ];
                if (($model->NIK == \Yii::$app->user->identity->username && $model->status != 1) || \Yii::$app->user->identity->role->id == 1) {
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, $options);
                } else {
                    return '<i class="glyphicon glyphicon-pencil disabled-link"></i>';
                }
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, $options);
            }, 'reply' => function($url, $model, $key){
                $options = [
                    'data-pjax' => '0',
                    'id' => 'btn-reply',
                    'value' => Url::to(['reply','id' => $model->id]),
                    'title' => 'Edit Cause & Countermeasure',
                    'class' => 'showModalButton'
                ];
                $karyawan = app\models\Karyawan::find()->where(['NIK' => \Yii::$app->user->identity->username])->one();
                if ($karyawan->DEPARTEMEN == $model->section_group && $model->status != 1) {
                    return Html::a('<i class="fa fa-fw fa-edit"></i>', '#', $options);
                } else {
                    return '<i class="fa fa-fw fa-edit disabled-link"></i>';
                }
                
            }, 'close' => function($url, $model, $key){
                $url = ['close', 'id' => $model->id];
                $options = [
                    'title' => 'Close',
                    'data-pjax' => '0',
                    'data-confirm' => 'Are yout sure to close this case ?'
                ];
                
                if ($model->status == 2 || $model->status == 4) {
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
                if ($model->status == 2 || $model->status == 4) {
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
                
            }, 'due_date' => function($url, $model, $key){
                $options = [
                    'data-pjax' => '0',
                    'id' => 'btn-due-date',
                    'value' => Url::to(['due-date','id' => $model->id]),
                    'title' => 'OK With Due Date',
                    'class' => 'showModalButton'
                ];
                //return Html::a('<i class="fa fa-fw fa-calendar-check-o"></i>', '#', $options);
                if ($model->status == 2 || $model->status == 4) {
                    return Html::a('<i class="fa fa-fw fa-calendar-check-o"></i>', '#', $options);
                } else {
                    return '<i class="fa fa-fw fa-calendar-check-o disabled-link"></i>';
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
        'attribute' => 'upload_file1',
        'label' => 'Gambar 1',
        'encodeLabel' => false,
        'value' => function($model){
            if ($model->img_filename1 != null) {
                //return Html::a(Html::img('@web/uploads/SHIFT_PATROL/' . $model->img_filename1, ['style' => 'height: 30px;']), Url::base(true) .'/uploads/SHIFT_PATROL/' . $model->img_filename1, ['target' => '_blank', 'data-pjax' => 0]);
                return Html::a('<i class="fa fa-fw fa-photo"></i><br>Before', Url::base(true) .'/uploads/SHIFT_PATROL/' . $model->img_filename1, ['target' => '_blank', 'data-pjax' => 0]);
            } else {
                return '-';
            }
        },
        'format' => 'raw',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        //'width' => '100px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 70px; font-size: 12px; text-align: center;',
        ],
    ],
    [
        'attribute' => 'upload_file2',
        'label' => 'Gambar 2',
        'encodeLabel' => false,
        'value' => function($model){
            if ($model->img_filename2 != null) {
                return Html::a('<i class="fa fa-fw fa-photo"></i><br/>After', Url::base(true) .'/uploads/SHIFT_PATROL/' . $model->img_filename2, ['target' => '_blank', 'data-pjax' => 0]);
            } else {
                return '-';
            }
        },
        'format' => 'raw',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        //'width' => '100px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 70px; font-size: 12px; text-align: center;',
        ],
    ],
    [
        'attribute' => 'patrol_type',
        'label' => '(+/-)',
        'value' => function($model){
            if ($model->patrol_type == 1) {
                //return Html::img('@web/uploads/ICON/icons8-thumbs-up-64.png', ['style' => 'height: 25px;']);
                return '<span style="font-size: 16px;" class="glyphicon glyphicon-thumbs-up text-green"></span>';
            } else {
                //return Html::img('@web/uploads/ICON/icons8-thumbs-down-64.png', ['style' => 'height: 25px;']);
                return '<span style="font-size: 16px;" class="glyphicon glyphicon-thumbs-down text-red"></span>';
            }
            //$tmp_arr = Yii::$app->params['shift_patrol_type'];
            //return $tmp_arr[$model->patrol_type];
        },
        'format' => 'raw',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        //'width' => '100px',
        'hiddenFromExport' => true,
        'filter' => Yii::$app->params['shift_patrol_type'],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px; text-align: center;',
        ],
    ],
    [
        'attribute' => 'penilaian',
        'value' => function($model){
            if ($model->patrol_type == 1) {
                return 'POSITIF';
            } else {
                return 'NEGATIF';
            }
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'hidden' => true,
    ],
    [
        'attribute' => 'case_no',
        'label' => 'No. Kasus',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '100px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 70px; font-size: 12px; text-align: center;',
        ],
    ],
    [
        'attribute' => 'patrol_time',
        'value' => function($model){
            return date('Y-m-d H:i', strtotime($model->patrol_time));
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '110px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 80px; font-size: 12px; text-align: center;',
        ],
    ],
    [
        'attribute' => 'NIK',
        'label' => 'PIC',
        'value' => function($model){
            return $model->NAMA_KARYAWAN;
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filter' => ArrayHelper::map(app\models\ShiftPatrolTbl::find()->select('NIK, NAMA_KARYAWAN')->groupBy('NIK, NAMA_KARYAWAN')->all(), 'NIK', 'NAMA_KARYAWAN'),
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 70px; font-size: 12px; text-align: center;',
        ],
    ],
    [
        'attribute' => 'location',
        'value' => function($model){
            if ($model->location_detail == null) {
                return $model->location;
            } else {
                return $model->location . ' (' . $model->location_detail . ')';
            }
        },
        //'hAlign' => 'center',
        'vAlign' => 'middle',
        'filter' => $location_arr,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 70px; font-size: 12px; text-align: center;',
        ],
    ],
    [
        'attribute' => 'category_id',
        'value' => function($model){
            if ($model->category_detail != null) {
                return $model->category->category_desc . ' (' . $model->category_detail . ')';
            } else {
                return $model->category->category_desc;
            }
            
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filter' => ArrayHelper::map(app\models\ShiftPatrolCategoryTbl::find()->where(['flag' => 1])->all(), 'id', 'category_desc'),
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 70px; font-size: 12px; text-align: center;',
        ],
    ],
    /*[
        'attribute' => 'time',
        'value' => function($model){
            return date('H:i', strtotime($model->patrol_time));
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '80px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 70px; font-size: 12px; text-align: center;',
        ],
    ],*/
    [
        'attribute' => 'description',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 150px; font-size: 12px; text-align: center;',
        ],
    ],
    [
        'attribute' => 'action',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 150px; font-size: 12px; text-align: center;',
        ],
    ],
    [
        'attribute' => 'cause',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 150px; font-size: 12px; text-align: center;',
        ],
    ],
    [
        'attribute' => 'countermeasure',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 150px; font-size: 12px; text-align: center;',
        ],
    ],
    [
        'attribute' => 'section_id',
        'value' => function($model){
            return $model->section_desc;
        },
        //'hAlign' => 'center',
        'vAlign' => 'middle',
        'filter' => $section_arr,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 100px; font-size: 12px; text-align: center;',
        ],
    ],
    [
        'attribute' => 'status',
        'value' => function($model){
            return $model->statusTbl->status_desc;
        },
        'format' => 'raw',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '80px',
        'filter' => ArrayHelper::map(app\models\IpqaStatusTbl::find()->orderBy('status_order ASC')->all(), 'status_id', 'status_desc'),
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 70px; font-size: 12px; text-align: center;',
        ],
    ],
    [
        'attribute' => 'reject_remark',
        'vAlign' => 'middle',
        //'format' => 'ntext',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 170px; font-size: 11px;',
        ],
    ],
    [
        'attribute' => 'reject_answer',
        'vAlign' => 'middle',
        //'format' => 'ntext',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 170px; font-size: 11px;',
        ],
    ],
    
];
?>
<div class="giiant-crud shift-patrol-tbl-index">

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
                } elseif ($model->status == 4) {
                    return ['class' => 'success text-red'];
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
                //'heading' => $heading,
                //'footer' => false,
            ],
        ]); 
        ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


