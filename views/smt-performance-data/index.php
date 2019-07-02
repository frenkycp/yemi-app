<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\SoAchievementDataSearch $searchModel
*/

$this->title = [
    'page_title' => 'SMT INJ Performance Data <span class="japanesse text-green">(SMT パフォーマンスデータ）</span>',
    'tab_title' => 'SMT INJ Performance Data',
    'breadcrumbs_title' => 'SMT INJ Performance Data'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
//$this->params['breadcrumbs'][] = $this->title;

if (isset($actionColumnTemplates)) {
$actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']);
    $actionColumnTemplateString = "{view} {update} {delete}";
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';

$this->registerCss(".japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

date_default_timezone_set('Asia/Jakarta');

$this->registerJs("$(function() {
   $('.modal_detail').click(function(e) {
     e.preventDefault();
     $('#modal').modal('show').find('.modal-body').html('<div class=\"text-center\">" . Html::img('@web/loading-01.gif', ['alt'=>'some', 'class'=>'thing']) . "</div>').load($(this).attr('href'));
   });
});");

$grid_column = [
    [
        'attribute' => 'period',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'style' => 'font-size: 12px; text-align: center; min-width: 50px;',
            'class' => 'form-control',
        ],
    ],
    [
        'attribute' => 'post_date',
        'value' => function($model){
            return date('Y-m-d', strtotime($model->post_date));
        },
        'label' => 'Date',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'style' => 'font-size: 12px; text-align: center; min-width: 80px;',
            'class' => 'form-control',
        ],
    ],
    [
        'attribute' => 'child_analyst',
        'label' => 'Location',
        'value' => function($model){
            return $model->child_analyst_desc;
        },
        'filter' => \Yii::$app->params['smt_inj_loc_arr'],
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'style' => 'font-size: 12px; text-align: center; min-width: 120px;',
            'class' => 'form-control',
        ],
    ],
    [
        'attribute' => 'LINE',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'style' => 'font-size: 12px; text-align: center; min-width: 50px;',
            'class' => 'form-control',
        ],
    ],
    [
        'attribute' => 'SMT_SHIFT',
        'label' => 'Shift',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'style' => 'font-size: 12px; text-align: center; min-width: 80px;',
            'class' => 'form-control',
        ],
    ],
    [
        'attribute' => 'child_all',
        'label' => 'Part Num.',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'style' => 'font-size: 12px; text-align: center; min-width: 70px;',
            'class' => 'form-control',
        ],
    ],
    [
        'attribute' => 'child_desc_all',
        'label' => 'Part Name',
        'vAlign' => 'middle',
        'mergeHeader' => true,
        'contentOptions' => [
            'style' => 'font-size: 12px; min-width: 170px;',
        ],
    ],
    [
        'attribute' => 'qty_all',
        'label' => 'Qty<br/>(A)',
        'encodeLabel' => false,
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '70px;',
        'mergeHeader' => true,
        'format' => ['decimal', 0],
    ],
    [
        'attribute' => 'std_all',
        'label' => 'ST<br/>(B)',
        'encodeLabel' => false,
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '70px;',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'lt_std',
        'label' => 'Total ST<br/>(C = A * B)',
        'encodeLabel' => false,
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '70px;',
        'mergeHeader' => true,
        'format' => ['decimal', 2],
    ],
    [
        'attribute' => 'lt_gross',
        'label' => 'Lead Time<br/>(D)',
        'encodeLabel' => false,
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '70px;',
        'mergeHeader' => true,
        'format' => ['decimal', 2],
    ],
    [
        'attribute' => 'planed_loss_minute',
        'label' => 'Loss Time<br/>(Planned)<br/>(E)',
        'encodeLabel' => false,
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '70px;',
        'mergeHeader' => true,
        'format' => ['decimal', 2],
    ],
    [
        'attribute' => 'out_section_minute',
        'label' => 'Loss Time<br/>(Out Section)<br/>(F)',
        'encodeLabel' => false,
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '70px;',
        'mergeHeader' => true,
        'format' => ['decimal', 2],
    ],
    [
        'attribute' => 'dandori_minute',
        'label' => 'Dandori',
        'encodeLabel' => false,
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '70px;',
        'mergeHeader' => true,
        'format' => ['decimal', 2],
    ],
    [
        'attribute' => 'break_down_minute',
        'label' => 'Break Down',
        'encodeLabel' => false,
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '70px;',
        'mergeHeader' => true,
        'format' => ['decimal', 2],
    ],
    [
        'attribute' => 'operating_loss_minute',
        'label' => 'Operating Loss',
        'encodeLabel' => false,
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '70px;',
        'mergeHeader' => true,
        'format' => ['decimal', 2],
    ],
    [
        'attribute' => 'operating_ratio',
        'label' => 'Operating Ratio(%)<br/>((D-E-F) / 1440)',
        'encodeLabel' => false,
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '70px;',
        'mergeHeader' => true,
        'format' => ['decimal', 2],
    ],
    [
        'attribute' => 'working_ratio',
        'label' => 'Working Ratio(%)<br/>(C / (D-E-F))',
        'encodeLabel' => false,
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '70px;',
        'mergeHeader' => true,
        'format' => ['decimal', 2],
    ],
];
?>
<div class="giiant-crud serno-output-index">

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <div class="">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $grid_column,
            'hover' => true,
            'showPageSummary' => true,
            //'condensed' => true,
            'striped' => true,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto; font-size: 12px;'], // only set when $responsive = false
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
                'heading' => 'Last Update : ' . date('Y-m-d H:i:s')
            ],
        ]); 
        yii\bootstrap\Modal::begin([
            'id' =>'modal',
            'header' => '<h3>Detail Information</h3>',
            'size' => 'modal-lg',
        ]);
        yii\bootstrap\Modal::end();
        ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


