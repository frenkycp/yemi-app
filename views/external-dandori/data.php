<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\ProdPlanDataSearch $searchModel
*/

$this->title = [
    'page_title' => 'Dandori Plan Data Table <span class="japanesse text-green"></span>',
    'tab_title' => 'Dandori Plan Data Table',
    'breadcrumbs_title' => 'Dandori Plan Data Table'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');

$this->registerJs("$(function() {
   $('#btn-dandori-start').click(function(e) {
     e.preventDefault();
     $('#common-modal').modal('show');
   });
});");

$columns = [
	[
        'class' => 'yii\grid\ActionColumn',
        'header' => "Dandori",
        'template' => '{dandori-start} {dandori-end} {dandori-handover}',
        'buttons' => [
            'dandori-start' => function($url, $model, $key){
                $link_txt = '<i class="fa fa-play"></i> Start';
                if($model->ext_dandori_status == 0 && $model->plan_run = 'N'){
                    return Html::a($link_txt, '#', [
                        'data-pjax' => '0',
                        //'data-confirm' => 'Are you sure to start external dandori for this plan ?',
                        'id' => 'btn-dandori-start',
                        'value' => Url::to(['dandori-start', 'lot_id' => $model->lot_id]),
                        'title' => 'Dandori Start',
                        'class' => 'showModalButton btn btn-primary btn-xs',
                    ]);
                    //return Html::a('<i class="glyphicon glyphicon-copy" style="font-size: 1.5em;"></i>', $url, $options);
                } else {
                    return '<button class="btn btn-primary btn-xs disabled">' . $link_txt . '</button>';
                }
                
            }, 'dandori-end' => function($url, $model, $key){
                $link_txt = '<i class="fa fa-stop"></i> End';
                if ($model->ext_dandori_status == 1 && $model->plan_run = 'N') {
                    return Html::a($link_txt, Url::to(['dandori-end', 'lot_id' => $model->lot_id]), [
                        'class' => 'btn btn-primary btn-xs',
                        'data-confirm' => 'Are you sure to finish external dandori for this plan ?',
                    ]);
                } else {
                    return '<button class="btn btn-primary btn-xs disabled">' . $link_txt . '</button>';
                }
            }, 'dandori-handover' => function($url, $model, $key){
                $link_txt = '<i class="fa fa-check-square-o"></i> Hand Over';
                if ($model->ext_dandori_status == 2 && $model->plan_run = 'N') {
                    return Html::a($link_txt, Url::to(['dandori-handover', 'lot_id' => $model->lot_id]), [
                        'class' => 'btn btn-primary btn-xs',
                        'data-confirm' => 'Are you sure to hand over external dandori for this plan ?',
                    ]);
                } else {
                    return '<button class="btn btn-primary btn-xs disabled">' . $link_txt . '</button>';
                }
            }
        ],
        'urlCreator' => function($action, $model, $key, $index) {
            // using the column name as key, not mapping to 'id' like the standard generator
            $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
            $params[0] = \Yii::$app->controller->id ? \Yii::$app->controller->id . '/' . $action : $action;
            return Url::toRoute($params);
        },
        'contentOptions' => ['nowrap'=>'nowrap', 'class' => 'text-center', 'style' => 'vertical-align: middle;'],
    ],
    [
        'attribute' => 'child_analyst',
        'label' => 'Location',
        'value' => function($model){
            return $model->child_analyst_desc;
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filter' => ArrayHelper::map(app\models\WipLocation::find()->select('child_analyst, child_analyst_desc')->where(['child_analyst' => ['WM03', 'WI01', 'WI02', 'WI03']])->groupBy('child_analyst, child_analyst_desc')->orderBy('child_analyst_desc')->all(), 'child_analyst', 'child_analyst_desc'),
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'plan_date',
        'value' => function($model){
            if ($model->plan_date == null) {
                return '-';
            }
            return date('Y-m-d', strtotime($model->plan_date));
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '100px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'lot_id',
        'label' => 'Lot Number',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '100px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'LINE',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filter' => [
        	'01' => '01',
        	'02' => '02',
        ],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'SMT_SHIFT',
        'label' => 'Shift',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '100px',
        'filter' => [
            '01-PAGI' => '01-PAGI',
            '02-SIANG' => '02-SIANG',
            '03-MALAM' => '03-MALAM',
        ],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 100px;'
        ],
    ],
    /*[
        'attribute' => 'KELOMPOK',
        'label' => 'Group',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filter' => [
        	'A' => 'A',
        	'B' => 'B',
        	'C' => 'C',
        	'D' => 'D',
        ],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],*/
    [
        'attribute' => 'child_all',
        'label' => 'Part Number',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '100px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'child_desc_all',
        'label' => 'Part Description',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'qty_all',
        'label' => 'Total Qty',
        'mergeHeader' => true,
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '100px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'class' => 'kartik\grid\EnumColumn',
        'attribute' => 'ext_dandori_status',
        'label' => 'Dandori Status',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'enum' => [
            0 => '<span class="text-red">' . \Yii::$app->params['ext_dandori_status'][0] . '</span>',
            1 => '<span class="text-yellow">' . \Yii::$app->params['ext_dandori_status'][1] . '</span>',
            2 => '<span class="text-yellow">' . \Yii::$app->params['ext_dandori_status'][2] . '</span>',
            3 => '<span class="text-green">' . \Yii::$app->params['ext_dandori_status'][3] . '</span>',
        ],
        'filter' => [
            0 => \Yii::$app->params['ext_dandori_status'][0],
            1 => \Yii::$app->params['ext_dandori_status'][1],
            2 => \Yii::$app->params['ext_dandori_status'][2],
            3 => \Yii::$app->params['ext_dandori_status'][3],
        ],
        'format' => 'html',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    /*[
        'attribute' => 'plan_run',
        'label' => 'Plan Status',
        'value' => function($model){
        	if ($model->plan_run == 'N') {
        		return '<span class="badge bg-aqua">OPEN</span>';
        	} elseif ($model->plan_run == 'R') {
        		return '<span class="badge bg-yellow">RUNNING</span>';
        	} else {
        		return '<span class="badge bg-green">CLOSED</span>';
        	}
        },
        'format' => 'html',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '100px',
        'filter' => [
            'R' => 'RUNNING',
            'N' => 'OPEN',
            'E' => 'CLOSED',
        ],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 100px;'
        ],
    ],*/
];
?>
<div class="giiant-crud wip-eff-tbl-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <div class="">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $columns,
            'hover' => true,
            //'condensed' => true,
            'pjax' => true,
            'striped' => true,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto; font-size: 12px;'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
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
                //'footer' => false,
            ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


