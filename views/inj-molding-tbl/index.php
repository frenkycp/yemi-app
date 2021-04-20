<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\InjMoldingTblSearch $searchModel
*/

$this->title = [
    'page_title' => 'Injection Molding Data Table <span class="japanesse text-green"></span>',
    'tab_title' => 'Injection Molding Data Table',
    'breadcrumbs_title' => 'Injection Molding Data Table'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$css_string = "
    .content-header {display: none;}";
$this->registerCss($css_string);

$columns = [
    [
        'class' => 'kartik\grid\ActionColumn',
        //'hidden' => !$is_clinic ? true : false,
        'template' => '{update}&nbsp;&nbsp;{maintenance}',
        'buttons' => [
            'update' => function ($url, $model, $key) {
                $options = [
                    'title' => Yii::t('cruds', 'Update'),
                    'aria-label' => Yii::t('cruds', 'Update'),
                    'data-pjax' => '0',
                    'class' => 'btn btn-primary btn-sm',
                ];
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, $options);
            }, 'maintenance' => function ($url, $model, $key) {
                $options = [
                    'title' => Yii::t('cruds', 'Maintenance'),
                    'aria-label' => Yii::t('cruds', 'Maintenance'),
                    'data-pjax' => '0',
                    'class' => 'btn btn-warning btn-sm',
                    'data-confirm' => 'Are you sure to maintain this Molding?',
                ];
                if ($model->MOLDING_STATUS == 0) {
                    return Html::a('<span class="glyphicon glyphicon-wrench"></span>', ['maintain', 'MOLDING_ID' => $model->MOLDING_ID], $options);
                } else {
                    return '<span class="glyphicon glyphicon-wrench disabled btn btn-warning btn-sm"></span>';
                }
                
            }
        ],
        'urlCreator' => function($action, $model, $key, $index) {
            // using the column name as key, not mapping to 'id' like the standard generator
            $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
            $params[0] = \Yii::$app->controller->id ? \Yii::$app->controller->id . '/' . $action : $action;
            return Url::toRoute($params);
        },
        'contentOptions' => ['nowrap'=>'nowrap', 'style' => 'min-width: 110px;']
    ],
    [
        'attribute' => 'MOLDING_ID',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'MOLDING_NAME',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'MACHINE_ID',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'MACHINE_DESC',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'TOTAL_COUNT',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'TARGET_COUNT',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'SHOT_PCT',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'MOLDING_STATUS',
        'value' => function($model){
            return \Yii::$app->params['inj_molding_status_arr'][$model->MOLDING_STATUS];
        },
        'filter' => \Yii::$app->params['inj_molding_status_arr'],
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'LAST_UPDATE',
        'value' => function($model){
            if ($model->LAST_UPDATE != null) {
                return date('Y-m-d H:i:s', strtotime($model->LAST_UPDATE));
            }
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'mergeHeader' => true,
    ],
];
?>
<div class="giiant-crud inj-molding-tbl-index">

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
            'pjax' => false, // pjax is set to always true for this demo
            'toolbar' =>  [
                Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'Add', ['create'], ['class' => 'btn btn-success']),
                '{export}',
                '{toggleData}',
            ],
            'rowOptions' => function($model){
                if ($model->MOLDING_STATUS == 2) {
                    return ['class' => 'danger'];
                }
            },
            // set export properties
            'export' => [
                'fontAwesome' => true
            ],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => 'Injection Molding Data Table',
            ],
        ]); 
        ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


