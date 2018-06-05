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
        'attribute' => 'vehicle',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'item_type',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'qty',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'receiving_date',
        'vAlign' => 'middle',
    ],
];

?>
<div class="plan-receiving-index">

    <p>
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
                    Html::a('New', ['create'], ['data-pjax' => 0, 'class' => 'btn btn-success', 'title' => Yii::t('kvgrid', 'Visual Plan Receiving')])
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
