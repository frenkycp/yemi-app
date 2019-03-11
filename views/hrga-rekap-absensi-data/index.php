<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\HrgaAttendanceDataSearch $searchModel
*/

$this->title = 'Absent Report (MONTH)';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs("$(function() {
   $('.popup_btn').click(function(e) {
     e.preventDefault();
     $('#modal').modal('show').find('.modal-content').html('<div class=\"text-center\">" . Html::img('@web/loading-01.gif', ['alt'=>'some', 'class'=>'thing']) . "</div>').load($(this).attr('href'));
   });
});");

$gridColumns = [
    [
        'attribute' => 'PERIOD',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '90px',
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
        'width' => '90px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'NAMA_KARYAWAN',
        'vAlign' => 'middle',
        'width' => '200px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'GRADE',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '70px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'ALPHA',
        'label' => 'A',
        'value' => function($model){
            if ($model->ALPHA == 0) {
                return 0;
            }
            return Html::a('<span class="badge bg-yellow">' . $model->ALPHA . '</span>', ['my-hr/get-disiplin-detail','nik'=>$model->NIK, 'nama_karyawan' => $model->NAMA_KARYAWAN, 'period' => $model->PERIOD, 'note' => 'A'], ['class' => 'popup_btn']);
        },
        'format' => 'html',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'IJIN',
        'label' => 'I',
        'value' => function($model){
            if ($model->IJIN == 0) {
                return 0;
            }
            return Html::a('<span class="badge bg-yellow">' . $model->IJIN . '</span>', ['my-hr/get-disiplin-detail','nik'=>$model->NIK, 'nama_karyawan' => $model->NAMA_KARYAWAN, 'period' => $model->PERIOD, 'note' => 'I'], ['class' => 'popup_btn']);
        },
        'format' => 'html',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'SAKIT',
        'label' => 'S',
        'value' => function($model){
            if ($model->SAKIT == 0) {
                return 0;
            }
            return Html::a('<span class="badge bg-yellow">' . $model->SAKIT . '</span>', ['my-hr/get-disiplin-detail','nik'=>$model->NIK, 'nama_karyawan' => $model->NAMA_KARYAWAN, 'period' => $model->PERIOD, 'note' => 'S'], ['class' => 'popup_btn']);
        },
        'format' => 'html',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'CUTI',
        'label' => 'C',
        'value' => function($model){
            if ($model->CUTI == 0) {
                return 0;
            }
            return Html::a('<span class="badge bg-yellow">' . $model->CUTI . '</span>', ['my-hr/get-disiplin-detail','nik'=>$model->NIK, 'nama_karyawan' => $model->NAMA_KARYAWAN, 'period' => $model->PERIOD, 'note' => 'C'], ['class' => 'popup_btn']);
        },
        'format' => 'html',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'CUTI_KHUSUS',
        'label' => 'CK',
        'value' => function($model){
            if ($model->CUTI_KHUSUS == 0) {
                return 0;
            }
            return Html::a('<span class="badge bg-yellow">' . $model->CUTI_KHUSUS . '</span>', ['my-hr/get-disiplin-detail','nik'=>$model->NIK, 'nama_karyawan' => $model->NAMA_KARYAWAN, 'period' => $model->PERIOD, 'note' => 'CK'], ['class' => 'popup_btn']);
        },
        'format' => 'html',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'DATANG_TERLAMBAT',
        'label' => 'DL',
        'value' => function($model){
            if ($model->DATANG_TERLAMBAT == 0) {
                return 0;
            }
            return Html::a('<span class="badge bg-yellow">' . $model->DATANG_TERLAMBAT . '</span>', ['my-hr/get-disiplin-detail','nik'=>$model->NIK, 'nama_karyawan' => $model->NAMA_KARYAWAN, 'period' => $model->PERIOD, 'note' => 'DL'], ['class' => 'popup_btn']);
        },
        'format' => 'html',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'PULANG_CEPAT',
        'label' => 'PC',
        'value' => function($model){
            if ($model->PULANG_CEPAT == 0) {
                return 0;
            }
            return Html::a('<span class="badge bg-yellow">' . $model->PULANG_CEPAT . '</span>', ['my-hr/get-disiplin-detail','nik'=>$model->NIK, 'nama_karyawan' => $model->NAMA_KARYAWAN, 'period' => $model->PERIOD, 'note' => 'PC'], ['class' => 'popup_btn']);
        },
        'format' => 'html',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'DISIPLIN',
        'label' => 'Tunjangan Disiplin',
        'value' => function($model){
            if ($model->DISIPLIN == 0) {
                return '<span class="text-red">TIDAK DAPAT</span>';
            }
            return '<span class="text-green">DAPAT</span>';
        },
        'format' => 'raw',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filter' => [
            1 => 'DAPAT',
            0 => 'TIDAK DAPAT'
        ],
        //'hiddenFromExport' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'SHIFT2',
        'label' => 'Shift II',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'SHIFT3',
        'label' => 'Shift III',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'SHIFT4',
        'label' => 'Shift IV',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
    ],
    /*[
        'attribute' => 'DISIPLIN',
        'value' => function($model){
            if ($model->DISIPLIN == 0) {
                return 'TIDAK DISIPLIN';
            }
            return 'DISIPLIN';
        },
        'format' => 'raw',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'hidden' => true
    ],*/
];
?>
<div class="giiant-crud absensi-tbl-index">

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