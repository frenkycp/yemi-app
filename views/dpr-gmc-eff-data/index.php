<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\CisClientIpAddressSearch $searchModel
*/

$this->title = [
    'page_title' => 'GMC Efficiency Data <span class="japanesse text-green">(GMC別能率データ）</span>',
    'tab_title' => 'GMC Efficiency Data',
    'breadcrumbs_title' => 'GMC Efficiency Data'
];
//$this->params['breadcrumbs'][] = $this->title;

if (isset($actionColumnTemplates)) {
$actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']);
    $actionColumnTemplateString = "{view} {update} {delete}";
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';

date_default_timezone_set('Asia/Jakarta');

$this->registerJs("$(function() {
   $('.modal_mp').click(function(e) {
     e.preventDefault();
     $('#modal').modal('show').find('.modal-body').html('<div class=\"text-center\">" . Html::img('@web/loading-01.gif', ['alt'=>'some', 'class'=>'thing']) . "</div>').load($(this).attr('href'));
   });
});");

$gridColumns = [
    [
        'class' => 'kartik\grid\SerialColumn',
        'contentOptions' => ['class' => 'kartik-sheet-style'],
        'width' => '36px',
        'header' => '',
        'headerOptions' => ['class' => 'kartik-sheet-style'],
        'pageSummary' => 'Total',
        'pageSummaryOptions' => ['colspan' => 5],
        'header' => '',
        'headerOptions' => ['class'=>'kartik-sheet-style'],
    ],
    [
        'attribute' => 'proddate',
        'label' => 'Prod. Date',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width'=>'120px',
    ],
    [
        'attribute' => 'line',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width'=>'120px',
        'filter' => $line_arr,
    ],
    [
        'attribute' => 'gmc',
        'label' => 'GMC',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width'=>'120px',
    ],
    [
        'attribute' => 'partName',
        'label' => 'Description',
        'vAlign' => 'middle',
        'mergeHeader' => true,
        //'width'=>'100px',
    ],
    [
        'attribute' => 'mp',
        'label' => 'Manpower',
        'hAlign' => 'center',
        'value' => function($model){
            return Html::a($model->totalMp, ['get-mp-list', 'proddate' => $model->proddate, 'line' => $model->line], ['class' => 'modal_mp btn btn-success btn-sm', 'data-pjax' => '0',]);
        },
        'format' => 'raw',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'qty_product',
        'value' => function($model){
            return Html::a('<span class="badge bg-light-blue">' . $model->qty_product . '</span>', ['get-product-list', 'proddate' => $model->proddate, 'line' => $model->line, 'gmc' => $model->gmc], ['class' => 'modal_mp', 'data-pjax' => '0',]);
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'format' => 'raw',
        'mergeHeader' => true,
        //'width'=>'100px',
    ],
    [
        'attribute' => 'start_time',
        /*'value' => function($model){
            return $model->mp_time_single;
            $start_time = date('H:i:s', strtotime(date($model->start_time) . ' -' . $model->mp_time_single . ' minutes'));
            return $start_time;
        },*/
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'end_time',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'working_time',
        'value' => function($model){
            $working_time = 0;
            if ($model->totalMp > 0) {
                $working_time = round($model->mp_time / $model->totalMp, 2);
            }
            return $working_time;
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'mergeHeader' => true,
        'pageSummary' => true
    ],
    [
        'attribute' => 'qty_time',
        'label' => 'Qty Time<br/>(A)',
        'encodeLabel' => false,
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'mergeHeader' => true,
        'pageSummary' => true
        //'width'=>'100px',
    ],
    [
        'attribute' => 'mp_time',
        'label' => 'MP Time<br/>(B)',
        'encodeLabel' => false,
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'mergeHeader' => true,
        'pageSummary' => true
        //'width'=>'100px',
    ],
    [
        'attribute' => 'efficiency',
        'encodeLabel' => false,
        'label' => 'Efficiency (%)<br/>(A / B)',
        'value' => function($model){
            $eff = 0;
            if ($model->mp_time > 0) {
                $eff = round(($model->qty_time / $model->mp_time) * 100, 2);
            }
            return $eff;
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'mergeHeader' => true,
    ],
];
?>
<div class="giiant-crud cis-client-ip-address-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'showPageSummary' => true,
            'columns' => $gridColumns,
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
                'heading' => 'Last Update : ' . date('Y-m-d H:i:s')
                //'footer' => false,
            ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


<?php
    yii\bootstrap\Modal::begin([
        'id' =>'modal',
        'header' => '<h3>Detail Information</h3>',
        'size' => 'modal-lg',
    ]);
    yii\bootstrap\Modal::end();

?>