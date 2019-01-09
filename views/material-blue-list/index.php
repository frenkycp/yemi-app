<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\form\ActiveForm;
use kartik\datetime\DateTimePicker;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\MaterialBlueListSearch $searchModel
*/

$this->title = Yii::t('models', 'Visual Picking Lists');
$this->params['breadcrumbs'][] = $this->title;

date_default_timezone_set('Asia/Jakarta');

if (isset($actionColumnTemplates)) {
$actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']);
    $actionColumnTemplateString = "{view} {update} {delete}";
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';

$grid_columns = [
	[
        'class' => 'yii\grid\CheckboxColumn',
        'checkboxOptions' => function($model) {
            $find_slip = app\models\GojekOrderTbl::find()
            ->where([
                'slip_id' => $model->set_list_no,
                'source' => 'MAT'
            ])
            ->one();
            if ($find_slip->slip_id == null) {
                return ['value' => $model->set_list_no];
            } else {
                return [
                    'value' => $model->set_list_no,
                    'disabled' => true,
                    'title' => 'This item has been ordered by ' . $find_slip->NAMA_KARYAWAN . ' to ' . $find_slip->to_loc
                ];
            }
            return ['value' => $model->set_list_no];
        },
    ],
    [
        'attribute' => 'set_list_no',
        'label' => 'Setlist Number',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '100px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'model',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '150px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'parent',
        'label' => 'Parent',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '100px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'parent_desc',
        'label' => 'Parent Description',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'analyst',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'analyst_desc',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'plan_qty',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '100px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'part_count_fix',
        'label' => 'Part Count (Fix)',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '100px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'req_date',
        'label' => 'VMS Date',
        'value' => function($model){
            return date('Y-m-d', strtotime($model->req_date));
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'completed_date',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
];

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
                            destination : \"\",
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
                    alert('Change the time at top-left of the table!');
                }
            }
            
        }); 
    });
");
?>
<div class="giiant-crud visual-picking-list-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <div class="table-responsive">
        <?= GridView::widget([
            'id' => 'grid',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $grid_columns,
            'hover' => true,
            'responsive' => true,
            //'condensed' => true,
            'striped' => false,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto; font-size: 12px;'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'pjax' => true, // pjax is set to always true for this demo
            'rowOptions' => function($model){
                $find_slip = app\models\GojekOrderTbl::find()
                ->where([
                    'slip_id' => $model->set_list_no,
                	'source' => 'MAT'
                ])
                ->one();
                if ($find_slip->slip_id == null) {
                    return ['class' => ''];
                } else {
                    return ['class' => 'bg-success'];
                }
            },
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
                'after' => '<button class="btn btn-primary" id="order_btn">Order</button>',
                'afterOptions' => [
                    'class'=>'kv-panel-after pull-right',
                ],
                'heading' => 'Last Update : ' . date('Y-m-d H:i:s')
            ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


