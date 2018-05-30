<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\WeeklyPlanSearch $searchModel
*/

$this->title = Yii::t('app', 'Weekly Summary');
$this->params['breadcrumbs'][] = $this->title;

date_default_timezone_set('Asia/Jakarta');

function weekOfMonth($date) {
    // estract date parts
    list($y, $m, $d) = explode('-', date('Y-m-d', strtotime($date)));

    // current week, min 1
    $w = 1;

    // for each day since the start of the month
    for ($i = 1; $i <= $d; ++$i) {
        // if that day was a sunday and is not the first day of month
        if ($i > 1 && date('w', strtotime("$y-$m-$i")) == 0) {
            // increment current week
            ++$w;
        }
    }

    // now return
    return $w;
}



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

$totPercentage = 0;
if($totPlan > 0)
{
    $totPercentage = round(($totActual / $totPlan) * 100, 1);
}

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
    /* [
        'attribute' => 'category',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ], */
    [
        'attribute' => 'period',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'week',
        'value' => function($model)
        {
            $week = $model->week;
            return '<b>Week-' . $week;
        },
        'format' => 'raw',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'week_range',
        'label' => 'ETD - SUB',
        'value' => function($model)
        {
            $week = $model->week;
            $start_date = date('d M Y', strtotime($model->weekStartDate));
            $end_date = date('d M Y', strtotime($model->weekEndDate));
            return $start_date . ' - ' . $end_date;
        },
        'format' => 'raw',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'pageSummary' => 'Total',
    ],
    [
        'attribute' => 'plan_qty',
        'hAlign' => 'center',
        'enableSorting' => false,
        'filter' => false,
        'pageSummary' => true,
        'format' => ['decimal',0],
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'actual_qty',
        'value' => 'actualQty',
        'hAlign' => 'center',
        'enableSorting' => false,
        'filter' => false,
        'pageSummary' => true,
        'format' => ['decimal',0],
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'balance_qty',
        'value' => 'balanceQty',
        'hAlign' => 'center',
        'enableSorting' => false,
        'filter' => false,
        'pageSummary' => true,
        'format' => ['decimal',0],
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'percentage',
        'value' => 'weekPercentage',
        'label' => 'Completion',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        //'format' => 'percent',
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
                'heading' => 'Last update : ' . date('d M Y H:i:s')
            ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


