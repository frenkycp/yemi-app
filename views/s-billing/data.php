<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\SBillingSearch $searchModel
*/

$this->title = [
    'page_title' => 'Invoice Data Table <span class="japanesse light-green"></span>',
    'tab_title' => 'Invoice Data Table',
    'breadcrumbs_title' => 'Invoice Data Table'
];

date_default_timezone_set('Asia/Jakarta');

$this->registerCss("h1 .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }
    td .btn {
        margin: 0px 2px;
    }
");

$gridColumns = [
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{received}{remark}',
        'buttons' => [
            'received' => function($url, $model, $key){
                $url = ['receive', 'no' => $model->no];
                $options = [
                    'title' => 'Received',
                    'data-pjax' => '0',
                    'data-confirm' => 'Did you receive the document?',
                ];
                if ($model->stage != 1 || $model->dihapus == 'Y') {
                    return '<button class="btn btn-block btn-success disabled btn-sm" title="Received"><span class="fa fa-sign-in"></span> Receive</button>';
                }
                return Html::a('<button class="btn btn-block btn-success btn-sm"><span class="fa fa-sign-in"></span> Receive</button>', $url, $options);
            },
            'finished' => function($url, $model, $key){
                $options = [
                    'data-pjax' => '0',
                    'value' => Url::to(['pch-finish','no' => $model->no]),
                    'title' => 'Pch. Finish',
                    'class' => 'showModalButton'
                ];

                if ($model->stage != 2) {
                    return '<button class="btn btn-danger disabled btn-sm" title="Pch. Finished"><span class="fa fa-check-square-o"></span></button>';
                }
                
                return Html::a('<button class="btn btn-success btn-sm" title="Pch. Finished"><span class="fa fa-check-square-o"></span></button>', '#', $options);

                /*$url = ['pch-finish', 'no' => $model->no];
                $options = [
                    'title' => 'Pch. Finished',
                    'data-pjax' => '0',
                ];
                if ($model->stage != 2) {
                    return '<button class="btn btn-danger disabled" title="Pch. Finished"><span class="fa fa-check-square-o"></span></button>';
                }
                return Html::a('<button class="btn btn-success"><span class="fa fa-check-square-o"></span></button>', $url, $options);*/
            },
            'remark' => function($url, $model, $key){
                $options = [
                    'data-pjax' => '0',
                    'value' => Url::to(['remark','no' => $model->no]),
                    'title' => 'Edit Remark',
                    'class' => 'showModalButton'
                ];
                
                return Html::a('<button style="margin-top: 5px;" class="btn btn-block btn-info btn-sm"><span class="fa fa-edit"></span> Remark</button>', '#', $options);
            },
        ],
        'urlCreator' => function($action, $model, $key, $index) {
            $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
            $params[0] = \Yii::$app->controller->id ? \Yii::$app->controller->id . '/' . $action : $action;
            return Url::toRoute($params);
        },
        'contentOptions' => ['nowrap'=>'nowrap', 'style' => 'min-width: 100px;']
    ],
    [
        'attribute' => 'docfile',
        'label' => 'Vendor<br/>Document',
        'encodeLabel' => false,
        'value' => function($model){
            return Html::a('<button class="btn btn-default btn-sm"><span class="fa fa-download"></span></button>', ['vendor-attachment', 'no' => $model->no
            ], [
                'title' => 'Download',
                'data-pjax' => '0',
            ]);
        },
        'mergeHeader' => true,
        'format' => 'raw',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'no',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'supplier_name',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'receipt_no',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'invoice_no',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'voucher_no',
        'hiddenFromExport' => true,
        'value' => function($model){
            if ($model->voucher_no != null) {
                return Html::a($model->voucher_no . ' <i class="fa fa-info-circle"></i>', ['voucher-detail', 'voucher_no' => $model->voucher_no], ['title' => 'Click for more detail...', 'target' => '_blank']);
            }
        },
        'format' => 'html',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'voucher_no_export',
        'label' => 'Voucher No.',
        'value' => function($model){
            return $model->voucher_no;
        },
        'hidden' => true,
        'format' => 'html',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'delivery_no',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'tax_no',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'amount',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'cur',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'doc_upload_date',
        'label' => 'Upload Date',
        'value' => function($model){
            if ($model->doc_upload_date != null) {
                return date('Y-m-d', strtotime($model->doc_upload_date));
            }
            
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'stage',
        'value' => function($model){
            if (isset(\Yii::$app->params['s_billing_stage_arr'][$model->stage])) {
                return \Yii::$app->params['s_billing_stage_arr'][$model->stage];
            } else {
                return '-';
            }
        },
        'filter' => \Yii::$app->params['s_billing_stage_arr'],
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'open_close',
        'label' => 'Status',
        'value' => function($model){
            if ($model->open_close == 'C') {
                return '<span class="label label-success">CLOSE</span>';
            } elseif ($model->open_close == 'O') {
                return '<span class="label label-danger">OPEN</span>';
            } else {
                return '-';
            }
        },
        'format' => 'html',
        'filter' => [
            'O' => 'OPEN',
            'C' => 'CLOSE',
        ],
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'dihapus',
        'label' => 'Deleted',
        'filter' => [
            'Y' => 'Y',
            'N' => 'N',
        ],
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'remark',
        'vAlign' => 'middle',
    ],
];
?>
<div class="giiant-crud supplier-billing-index">

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
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto; font-size: 12px;'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'toolbar' =>  [
                Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'Create Voucher', ['create-voucher'], ['class' => 'btn btn-success']),
                '{export}',
                '{toggleData}',
            ],
            'rowOptions' => function($model){
                if ($model->dihapus == 'Y') {
                    return ['class' => 'bg-danger'];
                }
            },
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


