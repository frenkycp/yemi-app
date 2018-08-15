<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\HrgaSplDataSearch $searchModel
*/

$this->title = Yii::t('models', 'Overtime Data');
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
        'attribute' => 'TGL_LEMBUR',
        'value' => function($model){
            return date('Y-m-d', strtotime($model->TGL_LEMBUR));
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width'=>'120px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'NIK',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '120px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'NAMA_KARYAWAN',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
        //'width'=>'100px',
    ],
    [
        'attribute' => 'CC_GROUP',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
        'filter' => ArrayHelper::map(app\models\SplView::find()->select('DISTINCT(CC_GROUP)')->where('CC_GROUP <> \'\'')->orderBy('CC_GROUP')->all(), 'CC_GROUP', 'CC_GROUP')
        //'width'=>'100px',
    ],
    [
        'attribute' => 'NILAI_LEMBUR_PLAN',
        'label' => 'Plan Lembur<br/>(Jam)',
        'hAlign' => 'center',
        'encodeLabel' => false,
        'vAlign' => 'middle',
        'mergeHeader' => true,
        //'width'=>'100px',
    ],
    [
        'attribute' => 'NILAI_LEMBUR_ACTUAL',
        'label' => 'Aktual Lembur<br/>(Jam)',
        'hAlign' => 'center',
        'encodeLabel' => false,
        'vAlign' => 'middle',
        'mergeHeader' => true,
        //'width'=>'100px',
    ],
    [
        'attribute' => 'KETERANGAN',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
        'mergeHeader' => true,
    ],
];
?>
<div class="giiant-crud spl-hdr-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

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
            //'pjax' => true, // pjax is set to always true for this demo
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
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


