<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use kartik\export\ExportMenu;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\CutiTblSearch $searchModel
*/

$this->title = [
    'page_title' => 'Shipping Carrier Data <span class="japanesse text-green"></span>',
    'tab_title' => 'Shipping Carrier Data',
    'breadcrumbs_title' => 'Shipping Carrier Data'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$carrier_data_arr = ArrayHelper::map(app\models\ShipLiner::find()->select('CARRIER')->groupBy('CARRIER')->orderBy('CARRIER')->all(), 'CARRIER', 'CARRIER');
$gridColumns = [
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{update}',
        'buttons' => [
            'update' => function($url, $model, $key){
                $url = ['update', 'SEQ' => $model->SEQ];
                $options = [
                    'title' => 'Edit',
                    'data-pjax' => '0',
                ];
                return Html::a('<button class="btn btn-success btn-sm btn-block"><i class="fa fa-edit"></i> EDIT</span></button>', $url, $options);
            },
        ],
        'contentOptions' => ['nowrap'=>'nowrap', 'style' => 'width: 100px;']
    ],
    [
        'attribute' => 'COUNTRY',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filter' => ArrayHelper::map(app\models\ShipLiner::find()->select('COUNTRY')->groupBy('COUNTRY')->orderBy('COUNTRY')->all(), 'COUNTRY', 'COUNTRY'),
    ],
    [
        'attribute' => 'POD',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filter' => ArrayHelper::map(app\models\ShipLiner::find()->select('POD')->groupBy('POD')->orderBy('POD')->all(), 'POD', 'POD'),
    ],
    [
        'attribute' => 'FLAG_PRIORITY',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'FLAG_DESC',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'CARRIER',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'editableOptions'=> [
            'inputType'=>\kartik\editable\Editable::INPUT_DROPDOWN_LIST,
            'asPopover' => true,
            'header' => 'Carrier',
            'data' => $carrier_data_arr,
            'options' => ['class'=>'form-control', 'prompt'=>'Select status...'],
        ],
        'filter' => $carrier_data_arr,
    ],
];
?>
<div class="giiant-crud ship-liner-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <div class="table-responsive">
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
            'containerOptions' => ['style' => 'overflow: auto;'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'pjax' => true, // pjax is set to always true for this demo
            'toolbar' =>  [
                Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'Add', ['create'], ['class' => 'btn btn-success']),
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


