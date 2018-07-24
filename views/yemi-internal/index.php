<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\web\View;
use app\models\SernoOutput;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\SernoOutput $searchModel
*/
$status = '';
if(isset($_GET['index_type']))
{
    if($_GET['index_type'] == 1)
    {
        $status = ' (Open)';
    }
    if($_GET['index_type'] == 2)
    {
        $status = ' (Closed)';
    }
}

$totActual = 0;
$totPlan = 0;
/*$data = $dataProvider->models;
foreach ($data as $key => $value) {
    $totActual = $totActual + $value['output'];
    $totPlan = $totPlan + $value['qty'];
}*/

$this->title = [
    'page_title' => 'Monthly Production Schedule (月次生産計画)',
    'tab_title' => 'Monthly Production Schedule',
    'breadcrumbs_title' => 'Monthly Production Schedule'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("h1 { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

$this->registerCss(".tab-content > .tab-pane,
.pill-content > .pill-pane {
    display: block;     
    height: 0;          
    overflow-y: hidden; 
}

.tab-content > .active,
.pill-content > .active {
    height: auto;       
} ");

$script = <<< JS
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout("refreshPage();", 600000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
JS;
$this->registerJs($script, View::POS_HEAD );

if (isset($actionColumnTemplates)) {
$actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']);
    //$actionColumnTemplateString = "{view} {update} {delete}";
    $actionColumnTemplateString = "{edit}";
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';

$main_link = ['/yemi-internal-summary/index'];
if(isset($_GET['dst']))
{
    $main_link = ['container-progress', 'etd' => $_GET['etd']];
}

$progress = [
    $monthly_total_plan == 0 ? 0 : round(($monthly_total_plan / $monthly_total_plan) * 100, 2),
    $monthly_total_plan == 0 ? 0 : round(($monthly_progress_plan / $monthly_total_plan) * 100, 2),
    $monthly_total_plan == 0 ? 0 : round(($monthly_progress_output / $monthly_total_plan) * 100, 2),
    $monthly_progress_plan == 0 ? 0 : round(($monthly_progress_delay / $monthly_progress_plan) * 100),
];

$gridColumns = [
    /*[
        'class' => '\kartik\grid\SerialColumn',
        'width' => '30px',
    ],*/
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
            },
            'edit' => function ($url, $model, $key) {
                $options = [
                    'title' => Yii::t('cruds', 'Update Data'),
                    'data-pjax' => '0',
                    'class' => 'btn btn-success btn-xs'
                ];
                return Html::a('Edit', Url::to(['update', 'pk' => $model->pk]), $options);
            }
        ],
        'urlCreator' => function($action, $model, $key, $index) {
            // using the column name as key, not mapping to 'id' like the standard generator
            $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
            $params[0] = \Yii::$app->controller->id ? \Yii::$app->controller->id . '/' . $action : $action;
            return Url::toRoute($params);
        },
        'contentOptions' => ['nowrap'=>'nowrap'],
        'vAlign' => 'middle',
        'width' => '60px',
        'hidden' => in_array(Yii::$app->user->identity->username, ['admin', 'prd']) ? false : true,
    ],
    /*[
        'class' => 'kartik\grid\ExpandRowColumn',
        'width' => '50px',
        'value' => function ($model, $key, $index, $column) {
            return GridView::ROW_COLLAPSED;
        },
        'detail' => function ($model, $key, $index, $column) {
            return Yii::$app->controller->renderPartial('_expand-row-details', ['model' => $model]);
        },
        'headerOptions' => ['class' => 'kartik-sheet-style'] ,
        'expandOneOnly' => true
    ],*/
    [
        'attribute' => 'id',
        'label' => 'Period',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 75px;'
        ],
        'pageSummary' => 'Total',
        'hAlign' => 'center'
    ],
    [
        'attribute' => 'line',
        'label' => 'Line',
        'value' => 'sernoMaster.line',
        'vAlign' => 'middle',
        //'width' => '160px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 130px;'
        ],
        'filter' => $line_arr
    ],
    [
        'attribute' => 'cust_desc',
        'value' => 'shipCustomer.customer_desc',
        'label' => 'Customer Description',
        'vAlign' => 'middle',
        //'mergeHeader' => true,
        'hidden' => \Yii::$app->request->get('dst') !== null ? false : true,
    ],
    [
        'attribute' => 'gmc',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '90px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'description',
        'value' => 'sernoMaster.description',
        'label' => 'Description',
        'vAlign' => 'middle',
        //'width' => '180px',
        'contentOptions' => [
            'style' => 'min-width: 170px;'
        ],
    ],
    
    [
        'attribute' => 'qty',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '60px',
        //'mergeHeader' => true,
        'pageSummary' => true,
        'format' => ['decimal',0]
    ],
    [
        'attribute' => 'output',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '60px',
        //'mergeHeader' => true,
        'pageSummary' => true,
        'format' => ['decimal',0]
    ],
    [
        'attribute' => 'is_minus',
        'value' => 'qtyBalance',
        'label' => 'Minus',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '60px',
        'filter' => [
            1 => 'Minus',
        ],
        'filterInputOptions' => ['class' => 'form-control', 'prompt' => 'All'],
        //'mergeHeader' => true,
        'pageSummary' => true,
        'format' => ['decimal',0]
    ],
    /*[
        'attribute' => 'ng',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '60px',
        //'mergeHeader' => true,
        'pageSummary' => true,
        'format' => ['decimal',0]
    ],*/
    [
        'attribute' => 'vms',
        'label' => 'VMS Date',
        'vAlign' => 'middle',
        //'format' => ['date', 'php:d-M-Y'],
        'width' => '120px',
        'hAlign' => 'center'
    ],
    [
        'attribute' => 'etd',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '100px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
        'contentOptions' => [
            'style' => 'min-width: 100px;'
        ],
        //'mergeHeader' => true,
    ],
    [
        'attribute' => 'dst',
        'vAlign' => 'middle',
        'width' => '90px',
        //'mergeHeader' => true,
        //'hAlign' => 'center'
    ],
    [
        'attribute' => 'category',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '100px',
        'filter' => ['MACHINE' => 'MACHINE', 'MAN' => 'MAN', 'MATERIAL' => 'MATERIAL', 'METHOD' => 'METHOD']
    ],
    [
        'attribute' => 'remark',
        'vAlign' => 'middle',
        'mergeHeader' => true,
        'width' => '170px',
    ],
    
];
?>
<div class="giiant-crud serno-output-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <h1 style="display: none;">
        <?= Yii::t('app', 'Production Status' . $status) ?>
        <small>
            List <?= isset($_GET['etd']) ? $_GET['etd'] : '' ?>
        </small>
        <?php
        $tgl = isset($_GET['etd']) ? $_GET['etd'] : '';
        //$heading = Yii::t('app', 'Production Status' . $status) . ' ' . $tgl;
        $heading = Yii::t('app', 'List Data');
        ?>
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

    <div class="row">
        <div class="col-md-6">
            <div class="progress-group">
                    <span class="progress-text">VMS Total Plan <?= date('M\' Y') ?></span>
                    <span class="progress-number"><b><?= number_format($monthly_total_plan) ?></b>/<?= number_format($monthly_total_plan) ?> <a href="<?= Url::to(['yemi-internal/index', 'vms' => date('Y-m')]) ?>"><i class="fa fa-fw fa-info-circle"></i></a></span>

                    <div class="progress">
                      <div class="progress-bar progress-bar-green" style="width: <?= $progress[0] ?>%"><?= $progress[0] ?>%</div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">VMS Total Plan (<?= date('01 M Y') ?> - <?= date('d M Y', strtotime("-1 days")) ?>)</span>
                    <span class="progress-number"><b><?= number_format($monthly_progress_plan) ?></b>/<?= number_format($monthly_total_plan) ?> <a href="<?= Url::to(['yemi-internal/index', 'monthly' => 1]) ?>"><i class="fa fa-fw fa-info-circle"></i></a></span>

                    <div class="progress">
                      <div class="progress-bar progress-bar-aqua<?= $progress[1] != 100 ? ' progress-bar-striped active' : '' ?>" style="width: <?= $progress[1] ?>%"><?= $progress[1] ?>%</div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">Total Output <?= date('M\' Y') ?></span>
                    <span class="progress-number"><b><?= number_format($monthly_progress_output) ?></b>/<?= number_format($monthly_total_plan) ?> <a href="<?= Url::to(['yemi-internal/index', 'monthly' => 1]) ?>"><i class="fa fa-fw fa-info-circle"></i></a></span>

                    <div class="progress">
                      <div class="progress-bar progress-bar-purple<?= $progress[2] != 100 ? ' progress-bar-striped active' : '' ?>" style="width: <?= $progress[2] ?>%"><?= $progress[2] ?>%</div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">Total Delay (<?= date('01 M Y') ?> - <?= date('d M Y', strtotime("-1 days")) ?>)</span>
                    <span class="progress-number"><b><?= number_format($monthly_progress_delay) ?></b>/<?= number_format($monthly_progress_plan) ?></span>

                    <div class="progress">
                      <div class="progress-bar progress-bar-red<?= $progress[3] != 100 ? ' progress-bar-striped active' : '' ?>" style="width: <?= $progress[3] ?>%"><?= $progress[3] ?>%</div>
                    </div>
                  </div>
        </div>
    </div>

    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $gridColumns,
            'hover' => true,
            'showPageSummary' => true,
            //'condensed' => true,
            'striped' => true,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'pjax' => true, // pjax is set to always true for this demo
            'toolbar' =>  [
                /*['content' => 
                    Html::a('View Chart', $main_link, ['data-pjax' => 0, 'class' => 'btn btn-warning', 'title' => Yii::t('kvgrid', 'Show View Chart')])
                ],*/
                '{export}',
                '{toggleData}',
            ],
            // set export properties
            'export' => [
                'fontAwesome' => true
            ],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => $heading
            ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


