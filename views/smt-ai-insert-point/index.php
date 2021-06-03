<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\SmtAiInsertPointSearch $searchModel
*/

$this->title = [
    'page_title' => 'PCB Insert Point Data <span class="japanesse light-green"></span>',
    'tab_title' => 'PCB Insert Point Data',
    'breadcrumbs_title' => 'PCB Insert Point Data'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("h1 .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }
    .disabled-link {color: DarkGrey; cursor: not-allowed;}");

$gridColumns = [
    [
        'attribute' => 'PART_NO',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'PARENT_PART_NO',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'POINT_SMT',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'POINT_RG',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'POINT_AV',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'POINT_JV',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'POINT_TOTAL',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
    ],
];
?>
<div class="giiant-crud smt-ai-insert-point-index">

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
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto;'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'toolbar' =>  [
                //Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'Add', ['create'], ['class' => 'btn btn-success']),
                '{export}',
                '{toggleData}',
            ],
            /*'rowOptions' => function($model){
                if ($model->Discontinue == 'Y') {
                    return ['class' => 'bg-danger'];
                }
            },*/
            // set export properties
            'export' => [
                'fontAwesome' => true
            ],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                //'footer' => false,
            ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


