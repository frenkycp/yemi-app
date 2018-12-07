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
    'page_title' => 'SMT Performance Data <span class="japanesse text-green"></span>',
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
        'label' => 'Date',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '100px;',
    ],
    [
        'attribute' => 'SMT_SHIFT',
        'label' => 'Shift',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '100px;',
    ],
    [
        'attribute' => 'LINE',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '70px;',
    ],
    [
        'attribute' => 'child_01',
        'label' => 'Part Num.',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '100px;',
    ],
    [
        'attribute' => 'child_desc_01',
        'label' => 'Part Name',
        'vAlign' => 'middle',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'qty_all',
        'label' => 'Qty',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '70px;',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'std_all',
        'label' => 'ST',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '70px;',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'lt_std',
        'label' => 'LT (Standart)',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '70px;',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'lt_gross',
        'label' => 'LT (Gross)',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '70px;',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'lt_loss',
        'label' => 'Loss Time',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '70px;',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'lt_nett',
        'label' => 'Loss Time',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '70px;',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'start_date',
        'label' => 'Start',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '100px;',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'end_date',
        'label' => 'End',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '100px;',
        'mergeHeader' => true,
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


