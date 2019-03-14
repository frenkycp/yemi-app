<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\GojekDriverPresenceSearch $searchModel
*/

$this->title = [
    'page_title' => 'Driver Attendance <span class="text-green japanesse"></span>',
    'tab_title' => 'Driver Attendance',
    'breadcrumbs_title' => 'Driver Attendance'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss(".japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

$this->registerJs("$(function() {
   $('.btn-update').click(function(e) {
     e.preventDefault();
     $('#common-modal').modal('show');
   });
});");

$gridColumns = [
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{presence_update}',
        'buttons' => [
            'presence_update' => function ($url, $model, $key) {
                $url = [
                    'value' => Url::to(['presence-update','GOJEK_ID'=>$model->GOJEK_ID]),
                    'title' => 'Attendance Update',
                    'class' => 'showModalButton'
                ];
                $options = [
                    'data-pjax' => '0',
                    'id' => 'btn-update'
                ];
                return Html::button('<span class="glyphicon glyphicon-pencil"></span>', $url, $options);
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
        'attribute' => 'GOJEK_ID',
        'label' => 'NIK',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'GOJEK_DESC',
        'label' => 'Employee Name',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'HADIR',
        'label' => 'Presence',
        'value' => function($model){
            if ($model->HADIR == 'Y') {
                return '<i class="fa fa-fw fa-circle-o text-green"></i>';
            } else {
                return '<i class="fa fa-fw fa-close text-red"></i>';
            }
        },
        'filter' => [
            'Y' => 'YES',
            'N' => 'NO'
        ],
        'format' => 'html',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'GOJEK_VALUE',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'label' => 'Driver Value',
    ],
];
?>
<div class="giiant-crud gojek-tbl-index">
    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <div class="">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $gridColumns,
            //'hover' => true,
            //'condensed' => true,
            'striped' => false,
            'pager' => [
                'firstPageLabel' => 'First',
                'lastPageLabel'  => 'Last'
            ],
            'showPageSummary' => true,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto; font-size: 12px;'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'pjax' => true, // pjax is set to always true for this demo
            'toolbar' =>  [
                ['content' => 
                    Html::a('Reset Value', ['reset-value'], ['data-pjax' => 0, 'class' => 'btn btn-warning', 'title' => Yii::t('kvgrid', 'Reset Value Data'), 'data-confirm' => 'Are you sure to reset value data for all driver?'])
                ],
                '{export}',
                '{toggleData}',
            ],
            // set export properties
            'export' => [
                'fontAwesome' => true
            ],
            'panel' => [
                'type' => GridView::TYPE_INFO,
            ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


