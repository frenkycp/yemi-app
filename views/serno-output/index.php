<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\web\View;

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

$this->title = Yii::t('app', 'Shipping Data');
$this->params['breadcrumbs'][] = $this->title;

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

$main_link = ['report'];
if(isset($_GET['dst']))
{
    $main_link = ['container-progress', 'etd' => $_GET['etd']];
}

$gridColumns = [
    [
        'class' => '\kartik\grid\SerialColumn',
        'width' => '30px',
    ],
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
    ],*/
    [
        'attribute' => 'cust_desc',
        'value' => 'shipCustomer.customer_desc',
        'label' => 'Customer Description',
        'vAlign' => 'middle',
        'mergeHeader' => true,
        'hidden' => \Yii::$app->request->get('dst') !== null ? false : true,
    ],
    [
        'attribute' => 'etd',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'pageSummary' => 'Total',
        'width' => '120px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 120px;'
        ],
        //'mergeHeader' => true,
    ],
    [
        'attribute' => 'dst',
        'vAlign' => 'middle',
        'width' => '150px',
        //'mergeHeader' => true,
        'contentOptions' => [
            'style' => 'min-width: 120px;',
        ],
        //'hAlign' => 'center'
    ],
    [
        'attribute' => 'gmc',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '120px',
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
        'width' => '170px',
        'contentOptions' => [
            'style' => 'min-width: 150px;',
        ],
    ],
    [
        'attribute' => 'qty',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '60px',
        'mergeHeader' => true,
        'pageSummary' => true,
        'format' => ['decimal',0]
    ],
    [
        'attribute' => 'output',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '60px',
        'mergeHeader' => true,
        'pageSummary' => true,
        'format' => ['decimal',0]
    ],
    [
        'attribute' => 'qtyBalance',
        'label' => 'Minus',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '60px',
        'mergeHeader' => true,
        'pageSummary' => true,
        'format' => ['decimal',0]
    ],
    [
        'attribute' => 'cntr',
        'label' => 'Container No',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '50px',
    ],
    /*[
        'attribute' => 'ng',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '60px',
        'mergeHeader' => true,
        'pageSummary' => true,
        'format' => ['decimal',0]
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
    ],*/
    
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
                ['content' => 
                    Html::a('Back', $main_link, ['data-pjax' => 0, 'class' => 'btn btn-warning', 'title' => Yii::t('kvgrid', 'Show Weekly Report Chart')])
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
                'heading' => $heading
            ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


