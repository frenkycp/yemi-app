<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use miloschuman\highcharts\Highcharts;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\MntMinimumStockSearch $searchModel
*/

$this->title = [
    'page_title' => 'Data Sparepart Maintenance <span class="text-green japanesse"></span>',
    'tab_title' => 'Data Sparepart Maintenance',
    'breadcrumbs_title' => 'Data Sparepart Maintenance'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss(".japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

$grid_column = [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'checkboxOptions' => function($model) {
            if ($model->NIP_RCV == null || $model->ACCOUNT == null || $model->LT == null || $model->PR_COST_DEP == null) {
                return [
                    'value' => $model->ITEM,
                    'disabled' => true,
                    'title' => 'Some data needed before ordered...!',
                ];
            }
            /*$find_slip = app\models\GojekOrderTbl::find()
            ->where([
                'slip_id' => $model->slip_id,
                'source' => 'WIP'
            ])
            ->one();
            if ($find_slip->slip_id == null) {
                return ['value' => $model->slip_id];
            } else {
                return [
                    'value' => $model->slip_id,
                    'disabled' => true,
                    'title' => 'This item has been ordered by ' . $find_slip->NAMA_KARYAWAN . ' to ' . $find_slip->to_loc
                ];
            }*/
            return ['value' => $model->ITEM];
        },
    ],
    [
        'attribute' => 'ITEM',
        'label' => 'Kode Item',
        /*'value' => function($model){
            return Html::a($model->ITEM, ['get-image-preview', 'urutan' => $model->ITEM], ['class' => 'imageModal', 'data-pjax' => '0',]);
        },
        'format' => 'raw',*/
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'image',
        'label' => 'Foto',
        'value' => function($model){
            return Html::a(Html::img('http://10.110.52.5:84/product_image/' . $model->ITEM . '.jpg', [
                'width' => '20px',
                'height' => '20px',
                'alt' => '-'
            ]), ['get-image-preview', 'urutan' => $model->ITEM], ['class' => 'imageModal', 'data-pjax' => '0',]);
        },
        'format' => 'html',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '50px',
    ],
    [
        'attribute' => 'ITEM_EQ_DESC_01',
        'label' => 'Deskripsi',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px; min-width: 120px;'
        ],
    ],
    [
        'attribute' => 'RACK',
        'label' => 'Rak',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'MACHINE',
        'label' => 'ID Mesin',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 60px;'
        ],
    ],
    [
        'attribute' => 'MACHINE_NAME',
        'label' => 'Nama Mesin',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 100px;'
        ],
    ],
    [
        'attribute' => 'CATEGORY',
        'label' => 'Kategori',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'hidden' => true,
    ],
    [
        'attribute' => 'ITEM_EQ_UM',
        'label' => 'UM',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 20px;'
        ],
    ],
    [
        'attribute' => 'MIN_STOCK_QTY',
        'encodeLabel' => false,
        'label' => 'Min<br/>Qty',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '80px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'req_qty',
        'encodeLabel' => false,
        'label' => 'Req.<br/>Qty',
        'value' => function($model){
            if ($model->ONHAND_STATUS == 4) {
                return '-';
            }
            return (2 * $model->MIN_STOCK_QTY);
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '80px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'ONHAND',
        'encodeLabel' => false,
        'label' => 'Onhand<br/>Qty',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '80px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'PO',
        'encodeLabel' => false,
        'label' => 'PO<br/>Qty',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '80px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'IMR',
        'encodeLabel' => false,
        'label' => 'IMR<br/>Qty',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '80px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'ONHAND_STATUS_DESC',
        'label' => 'Status',
        'value' => function($model){
            $label_class = '';
            if ($model->ONHAND_STATUS_DESC == 'ASAP TO ORDER') {
                $label_class = 'label-danger';
            } elseif ($model->ONHAND_STATUS_DESC == 'ORDER' || $model->ONHAND_STATUS_DESC == 'ASAP WAITING RECEIVE') {
                $label_class = 'label-warning';
            } elseif ($model->ONHAND_STATUS_DESC == 'READY') {
                $label_class = 'label-success';
            }
            return '<span class="label ' . $label_class . '">' . $model->ONHAND_STATUS_DESC . '</span>';
        },
        'format' => 'raw',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 80px;'
        ],
        'filter' => $dropdown_status,
    ],
    [
        'attribute' => 'ONHAND_STATUS_BY_MTTR',
        'label' => 'Status (By MTTR)',
        'value' => function($model){
            $label_class = '';
            if ($model->ONHAND_STATUS_BY_MTTR == 'ASAP TO ORDER') {
                $label_class = 'label-danger';
            } elseif ($model->ONHAND_STATUS_BY_MTTR == 'ORDER' || $model->ONHAND_STATUS_BY_MTTR == 'ASAP WAITING RECEIVE') {
                $label_class = 'label-warning';
            } elseif ($model->ONHAND_STATUS_BY_MTTR == 'READY') {
                $label_class = 'label-success';
            }
            return '<span class="label ' . $label_class . '">' . $model->ONHAND_STATUS_BY_MTTR . '</span>';
        },
        'format' => 'raw',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 80px;'
        ],
        'filter' => $dropdown_status,
    ],
    [
        'attribute' => 'LAST_MONTH_MTTR',
        'label' => 'MTTR (Last Month)',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'POST_DATE',
        'value' => function($model){
            return $model->POST_DATE !== null ? date('Y-m-d', strtotime($model->POST_DATE)) : '-';
        },
        'label' => 'Last<br/>Purchase Date',
        'encodeLabel' => false,
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'UNIT_PRICE',
        'label' => 'Last Price',
        'value' => function($model){
            return number_format($model->UNIT_PRICE);
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'CURR',
        'label' => 'Currency',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'budget',
        'label' => 'Expenses/<br/>Fix Asset',
        'encodeLabel' => false,
        'value' => function($model)
        {
            $price = $model->UNIT_PRICE;
            if ($price == 0 || $model->CURR == null) {
                return '-';
            } else {
                $budget_rate = app\models\AccountBudgetRate::find()
                ->where(['<', 'START_DATE', date('Y-m-d 00:00:00')])
                ->andWhere(['>', 'END_DATE', date('Y-m-d 00:00:00')])
                ->andWhere(['CURR' => $model->CURR])
                ->one();

                if ($budget_rate == null) {
                    $budget_rate = app\models\AccountBudgetRate::find()
                    ->where(['CURR' => $model->CURR])
                    ->orderBy('START_DATE DESC')
                    ->one();
                }

                $rate = $budget_rate->RATE;
                $usd_price = 0;
                if ($rate != 0) {
                    $usd_price = round($price / $rate);
                }
                

                if ($usd_price <= 1000) {
                    return 'Expenses';
                } else {
                    return 'Fixed Asset';
                }
                return $usd_price;
            }
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'NIP_RCV',
        //'label' => 'Currency',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'ACCOUNT',
        //'label' => 'Currency',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'LT',
        //'label' => 'Currency',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'PR_COST_DEP',
        //'label' => 'Currency',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
];

$this->registerJs("$(document).ready(function() {
    $('#order_btn').click(function(){
        var keys = $('#grid').yiiGridView('getSelectedRows');
        if(keys.length == 0){
            alert('Please select minimal 1 item...!');
            return false;
        }
        var strvalue = \"\";
        var value_arr = [];
        $('input[name=\"selection[]\"]:checked').each(function() {
            var tmp_qty = parseInt($(this).closest('tr').find('td:eq(10)').text());
            var tmp_niprcv = $(this).closest('tr').find('td:eq(19)').text();
            var tmp_account = $(this).closest('tr').find('td:eq(20)').text();
            var tmp_lt = $(this).closest('tr').find('td:eq(21)').text();
            var tmp_cost_dep = $(this).closest('tr').find('td:eq(22)').text();
            value_arr.push({item:this.value, req_qty:tmp_qty, nip_rcv:tmp_niprcv, account:tmp_account, lt:tmp_lt, cost_dep: tmp_cost_dep});
            //alert(tmp_qty);
            if(strvalue!=\"\")
                strvalue = strvalue + \",\"+this.value;
            else
                strvalue = this.value;
        });
        $.post({
            url: '" . Url::to(['order']) . "',
            data: {
                keylist: keys,
                value : strvalue,
                order_arr : JSON.stringify(value_arr)
            },
            dataType: 'json',
            success: function(data) {
                //alert(data.message);
                if(data.success == false){
                    alert(\"Can't create IMR. \" + data.message);
                } else {
                    alert(data.message);
                    location.href = location.href;
                }
            },
            error: function (request, status, error) {
                alert(error);
            }
        });
    });
    $('.imageModal').click(function(e) {
        e.preventDefault();
        $('#image-modal').modal('show').find('.modal-body').load($(this).attr('href'));
    });
});");
?>

<?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>
<div class="row">
    <div class="col-sm-6">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Summary</h3>
            </div>
            <div class="panel-body no-padding">
                <?php
                echo Highcharts::widget([
                    'scripts' => [
                        //'modules/exporting',
                        //'themes/sand-signika',
                        //'themes/grid-light',
                    ],
                    'options' => [
                        'chart' => [
                            'type' => 'pie',
                            'style' => [
                                'fontFamily' => 'sans-serif',
                            ],
                            'plotBackgroundColor' => null,
                            'plotBorderWidth' => null,
                            'plotShadow' => false,
                            'height' => 400,
                        ],
                        'title' => [
                            'text' => null
                        ],
                        'credits' => [
                            'enabled' =>false
                        ],
                        'tooltip' => [
                            'pointFormat' => '{series.name}: <b>{point.percentage:.0f}% ({point.y} Part(s))</b>',
                        ],
                        'plotOptions' => [
                            'pie' => [
                                // 'allowPointSelect' => true,
                                // 'cursor' => 'pointer',
                                'dataLabels' => [
                                    'enabled' => true,
                                    'format' => '<b>{point.name}</b>: {point.percentage:.0f}% ({point.y} Part(s))'
                                ],
                            ],
                            /*'series' => [
                                'cursor' => 'pointer',
                                'point' => [
                                    'events' => [
                                        'click' => new JsExpression("
                                            function(e){
                                                e.preventDefault();
                                                $('#modal').modal('show').find('.modal-body').html('<div class=\"text-center\">" . Html::img('@web/loading-01.gif', ['alt'=>'some', 'class'=>'thing']) . "</div>').load(this.options.url);
                                            }
                                        "),
                                    ]
                                ]
                            ],*/
                        ],
                        'series' => $data
                    ],
                ]);
                ?>
            </div>
        </div>
    </div>
</div>

<div class="giiant-crud minimum-stock-index">
    <div class="">
        <?= GridView::widget([
            'id' => 'grid',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $grid_column,
            'hover' => true,
            'pager' => [
                'firstPageLabel' => 'First',
                'lastPageLabel'  => 'Last'
            ],
            //'showPageSummary' => true,
            //'condensed' => true,
            'striped' => true,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto; font-size: 12px;'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'pjax' => true, // pjax is set to always true for this demo
            'toolbar' =>  [
                /*['content' => 
                    Html::a('View Chart', $main_link, ['data-pjax' => 0, 'class' => 'btn btn-warning', 'title' => Yii::t('kvgrid', 'Show View Chart')])
                ],*/
                '{export}',
                '{toggleData}',
            ],
            // set export properties
            'export' => [
                'fontAwesome' => true
            ],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'after' => '<button class="btn btn-primary" id="order_btn">Order</button>',
                'afterOptions' => [
                    'class'=>'kv-panel-after pull-right',
                ]
            ],
        ]); 

        yii\bootstrap\Modal::begin([
            'id' =>'image-modal',
            //'header' => '',
            //'size' => 'modal-lg',
        ]);
        yii\bootstrap\Modal::end();
        ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


