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

$columns = [
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{update}',
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
                if ($model->NIK == \Yii::$app->user->identity->username) {
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, $options);
                } else {
                    return '<i class="glyphicon glyphicon-pencil disabled-link"></i>';
                }
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, $options);
            }
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
                return Html::a(Html::img('@web/uploads/SHIFT_PATROL/' . $model->img_filename1, ['style' => 'height: 30px;']), Url::base(true) .'/uploads/SHIFT_PATROL/' . $model->img_filename1, ['target' => '_blank', 'data-pjax' => 0]);
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
                return Html::a(Html::img('@web/uploads/SHIFT_PATROL/' . $model->img_filename2, ['style' => 'height: 30px;']), Url::base(true) .'/uploads/SHIFT_PATROL/' . $model->img_filename2, ['target' => '_blank', 'data-pjax' => 0]);
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
        'width' => '100px',
        'hiddenFromExport' => true,
        'filter' => Yii::$app->params['shift_patrol_type'],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 70px; font-size: 12px; text-align: center;',
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
        'attribute' => 'patrol_time',
        'value' => function($model){
            return date('Y-m-d', strtotime($model->patrol_time));
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '100px',
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
    [
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
        'attribute' => 'section_desc',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 100px; font-size: 12px; text-align: center;',
        ],
    ],
    [
        'attribute' => 'status',
        'value' => function($model){
            if ($model->status == 0) {
                return 'OPEN';
            } elseif ($model->status == 10) {
                return 'CLOSED';
            } else {
                return '-';
            }
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '80px',
        'filter' => [
            0 => 'OPEN',
            10 => 'CLOSED'
        ],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 70px; font-size: 12px; text-align: center;',
        ],
    ],
    [
        'attribute' => 'NIK',
        'label' => 'PIC',
        'value' => function($model){
            return $model->NIK . ' - ' . $model->NAMA_KARYAWAN;
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 70px; font-size: 12px; text-align: center;',
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


