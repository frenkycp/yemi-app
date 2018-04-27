<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\export\ExportMenu;
//use kartik\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\web\View;
use miloschuman\highcharts\Highcharts;
use scotthuangzl\googlechart\GoogleChart;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\JobOrderSearch $searchModel
*/

$this->title = Yii::t('app', 'Job Orders Summary');
$this->params['breadcrumbs'][] = $this->title;

if (isset($actionColumnTemplates)) {
$actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']);
    $actionColumnTemplateString = "{view} {update} {delete}";
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';



$gridColumn = [
    /* [
        'class' => 'yii\grid\ActionColumn',
        'template' => $actionColumnTemplateString,
        'buttons' => [
            'view' => function ($url, $model, $key) {
                $options = [
                    'title' => Yii::t('yii', 'View'),
                    'aria-label' => Yii::t('yii', 'View'),
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
        'attribute' => 'MODEL',
        //'hAlign' => 'center',
        //'headerOptions' => ['style' => 'text-align: center;'],
        'vAlign' => 'middle',
        'enableSorting' => false,
    ],
    [
        'attribute' => 'ITEM_DESC',
        'label' => 'Description',
        //'hAlign' => 'center',
        //'headerOptions' => ['style' => 'text-align: center;'],
        'vAlign' => 'middle',
        'enableSorting' => false,
    ],
    [
        'attribute' => 'DESTINATION',
        //'hAlign' => 'center',
        //'headerOptions' => ['style' => 'text-align: center;'],
        'vAlign' => 'middle',
        'enableSorting' => false,
    ],
    [
        'attribute' => 'LOC_DESC',
        'value' => 'LOC_DESC',
        //'hAlign' => 'center',
        //'headerOptions' => ['style' => 'text-align: center;'],
        'vAlign' => 'middle',
        'enableSorting' => false,
    ],
    [
        'attribute' => 'SCH_DATE',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'format' => ['date', 'php:d-M-Y'],
        'enableSorting' => false,
    ],
    [
        'attribute' => 'ORDER_QTY',
        'value' => 'ORDER_QTY',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'enableSorting' => false,
    ],
    [
        'attribute' => 'COMMIT_QTY',
        'value' => 'COMMIT_QTY',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'enableSorting' => false,
    ],
    [
        'attribute' => 'OPEN_QTY',
        'value' => 'OPEN_QTY',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'enableSorting' => false,
    ],
    [
        'attribute' => 'DANDORI',
        'value' => 'DANDORI',
        'label' => 'Dandori (Minute)',
        'contentOptions' => [
            'style' => 'width: 100px; white-space: normal;'
        ],
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'enableSorting' => false,
    ],
    [
        'attribute' => 'LOST_TIME',
        'label' => 'Lost (Minute)',
        'value' => 'LOST_TIME',
        'contentOptions' => [
            'style' => 'width: 100px; white-space: normal;'
        ],
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'enableSorting' => false,
    ],
    [
        'attribute' => 'NOTE',
        'value' => function($model){
            return ucwords(strtolower($model->NOTE));
        },
        'headerOptions' => ['style' => 'text-align: center;'],
        //'hAlign' => 'center',
        'vAlign' => 'middle',
        'enableSorting' => false,
    ],
    [
        'attribute' => 'progress_bar',
        'label' => 'Status',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'contentOptions' => [
            'style' => 'width: 100px; white-space: normal;'
        ],
        'format' => 'raw',
        'hiddenFromExport' => true,
        'value' => function($model){
            $orderQty = $model->ORDER_QTY;
            $commitQty = $model->COMMIT_QTY;
            $percent = 0;
            if($orderQty != 0)
            {
                $percent = round(($commitQty/$orderQty)*100);
            }
            if($percent == 0)
            {
                $percent = 99;
            }
            $class_bar = '';
            //$completeText = '';
            $completeText = $model->STAGE;
            $completeText = substr($completeText,3);
            $class_bar = 'warning progress-bar-striped';
            if($percent < 50)
            {
                $class_bar = 'danger progress-bar-striped';
            }
            else if($percent < 100)
            {
                $class_bar = 'warning progress-bar-striped';
            }
            else
            {
                $class_bar = 'success';
                $completeText = 'Completed';
            }

            $completeText = ucwords(strtolower($completeText));
            
            $progress_bar = '<div class="progress active">
                                <div class="progress-bar progress-bar-' . $class_bar .'" style="width: ' . $percent . '%">' . $completeText .'</div>
                            </div>';
            return $progress_bar;
        },
    ],
    /* [
        'attribute' => 'progress_badge',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'label' => '',
        'format' => 'raw',
        'hiddenFromExport' => true,
        'value' => function($model){
            $orderQty = $model->ORDER_QTY;
            $commitQty = $model->COMMIT_QTY;
            $percent = ($commitQty/$orderQty)*100;

            if($percent < 50)
            {
                $class_badge = 'bg-red';
            }
            else if($percent < 100)
            {
                $class_badge = 'bg-yellow';
            }
            else
            {
                $class_badge = 'bg-green';
            }

            $progress_bar = '<span class="badge ' . $class_badge . '">' . round($percent) .'%</span>';
            return $progress_bar;
        },
    ], */
];

/* $fullExportMenu = ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    'target' => ExportMenu::TARGET_BLANK,
    'fontAwesome' => true,
    'asDropdown' => false, // this is important for this case so we just need to get a HTML list    
    'dropdownOptions' => [
        'label' => '<i class="glyphicon glyphicon-export"></i> Full'
    ],
]); */

$script = <<< JS
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout("refreshPage();", 60000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
JS;
$this->registerJs($script, View::POS_HEAD );
?>
<div class="giiant-crud job-order-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <h1 style="display: none;">
        <?= Yii::t('app', 'Job Orders') ?>
        <small>
            List
        </small>
    </h1>
    <div class="clearfix crud-navigation" style="display: none;">
        <div class="pull-left">
            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']) ?>
        </div>

        <div class="pull-right">

                        
            <?= '';
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

    <!-- <hr /> -->
    <?php
    $dp = $dataProvider->getModels();
    $orderQty = 0;
    $commitQty = 0;
    if($dataProvider->getCount() > 0)
    {
        foreach ($dp as $value) {
            $orderQty += $value->ORDER_QTY;
            $commitQty += $value->COMMIT_QTY;
        }
        $percentage = round(($commitQty/$orderQty)*100);
    }
    ?>

    <?php
    /* echo Highcharts::widget([
        'options' => [
            'chart' => [
                'type' => 'solidgauge'
            ],

            'title' => null,

            'pane' => [
                'center' => ['50%', '85%'],
                'size' => '140%',
                'startAngle' => -90,
                'endAngle' => 90,
                'background' => [
                    'backgroundColor' => (Highcharts.theme && Highcharts.theme.background2) || '#EEE',
                    'innerRadius' => '60%',
                    'outerRadius' => '100%',
                    'shape' => 'arc'
                ]
            ],

            'tooltip' => [
                'enabled' => false
            ],

            // the value axis
            'yAxis' => [
                'min' => 0,
                'max' => 200,
                'title' => [
                    'text' => 'Speed'
                ],
                'stops' => [
                    [0.1, '#55BF3B'], // green
                    [0.5, '#DDDF0D'], // yellow
                    [0.9, '#DF5353'] // red
                ],
                'lineWidth' => 0,
                'minorTickInterval' => null,
                'tickAmount' => 2,
                'title' => [
                    'y' => -70
                ],
                'labels' => [
                    'y' => 16
                ]
            ],
            'credits' => [
                'enabled' => false
            ],
            'plotOptions' => [
                'solidgauge' => [
                    'dataLabels' => [
                        'y' => 5,
                        'borderWidth' => 0,
                        'useHTML' => true
                    ]
                ]
            ],
            'series' => [[
                'name' => 'Speed',
                'data' => [80],
                'dataLabels' => [
                    'format' => '<div style="text-align:center"><span style="font-size:25px;color:' .
                        ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') . '">[y]</span><br/>' .
                           '<span style="font-size:12px;color:silver">km/h</span></div>'
                ],
                'tooltip' => [
                    'valueSuffix' => ' km/h'
                ]
            ]]
        ]
    ]); */
    ?>

    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'responsiveWrap' => false,
            'bordered' => true,
            'condensed' => true,
            'responsive' => true,
            'hover' => true,
            'panel' => [
            'type' => 'primary',
            'heading' => Html::a('Today', Url::to(['index']), ['data-pjax' => 0, 'class' => 'btn btn-sm', 'style' => 'background-color: #00c0ef;']) . 
                '&nbsp;&nbsp;' . Html::a('This Month', Url::to(['index', 'index_type' => 1]), ['data-pjax' => 0, 'class' => 'btn btn-sm', 'style' => 'background-color: #00c0ef;']) . '&nbsp;&nbsp;' 
                /* . ExportMenu::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $gridColumns,
                    'showColumnSelector' => false,
                    //'hiddenColumns'=>[0, 9], // SerialColumn & ActionColumn
                    //'disabledColumns'=>[1, 2], // ID & Name
                    'fontAwesome' => true,
                    'target' => '_self',
                    'filename' => 'SMT Report',
                    'dropdownOptions' => [
                        'label' => 'Export All',
                        'class' => 'btn btn-default btn-sm'
                    ]
                ]) */,
            //'footer' => false,
            'before' => false
        ],
        'beforeHeader'=>[
        [
        'columns'=>[
        ['content' => GoogleChart::widget( array('visualization' => 'Gauge', 'packages' => 'gauge',
                            'data' => array(
                                array('Label', 'Value'),
                                array('Total(%)', $percentage)
                            ),
                            'options' => array(
                                'width' => 400,
                                'height' => 120,
                                'redFrom' => 0,
                                'redTo' => 30,
                                'yellowFrom' => 30,
                                'yellowTo' => 60,
                                'greenFrom' => 60,
                                'greenTo' => 100,
                                'minorTicks' => 5
                            )
                        )), 'options'=>['colspan'=>4]],
        ],
        'options'=>['class'=>'skip-export'] // remove this row from export
        ]
    ],
        'toolbar' => [
            //'{export}',
        ],
        /* 'export' => [
            'fontAwesome' => true,
            'itemsAfter'=> [
                '<li role="presentation" class="divider"></li>',
                '<li class="dropdown-header">Export All Data</li>',
                $fullExportMenu
            ],
        ], */
        
        'columns' => $gridColumn,
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


