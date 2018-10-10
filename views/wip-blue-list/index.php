<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\form\ActiveForm;
use kartik\touchspin\TouchSpin;
use kartik\datetime\DateTimePicker;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\MesinCheckNgSearch $searchModel
*/

$this->title = [
    'page_title' => 'WIP Blue List Data <span class="text-green japanesse"></span>',
    'tab_title' => 'WIP Blue List Data',
    'breadcrumbs_title' => 'WIP Blue List Data'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss(".japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

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
        $('#order_btn').click(function(){
            var request_time = $('#request_time').val();
            if(request_time == ''){
                alert('Please fill request time at the top left of the table before order!');
                $(\"html, body\").animate({ scrollTop: 0 }, \"slow\");
                return false;
            } else {
                if (confirm('Do you want to request order for ' + request_time + ' ?')) {
                    var keys = $('#grid').yiiGridView('getSelectedRows');
                    var strvalue = \"\";
                    var dest_value = $('#loc_to_select').val();
                    if(dest_value != ''){
                        $('input[name=\"selection[]\"]:checked').each(function() {
                            if(strvalue!=\"\")
                                strvalue = strvalue + \",\"+this.value;
                            else
                                strvalue = this.value;
                        });
                        $.post({
                            url: '" . Url::to(['order']) . "',
                            data: {
                                keylist: keys,
                                nama : 'Frenky',
                                value : strvalue,
                                destination : dest_value,
                                request_time: request_time
                            },
                            dataType: 'json',
                            success: function(data) {
                                if(data.success == false){
                                    alert(\"Can't create order. \" + data.message);
                                } else {
                                    alert(data.message);
                                    location.href = location.href;
                                }
                            },
                            error: function (request, status, error) {
                                alert(error);
                            }
                        });
                    } else {
                        alert('Please select destination first!');
                    }
                } else {
                    alert('Change the time at top-left of the table!');
                }
            }
            
        }); 
    });
");

//date_default_timezone_set('Asia/Jakarta');

$grid_columns = [
    /* [
        'class' => '\kartik\grid\SerialColumn',
        'width' => '30px',
    ], 
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => $actionColumnTemplateString,
        'buttons' => [
            'view' => function ($url, $model, $key) {
                $options = [
                    'title' => Yii::t('cruds', 'View'),
                    'aria-label' => Yii::t('cruds', 'View'),
                    'data-pjax' => '0',
                ];
                return Html::a('<span class="glyphicon glyphicon-file"></span>', $url, $options);
            }, 'change_color' => function($url, $model, $key){
                $url = ['change-color', 'urutan' => $model->urutan];
                $options = [
                    'title' => 'Change Machine Status',
                    'data-pjax' => '0',
                ];
                return Html::a('<span class="glyphicon glyphicon-refresh"></span>', $url, $options);
            },
        ],
        'urlCreator' => function($action, $model, $key, $index) {
            // using the column name as key, not mapping to 'id' like the standard generator
            $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
            $params[0] = \Yii::$app->controller->id ? \Yii::$app->controller->id . '/' . $action : $action;
            return Url::toRoute($params);
        },
        'contentOptions' => ['nowrap'=>'nowrap']
    ],*/
    [
        'class' => 'yii\grid\CheckboxColumn',
        'checkboxOptions' => function($model) {
            $find_slip = app\models\GojekOrderTbl::find()
            ->where([
                'slip_id' => $model->slip_id
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
            }
            return ['value' => $model->slip_id];
        },
    ],
    [
        'attribute' => 'location',
        'value' => 'wipHdr.child_analyst_desc',
        'label' => 'Location',
        'vAlign' => 'middle',
        'width' => '200px',
        'filter' => $location_dropdown,
        //'headerOptions' => ['class' => 'kartik-sheet-style'] 
    ],
    /*[
        'attribute' => 'bom_level',
        'label' => 'BOM<br/>Level',
        'encodeLabel' => false,
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '80px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'period',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '90px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
        'hidden' => true,
    ],*/
    /*[
        'attribute' => 'upload_id',
        'label' => 'VMS No',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '100px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],*/
    [
        'attribute' => 'slip_id',
        'label' => 'Slip No.',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '100px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'session_id',
        'label' => 'Session<br/>No.',
        'encodeLabel' => false,
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '100px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
        //'hidden' => true
    ],
    [
        'attribute' => 'period_line',
        'label' => 'Line',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '80px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'speaker_model',
        'value' => 'wipHdr.model_group',
        'label' => 'Model',
        'vAlign' => 'middle',
        'width' => '120px',
        'contentOptions' => [
            'style' => 'min-width: 100px;'
        ],
    ],
    [
        'attribute' => 'child',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '100px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'wipHdr.child_desc',
        'vAlign' => 'middle',
        //'hAlign' => 'center'
    ],
    [
        'attribute' => 'summaryQty',
        'label' => 'Qty',
        'vAlign' => 'middle',
        'width' => '70px',
        'hAlign' => 'center'
    ],
    [
        'class'=>'kartik\grid\EditableColumn',
        'attribute' => 'gojek_req_qty',
        'label' => 'Request<br/>Qty',
        'encodeLabel' => false,
        'value' => function($model){
            return $model->gojek_req_qty == null ? $model->summaryQty : $model->gojek_req_qty;
        },
        'width' => '70px',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'editableOptions'=> [
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
            'options' => [
                
            ],
        ]
    ],
    [
        'attribute' => 'source_date',
        'label' => 'FA Start',
        'value' => function($model){
            return $model->source_date == null ? '-' : date('Y-m-d', strtotime($model->source_date));
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'contentOptions' => [
            'style' => 'min-width: 120px;'
        ],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'due_date',
        'label' => 'Due Date',
        'value' => function($model){
            return $model->due_date == null ? '-' : date('Y-m-d', strtotime($model->due_date));
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'contentOptions' => [
            'style' => 'min-width: 120px;'
        ],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    /*[
        'attribute' => 'stage',
        'label' => 'Status',
        'value' => function($model){
            $status_arr = explode('-', $model->stage);
            return $status_arr[1];
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filter' => $status_dropdown,
    ],*/
    /*[
        'attribute' => 'start_date',
        'label' => 'Start Date',
        'value' => function($model){
            return $model->start_date == null ? '-' : date('Y-m-d', strtotime($model->start_date));
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '100px',
        'contentOptions' => [
            'style' => 'min-width: 100px;'
        ],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    
    [
        'attribute' => 'created_user_desc',
        'label' => 'Created By',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'start_job_user_desc',
        'label' => 'Started By',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'end_job_user_desc',
        'label' => 'Completed By',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'hand_over_job_user_desc',
        'label' => 'Hand Overed By',
        'vAlign' => 'middle',
    ],*/
    
]
?>
<div class="giiant-crud mesin-check-ng-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <!-- <hr /> -->

    <div class="table-responsive">
        <?= GridView::widget([
            'id' => 'grid',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $grid_columns,
            'hover' => true,
            'responsive' => true,
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
                'before' => '<div class="col-md-3"><label class="">Request For</label>' . DateTimePicker::widget([
                    'name' => 'dp_1',
                    'id' => 'request_time',
                    'readonly' => true,
                    //'value' => date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:00') . ' + 1 hour')),
                    'type' => DateTimePicker::TYPE_COMPONENT_PREPEND,
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd hh:ii:ss'
                    ]
                ]) . '</div>',
                'after' => 'To Location : ' . Html::dropDownList('loc_to', null, $location_dropdown, [
                    'class' => 'btn btn-danger',
                    'id' => 'loc_to_select',
                    'prompt' => 'Select Destination ...'
                ]) . '&nbsp;&nbsp;<button class="btn btn-primary" id="order_btn">Order</button>',
                'afterOptions' => [
                    'class'=>'kv-panel-after pull-right',
                ],
                'heading' => 'Last Update : ' . date('Y-m-d H:i:s')
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


