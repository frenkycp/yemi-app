<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\PabxLogSearch $searchModel
*/

$this->title = [
    'page_title' => 'NG SMT Data Table <span class="japanesse text-green"></span>',
    'tab_title' => 'NG SMT Data Table',
    'breadcrumbs_title' => 'NG SMT Data Table'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');

$ng_pcb_cause_category_dropdown = \Yii::$app->params['ng_pcb_cause_category_dropdown'];
ksort($ng_pcb_cause_category_dropdown);

$this->registerJs("$(function() {
    $('.detail-btn').click(function(e) {
        e.preventDefault();
        $('#modal-detail').modal('show').find('.modal-body').html('<div class=\"text-center\">" . Html::img('@web/loading-01.gif', ['alt'=>'some', 'class'=>'thing']) . "</div>').load($(this).attr('href'));
    });
});");

$this->registerCss("
    .btn-block {margin: 3px;}
");

$gridColumns = [
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{update} {next-actions}',
        'buttons' => [
            'update' => function ($url, $model, $key) {
                $options = [
                    'title' => Yii::t('cruds', 'Edit'),
                    'aria-label' => Yii::t('cruds', 'Edit'),
                    'data-pjax' => '0',
                    'class' => 'btn btn-primary btn-xs btn-block'
                ];
                //$url = ['update','id' => $model->id];
                return Html::a('<i class="fa fa-fw fa-edit"></i> Edit', $url, $options);
            }, 'next-actions' => function($url, $model, $key){
                $url = [
                    'value' => Url::to(['next-action','id' => $model->id]),
                    'title' => 'Edit Actions',
                    'class' => 'showModalButton btn btn-xs btn-primary btn-block'
                ];
                $options = [
                    'data-pjax' => '0',
                    'id' => 'btn-actions'
                ];

                if ($model->ng_cause_category == 'MAN' && $model->action_status == 'O') {
                    return Html::a('<i class="fa fa-tasks"></i> Action', ['countermeasure', 'id' => $model->id], ['class' => 'btn btn-xs btn-primary btn-block']);
                } else {
                    return '<button class="btn btn-xs btn-primary btn-block disabled"><i class="fa fa-fw fa-tasks"></i> Action</button>';
                }
                
            }
        ],
        'urlCreator' => function($action, $model, $key, $index) {
            // using the column name as key, not mapping to 'id' like the standard generator
            $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
            $params[0] = \Yii::$app->controller->id ? \Yii::$app->controller->id . '/' . $action : $action;
            return Url::toRoute($params);
        },
        'contentOptions' => ['nowrap'=>'nowrap', 'style' => 'max-width: 90px;']
    ],
	[
        'attribute' => 'document_no',
        'label' => 'Report No.',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'gmc_desc',
        'label' => 'Model',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'pcb_id',
        'label' => 'Part No.',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'pcb_name',
        'label' => 'Part Name',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'pcb_side',
        'label' => 'Side',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'smt_group',
        'label' => 'Group',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'ng_location',
        'label' => 'NG Location',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'ng_qty',
        'label' => 'QTY',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; width: 40px;'
        ],
    ],
    [
        'attribute' => 'ng_category_desc',
        'label' => 'NG Category',
        'vAlign' => 'middle',
        'filter' => ArrayHelper::map(app\models\ProdNgCategory::find()->select('category_name')->groupBy('category_name')->orderBy('category_name')->all(), 'category_name', 'category_name'),
        'filterInputOptions' => [
            'class' => 'form-control',
        ],
    ],
    [
        'attribute' => 'ng_category_detail',
        'label' => 'NG Category Detail',
        'vAlign' => 'middle',
        'filter' => ArrayHelper::map(app\models\ProdNgCategory::find()->select('category_detail')->groupBy('category_detail')->orderBy('category_detail')->all(), 'category_detail', 'category_detail'),
        'filterInputOptions' => [
            'class' => 'form-control',
        ],
    ],
    [
        'attribute' => 'ng_cause_category',
        'label' => 'Category',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filter' => $ng_pcb_cause_category_dropdown,
        'filterInputOptions' => [
            'class' => 'form-control',
        ],
    ],
    [
        'attribute' => 'ng_detail',
        'label' => 'Remark',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
        ],
    ],
    [
        'attribute' => 'pcb_repair',
        'label' => 'Action (Repair)',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
        ],
    ],
    [
        'attribute' => 'emp_name',
        'label' => 'PIC (NG)',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'smt_pic_aoi_name',
        'label' => 'PIC (AOI)',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'smt_group_pic_name',
        'label' => 'PIC (Group)',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'next_action',
        'label' => 'Next Action',
        'vAlign' => 'middle',
        'filter' => \Yii::$app->params['ng_next_action_dropdown'],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'action_status',
        'value' => function($model)
        {
            if ($model->action_status == 'O') {
                return 'OPEN';
            } else {
                return 'CLOSE';
            }
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filter' => [
            'O' => 'OPEN',
            'CLOSE' => 'CLOSE'
        ],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'line',
        'label' => 'Line',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; width: 40px;'
        ],
    ],
    [
        'attribute' => 'created_time',
        'value' => function($model){
            return date('Y-m-d H:i:s', strtotime($model->created_time));
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; width: 80px; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'created_by_name',
        'label' => 'By',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
        ],
    ],
    [
        'attribute' => 'created_by_id',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; width: 60px; min-width: 60px;',
        ],
    ],
    [
        'attribute' => 'created_by_name',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; width: 60px; min-width: 60px;',
        ],
    ],
];
?>
<div class="giiant-crud pabx-log-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <div class="">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $gridColumns,
            'hover' => true,
            //'condensed' => true,
            'striped' => true,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto; font-size: 12px;'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'toolbar' => [
            	Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'Add', ['create'], ['class' => 'btn btn-success']),
                '{export}',
                '{toggleData}',
            ],
            // set export properties
            'export' => [
                'fontAwesome' => true
            ],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => 'Last Update : ' . date('Y-m-d H:i:s')
                //'footer' => false,
            ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


<?php
    yii\bootstrap\Modal::begin([
        'id' =>'modal-detail',
        'header' => '<h3>Detail </h3>',
        'size' => 'modal-lg',
    ]);
    yii\bootstrap\Modal::end();
?>