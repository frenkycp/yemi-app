<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use app\models\PlanReceiving;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\PlanReceivingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Plan Receiving';
$this->params['breadcrumbs'][] = $this->title;

if (isset($actionColumnTemplates)) {
$actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']);
    $actionColumnTemplateString = "{view} {update} {delete}";
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';

$columns = [
    //['class' => 'yii\grid\SerialColumn'],

    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => $actionColumnTemplateString,
        'buttons' => [
            'view' => function ($url, $model, $key) {
                $options = [
                    'title' => 'View',
                    'aria-label' => 'View',
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
        'attribute' => 'month_periode',
        'label' => 'Periode',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '100px'
    ],
    [
        'attribute' => 'vendor_name',
        'vAlign' => 'middle',
    ],
    
    [
        'attribute' => 'qty',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '70px'
    ],
    [
        'attribute' => 'vehicle',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'item_type',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    
    [
        'attribute' => 'receiving_date',
        'label' => 'Plan Date',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'class'=>'kartik\grid\EditableColumn',
        'attribute' => 'eta_yemi_date',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'editableOptions'=> [
            'inputType'=>\kartik\editable\Editable::INPUT_DATE,
            'options' => [
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'yyyy-mm-dd'
                ]
            ],
        ]
    ],
    [
        'class'=>'kartik\grid\EditableColumn',
        'attribute' => 'unloading_time',
        'encodeLabel' => false,
        'label' => 'Unloading<br/>Time',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'editableOptions'=> [
            'inputType'=>\kartik\editable\Editable::INPUT_TIME,
            'options' => [
                'pluginOptions' => [
                    'showSeconds' => true,
                    'showMeridian' => false,
                    'minuteStep' => 1,
                    'secondStep' => 5,
                ]
            ]
        ]
    ],
    [
        'class'=>'kartik\grid\EditableColumn',
        'attribute' => 'completed_time',
        'encodeLabel' => false,
        'label' => 'Completed<br/>Time',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'editableOptions'=> [
            'inputType'=>\kartik\editable\Editable::INPUT_TIME,
            'options' => [
                'pluginOptions' => [
                    'showSeconds' => true,
                    'showMeridian' => false,
                    'minuteStep' => 1,
                    'secondStep' => 5,
                ]
            ]
        ]
    ],
    [
        'attribute' => 'urgent_status',
        'value' => function($model){
            $urgency = 'NORMAL';
            $label_class = 'label label-success';
            if ($model->urgent_status == 1) {
                $urgency = 'URGENT';
                $label_class = 'label label-danger';
            }
            return '<span class="' . $label_class . '">' . $urgency . '</span>';
        },
        'format' => 'raw',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filter' => [
            0 => 'NORMAL',
            1 => 'URGENT'
        ],
    ],
    [
        'attribute' => 'container_no',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
];

?>
<div class="plan-receiving-index">

    <p style="display: none;">
        <?= Html::a('Create Plan Receiving', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $columns,
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
                    Html::a('New', ['create'], ['data-pjax' => 0, 'class' => 'btn btn-success', 'title' => 'Visual Plan Receiving'])
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
                'heading' => 'Plan Receiving',
            ],
        ]); ?>
    </div>
</div>
