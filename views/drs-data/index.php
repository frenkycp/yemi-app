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
    'page_title' => 'Defect Report Slip Data <span class="light-green japanesse"></span>',
    'tab_title' => 'Defect Report Slip Data',
    'breadcrumbs_title' => 'Defect Report Slip Data'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');

$this->registerCss("");

$gridColumns = [
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{request} {pc_approve} {wh_approve} {pulled_up}',
        'buttons' => [
            'request' => function($url, $model, $key){
                $url = ['request', 'DRS_NO' => $model->DRS_NO];
                $options = [
                    'title' => 'Request Supplement',
                    'data-pjax' => '0',
                    'data-confirm' => 'Are you sure to request supplement for this item...?',
                    'class' => 'btn btn-success btn-sm btn-block'
                ];
                if ($model->REQUEST_STAGE == 0) {
                    return Html::a('PRD. REQUEST', $url, $options);
                } else {
                    return '<button class="btn btn-success btn-sm btn-block disabled">PRD. REQUEST</button>';
                }
                
            },
            'pc_approve' => function($url, $model, $key){
                $url = ['pc-approve', 'DRS_NO' => $model->DRS_NO];
                $options = [
                    'title' => 'PC Approve',
                    'data-pjax' => '0',
                    'data-confirm' => 'Are you sure to approve this item...?',
                    'class' => 'btn btn-success btn-sm btn-block'
                ];
                if ($model->REQUEST_STAGE == 1) {
                    return Html::a('PC APPROVE', $url, $options);
                } else {
                    return '<button class="btn btn-success btn-sm btn-block disabled">PC APPROVE</button>';
                }
                
            },
            'wh_approve' => function($url, $model, $key){
                $url = ['wh-approve', 'DRS_NO' => $model->DRS_NO];
                $options = [
                    'title' => 'WH Approve',
                    'data-pjax' => '0',
                    'data-confirm' => 'Are you sure to approve this item...?',
                    'class' => 'btn btn-success btn-sm btn-block'
                ];
                if ($model->REQUEST_STAGE == 2) {
                    return Html::a('WH APPROVE', $url, $options);
                } else {
                    return '<button class="btn btn-success btn-sm btn-block disabled">WH APPROVE</button>';
                }
                
            },
            'pulled_up' => function($url, $model, $key){
                $url = ['pulled-up', 'DRS_NO' => $model->DRS_NO];
                $options = [
                    'title' => 'Pulled Up',
                    'data-pjax' => '0',
                    'data-confirm' => 'Are you sure to pull-up this item...?',
                    'class' => 'btn btn-success btn-sm btn-block'
                ];
                if ($model->REQUEST_STAGE == 3) {
                    return Html::a('PULLED UP', $url, $options);
                } else {
                    return '<button class="btn btn-success btn-sm btn-block disabled">PULLED UP</button>';
                }
                
            },
        ],
        'contentOptions' => ['nowrap'=>'nowrap', 'style' => 'width: 100px;']
    ],
    [
        'attribute' => 'DRS_NO',
        'label' => 'DRS NO',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '100px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 100px;'
        ],
    ],
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
            'style' => 'font-size: 12px; min-width: 130px;'
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
    [
        'attribute' => 'DETAIL_NG',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'LOT_CODE',
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
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px; min-width: 130px;'
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
        'attribute' => 'DSR_STAT',
        'label' => 'DRS Status',
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
        'filter' => [
            'O' => 'OPEN',
            'C' => 'CLOSE'
        ],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
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
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px; min-width: 130px;'
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
    /*[
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
    ],*/
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
    [
        'attribute' => 'SUPPLEMENT_REQUEST',
        'filter' => [
            'Y' => 'Y',
            'N' => 'N',
        ],
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'REQUEST_STAGE',
        'label' => 'Request Stage',
        'value' => function($model){
            return \Yii::$app->params['supplement_request_stage'][$model->REQUEST_STAGE];
        },
        'filter' => \Yii::$app->params['supplement_request_stage'],
        'hAlign' => 'center',
        'vAlign' => 'middle',
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


