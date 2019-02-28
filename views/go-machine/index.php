<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\GoMachineSearch $searchModel
*/

$this->title = Yii::t('models', 'Go Machines');
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
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{order}',
        'buttons' => [
            'order' => function($url, $model, $key){
                $url = ['order', 'id' => $model->id];
                $options = [
                    'title' => 'Order',
                    'data-pjax' => '0',
                    'data-confirm' => 'Are you sure to order this item ?'
                ];
                return Html::a('<span class="fa fa-cart-plus"></span>', $url, $options);
            },
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
        'attribute' => 'mesin_group',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;',
        ],
    ],
    [
        'attribute' => 'mesin_id',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;',
        ],
    ],
    [
        'attribute' => 'machine_desc',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;',
        ],
    ],
    [
        'attribute' => 'model',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;',
        ],
    ],
];
?>
<div class="giiant-crud go-machine-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    
    <div class="">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $columns,
            'hover' => true,
            //'condensed' => true,
            'striped' => true,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto;'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'pjax' => true, // pjax is set to always true for this demo
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
                //'footer' => false,
            ],
        ]); 
        ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


