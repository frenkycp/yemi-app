<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\MesinCheckDtrSearch $searchModel
*/

$this->title = Yii::t('app', 'Master Plan Data List');
$this->params['breadcrumbs'][] = $this->title;

if (isset($actionColumnTemplates)) {
$actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']);
    $actionColumnTemplateString = "{view} {update} {delete}";
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';

$this->registerJs("$(function() {
   $('.popupModal').click(function(e) {
        e.preventDefault();
        $('#modal').modal('show').find('.modal-body')
        .load($(this).attr('href'));
   });
   $('.popupHistory').click(function(e) {
        e.preventDefault();
        $('#history_modal').modal('show').find('.modal-body')
        .load($(this).attr('href'));
   });
});");

$grid_columns = [
    [
	    'class' => 'yii\grid\ActionColumn',
        //'template' => "{check_sheet} {history}",
	    'template' => "{check_sheet}",
	    'buttons' => [
	        'view' => function ($url, $model, $key) {
	            $options = [
	                'title' => Yii::t('cruds', 'View'),
	                'aria-label' => Yii::t('cruds', 'View'),
	                'data-pjax' => '0',
	            ];
	            return Html::a('<span class="glyphicon glyphicon-file"></span>', $url, $options);
	        },
            'check_sheet' => function ($url, $model, $key) {
                $options = [
                    'title' => 'View Check Sheet',
                    'class' => 'popupModal',
                ];
                $url = ['get-check-sheet', 'mesin_id' => $model->mesin_id, 'mesin_periode' => $model->mesin_periode];
                return Html::a('<span class="glyphicon glyphicon-list-alt"></span>', $url, $options);
            },
            'history' => function ($url, $model, $key) {
                $options = [
                    'title' => 'View History',
                    'class' => 'popupHistory',
                ];
                $url = ['get-history', 'mesin_id' => $model->mesin_id, 'mesin_periode' => $model->mesin_periode];
                return Html::a('<span class="glyphicon glyphicon-time"></span>', $url, $options);
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
        'attribute' => 'mesin_id',
        'label' => 'Machine ID',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '10%',
    ],
    [
        'attribute' => 'machine_desc',
        'label' => 'Description',
        'vAlign' => 'middle',
        'width' => '20%',
        //'hAlign' => 'center'
    ],
    [
        'attribute' => 'location',
        'vAlign' => 'middle',
        'width' => '10%',
        'hAlign' => 'center'
    ],
    [
        'attribute' => 'area',
        'vAlign' => 'middle',
        'width' => '15%',
        //'hAlign' => 'center'
    ],
    [
        'attribute' => 'mesin_periode',
        'label' => 'Machine Period',
        'vAlign' => 'middle',
        'width' => '10%',
        //'hAlign' => 'center'
    ],
    [
        'attribute' => 'master_plan_maintenance',
        'label' => 'Master Plan',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '15%',
        'value' => function($model){
            return $model->master_plan_maintenance == null ? '-' : date('d-M-Y', strtotime($model->master_plan_maintenance));
        },
        //'format' => ['date', 'php:d-M-Y']
    ],
    [
        'attribute' => 'mesin_last_update',
        'label' => 'Last Update',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '20%',
        'value' => function($model){
            return $model->mesin_last_update == null ? '-' : date('d-M-Y', strtotime($model->mesin_last_update));
        },
        //'format' => ['date', 'php:d-M-Y H:i:s'],
        //'width' => '120px',
    ],
];
?>
<div class="giiant-crud mesin-check-dtr-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php //\yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <h1 style="display: none;">
        <?= Yii::t('app', 'Mesin Check Dtrs') ?>
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

    <!--<hr />-->

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
            //'pjax' => false, // pjax is set to always true for this demo
            'toolbar' =>  [
                ['content' => 
                    Html::a('View Chart', ['/masterplan-report/index'], ['data-pjax' => 0, 'class' => 'btn btn-warning', 'title' => Yii::t('kvgrid', 'Back to Chart')])
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

        <?php
            yii\bootstrap\Modal::begin([
                'id' =>'modal',
                'header' => '<h3>Check Sheet</h3>',
                'size' => 'modal-lg',
            ]);
            yii\bootstrap\Modal::end();

            yii\bootstrap\Modal::begin([
                'id' =>'history_modal',
                'header' => '<h3>History</h3>',
                'size' => 'modal-lg',
            ]);
            yii\bootstrap\Modal::end();
        ?>
    </div>

</div>


<?php //\yii\widgets\Pjax::end() ?>


