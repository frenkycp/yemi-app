<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\HrComplaintSearch $searchModel
*/

$this->title = 'Question & Answer (with ' . $_GET['category'] . ')';
$this->params['breadcrumbs'][] = $this->title;

if (isset($actionColumnTemplates)) {
$actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']);
    $actionColumnTemplateString = "{view} {update} {delete}";
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';

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
                    'content' => Html::a('New Report', ['my-hr/create-laporan', 'category' => $_GET['category']], ['data-pjax' => 0, 'class' => 'btn btn-success pull-left'])
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
                'heading' => ''
            ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>