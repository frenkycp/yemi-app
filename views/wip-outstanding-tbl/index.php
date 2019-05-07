<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\CutiTblSearch $searchModel
*/

$this->title = [
    'page_title' => 'WIP Outstanding Data <span class="japanesse text-green"></span>',
    'tab_title' => 'WIP Outstanding Data',
    'breadcrumbs_title' => 'WIP Outstanding Data'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("h1 .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

date_default_timezone_set('Asia/Jakarta');

$columns = [
    [
        'attribute' => 'period',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '200px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 70px; text-align: center;',
        ],
    ],
    [
        'attribute' => 'start_date',
        'value' => function($model){
            return date('Y-m-d', strtotime($model->start_date));
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '200px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 70px; text-align: center;',
        ],
    ],
    [
        'attribute' => 'child_analyst',
        'label' => 'Location',
        'value' => function($model){
            return $model->child_analyst_desc;
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '250px',
        'filter' => ArrayHelper::map(app\models\WipLocation::find()->orderBy('child_analyst_desc')->all(), 'child_analyst', 'child_analyst_desc'),
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 70px; text-align: center;',
        ],
    ],
    [
        'attribute' => 'child',
        'label' => 'Part Numb.',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '200px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 70px; text-align: center;',
        ],
    ],
    [
        'attribute' => 'child_desc',
        'label' => 'Description',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 110px; text-align: center;',
        ],
    ],
    [
        'attribute' => 'model_group',
        'label' => 'Model Group',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 110px; text-align: center;',
        ],
    ],
];
?>

<div class="giiant-crud ipqa-patrol-tbl-index">

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
                'heading' => $heading,
                //'footer' => false,
            ],
        ]); 
        ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


