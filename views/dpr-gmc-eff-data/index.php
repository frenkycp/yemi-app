<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\CisClientIpAddressSearch $searchModel
*/

$this->title = Yii::t('models', 'GMC Efficiency Data');
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
     $('#modal').modal('show').find('.modal-body').load($(this).attr('href'));
   });
});");

$gridColumns = [
    [
        'class' => 'kartik\grid\SerialColumn',
        'contentOptions' => ['class' => 'kartik-sheet-style'],
        'width' => '36px',
        'header' => '',
        'headerOptions' => ['class' => 'kartik-sheet-style']
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
    ],
    [
        'attribute' => 'gmc',
        'label' => 'GMC',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width'=>'120px',
    ],
    [
        'attribute' => 'description',
        'vAlign' => 'middle',
        //'width'=>'100px',
    ],
    [
        'attribute' => 'total_mp',
        'label' => 'List MP',
        'value' => function($model){
            return Html::a('Detail', ['get-mp-list', 'proddate' => $model->proddate, 'line' => $model->line], ['class' => 'modal_mp btn btn-success', 'data-pjax' => '0',]);
        },
        'format' => 'raw',
    ],
    [
        'attribute' => 'qty_product',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        //'width'=>'100px',
    ],
    [
        'attribute' => 'qty_time',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        //'width'=>'100px',
    ],
    [
        'attribute' => 'mp_time',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        //'width'=>'100px',
    ],
    [
        'attribute' => 'efficiency',
        'label' => 'Efficiency (%)',
        'hAlign' => 'center',
        'vAlign' => 'middle',
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
        'header' => '<h3>Manpower</h3>',
        //'size' => 'modal-lg',
    ]);
    yii\bootstrap\Modal::end();

?>