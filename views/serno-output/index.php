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

$this->title = [
    'page_title' => 'Shipping Container Data <span class="japanesse text-green">(出荷コンテナーデータ）</span>',
    'tab_title' => 'Shipping Container Data',
    'breadcrumbs_title' => 'Shipping Container Data chart'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss(".japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

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

/*$script = <<< JS
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout("refreshPage();", 600000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
JS;
$this->registerJs($script, View::POS_HEAD );*/

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
    /*[
        'class' => '\kartik\grid\SerialColumn',
        'width' => '30px',
    ],
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
    ],*/
    [
        'attribute' => 'week_no',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 90px; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'cust_desc',
        'value' => 'shipCustomer.customer_desc',
        'label' => 'Customer Description',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
        'hidden' => \Yii::$app->request->get('dst') !== null ? false : true,
    ],
    [
        'attribute' => 'etd',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'pageSummary' => 'Total',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 90px; font-size: 12px;'
        ],
        //
    ],
    [
        'attribute' => 'so',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 70px; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'stc',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 70px; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'dst',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 110px; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'gmc',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 80px; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'description',
        'value' => 'sernoMaster.description',
        'label' => 'Description',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 130px; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'qty',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '60px',
        
        'pageSummary' => true,
        'format' => ['decimal',0]
    ],
    [
        'attribute' => 'output',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '60px',
        
        'pageSummary' => true,
        'format' => ['decimal',0]
    ],
    [
        'attribute' => 'qtyBalance',
        'label' => 'Minus',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '60px',
        
        'pageSummary' => true,
        'format' => ['decimal',0]
    ],
    [
        'attribute' => 'cntr',
        'label' => 'Container<br/>No',
        'encodeLabel' => false,
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 50px; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'back_order',
        'label' => 'Priority',
        'value' => function($model){
            if ($model->back_order == 2) {
                return '<span class="text-red"><b>Air Shipment</b></span>';
            } else {
                return '';
            }
        },
        'format' => 'raw',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filter' => [
            2 => 'Air Shipment'
        ],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'remark',
        'vAlign' => 'middle',
        
        'width' => '170px',
    ],
    [
        'attribute' => 'etd_old',
        'label' => 'ETD Before',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 90px; font-size: 12px;'
        ],
        //
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

    <div class="">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $gridColumns,
            //'hover' => true,
            'showPageSummary' => true,
            //'condensed' => true,
            'striped' => false,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto; font-size: 12px;'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'pjax' => true, // pjax is set to always true for this demo
            'rowOptions' => function($model){
                if ($model->etd_old !== '') {
                    if ($model->etd_old > $model->etd) {
                        return ['class' => 'bg-danger'];
                    } elseif ($model->etd_old < $model->etd) {
                        return ['class' => 'bg-success'];
                    }
                    
                }
            },
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
            ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


