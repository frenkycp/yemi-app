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
        'pageSummary' => 'Total',
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
        'attribute' => 'DEPT_SECTION',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
        'filter' => ArrayHelper::map(app\models\SplView::find()->select('DISTINCT(DEPT_SECTION)')->where('DEPT_SECTION <> \'\'')->orderBy('DEPT_SECTION')->all(), 'DEPT_SECTION', 'DEPT_SECTION')
        //'width'=>'100px',
    ],
    [
        'attribute' => 'START_LEMBUR_ACTUAL',
        'label' => 'Masuk<br/>(Aktual)',
        'encodeLabel' => false,
        'value' => function($model){
            return $model->START_LEMBUR_ACTUAL == null ? '-' : date('H:i:s', strtotime($model->START_LEMBUR_ACTUAL));
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width'=>'70px',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'END_LEMBUR_ACTUAL',
        'label' => 'Keluar<br/>(Aktual)',
        'encodeLabel' => false,
        'value' => function($model){
            return $model->END_LEMBUR_ACTUAL == null ? '-' : date('H:i:s', strtotime($model->END_LEMBUR_ACTUAL));
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width'=>'70px',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'NILAI_LEMBUR_PLAN',
        'label' => 'Plan Lembur<br/>(Jam)',
        'encodeLabel' => false,
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'mergeHeader' => true,
        //'width'=>'100px',
    ],
    [
        'attribute' => 'NILAI_LEMBUR_ACTUAL',
        'label' => 'Aktual Lembur<br/>(Jam)',
        'value' => function($model){
            if ($model->NILAI_LEMBUR_ACTUAL === null) {
                return Html::img(['uploads/processing_01.gif'], ['height' => '35']);
            } elseif ($model->NILAI_LEMBUR_ACTUAL == 0) {
                return '<span class="text-red">Tidak Lembur</span>';
            } else {
                return $model->NILAI_LEMBUR_ACTUAL;
            }
        },
        'format' => 'html',
        'hAlign' => 'center',
        'encodeLabel' => false,
        'vAlign' => 'middle',
        'mergeHeader' => true,
        'pageSummary' => true,
        'hiddenFromExport' => true,
        //'width'=>'100px',
    ],
    [
        'attribute' => 'NILAI_LEMBUR_ACTUAL_EXPORT',
        'label' => 'Aktual Lembur<br/>(Jam)',
        'value' => function($model){
            if ($model->NILAI_LEMBUR_ACTUAL === null) {
                return 'Processing';
            } elseif ($model->NILAI_LEMBUR_ACTUAL == 0) {
                return 'Tidak Lembur';
            } else {
                return $model->NILAI_LEMBUR_ACTUAL;
            }
        },
        'format' => 'html',
        'hAlign' => 'center',
        'encodeLabel' => false,
        'vAlign' => 'middle',
        'mergeHeader' => true,
        'pageSummary' => true,
        'hidden'=> true,
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
            'showPageSummary' => true,
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


