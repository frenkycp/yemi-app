<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use app\models\PlanReceiving;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\PlanReceivingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = [
    'page_title' => 'Plan Receiving <span class="japanesse text-green">(納入計画表)</span>',
    'tab_title' => 'Plan Receiving',
    'breadcrumbs_title' => 'Plan Receiving'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$this->registerCss(".japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

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
        //'width' => '100px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 70px;'
        ],
    ],
    [
        'attribute' => 'vendor_name',
        'vAlign' => 'middle',
        'pageSummary' => 'Total',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    
    [
        'attribute' => 'qty',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '70px',
        'pageSummary' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'vehicle',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filter' => ArrayHelper::map(app\models\Vehicle::find()->select('DISTINCT(name)')->where([
            'flag' => 1
        ])->orderBy('name')->all(), 'name', 'name'),
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'item_type',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filter' => ArrayHelper::map(app\models\ItemUnit::find()->select('DISTINCT(name)')->where([
            'flag' => 1
        ])->orderBy('name')->all(), 'name', 'name'),
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'receiving_date',
        'label' => 'Plan Date',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 80px;'
        ],
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
                ],
            ],
            'contentOptions' => [
                'style' => 'min-width: 80px;'
            ],
        ],
    ],
    [
        'attribute' => 'cut_off_date',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'etd_port_date',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'eta_port_date',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 80px;'
        ],
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
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'container_no',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'bl_no',
        'label' => 'BL No.',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'created_date',
        'label' => 'Created Date',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'created_by',
        'label' => 'Created By',
        'value' => function($model){
            if ($model->created_by != null) {
                $user = app\models\User::findIdentity($model->created_by);
                return $user->name;
            }
            return '-';
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'last_modified_date',
        'label' => 'Last Modified<br/>Date',
        'encodeLabel' => false,
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'last_modified_by',
        'label' => 'Last Modified<br/>By',
        'encodeLabel' => false,
        'value' => function($model){
            if ($model->last_modified_by != null) {
                $user = app\models\User::findIdentity($model->last_modified_by);
                return $user->name;
            }
            return '-';
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
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
            'showPageSummary' => true,
            //'condensed' => true,
            'striped' => true,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto; font-size: 11px;'], // only set when $responsive = false
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
