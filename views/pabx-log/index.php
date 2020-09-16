<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\PabxLogSearch $searchModel
*/

$this->title = [
    'page_title' => 'PABX Log Data <span class="japanesse text-green"></span>',
    'tab_title' => 'PABX Log Data',
    'breadcrumbs_title' => 'PABX Log Data'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }
");

date_default_timezone_set('Asia/Jakarta');

$gridColumns = [
    [
        'attribute' => 'last_update',
        'value' => function($model){
            if ($model->last_update == null) {
                return '-';
            } else {
                return date('Y-m-d H:i:s', strtotime($model->last_update));
            }
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => ' min-width: 100px;'
        ],
    ],
    [
        'attribute' => 'nik',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => ' min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'nama_karyawan',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => ' min-width: 100px;'
        ],
    ],
    [
        'attribute' => 'departemen',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => ' min-width: 100px;'
        ],
    ],
    [
        'attribute' => 'durasi',
        'value' => function($model){
            if ($model->durasi == null) {
                return '-';
            } else {
                return date('H:i:s', strtotime($model->durasi));
            }
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => ' min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'phone',
        'label' => 'Phone Number',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => ' min-width: 100px;'
        ],
    ],
    [
        'attribute' => 'provider_name',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => ' min-width: 100px;'
        ],
    ],
    [
        'attribute' => 'registered_name',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => ' min-width: 100px;'
        ],
    ],
];
?>
<div class="giiant-crud pabx-log-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <div class="">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $gridColumns,
            'hover' => true,
            //'condensed' => true,
            'striped' => true,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto; '], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'toolbar' => $toolbar,
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


