<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\HrComplaintSearch $searchModel
*/

$this->title = [
    'page_title' => 'My BPJS <small class="">Question & Answer (BPJS Kesehatan & BPJS Ketenagakerjaan)</small>',
    'tab_title' => 'My BPJS',
    'breadcrumbs_title' => 'My BPJS'
];

$gridColumns = [
    /*[
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
    ],*/
    [
        'attribute' => 'input_datetime',
        'label' => 'Input Datetime',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '130px',
        'value' => function($model){
            if ($model->input_datetime == null) {
                return '-';
            } else {
                return date('Y-m-d H:i', strtotime($model->input_datetime));
            }
        },
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
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
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'response_datetime',
        'label' => 'Answer Datetime',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '130px',
        'value' => function($model){
            if ($model->response_datetime == null) {
                return '-';
            } else {
                return date('Y-m-d H:i', strtotime($model->response_datetime));
            }
        },
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
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
            'style' => 'font-size: 12px;'
        ],
    ],
]
?>
<div class="giiant-crud hr-complaint-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <div class="">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $gridColumns,
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
                [
                    'content' => Html::a('New', ['my-hr/create-bpjs', 'category' => $_GET['category']], ['data-pjax' => 0, 'class' => 'btn btn-success pull-left'])
                ],
                [
                    'content' => Html::a('Back', ['my-hr/index'], ['data-pjax' => 0, 'class' => 'btn btn-warning'])
                ],
                //'{export}',
                '{toggleData}',
            ],
            // set export properties
            'export' => [
                'fontAwesome' => true
            ],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'before' => '<em><span class="text-red" style="font-size: 1.4em;">* Untuk fast response, silakan menghubungi <b>Ibu Jeli</b> <u>(08119421088)</u> atau <b>Ibu Anggra</b> <u>(081519691007)</u></span></em>',
                'heading' => ''
            ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>