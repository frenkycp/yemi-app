<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\date\DatePicker;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\SBillingSearch $searchModel
*/

$this->title = [
    'page_title' => 'Waiting Payment Data Table <span class="japanesse light-green"></span>',
    'tab_title' => 'Waiting Payment Data Table',
    'breadcrumbs_title' => 'Waiting Payment Data Table'
];

date_default_timezone_set('Asia/Jakarta');

$this->registerCss("h1 .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }
    td .btn {
        margin: 0px 2px;
    }
    .float{
        position:fixed;
        z-index: 2;
        width:110px;
        height:60px;
        top:135px;
        right:200px;
        background-color:#0C9;
        color:#FFF;
        //border-radius:50px;
        text-align:center;
        box-shadow: 2px 2px 3px #999;
    }
");

$this->registerJs("
    $(document).ready(function() {
        var tmp_qty = 0;
        
        var keys;
        function setTotalQty(){
            var total_qty = 0;
            $('input[name=\"selection[]\"]:checked').each(function() {
                tmp_qty = parseInt($(this).closest('tr').find('td:eq(6)').text());
                total_qty += tmp_qty;
            });
            $('#total_qty').val(Intl.NumberFormat('en-US').format(total_qty));
            keys = $('#grid').yiiGridView('getSelectedRows');
            if(keys.length > 0){
                $('#finish_payment_btn').prop('disabled', false);
                $('#finish_payment_btn').removeClass('disabled');
            } else {
                $('#finish_payment_btn').prop('disabled', true);
                $('#finish_payment_btn').addClass('disabled');
            }
        }
        $('.select-on-check-all').change(function(){
            setTotalQty();
        });
        $('.cb-column').change(function(){
            setTotalQty();
        });

        $('#finish_payment_btn').click(function(){
            var transfer_date = $('#transfer_date').val();
            if(tmp_qty == 0) {
                //alert('KOSONG');
                return false;
            }
            var strvalue = \"\";
            
            $('input[name=\"selection[]\"]:checked').each(function() {
                if(strvalue!=\"\")
                    strvalue = strvalue + \"|\"+this.value;
                else
                    strvalue = this.value;
            });
            //alert(strvalue);
            if (confirm('Are you sure to continue?')) {
                $('#overlay-id').show();
                $(this).attr('disabled', true).addClass('disabled');
                $.post({
                    url: '" . Url::to(['finish-payment']) . "',
                    data: {
                        keylist: keys,
                        value: strvalue,
                        transfer_date: transfer_date
                    },
                    dataType: 'json',
                    success: function(data) {
                        if(data.success == false){
                            alert(\"Can't finish payment. \" + data.message);
                        } else {
                            alert(data.message);
                        }
                        location.href = location.href;
                    },
                    error: function (request, status, error) {
                        alert(error);
                        location.href = location.href;
                    }
                });
            }
        });
    });
");

$gridColumns = [
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{detail}',
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
        'class' => 'yii\grid\CheckboxColumn',
        'checkboxOptions' => function($model) {
            return [
                'value' => $model->voucher_no,
                'class' => 'cb-column'
            ];
        },
    ],
    [
        'attribute' => 'voucher_no',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'voucher_period',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'supplier_name',
        'vAlign' => 'middle',
        'filter' => $supplier_dropdown,
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'options' => ['prompt' => ''],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ],
        //'hAlign' => 'center',
    ],
    [
        'attribute' => 'cur',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
        'pageSummary' => 'Total',
    ],
    [
        'attribute' => 'amount',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
        'pageSummary' => true,
    ],
    [
        'attribute' => 'create_time',
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

    <div class="box box-primary">
        <div class="box-body no-padding">
            <?= GridView::widget([
                'id' => 'grid',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $gridColumns,
                'showPageSummary' => true,
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
                    'after' => 
                    '<div class="form-group">
                    <label class="control-label" for="transfer_date">Transfer Date</label>'
                    . DatePicker::widget([
                        'name' => 'transfer_date',
                        'id' => 'transfer_date',
                        'type' => DatePicker::TYPE_INPUT,
                        'value' => date('Y-m-d'),
                        'options' => ['placeholder' => 'Select transfer date ...'],
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true,
                            'autoclose'=>true
                        ]
                    ]) .
                '</div>'
                    . '<button class="btn btn-primary disabled" id="finish_payment_btn">Finish Payment</button>',
                    'afterOptions' => [
                        'class'=>'kv-panel-after pull-right',
                    ],
                    //'heading' => 'Last Update : ' . date('Y-m-d H:i:s')
                ],
            ]); ?>
            
        </div>
        <div class="overlay" id="overlay-id" style="display: none;">
            <i class="fa fa-refresh fa-spin"></i>
        </div>
    </div>

</div>

<div class="form-group float">
    <label class="control-label" for="total_qty">Total</label>
    <?= Html::textInput('total_qty', '0', [
        'class' => 'form-control text-center',
        'readonly' => true,
        'id' => 'total_qty'
    ]); ?>
</div>


<?php \yii\widgets\Pjax::end() ?>


