<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\search\LineLosstimeDataSearch $searchModel
 */

$this->title = [
    'page_title' => 'Line Losstime Data <span class="japanesse"></span>',
    'tab_title' => 'Line Losstime Data',
    'breadcrumbs_title' => 'Line Losstime Data'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss(".japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

date_default_timezone_set('Asia/Jakarta');

if (isset($actionColumnTemplates)) {
    $actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
    Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']);
    $actionColumnTemplateString = "{view} {update} {delete}";
}
$actionColumnTemplateString = '<div class="action-buttons">' . $actionColumnTemplateString . '</div>';

$gridColumns = [
    /*[
        'class' => '\kartik\grid\SerialColumn',
        'width' => '30px',
    ],*/
    [
        'attribute' => 'proddate',
        //'label' => 'Slip Number',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '100px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 75px; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'line',
        //'label' => 'Slip Number',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filter' => ArrayHelper::map(app\models\HakAkses::find()->where([
            'level_akses' => '4'
        ])->orderBy('hak_akses')->all(), 'hak_akses', 'hak_akses'),
        'width' => '100px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 75px; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'mp',
        'label' => 'Manpower',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '50px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 75px; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'start_time',
        //'label' => 'Slip Number',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '90px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 75px; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'end_time',
        //'label' => 'Slip Number',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '90px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 75px; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'losstime',
        //'label' => 'Slip Number',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '90px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 75px; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'category',
        //'label' => 'Slip Number',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '90px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 75px; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'model',
        'label' => 'Change Model',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '90px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 75px; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'description',
        'label' => 'Model Description',
        'value' => function($model){
            return $model->partName;
        },
        //'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '150px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 75px; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'reason',
        //'label' => 'Half Process',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
        //'width' => '120px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 75px; font-size: 12px;'
        ],
    ],
];
?>
<div class="giiant-crud serno-losstime-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
    ?>

    
    <?php \yii\widgets\Pjax::begin(['id' => 'pjax-main', 'enableReplaceState' => false, 'linkSelector' => '#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success' => 'function(){alert("yo")}']]) ?>

    <div class="table-responsive">
    <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $gridColumns,
            'hover' => true,
            'showPageSummary' => true,
            //'condensed' => true,
            'striped' => true,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto; font-size:12px;'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'pjax' => true, // pjax is set to always true for this demo
            'toolbar' =>  [
                /*['content' => 
                    Html::a('View Chart', $main_link, ['data-pjax' => 0, 'class' => 'btn btn-warning', 'title' => Yii::t('kvgrid', 'Show View Chart')])
                ],*/
                '{export}',
                '{toggleData}',
            ],
            // set export properties
            'export' => [
                'fontAwesome' => true
            ],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => 'Last Update : ' . date('Y-m-d H:i:s')
            ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


