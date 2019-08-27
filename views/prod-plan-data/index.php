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
    'page_title' => 'Production Plan Data <span class="japanesse text-green"></span>',
    'tab_title' => 'Production Plan Data',
    'breadcrumbs_title' => 'Production Plan Data'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');

$columns = [
	[
        'class' => 'yii\grid\ActionColumn',
        'template' => '{update}&nbsp;&nbsp;|&nbsp;&nbsp;{flow-process}',
        'buttons' => [
            'view' => function ($url, $model, $key) {
                $options = [
                    'title' => Yii::t('cruds', 'View'),
                    'aria-label' => Yii::t('cruds', 'View'),
                    'data-pjax' => '0',
                ];
                return Html::a('<span class="glyphicon glyphicon-file"></span>', $url, $options);
            }, 'flow-process' => function($url, $model, $key){
                $url = ['display/lot-flow-process', 'lot_number' => $model->lot_id];
                $options = [
                    'title' => 'View Flow Process',
                    'data-pjax' => '0',
                ];
                if ($model->child_analyst == 'WW02') {
                    return Html::a('<span class="fa fa-bar-chart"></span>', $url, $options);
                } else {
                    return '';
                }
                
            }
        ],
        'urlCreator' => function($action, $model, $key, $index) {
            // using the column name as key, not mapping to 'id' like the standard generator
            $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
            $params[0] = \Yii::$app->controller->id ? \Yii::$app->controller->id . '/' . $action : $action;
            return Url::toRoute($params);
        },
        'contentOptions' => ['nowrap'=>'nowrap'],
    ],
    [
        'attribute' => 'child_analyst_desc',
        'label' => 'Location',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filter' => ArrayHelper::map(app\models\WipLocation::find()->select('child_analyst_desc, child_analyst_desc')->groupBy('child_analyst_desc, child_analyst_desc')->orderBy('child_analyst_desc')->all(), 'child_analyst_desc', 'child_analyst_desc'),
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
    [
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
    ],
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
        'attribute' => 'plan_run',
        'label' => 'status',
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
    ],
	/*'child_01',*/
	/*'child_desc_01',*/
	/*'slip_id_02',*/
	/*'child_02',*/
	/*'child_desc_02',*/
	/*'slip_id_03',*/
	/*'child_03',*/
	/*'child_desc_03',*/
	/*'slip_id_04',*/
	/*'child_04',*/
	/*'child_desc_04',*/
	/*'slip_id_05',*/
	/*'child_05',*/
	/*'child_desc_05',*/
	/*'slip_id_06',*/
	/*'child_06',*/
	/*'child_desc_06',*/
	/*'slip_id_07',*/
	/*'child_07',*/
	/*'child_desc_07',*/
	/*'slip_id_08',*/
	/*'child_08',*/
	/*'child_desc_08',*/
	/*'slip_id_09',*/
	/*'child_09',*/
	/*'child_desc_09',*/
	/*'slip_id_10',*/
	/*'child_10',*/
	/*'child_desc_10',*/
	/*'child_all',*/
	/*'child_desc_all',*/
	/*'period',*/
	/*'USER_ID',*/
	/*'USER_DESC',*/
	/*'note01',*/
	/*'note02',*/
	/*'note03',*/
	/*'note04',*/
	/*'note05',*/
	/*'note06',*/
	/*'note07',*/
	/*'note08',*/
	/*'note09',*/
	/*'note10',*/
	/*'note11',*/
	/*'note12',*/
	/*'note13',*/
	/*'note14',*/
	/*'note15',*/
	/*'note16',*/
	/*'note17',*/
	/*'note18',*/
	/*'period_original',*/
	/*'plan_item',*/
	/*'plan_stats',*/
	/*'plan_run',*/
	/*'act_qty_01',*/
	/*'std_time_01',*/
	/*'act_qty_02',*/
	/*'std_time_02',*/
	/*'act_qty_03',*/
	/*'std_time_03',*/
	/*'act_qty_04',*/
	/*'std_time_04',*/
	/*'act_qty_05',*/
	/*'std_time_05',*/
	/*'act_qty_06',*/
	/*'std_time_06',*/
	/*'act_qty_07',*/
	/*'std_time_07',*/
	/*'act_qty_08',*/
	/*'std_time_08',*/
	/*'act_qty_09',*/
	/*'std_time_09',*/
	/*'act_qty_10',*/
	/*'std_time_10',*/
	/*'qty_all',*/
	/*'std_all',*/
	/*'lt_gross',*/
	/*'lt_loss',*/
	/*'lt_nett',*/
	/*'lt_std',*/
	/*'efisiensi_gross',*/
	/*'efisiensi',*/
	/*'long01',*/
	/*'long02',*/
	/*'long03',*/
	/*'long04',*/
	/*'long05',*/
	/*'long06',*/
	/*'long07',*/
	/*'long08',*/
	/*'long09',*/
	/*'long10',*/
	/*'long11',*/
	/*'long12',*/
	/*'long13',*/
	/*'long14',*/
	/*'long15',*/
	/*'long16',*/
	/*'long17',*/
	/*'long18',*/
	/*'long_total',*/
	/*'break_time',*/
	/*'nozzle_maintenance',*/
	/*'change_schedule',*/
	/*'air_pressure_problem',*/
	/*'power_failure',*/
	/*'part_shortage',*/
	/*'set_up_1st_time_running_tp',*/
	/*'part_arrangement_dcn',*/
	/*'meeting',*/
	/*'dandori',*/
	/*'porgram_error',*/
	/*'m_c_problem',*/
	/*'feeder_problem',*/
	/*'quality_problem',*/
	/*'pcb_transfer_problem',*/
	/*'profile_problem',*/
	/*'pick_up_error',*/
	/*'other',*/
	/*'plan_qty',*/
	/*'plan_balance',*/
	/*'slip_count',*/
	/*'start_date',*/
	/*'end_date',*/
	/*'post_date',*/
	/*'LAST_UPDATE',*/
	/*'post_date_original',*/
	/*'plan_date',*/
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


