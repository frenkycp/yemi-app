<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\WeeklyPlanSearch $searchModel
*/

$this->title = Yii::t('app', 'Weekly Plans');
$this->params['breadcrumbs'][] = $this->title;

if (isset($actionColumnTemplates)) {
$actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']);
    $actionColumnTemplateString = "{view} {update} {delete}";
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';


$totActual = 0;
$totPlan = 0;
$data = $dataProvider->getModels();
foreach ($data as $key => $value) {
    $totActual = $totActual + $value['actualQty'];
    $totPlan = $totPlan + $value['plan_qty'];
}
$totPercentage = round(($totActual / $totPlan) * 100);
//$totPercentage = 98;
$columns = [
    /* [
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
    ], */
    [
        'attribute' => 'category',
        'hAlign' => 'center',
        'pageSummary' => 'Total',
    ],
    [
        'attribute' => 'period',
        'hAlign' => 'center'
    ],
    [
        'attribute' => 'week',
        'hAlign' => 'center'
    ],
    [
        'attribute' => 'plan_qty',
        'hAlign' => 'center',
        'enableSorting' => false,
        'filter' => false,
        'pageSummary' => true,
        'format' => ['decimal',0]
    ],
    [
        'attribute' => 'actual_qty',
        'value' => 'actualQty',
        'hAlign' => 'center',
        'enableSorting' => false,
        'filter' => false,
        'pageSummary' => true,
        'format' => ['decimal',0]
    ],
    [
        'attribute' => 'balance_qty',
        'value' => 'balanceQty',
        'hAlign' => 'center',
        'enableSorting' => false,
        'filter' => false,
        'pageSummary' => true,
        'format' => ['decimal',0]
    ],
    [
        'attribute' => 'percentage',
        'value' => 'weekPercentage',
        'label' => 'Completion',
        'hAlign' => 'center',
        'format' => 'percent',
        'pageSummary' => $totPercentage . '%',
        //'enableSorting' => false,
        //'filter' => false,
    ],
];

?>
<div class="giiant-crud weekly-plan-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <h1 style="display: none;">
        <?= Yii::t('app', 'Weekly Plans') ?>
        <small>
            List
        </small>
    </h1>
    <div class="clearfix crud-navigation" style="display: none;">
        <div class="pull-left">
            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']) ?>
        </div>

        <div class="pull-right">

                        
            <?= 
            \yii\bootstrap\ButtonDropdown::widget(
            [
            'id' => 'giiant-relations',
            'encodeLabel' => false,
            'label' => '<span class="glyphicon glyphicon-paperclip"></span> ' . 'Relations',
            'dropdown' => [
            'options' => [
            'class' => 'dropdown-menu-right'
            ],
            'encodeLabels' => false,
            'items' => [

]
            ],
            'options' => [
            'class' => 'btn-default'
            ]
            ]
            );
            ?>
        </div>
    </div>

    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $columns,
            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'pjax' => true, // pjax is set to always true for this demo
            'showPageSummary' => true,
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
            ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


