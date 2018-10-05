<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\SoAchievementDataSearch $searchModel
*/

$this->title = Yii::t('models', 'Sales Order Achievement');
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
   $('.modal_detail').click(function(e) {
     e.preventDefault();
     $('#modal').modal('show').find('.modal-body').load($(this).attr('href'));
   });
});");

$grid_column = [
    [
        'attribute' => 'id',
        'label' => 'Period',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '130px',
    ],
    [
        'attribute' => 'monthly_total_plan',
        'label' => 'Total Sales Order Qty',
        'format'=> ['decimal', 0],
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'total_delay',
        'label' => 'Back Order Qty',
        'value' => function($model){
            if ($model->total_delay == 0) {
                return $model->total_delay;
            } else {
                return Html::a("$model->total_delay", ['get-so-detail-data', 'period' => $model->id, 'line' => $model->line], ['class' => 'modal_detail btn btn-warning btn-xs', 'data-pjax' => '0', 'title' => 'Click to show detail']);
            }
            
        },
        'format' => 'raw',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'achievement',
        'label' => 'Achievement',
        'value' => function($model){
            $percentage = 0;
            if ($model->monthly_total_plan > 0) {
                $percentage = round((($model->monthly_total_plan - $model->total_delay) / $model->monthly_total_plan) * 100, 2);
            }
            $text_class = 'text-green';
            if ($percentage < 100) {
                $text_class = 'text-red';
            }
            return "<span class=\"$text_class\">$percentage%</span>";
        },
        'format' => 'raw',
        'hAlign' => 'center',
        'vAlign' => 'middle',
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
            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
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


