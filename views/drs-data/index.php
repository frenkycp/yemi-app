<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\AssetTblSearch $searchModel
*/

$this->title = [
    'page_title' => 'Defect Report Slip Data <span class="text-green japanesse"></span>',
    'tab_title' => 'Defect Report Slip Data',
    'breadcrumbs_title' => 'Defect Report Slip Data'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');

$this->registerCss(".japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

$gridColumns = [
    [
        'attribute' => 'DRS_DATE',
        'label' => 'Date',
        'value' => function($model){
            $date = '-';
            if ($model->DRS_DATE != null) {
                $date = date('Y-m-d', strtotime($model->DRS_DATE));
            }
            return $date;
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '100px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 100px;'
        ],
    ],
    [
        'attribute' => 'NG_LOC',
        'label' => 'NG Location',
        'value' => function($model){
            return $model->NG_LOC_DESC;
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '105px',
        'filter' => ArrayHelper::map(app\models\DrsLocTbl::find()->orderBy('LOC_DESC ASC')->all(), 'LOC', 'LOC_DESC'),
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'ITEM',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '100px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 100px;'
        ],
    ],
    [
        'attribute' => 'ITEM_DESC',
        'label' => 'Item Description',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'UM',
        'label' => 'UOM',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '60px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'NG_QTY',
        'label' => 'NG Qty',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '60px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'LOT_QTY',
        'label' => 'Lot Qty',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '60px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'REASON_ID',
        'label' => 'Reason',
        'value' => function($model){
            return $model->REASON_DESC;
        },
        //'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '150px',
        'filter' => ArrayHelper::map(app\models\DrsReasonTbl::find()->orderBy('REASON_DESC ASC')->all(), 'REASON_ID', 'REASON_DESC'),
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'REMARK',
        'label' => 'Remark',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    /*[
        'attribute' => 'DRS_PUR_LOC',
        'label' => 'Vendor Code',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '100px',
        'mergeHeader' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],*/
    [
        'attribute' => 'DRS_PUR_LOC_DESC',
        'label' => 'Vendor Name (DRS)',
        'encodeLabel' => false,
        'vAlign' => 'middle',
        'width' => '100px',
        'mergeHeader' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    /*[
        'attribute' => 'DRS_CURR',
        'label' => 'Curr.',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '100px',
        'mergeHeader' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'DRS_UNIT_PRICE',
        'label' => 'Price',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '100px',
        'mergeHeader' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'DRS_AMOUNT',
        'label' => 'Amount',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '100px',
        'mergeHeader' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],*/
    [
        'attribute' => 'PIC_DELIVERY',
        'label' => 'Deliv. PIC',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '100px',
        'mergeHeader' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    /*[
        'attribute' => 'DSR_STAT',
        'label' => 'Status',
        'value' => function($model){
            if ($model->DSR_STAT == 'O') {
                return 'OPEN';
            } else {
                return 'CLOSE';
            }
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '100px',
        'mergeHeader' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],*/
    [
        'attribute' => 'REFERENSI_NOTE',
        'label' => 'Reference',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '100px',
        'mergeHeader' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'DRS_USER_ID',
        'label' => 'DRS User ID',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '100px',
        'mergeHeader' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'DRS_USER_DESC',
        'label' => 'DRS User Name',
        'vAlign' => 'middle',
        'width' => '100px',
        'mergeHeader' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'DRS_LAST_UPDATE',
        'label' => 'DRS Last Update',
        'label' => 'Last Update',
        'value' => function($model){
            $last_update = '-';
            if ($model->DRS_LAST_UPDATE != null) {
                $last_update = date('Y-m-d H:i:s', strtotime($model->DRS_LAST_UPDATE));
            }
            return $last_update;
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '100px',
        'mergeHeader' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'DEBIT_PUR_LOC_DESC',
        'label' => 'Vendor Name (Debit)',
        'encodeLabel' => false,
        'vAlign' => 'middle',
        'width' => '100px',
        'mergeHeader' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'DEBIT_NO',
        'label' => 'Debit Num.',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '100px',
        'mergeHeader' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'DEBIT_URUT',
        'label' => 'Debit Urut',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '100px',
        'mergeHeader' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'DEBIT_QTY',
        'label' => 'Debit Qty',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '100px',
        'mergeHeader' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'DEBIT_CURR',
        'label' => 'Debit Curr.',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '100px',
        'mergeHeader' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'DEBIT_PRICE',
        'label' => 'Debit Price',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '100px',
        'mergeHeader' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'DEBIT_AMOUNT',
        'label' => 'Debit Amount',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '100px',
        'mergeHeader' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'DEBIT_STAT',
        'label' => 'Debit Status',
        'value' => function($model){
            if ($model->DEBIT_STAT == 'O') {
                return 'OPEN';
            } else {
                return 'CLOSE';
            }
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '100px',
        'mergeHeader' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'DEBIT_DATE',
        'label' => 'Debit Date',
        'value' => function($model){
            $debit_date = '-';
            if ($model->DEBIT_DATE != null) {
                $debit_date = date('Y-m-d H:i:s', strtotime($model->DEBIT_DATE));
            }
            return $debit_date;
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '100px',
        'mergeHeader' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'DEBIT_REASON',
        'label' => 'Debit Reason',
        'value' => function($model){
            return $model->DEBIT_REASON_DESC;
        },
        'vAlign' => 'middle',
        'width' => '100px',
        'mergeHeader' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'DEBIT_NOTE',
        'label' => 'Debit Note',
        'vAlign' => 'middle',
        'width' => '100px',
        'mergeHeader' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'DEBIT_NOTE2',
        'label' => 'Debit Note 2',
        'vAlign' => 'middle',
        'width' => '100px',
        'mergeHeader' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'DEBIT_USER_ID',
        'label' => 'Debit User ID',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '100px',
        'mergeHeader' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'DEBIT_USER_DESC',
        'label' => 'Debit User Name',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '100px',
        'mergeHeader' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'DEBIT_LAST_UPDATE',
        'label' => 'Debit Last Update',
        'value' => function($model){
            $debit_last_update = '-';
            if ($model->DEBIT_LAST_UPDATE != null) {
                $debit_last_update = date('Y-m-d H:i:s', strtotime($model->DEBIT_LAST_UPDATE));
            }
            return $debit_last_update;
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '100px',
        'mergeHeader' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
];
?>
<div class="giiant-crud asset-tbl-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <div class="">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $gridColumns,
            //'hover' => true,
            //'condensed' => true,
            'striped' => false,
            'pager' => [
                'firstPageLabel' => 'First',
                'lastPageLabel'  => 'Last'
            ],
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
                'type' => GridView::TYPE_INFO,
            ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


