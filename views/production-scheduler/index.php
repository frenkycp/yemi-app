<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\form\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\MesinCheckNgSearch $searchModel
*/

$this->title = [
    'page_title' => '',
    'tab_title' => 'Production Plan Scheduler',
    'breadcrumbs_title' => 'Production Plan Scheduler'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }
    .navbar2 {
        overflow: hidden;
        //background-color: #333;
        position: fixed;
        top: 0;
        width: 100%;
    }
    .main {
        padding: 16px;
        margin-top: 0px;
        //height: 1500px; /* Used in this example to enable scrolling */
    }
    .float{
        position:fixed;
        z-index: 2;
        width:80px;
        height:60px;
        top:135px;
        right:33px;
        background-color:#0C9;
        color:#FFF;
        //border-radius:50px;
        text-align:center;
        box-shadow: 2px 2px 3px #999;
    }
");

date_default_timezone_set('Asia/Jakarta');

if (isset($actionColumnTemplates)) {
$actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']);
    if (Yii::$app->user->identity->role->id == 1) {
        $actionColumnTemplateString = "{update} {delete} {change_color}";
    } else {
        $actionColumnTemplateString = "{update} {change_color}";
    }
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';

$this->registerJs("
    $(document).ready(function() {
        function setTotalQty(){
            var total_qty = 0;
            $('input[name=\"selection[]\"]:checked').each(function() {
                var tmp_qty = parseInt($(this).closest('tr').find('td:eq(12)').text());
                total_qty += tmp_qty;
            });
            $('#total_qty').val(total_qty);
        }
        $('.select-on-check-all').change(function(){
            setTotalQty();
        });
        $('.cb-column').change(function(){
            setTotalQty();
        });
        $('#order_btn').click(function(){
            var keys = $('#grid').yiiGridView('getSelectedRows');

            var loc_val = $('#location_dropdown option:selected').val();
            var loc_desc_val = $('#location_dropdown option:selected').text();
            var line_val = $('#line option:selected').val();
            var shift_val = $('#shift option:selected').val();
            var group_val = $('#group option:selected').val();
            var plan_date_val = $('#plan_date').val();
            var jenis_mesin_val = $('#jenis_mesin option:selected').val();
            
            if(loc_val == ''){
                alert('Please select location first before order!');
                return false;
            }

            if(keys.length > 10){
                alert('Your plan contains ' + keys.length + ' slip number! (Max. 10 slip number)');
                return false;
            }

            if(keys.length == 0){
                alert('Please select minimal 1 slip number...!');
                return false;
            }

            var tmp_no = '';
            var tmp_model = '';
            var tmp_parent = '';
            var tmp_parent_desc = '';
            var is_multiple = false;
            var is_multiple_model = false;
            var strvalue = \"\";
            $('input[name=\"selection[]\"]:checked').each(function() {
                var tmp_child = this.value.split('|');
                if(tmp_no == ''){
                    tmp_no = tmp_child[1];
                } else {
                    if(tmp_no != tmp_child[1]){
                        is_multiple = true;
                    }
                }

                tmp_parent = tmp_child[3];
                tmp_parent_desc = tmp_child[4];

                if(tmp_model == ''){
                    tmp_model = tmp_child[2];
                }

                if(tmp_model != tmp_child[2]){
                    is_multiple_model = true;
                }

                if(strvalue!=\"\")
                    strvalue = strvalue + \",\"+tmp_child[0];
                else
                    strvalue = tmp_child[0];
            });
            //alert(tmp_model);
            if(is_multiple == true){
                alert('There is multiple item in your selection...! (1 lot 1 item)');
                return false;
            }

            if(loc_val == 'WW02' || loc_val == 'WU01'){
                if(is_multiple_model == true){
                    alert('There is multiple model in your selection...! (1 lot 1 model)');
                    return false;
                }
            }

            if (confirm('Are you sure to continue?')) {
                $(this).attr('disabled', true).addClass('disabled');
                $.post({
                    url: '" . Url::to(['create-plan']) . "',
                    data: {
                        keylist: keys,
                        value: strvalue,
                        loc : loc_val,
                        loc_desc : loc_desc_val,
                        line : line_val,
                        shift : shift_val,
                        group : group_val,
                        plan_date : plan_date_val,
                        jenis_mesin : jenis_mesin_val,
                        model_group : tmp_model,
                        parent : tmp_parent,
                        parent_desc : tmp_parent_desc
                    },
                    dataType: 'json',
                    success: function(data) {
                        if(data.success == false){
                            alert(\"Can't create plan. \" + data.message);
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

//date_default_timezone_set('Asia/Jakarta');

$grid_columns = [
    [
        'class' => 'yii\grid\CheckboxColumn',
        'checkboxOptions' => function($model) {
            $model_group = $model->model_group == null ? '-' : $model->model_group;
            return [
                'value' => $model->slip_id . '|' . $model->child . '|' . $model_group . '|' . $model->parent . '|' . $model->parent_desc,
                'class' => 'cb-column'
            ];
        },
    ],
    [
        'attribute' => 'model_group',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'parent',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 70px;'
        ],
    ],
    [
        'attribute' => 'parent_desc',
        'vAlign' => 'middle',
        //'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'source_date',
        'value' => function($model){
            $source_date = '-';
            if ($model->source_date != null) {
                $source_date = date('Y-m-d', strtotime($model->source_date));
            }
            return $source_date;
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'child',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 70px;'
        ],
    ],
    [
        'attribute' => 'child_desc',
        'vAlign' => 'middle',
        //'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'period',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 60px;'
        ],
    ],
    [
        'attribute' => 'start_date',
        'value' => function($model){
            $start_date = '-';
            if ($model->start_date != null) {
                $start_date = date('Y-m-d', strtotime($model->start_date));
            }
            return $start_date;
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 85px;'
        ],
    ],
    [
        'attribute' => 'slip_id',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'child_analyst',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'hidden' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;',
            'readonly' => true,
        ],
    ],
    [
        'attribute' => 'child_analyst_desc',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;',
            'readonly' => true,
        ],
    ],
    [
        'attribute' => 'act_qty',
        'vAlign' => 'middle',
        //'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'source_qty',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
];
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Production Plan Scheduler</h3>
    </div>
    <div class="box-body">

        <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        ]); ?>

        <div class="row">
            <div class="col-md-2">
                <?= $form->field($searchModel, 'child_analyst')->dropDownList($location_dropdown, [
                    'prompt' => 'Select Location ...',
                    'onchange' => 'this.form.submit();',
                    'id' => 'location_dropdown',
                ])->label('Location'); ?>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <label class="control-label" for="line">Line</label>
                    <?= Html::dropDownList('line', null, [
                        '01' => '01',
                        '02' => '02',
                    ], [
                        'class' => 'form-control',
                        'id' => 'line',
                    ]) ?>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label" for="shift">Shift</label>
                    <?= Html::dropDownList('shift', null, [
                        '01-PAGI' => '01-PAGI',
                        '02-SIANG' => '02-SIANG',
                        '03-MALAM' => '03-MALAM',
                    ], [
                        'class' => 'form-control',
                        'id' => 'shift',
                    ]) ?>
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <label class="control-label" for="group">Group</label>
                    <?= Html::dropDownList('group', null, [
                        'A' => 'A',
                        'B' => 'B',
                        'C' => 'C',
                        'D' => 'D',
                    ], [
                        'class' => 'form-control',
                        'id' => 'group',
                    ]) ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label" for="group">Machine</label>
                    <?= Html::dropDownList('jenis_mesin', null, $jenis_mesin_dropdown, [
                        'class' => 'form-control',
                        'id' => 'jenis_mesin',
                        'prompt' => '-- Select group (WW Must) --'
                    ]); ?>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label" for="plan_date">Plan Date</label>
                    <?= DatePicker::widget([
                        'name' => 'plan_date',
                        'id' => 'plan_date',
                        'type' => DatePicker::TYPE_INPUT,
                        'value' => date('Y-m-d'),
                        'options' => ['placeholder' => 'Select plan date ...'],
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true,
                            'autoclose'=>true
                        ]
                    ]); ?>
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
            
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>

<div class="giiant-crud mesin-check-ng-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <!-- <hr /> -->

    <div class="">
        <?= GridView::widget([
            'id' => 'grid',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $grid_columns,
            'hover' => false,
            'responsive' => true,
            //'condensed' => true,
            'striped' => false,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto; font-size: 12px;'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'pjax' => true, // pjax is set to always true for this demo
            /*'rowOptions' => function($model){
                $find_slip = app\models\GojekOrderTbl::find()
                ->where([
                    'slip_id' => $model->slip_id
                ])
                ->one();
                if ($find_slip->slip_id == null) {
                    return ['class' => ''];
                } else {
                    return ['class' => 'bg-success'];
                }
            },*/
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
                'after' => '<button class="btn btn-primary" id="order_btn">Order</button>',
                'afterOptions' => [
                    'class'=>'kv-panel-after pull-right',
                ],
                //'heading' => 'Last Update : ' . date('Y-m-d H:i:s')
            ],
        ]); ?>
        <?php
            /*yii\bootstrap\Modal::begin([
                'id' =>'modal',
                'header' => '<h3>Machine Spare Parts</h3>',
                'size' => 'modal-lg',
            ]);
            yii\bootstrap\Modal::end();

            yii\bootstrap\Modal::begin([
                'id' =>'image-modal',
                'header' => '<h3>NG Image</h3>',
                //'size' => 'modal-lg',
            ]);
            yii\bootstrap\Modal::end(); */

        ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


