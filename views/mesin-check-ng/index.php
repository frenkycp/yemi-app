<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\MesinCheckNgSearch $searchModel
*/

$this->title = Yii::t('app', 'Machine Check Data');
$this->params['breadcrumbs'][] = $this->title;

if (isset($actionColumnTemplates)) {
$actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']);
    $actionColumnTemplateString = "{view} {update} {delete}";
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';

$grid_columns = [
    [
        'class' => '\kartik\grid\SerialColumn',
        'width' => '30px',
    ],
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
        'attribute' => 'location',
        'vAlign' => 'middle',
        //'width' => '100px',
        'hidden' => true,
        //'hAlign' => 'center'
    ],
    [
        'attribute' => 'area',
        'vAlign' => 'middle',
        //'width' => '150px',
        //'hAlign' => 'center'
    ],
    [
        'attribute' => 'mesin_id',
        'label' => 'Machine ID',
        'vAlign' => 'middle',
        //'width' => '100px',
        'hAlign' => 'center'
    ],
    [
        'attribute' => 'mesin_nama',
        'label' => 'Machine Name',
        'vAlign' => 'middle',
        'width' => '150px',
        //'hAlign' => 'center'
    ],
    [
        'attribute' => 'mesin_no',
        'label' => 'NO',
        'vAlign' => 'middle',
        'width' => '4%',
        'hAlign' => 'center'
    ],
    [
        'attribute' => 'mesin_bagian',
        'label' => 'Parts',
        'filter' => false,
        'vAlign' => 'middle',
        //'width' => '150px',
        //'hAlign' => 'center'
    ],
    [
        'attribute' => 'mesin_bagian_ket',
        'label' => 'Parts Info',
        'filter' => false,
        'vAlign' => 'middle',
        //'width' => '150px',
        //'hAlign' => 'center'
    ],
    [
        'attribute' => 'mesin_catatan',
        'label' => 'Parts Remarks',
        'filter' => false,
        'vAlign' => 'middle',
        //'width' => '150px',
        //'hAlign' => 'center'
    ],
    [
        'attribute' => 'repair_note',
        'label' => 'Repair Note',
        'filter' => false,
        'vAlign' => 'middle',
        //'width' => '150px',
        //'hAlign' => 'center'
    ],
    [
        'attribute' => 'repair_status',
        'label' => 'Status',
        //'width' => '100px',
        'value' => function($model){
            if ($model->repair_status == 'O') {
                return 'OPEN';
            }else {
                return 'CLOSED';
            }
        },
        'vAlign' => 'middle',
        'filter' => [
            'O' => 'OPEN',
            'C' => 'CLOSED'
        ],
        'hAlign' => 'center'
    ],
    [
        'attribute' => 'mesin_last_update',
        'label' => 'Last Update',
        'vAlign' => 'middle',
        //'width' => '150px',
        //'hAlign' => 'center'
    ],
]
?>
<div class="giiant-crud mesin-check-ng-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <h1 style="display: none;">
        <?= Yii::t('app', 'Mesin Check Ngs') ?>
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

    <!-- <hr /> -->

    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $grid_columns,
            'hover' => true,
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
                    Html::a('Back', ['ng-progress'], ['data-pjax' => 0, 'class' => 'btn btn-warning', 'title' => Yii::t('kvgrid', 'Show Weekly Report Chart')])
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
                'heading' => $heading,
                //'footer' => false,
            ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


