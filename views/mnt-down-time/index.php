<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use app\models\MachineIotSingle;

$this->title = [
    'page_title' => 'Monthly Down Time Data <span class="japanesse text-green"></span>',
    'tab_title' => 'Monthly Down Time Data',
    'breadcrumbs_title' => 'Monthly Down Time Data'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }
");

date_default_timezone_set('Asia/Jakarta');

$gridColumns = [
    [
        'class' => 'kartik\grid\SerialColumn',
        'contentOptions' => ['class' => 'kartik-sheet-style'],
        'width' => '36px',
        'header' => '',
        'headerOptions' => ['class' => 'kartik-sheet-style']
    ],
    [
        'attribute' => 'period',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'mesin_id',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'mesin_nama',
        'vAlign' => 'middle',
        //'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'location',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'area',
        'vAlign' => 'middle',
        //'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'down_time',
        'label' => 'Down Time (min)',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'down_time_number',

        'value' => function($model){
            if ($model->down_time_number <= 0) {
                return 0;
            } else {
                $tmp_year = substr($model->period, 0, 4);
                $tmp_month = substr($model->period, 4);
                $tmp_period = $tmp_year . '-' . $tmp_month;
                return Html::a($model->down_time_number,
                    ['mesin-check-ng/index',
                        'downtime_status' => 1,
                        'mesin_id' => $model->mesin_id,
                        'mesin_last_update' => $tmp_period
                    ],
                    ['title' => 'Click to view detail ...', 'target' => '_blank']);
            }
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'format' => 'raw',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'down_time_iot',
        'label' => 'Down Time (min) - IoT',
        'value' => function($model){
            $tmp_data = MachineIotSingle::find()
            ->select([
                'total_down_time' => 'SUM(merah)',
                'total_down_time_number' => 'COUNT(merah)',
            ])
            ->where([
                'mesin_id' => $model->mesin_id,
                'period' => $model->period,
                'status_warna' => 'MERAH'
            ])
            ->andWhere(['>', 'count', 60])
            ->one();
            return number_format($tmp_data->total_down_time / 60);
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'down_time_number_iot',
        'label' => 'Down Time Number - IoT',
        'value' => function($model){
            $tmp_data = MachineIotSingle::find()
            ->select([
                'total_down_time' => 'SUM(merah)',
                'total_down_time_number' => 'COUNT(merah)',
            ])
            ->where([
                'mesin_id' => $model->mesin_id,
                'period' => $model->period,
                'status_warna' => 'MERAH'
            ])
            ->andWhere(['>', 'count', 60])
            ->one();
            return number_format($tmp_data->total_down_time_number);
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'working_days',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'mttr',
        'label' => 'MTTR',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'mtbf',
        'label' => 'MTBF',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'mttr_iot',
        'label' => 'MTTR - IoT',
        'value' => function($model){
            $tmp_data = MachineIotSingle::find()
            ->select([
                'total_down_time' => 'SUM(merah)',
                'total_down_time_number' => 'COUNT(merah)',
            ])
            ->where([
                'mesin_id' => $model->mesin_id,
                'period' => $model->period,
                'status_warna' => 'MERAH'
            ])
            ->andWhere(['>', 'count', 60])
            ->one();
            if ($tmp_data->total_down_time_number > 0) {
                return round((($tmp_data->total_down_time / 60) / $tmp_data->total_down_time_number));
            } else {
                return 0;
            }
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'mtbf_iot',
        'label' => 'MTBF - IoT',
        'value' => function($model){
            $tmp_data = MachineIotSingle::find()
            ->select([
                'total_down_time' => 'SUM(merah)',
                'total_down_time_number' => 'COUNT(merah)',
            ])
            ->where([
                'mesin_id' => $model->mesin_id,
                'period' => $model->period,
                'status_warna' => 'MERAH'
            ])
            ->andWhere(['>', 'count', 60])
            ->one();
            if ($tmp_data->total_down_time_number > 0) {
                return round((($model->working_days * 1220) - ($tmp_data->total_down_time / 60)) / $tmp_data->total_down_time_number);
            } else {
                return 0;
            }
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'non_down_time',
        'label' => 'Non Down Time (min)',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 80px;'
        ],
    ],
    
];
?>
<div class="giiant-crud gojek-order-tbl-index">

    <?php
             echo $this->render('_search', [
                'model' => $searchModel,
                'mesin_dropdown' => $mesin_dropdown
            ]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <div class="">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'columns' => $gridColumns,
            'hover' => true,
            //'condensed' => true,
            'striped' => true,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto;'], // only set when $responsive = false
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
                'heading' => 'Last Update : ' . date('Y-m-d H:i:s')
                //'footer' => false,
            ],
        ]); ?>
    </div>

</div>