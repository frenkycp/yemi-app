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
    'page_title' => 'Data Table <span class="japanesse light-green"></span>',
    'tab_title' => 'Data Table',
    'breadcrumbs_title' => 'Data Table'
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
        'template' => '{received} {finished} {handover} {remark}',
        'buttons' => [
            'received' => function($url, $model, $key){
                $url = ['receive', 'no' => $model->no];
                $options = [
                    'title' => 'Received',
                    'data-pjax' => '0',
                    'data-confirm' => 'Did you receive the document?',
                ];
                if ($model->stage != 1) {
                    return '<button class="btn btn-danger disabled" title="Received"><span class="fa fa-sign-in"></span></button>';
                }
                return Html::a('<button class="btn btn-success"><span class="fa fa-sign-in"></span></button>', $url, $options);
            },
            'finished' => function($url, $model, $key){
                $options = [
                    'data-pjax' => '0',
                    'value' => Url::to(['pch-finish','no' => $model->no]),
                    'title' => 'Pch. Finish',
                    'class' => 'showModalButton'
                ];

                if ($model->stage != 2) {
                    return '<button class="btn btn-danger disabled" title="Pch. Finished"><span class="fa fa-check-square-o"></span></button>';
                }
                
                return Html::a('<button class="btn btn-success" title="Pch. Finished"><span class="fa fa-check-square-o"></span></button>', '#', $options);

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
            'handover' => function($url, $model, $key){
                $url = ['handover', 'no' => $model->no];
                $options = [
                    'title' => 'Handover to Finance',
                    'data-pjax' => '0',
                    'data-confirm' => 'Is it already handover to Finance?',
                ];
                if ($model->stage != 3) {
                    return '<button class="btn btn-danger disabled" title="Handover to Finance"><span class="fa fa-hand-paper-o"></span></button>';
                }
                return Html::a('<button class="btn btn-success"><span class="fa fa-hand-paper-o"></span></button>', $url, $options);
            },
            'remark' => function($url, $model, $key){
                $options = [
                    'data-pjax' => '0',
                    'value' => Url::to(['remark','no' => $model->no]),
                    'title' => 'Edit Remark',
                    'class' => 'showModalButton'
                ];
                
                return Html::a('<button class="btn btn-info"><span class="fa fa-edit"></span></button>', '#', $options);
            },
        ],
        'urlCreator' => function($action, $model, $key, $index) {
            $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
            $params[0] = \Yii::$app->controller->id ? \Yii::$app->controller->id . '/' . $action : $action;
            return Url::toRoute($params);
        },
        'contentOptions' => ['nowrap'=>'nowrap', 'style' => 'min-width: 250px;']
    ],
    [
        'attribute' => 'dokumen',
        'label' => 'Vendor<br/>Document',
        'encodeLabel' => false,
        'value' => function($model){
            return Html::a('<button class="btn btn-default"><span class="fa fa-download"></span></button>', ['vendor-attachment', 'no' => $model->no
            ], [
                'title' => 'Download Attachment',
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
            return date('Y-m-d', strtotime($model->doc_upload_date));
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
                //Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'Add', ['create'], ['class' => 'btn btn-success']),
                '{export}',
                '{toggleData}',
            ],
            /*'rowOptions' => function($model){
                if ($model->Discontinue == 'Y') {
                    return ['class' => 'bg-danger'];
                }
            },*/
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


