<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\HrFacilitySearch $searchModel
*/

$this->title = [
    'page_title' => 'Question & Answer (FACILITY) <small class="japanesse text-green"></small>',
    'tab_title' => 'Question & Answer (FACILITY)',
    'breadcrumbs_title' => 'Question & Answer (FACILITY)'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss(".japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

$grid_columns = [
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{add-response}',
        'buttons' => [
            'view' => function ($url, $model, $key) {
                $options = [
                    'title' => Yii::t('cruds', 'View'),
                    'aria-label' => Yii::t('cruds', 'View'),
                    'data-pjax' => '0',
                ];
                return Html::a('<span class="glyphicon glyphicon-file"></span>', $url, $options);
            }, 'add-response' => function($url, $model, $key){
                $url = ['add-response', 'id' => $model->id];
                $options = [
                    'title' => 'Add Response',
                    'data-pjax' => '0',
                ];
                return Html::a('<span class="fa fa-reply"></span>', $url, $options);
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
        'attribute' => 'img_filename',
        'label' => 'Pict.',
        'encodeLabel' => false,
        'value' => function($model){
            if ($model->img_filename != null) {
                return Html::a('<i class="fa fa-fw fa-photo"></i>', Url::base(true) .'/uploads/MY FACILITY/' . $model->img_filename, ['target' => '_blank', 'data-pjax' => 0]);
            } else {
                return '-';
            }
        },
        'format' => 'raw',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'mergeHeader' => true,
        //'width' => '100px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 70px; font-size: 12px; text-align: center;',
        ],
    ],
    [
        'attribute' => 'remark_category',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'label' => '(+/-)',
        'filter' => [
            1 => 'POSITIF',
            0 => 'NEGATIF'
        ],
        'value' => function($model){
            if ($model->remark_category == 1) {
                //return Html::img('@web/uploads/ICON/icons8-thumbs-up-64.png', ['style' => 'height: 25px;']);
                return '<span style="font-size: 16px;" class="glyphicon glyphicon-thumbs-up text-green"></span>';
            } else {
                //return Html::img('@web/uploads/ICON/icons8-thumbs-down-64.png', ['style' => 'height: 25px;']);
                return '<span style="font-size: 16px;" class="glyphicon glyphicon-thumbs-down text-red"></span>';
            }
        },
        'format' => 'raw',
        'width' => '70px;',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'period',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '80px;',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'input_datetime',
        'label' => 'Question<br/>Datetime',
        'encodeLabel' => false,
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '80px',
        'value' => function($model){
            if ($model->input_datetime == null) {
                return '-';
            } else {
                return date('Y-m-d H:i', strtotime($model->input_datetime));
            }
        },
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'response_datetime',
        'label' => 'Answered<br/>Datetime',
        'encodeLabel' => false,
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '80px',
        'value' => function($model){
            if ($model->response_datetime == null) {
                return '-';
            } else {
                return date('Y-m-d H:i', strtotime($model->response_datetime));
            }
        },
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'nik',
        'label' => 'NIK',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '80px;',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'emp_name',
        'label' => 'Name',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'dept',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'section',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'status',
        'value' => function($model){
            if ($model->status == 0) {
                return '<span class="label label-warning">WAITING</span>';
            } elseif($model->status == 1) {
                return '<span class="label label-success">ANSWERED</span>';
            }
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'format' => 'html',
        'width' => '120px;',
        'filter' => [
            0 => 'WAITING',
            1 => 'ANSWERED'
        ],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;  min-width: 90px;'
        ],
    ],
    [
        'attribute' => 'remark',
        'label' => 'Question',
        'vAlign' => 'middle',
        'format' => 'ntext',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'response',
        'label' => 'Answer',
        'vAlign' => 'middle',
        'format' => 'ntext',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ]
];
?>
<div class="giiant-crud hr-facility-index">

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
            //'showPageSummary' => true,
            //'condensed' => true,
            'striped' => true,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto; font-size: 12px;'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'pjax' => true, // pjax is set to always true for this demo
            'toolbar' =>  [
                '{export}',
                '{toggleData}',
            ],
            // set export properties
            'export' => [
                'fontAwesome' => true
            ],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => ''
            ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


