<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\VisualPickingListSearch $searchModel
*/

$this->title = Yii::t('models', 'Group Model Detail');
$this->params['breadcrumbs'][] = $this->title;

if (isset($actionColumnTemplates)) {
$actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']);
    if (Yii::$app->user->identity->role->id == 1) {
        $actionColumnTemplateString = "{view} {update} {delete}";
    } else {
        $actionColumnTemplateString = "{delete}";
    }
    
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';

$gridColumns = [
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
        'attribute' => 'PERIOD',
        'vAlign' => 'middle',
        'hAlign' => 'center'
    ],
    [
        'attribute' => 'TYPE',
        'vAlign' => 'middle',
        'hAlign' => 'center'
    ],
    [
        'attribute' => 'MODEL',
        'vAlign' => 'middle',
        'hAlign' => 'center'
    ],
    [
        'attribute' => 'MODEL_GROUP',
        'vAlign' => 'middle',
        'hAlign' => 'center'
    ],
    /*[
        'attribute' => 'ITEM',
        'vAlign' => 'middle',
        'hAlign' => 'center'
    ],
    [
        'attribute' => 'DESC',
        'vAlign' => 'middle',
        //'hAlign' => 'center'
    ],*/
    [
        'attribute' => 'BU',
        'vAlign' => 'middle',
        'hAlign' => 'center'
    ],
    [
        'attribute' => 'QTY_BGT',
        'value' => function($model){
            return number_format($model->QTY_BGT);
        },
        'encodeLabel' => false,
        'label' => 'Qty Budget<br/>(予算)',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'hidden' => $_GET['filter_by'] == 'QTY' ? false : true,
        'pageSummary' => true,
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'QTY_ACT_FOR',
        'value' => function($model){
            return number_format($model->QTY_ACT_FOR);
        },
        'encodeLabel' => false,
        'label' => 'Qty Act/Forecast<br/>(見込み/実績)',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'hidden' => $_GET['filter_by'] == 'QTY' ? false : true,
        'pageSummary' => true,
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'QTY_BALANCE',
        'value' => function($model){
            return number_format($model->QTY_BALANCE);
        },
        'encodeLabel' => false,
        'label' => 'Qty Balance<br/>(対予算)',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'hidden' => $_GET['filter_by'] == 'QTY' ? false : true,
        //'pageSummary' => true,
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'AMOUNT_BGT',
        'value' => function($model){
            return number_format($model->AMOUNT_BGT);
        },
        'encodeLabel' => false,
        'label' => 'Amount Budget<br/>(予算)',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'hidden' => $_GET['filter_by'] == 'AMOUNT' ? false : true,
        'pageSummary' => true,
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'AMOUNT_ACT_FOR',
        'value' => function($model){
            return number_format($model->AMOUNT_ACT_FOR);
        },
        'encodeLabel' => false,
        'label' => 'Actual Act/Forecast<br/>(見込み/実績)',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'hidden' => $_GET['filter_by'] == 'AMOUNT' ? false : true,
        'pageSummary' => true,
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'AMOUNT_BALANCE',
        'value' => function($model){
            return number_format($model->AMOUNT_BALANCE);
        },
        'encodeLabel' => false,
        'label' => 'Amount Balance<br/>(対予算)',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'hidden' => $_GET['filter_by'] == 'AMOUNT' ? false : true,
        //'pageSummary' => true,
        'mergeHeader' => true,
    ],
];
?>
<div class="giiant-crud visual-picking-list-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $gridColumns,
            'hover' => true,
            'showPageSummary' => true,
            //'condensed' => true,
            'striped' => true,
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


