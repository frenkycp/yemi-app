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
    'page_title' => 'SMT Performance Data <span class="japanesse text-green">(SMT パフォーマンスデータ）</span>',
    'tab_title' => 'SMT Performance Data',
    'breadcrumbs_title' => 'SMT Performance Data'
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
        'filter' => [
            'WM03' => 'SMT',
            'WI01' => 'INJ SMALL',
            'WI02' => 'INJ LARGE',
        ],
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
        'attribute' => 'child_01',
        'label' => 'Part Num.',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'style' => 'font-size: 12px; text-align: center; min-width: 70px;',
            'class' => 'form-control',
        ],
    ],
    [
        'attribute' => 'child_desc_01',
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
        'attribute' => 'machine_run_std_second',
        'label' => 'Total ST<br/>(C = A * B)',
        'value' => function($model){
            return round($model->machine_run_std_second / 60, 2);
        },
        'encodeLabel' => false,
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '70px;',
        'mergeHeader' => true,
        'format' => ['decimal', 2],
    ],
    [
        'attribute' => 'machine_run_act_second',
        'label' => 'Lead Time<br/>(D)',
        'value' => function($model){
            return round($model->machine_run_act_second / 60, 2);
        },
        'encodeLabel' => false,
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '70px;',
        'mergeHeader' => true,
        'format' => ['decimal', 2],
    ],
    [
        'attribute' => 'loss_planned',
        'label' => 'Loss Time<br/>(Planned)<br/>(E)',
        'value' => function($model){
            return round($model->loss_planned / 60, 2);
        },
        'encodeLabel' => false,
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '70px;',
        'mergeHeader' => true,
        'format' => ['decimal', 2],
    ],
    [
        'attribute' => 'loss_planned_outsection',
        'label' => 'Loss Time<br/>(Planned Out Section)<br/>(F)',
        'value' => function($model){
            return round($model->loss_planned_outsection / 60, 2);
        },
        'encodeLabel' => false,
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '70px;',
        'mergeHeader' => true,
        'format' => ['decimal', 2],
    ],
    [
        'attribute' => 'total_lost',
        'label' => 'Loss Time<br/>(Total)<br/>(G)',
        'value' => function($model){
            return round($model->total_lost / 60, 2);
        },
        'encodeLabel' => false,
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '70px;',
        'mergeHeader' => true,
        'format' => ['decimal', 2],
    ],
    [
        'attribute' => 'machine_utilization',
        'label' => 'Utilization(%)<br/>(C / D)',
        'encodeLabel' => false,
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '70px;',
        'mergeHeader' => true,
        'format' => ['decimal', 2],
    ],
    [
        'attribute' => 'gross_minus_planned_loss',
        'label' => 'Gross(%)<br/>(C / (D - E))',
        'encodeLabel' => false,
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '70px;',
        'mergeHeader' => true,
        'format' => ['decimal', 2],
    ],
    [
        'attribute' => 'nett1_minus_planned_outsection_loss',
        'label' => 'Nett 1(%)<br/>(C / (D - F))',
        'encodeLabel' => false,
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '70px;',
        'mergeHeader' => true,
        'format' => ['decimal', 2],
    ],
    [
        'attribute' => 'nett2_minus_all_loss',
        'label' => 'Nett 2(%)<br/>(C / (D - G))',
        'encodeLabel' => false,
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '70px;',
        'mergeHeader' => true,
        'format' => ['decimal', 2],
    ],
    [
        'attribute' => 'efisiensi_working_ratio',
        'label' => 'Working Ratio(%)<br/>((C / 0.8) / (D - F))',
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


