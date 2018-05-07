<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

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

$this->title = Yii::t('app', 'Serno Outputs');
$this->params['breadcrumbs'][] = $this->title;

if (isset($actionColumnTemplates)) {
$actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']);
    $actionColumnTemplateString = "{view} {update} {delete}";
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';

$main_link = ['report'];
if(isset($_GET['stc']))
{
    $main_link = ['container-progress', 'etd' => $_GET['etd']];
}

$gridColumns = [
    [
        'class' => 'yii\grid\ActionColumn',
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
        'attribute' => 'cust_desc',
        'value' => 'shipCustomer.customer_desc',
        'label' => 'Customer Description'
    ],
    [
        'attribute' => 'dst',
        //'hAlign' => 'center'
    ],
    [
        'attribute' => 'gmc',
        'hAlign' => 'center'
    ],
    [
        'attribute' => 'description',
        'value' => 'sernoMaster.description',
        'label' => 'Description'
    ],
    [
        'attribute' => 'qty',
        'hAlign' => 'center'
    ],
    [
        'attribute' => 'output',
        'hAlign' => 'center'
    ],
    [
        'attribute' => 'qtyBalance',
        'label' => 'Minus',
        'hAlign' => 'center'
    ],
    [
        'attribute' => 'ng',
        'hAlign' => 'center'
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
        $heading = Yii::t('app', 'Production Status' . $status) . ' ' . $tgl;
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
            'columns' => $gridColumns,
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
        /* 'dataProvider' => $dataProvider,
        'pager' => [
        'class' => yii\widgets\LinkPager::className(),
        'firstPageLabel' => 'First',
        'lastPageLabel' => 'Last',
        ],
                    //'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
        'headerRowOptions' => ['class'=>'x'],
        'columns' => $gridColumns, */
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


