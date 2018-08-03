<?php

use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use kartik\grid\GridView;

$this->title = [
    'page_title' => 'Monthly Fullfillment <span class="japanesse text-green"></span>',
    'tab_title' => 'Monthly Fullfillment',
    'breadcrumbs_title' => 'Monthly Fullfillment'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$gridColumns = [
	[
        'class' => '\kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'attribute' => 'id',
        'label' => 'period',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '100px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
        'pageSummary' => 'Total',
    ],
    [
        'attribute' => 'gmc',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '120px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'description',
        'value' => 'sernoMaster.description',
        'label' => 'Description',
        'vAlign' => 'middle',
        'width' => '170px',
        'contentOptions' => [
            'style' => 'min-width: 150px;',
        ],
    ],
    [
        'attribute' => 'dst',
        'label' => 'Port',
        'vAlign' => 'middle',
        'width' => '150px',
        //'mergeHeader' => true,
        'contentOptions' => [
            'style' => 'min-width: 120px;',
        ],
        //'hAlign' => 'center'
    ],
    [
        'attribute' => 'qty',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '60px',
        'pageSummary' => true,
        'format' => ['decimal',0]
    ],
    [
        'attribute' => 'output',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '60px',
        'pageSummary' => true,
        'format' => ['decimal',0]
    ],
    [
        'attribute' => 'etd',
        'label' => 'New ETD',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '120px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 120px;'
        ],
        //'mergeHeader' => true,
    ],
];

$ff_percentage = 0;
$total_bo = 0;
if ($fullfillment->monthly_total_plan != 0) {
	$ff_percentage = round(($fullfillment->monthly_progress_plan / $fullfillment->monthly_total_plan) * 100, 2);
	$total_bo = $fullfillment->monthly_total_plan - $fullfillment->monthly_progress_plan;
}

?>

<div class="row">
	<div class="col-sm-6">
		<div class="progress-group">
			
			<span class="progress-text">Fullfillment <?= date('M\' Y', strtotime($period . '01')) ?> (Back Order Qty = <?= $total_bo ?>)</span>
			<span class="progress-number"><b><?= number_format($fullfillment->monthly_progress_plan) ?></b>/<?= number_format($fullfillment->monthly_total_plan) ?>
			</span>
			<div class="progress">
		          	<div class="progress-bar progress-bar-primary<?= $ff_percentage != 100 ? ' progress-bar-striped active' : '' ?>" style="width: <?= $ff_percentage ?>%"><?= $ff_percentage ?>%</div>
		    </div>
		</div>
	</div>
	
</div>

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
            'heading' => 'Back Order Data List'
        ],
    ]); ?>
</div>