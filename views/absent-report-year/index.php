<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\HrgaAttendanceDataSearch $searchModel
*/

$this->title = 'Absent Report (YEAR)';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs("$(function() {
   $('.popup_btn').click(function(e) {
     e.preventDefault();
     $('#modal').modal('show').find('.modal-content').html('<div class=\"text-center\">" . Html::img('@web/loading-01.gif', ['alt'=>'some', 'class'=>'thing']) . "</div>').load($(this).attr('href'));
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
        'attribute' => 'YEAR',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '100px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'NOTE',
        'label' => 'Category',
        'value' => function($model){
            return $model->CATEGORY;
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filter' => [
            'DL' => 'DATANG TERLAMBAT',
            'PC' => 'PULANG CEPAT',
            'A' => 'ALPHA',
            'I' => 'IJIN',
            'S' => 'SAKIT',
        ],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'SECTION',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'NIK',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '110px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'NAMA_KARYAWAN',
        'label' => 'Name',
        'vAlign' => 'middle',
        'width' => '250px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'total',
        'value' => function($model){
            return Html::a('<span class="badge bg-yellow">' . $model->total . '</span>', ['get-disiplin-detail', 'nik'=>$model->NIK, 'nama_karyawan' => $model->NAMA_KARYAWAN, 'year' => $model->YEAR, 'note' => $model->NOTE], ['class' => 'popup_btn']);
        },
        'format' => 'raw',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
];
?>


<div class="giiant-crud absensi-tbl-index">
    
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
                'heading' => $heading,
                //'footer' => false,
            ],
        ]); ?>
    </div>

</div>

<?php \yii\widgets\Pjax::end() ?>

<?php
    yii\bootstrap\Modal::begin([
        'id' =>'modal',
        'header' => '<h3>Detail Info</h3>',
        'size' => 'modal-lg',
    ]);
    yii\bootstrap\Modal::end();
?>