<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\ExpiredItemSearch $searchModel
*/

$this->title = [
    'page_title' => 'Expired Item Data <span class="japanesse text-green"></span>',
    'tab_title' => 'Expired Item Data',
    'breadcrumbs_title' => 'Expired Item Data'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

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

        $('#submit-btn').addClass('disabled');
        $('#submit-btn').prop('disabled', true);

        function setTotalQty(){
            var total_qty = 0;
            var selectedVal = $('#req-category').find('option:selected').val();

            if(selectedVal == 2) {
                $('#po-number').show();
            } else {
                $('#po-number').hide();
            }

            $('input[name=\"selection[]\"]:checked').each(function() {
                tmp_qty = parseFloat($(this).closest('tr').find('td:eq(6)').text());
                total_qty += tmp_qty;
            });
            $('#total_qty').val(Intl.NumberFormat('en-US').format(total_qty));
            $('#total-qty-hidden').val(total_qty);
            keys = $('#grid').yiiGridView('getSelectedRows');
            if(keys.length > 0 && selectedVal != ''){
                $('#submit-btn').removeClass('disabled');
                $('#submit-btn').prop('disabled', false);
            } else {
                $('#submit-btn').addClass('disabled');
                $('#submit-btn').prop('disabled', true);
            }
        }
        $('.select-on-check-all').change(function(){
            setTotalQty();
        });
        $('.cb-column').change(function(){
            setTotalQty();
        });

        $('#submit-btn').click(function(){
            var strvalue = \"\";
            var tmp_item = '';
            var tmp_item_desc = '';
            var tmp_uom = '';
            var tmp_vendor = '';
            var tmp_latest_epired_date = '';
            var tmp_lot_no = '';
            var is_multiple = false;

            $('input[name=\"selection[]\"]:checked').each(function() {
                if(tmp_item == '') {
                    tmp_lot_no = $(this).closest('tr').find('td:eq(2)').text();
                    tmp_item = $(this).closest('tr').find('td:eq(3)').text();
                    tmp_item_desc = $(this).closest('tr').find('td:eq(4)').text();
                    tmp_uom = $(this).closest('tr').find('td:eq(7)').text();
                    tmp_vendor = $(this).closest('tr').find('td:eq(8)').text();
                    tmp_latest_epired_date = $(this).closest('tr').find('td:eq(9)').text();
                } else {
                    if(tmp_item != $(this).closest('tr').find('td:eq(3)').text()){
                        is_multiple = true;
                    }
                    if(new Date($(this).closest('tr').find('td:eq(9)').text()) > new Date(tmp_latest_epired_date)){
                        tmp_latest_epired_date = $(this).closest('tr').find('td:eq(9)').text();
                    }
                    if(tmp_lot_no.includes($(this).closest('tr').find('td:eq(2)').text()) == false) {
                        tmp_lot_no += ', ' + $(this).closest('tr').find('td:eq(2)').text();
                    }
                }
                if(strvalue!=\"\")
                    strvalue = strvalue + \"|\"+this.value;
                else
                    strvalue = this.value;
            });

            //alert(strvalue);

            if(is_multiple == true){
                alert('There is multiple item in your selection...! Please select 1 item only...');
                return false;
            }

            if (confirm('Are you sure to continue?')) {
                var category = $('#req-category').val();
                var po_no = $('#po-number').val();
                var grandtotal = $('#total-qty-hidden').val();
                $('#overlay-id').show();
                $(this).attr('disabled', true).addClass('disabled');
                $.post({
                    url: '" . Url::to(['pc-judgement']) . "',
                    data: {
                        keylist: keys,
                        value: strvalue,
                        category: category,
                        po_no: po_no,
                        lot_no: tmp_lot_no,
                        item: tmp_item,
                        item_desc: tmp_item_desc,
                        uom: tmp_uom,
                        grandtotal: grandtotal,
                        vendor: tmp_vendor,
                        latest_expired_date: tmp_latest_epired_date
                    },
                    dataType: 'json',
                    success: function(data) {
                        if(data.success == false){
                            alert(\"Can't finish action. \" + data.message);
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

        $('#req-category').change(function(){
            setTotalQty();
        });
    });
");

$columns = [
    /*[
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{scrap}',
        'buttons' => [
            'scrap' => function($url, $model, $key){
                $url = ['scrap', 'SERIAL_NO' => $model->SERIAL_NO];
                $options = [
                    'title' => 'Request Scrap',
                    'data-pjax' => '0',
                    //'data-confirm' => 'Are you sure to scrap this item?',
                ];
                if ($model->SCRAP_REQUEST_STATUS != 0) {
                    return '<button class="btn btn-danger disabled" title="Scrap request has been made..."><span class="fa fa-trash"></span></button>';
                }
                return Html::a('<button class="btn btn-danger"><span class="fa fa-trash"></span></button>', $url, $options);
            },
            
        ],
        'urlCreator' => function($action, $model, $key, $index) {
            $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
            $params[0] = \Yii::$app->controller->id ? \Yii::$app->controller->id . '/' . $action : $action;
            return Url::toRoute($params);
        },
        'contentOptions' => ['nowrap'=>'nowrap', 'style' => 'min-width: 70px;']
    ],*/
    [
        'class' => '\kartik\grid\CheckboxColumn',
        'checkboxOptions' => function($model) {
            if ($model->SCRAP_REQUEST_STATUS == 0) {
                return [
                    'value' => $model->SERIAL_NO,
                    'class' => 'cb-column'
                ];
            } else {
                return ['disabled' => true, 'class' => 'disabled'];
            }
            
        },
        'rowHighlight' => false,
    ],
    [
        'attribute' => 'SERIAL_NO',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'LOT_NO',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'ITEM',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'ITEM_DESC',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'LOC_DESC',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'NILAI_INVENTORY',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'UM',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'SUPPLIER_DESC',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'EXPIRED_DATE',
        'value' => function($model){
            return date('Y-m-d', strtotime($model->EXPIRED_DATE));
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'SCRAP_REQUEST_STATUS',
        'value' => function($model){
            //if($model->SCRAP_REQUEST_STATUS != null){
                return \Yii::$app->params['expired_item_status'][$model->SCRAP_REQUEST_STATUS];
            //}
        },
        'filter' => \Yii::$app->params['expired_item_status'],
        'format' => 'html',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
];

?>
<div class="giiant-crud trace-item-dtr-index">

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
                'columns' => $columns,
                'hover' => false,
                //'condensed' => true,
                'striped' => false,
                //'floatHeader'=>true,
                //'floatHeaderOptions'=>['scrollingTop'=>'50'],
                'containerOptions' => ['style' => 'overflow: auto;'], // only set when $responsive = false
                'headerRowOptions' => ['class' => 'kartik-sheet-style'],
                'filterRowOptions' => ['class' => 'kartik-sheet-style'],
                'rowOptions' => function($model){
                    if (strtotime(date('Y-m-d 00:00:00')) >= strtotime($model->EXPIRED_DATE)) {
                        return ['class' => 'bg-danger'];
                    } else {
                        return ['class' => 'bg-warning'];
                    }
                },
                //'pjax' => false, // pjax is set to always true for this demo
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
                    //'footer' => false,
                    'after' => Html::dropDownList('req_category', null, [
                        //1 => 'Request Warranty Label',
                        2 => 'PO Issued'
                    ], [
                        'class' => 'btn btn-primary',
                        'id' => 'req-category',
                        'prompt' => 'Select Category...'
                    ]) . '&nbsp;&nbsp;' . Html::input('text', 'po_no', null, [
                        'placeholder' => 'Input PO No.',
                        'id' => 'po-number',
                        'style' => 'display: none;'
                    ]) . '&nbsp;&nbsp;<button class="btn btn-success" id="submit-btn">Submit</button>',
                    'afterOptions' => [
                        'class'=>'kv-panel-after pull-right',
                    ],
                ],
            ]); 
            ?>
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
    <?= Html::hiddenInput('total_qty_hidden', '0', [
        'class' => 'form-control text-center',
        'id' => 'total-qty-hidden'
    ]); ?>
</div>


<?php \yii\widgets\Pjax::end() ?>


