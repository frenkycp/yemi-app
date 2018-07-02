<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\web\View;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\WeeklyPlanSearch $searchModel
*/

//$this->title = 'Weekly Summary <span class="text-green">週次出荷（計画対実績）</span>';
$this->title = [
    'page_title' => 'Weekly Summary <span class="text-green">週次出荷表 (計画対実績)</span>',
    'tab_title' => 'Weekly Summary',
    'breadcrumbs_title' => 'Weekly Summary'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');

$this->registerCss("h1 span { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

/*$script = <<< JS
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();   
    });
JS;
$this->registerJs($script, View::POS_HEAD );*/

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
$totActualExport = 0;
$totPlanExport = 0;

$data = $dataProvider->getModels();
foreach ($data as $key => $value) {
    $totActual = $totActual + $value['actualQty'];
    $totPlan = $totPlan + $value['plan_qty'];
    $totActualExport += $value['actual_export'];
    $totPlanExport += $value['plan_export'];
}

$totPercentage = 0;
if($totPlan > 0)
{
    $totPercentage = round(($totActual / $totPlan) * 100, 1);
}

$totPercentageExport = 0;
if($totPlanExport > 0)
{
    $totPercentageExport = round(($totActualExport / $totPlanExport) * 100, 1);
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
        'mergeHeader' => true,
        'width' => '200px'
    ],
    [
        'attribute' => 'plan_qty',
        'hAlign' => 'center',
        'enableSorting' => false,
        'filter' => false,
        'pageSummary' => true,
        'format' => ['decimal',0],
        'vAlign' => 'middle',
        'mergeHeader' => true,
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
        'mergeHeader' => true,
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
        'mergeHeader' => true,
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
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'delayQty',
        'label' => 'Delay<br/>Qty',
        'encodeLabel' => false,
        'hAlign' => 'center',
        'pageSummary' => true,
        'format' => ['decimal',0],
        'vAlign' => 'middle',
        'mergeHeader' => true,
        'contentOptions' => [
            'class' => 'danger'
        ],
    ],
    [
        'attribute' => 'onTimeCompletion',
        'hAlign' => 'center',
        'label' => 'On-Time<br/>Completion',
        'encodeLabel' => false,
        //'pageSummary' => true,
        'vAlign' => 'middle',
        'mergeHeader' => true,
        'contentOptions' => [
            'class' => 'danger'
        ],
    ],
    [
        'attribute' => 'plan_export',
        'label' => 'Plan<br/>Export',
        'encodeLabel' => false,
        'hAlign' => 'center',
        'enableSorting' => false,
        'filter' => false,
        'pageSummary' => true,
        'format' => ['decimal',0],
        'vAlign' => 'middle',
        'mergeHeader' => true,
        'contentOptions' => [
            'class' => 'info'
        ],
    ],
    [
        'attribute' => 'actual_export',
        'label' => 'Actual<br/>Export',
        'encodeLabel' => false,
        'hAlign' => 'center',
        'enableSorting' => false,
        'filter' => false,
        'pageSummary' => true,
        'format' => ['decimal',0],
        'vAlign' => 'middle',
        'mergeHeader' => true,
        'contentOptions' => [
            'class' => 'info'
        ],
    ],
    [
        'attribute' => 'balance_export',
        'label' => 'Balance<br/>Export',
        'encodeLabel' => false,
        'hAlign' => 'center',
        'enableSorting' => false,
        'filter' => false,
        'pageSummary' => true,
        'format' => ['decimal',0],
        'vAlign' => 'middle',
        'mergeHeader' => true,
        'contentOptions' => [
            'class' => 'info'
        ],
    ],
    [
        'attribute' => 'percentage_export',
        //'value' => 'weekPercentageExport',
        'value' => function($model){
            if ($model->remark != null) {
                return '<abbr class="text-danger" title="' . $model->remark . '">' . $model->getWeekPercentageExport() . '</abbr>';
            }
            return $model->getWeekPercentageExport();
        },
        'format' => 'raw',
        'label' => 'Completion<br/>Export',
        'encodeLabel' => false,
        'hAlign' => 'center',
        'vAlign' => 'middle',
        //'format' => 'percent',
        'pageSummary' => $totPercentageExport . '%',
        //'enableSorting' => false,
        //'filter' => false,
        'mergeHeader' => true,
        'contentOptions' => [
            'class' => 'info'
        ],
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


