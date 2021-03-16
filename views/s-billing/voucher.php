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
    'page_title' => 'Voucher Data Table <span class="japanesse light-green"></span>',
    'tab_title' => 'Voucher Data Table',
    'breadcrumbs_title' => 'Voucher Data Table'
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
        'template' => '{handover}{detail}',
        'buttons' => [
            'handover' => function($url, $model, $key){
                $url = ['handover', 'voucher_no' => $model->voucher_no];
                $options = [
                    'title' => 'Handover',
                    'data-pjax' => '0',
                    'data-confirm' => 'Handover...?',
                ];
                if ($model->handover_status == 'C') {
                    return '<button class="btn btn-block btn-success disabled btn-sm" title="Handover"><span class="fa fa-hand-paper-o"></span> Handover</button>';
                }
                return Html::a('<button class="btn btn-block btn-success btn-sm"><span class="fa fa-hand-paper-o"></span> Handover</button>', $url, $options);
            },
            'detail' => function($url, $model, $key){
                $url = ['voucher-detail', 'voucher_no' => $model->voucher_no];
                $options = [
                    'title' => 'Voucher Detail',
                    'data-pjax' => '0',
                ];
                return Html::a('<button style="margin-top: 5px;" class="btn btn-block btn-info btn-sm"><span class="fa fa-search-plus"></span> Detail</button>', $url, $options);
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
        'attribute' => 'voucher_no',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'create_by_name',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'create_time',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'handover_status',
        'value' => function($model){
            if ($model->handover_status == 'C') {
                return '<span class="label label-success">CLOSE</span>';
            } elseif ($model->handover_status == 'O') {
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
        'label' => 'Handover<br/>Status',
        'encodeLabel' => false,
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'attachment',
        'value' => function($model){
            return Html::a('<button class="btn btn-default btn-sm"><span class="fa fa-download"></span></button>', ['voucher-attachment', 'voucher_no' => $model->voucher_no
            ], [
                'title' => 'Download',
                'data-pjax' => '0',
            ]) . Html::a('<button class="btn btn-default btn-sm"><span class="fa fa-pencil"></span></button>', ['voucher-attachment-edit', 'voucher_no' => $model->voucher_no
            ], [
                'title' => 'Update',
                'data-pjax' => '0',
            ]);
        },
        'mergeHeader' => true,
        'format' => 'raw',
        'vAlign' => 'middle',
        'hAlign' => 'center',
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
                //Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'Create Voucher', ['create-voucher'], ['class' => 'btn btn-success']),
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


