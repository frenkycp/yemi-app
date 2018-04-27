<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\growl\Growl;
//use yii\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\TpPartList $searchModel
*/

$this->title = Yii::t('app', 'TP Part Lists');
$this->params['breadcrumbs'][] = $this->title;

$session = Yii::$app->session;
if($session->has('success'))
{
    $session->remove('success');
    echo Growl::widget([
                'type' => Growl::TYPE_SUCCESS,
                'title' => 'Well done!',
                'icon' => 'glyphicon glyphicon-ok-sign',
                'body' => 'You successfully read this important alert message.',
                'showSeparator' => true,
                'delay' => 0,
                'pluginOptions' => [
                    'showProgressbar' => true,
                    'placement' => [
                        'from' => 'top',
                        'align' => 'right',
                    ]
                ]
            ]);
}


if (isset($actionColumnTemplates)) {
$actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']);
    $actionColumnTemplateString = "{view} {update} {delete}";
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';

$gridColumn = [
    [
        'class' => 'yii\grid\ActionColumn',
        'template' => $actionColumnTemplateString,
        'buttons' => [
            'view' => function ($url, $model, $key) {
                $options = [
                    'title' => Yii::t('yii', 'View'),
                    'aria-label' => Yii::t('yii', 'View'),
                    'data-pjax' => '0',
                ];
                return Html::a('<span class="glyphicon glyphicon-file"></span>', $url, $options);
            }
        ],
        'urlCreator' => function($action, $model, $key, $index) {
            // using the column name as key, not mapping to 'id' like the standard generator
            $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
            $params[0] = \Yii::$app->controller->id ? \Yii::$app->controller->id . '/' . $action : $action;
            return Url::toRoute($params);
        },
        'contentOptions' => ['nowrap'=>'nowrap'],
    ],
    [
        'attribute' => 'speaker_model',
        'label' => 'Model Name',
        'hAlign' => 'center',
        //'headerOptions' => ['style' => 'text-align: center;'],
        'vAlign' => 'middle',
        //'enableSorting' => false,
    ],
    [
        'attribute' => 'part_no',
        'label' => 'Part No',
        'hAlign' => 'center',
        //'headerOptions' => ['style' => 'text-align: center;'],
        'vAlign' => 'middle',
        //'enableSorting' => false,
    ],
    [
        'attribute' => 'part_name',
        //'hAlign' => 'center',
        //'headerOptions' => ['style' => 'text-align: center;'],
        'vAlign' => 'middle',
        'enableSorting' => false,
    ],
    [
        'attribute' => 'total_product',
        'label' => 'Product',
        'hAlign' => 'center',
        //'headerOptions' => ['style' => 'text-align: center;'],
        'vAlign' => 'middle',
        'enableSorting' => false,
    ],
    [
        'attribute' => 'total_assy',
        'label' => 'Assy',
        'hAlign' => 'center',
        //'headerOptions' => ['style' => 'text-align: center;'],
        'vAlign' => 'middle',
        'enableSorting' => false,
    ],
    [
        'attribute' => 'total_spare_part',
        'label' => 'Sparepart',
        'hAlign' => 'center',
        //'headerOptions' => ['style' => 'text-align: center;'],
        'vAlign' => 'middle',
        'enableSorting' => false,
    ],
    [
        'attribute' => 'total_requirement',
        'label' => 'Total',
        'hAlign' => 'center',
        //'headerOptions' => ['style' => 'text-align: center;'],
        'vAlign' => 'middle',
        'enableSorting' => false,
    ],
    [
        'attribute' => 'pc_remarks',
        'label' => 'PC Remarks',
        'hidden' => true,
    ],
    [
        'attribute' => 'present_po',
        'label' => 'P/O (Present)',
        'hidden' => true,
    ],
    [
        'attribute' => 'present_due_date',
        'label' => 'Due Date (Present)',
        'hidden' => true,
    ],
    [
        'attribute' => 'present_po',
        'label' => 'Qty (Present)',
        'hidden' => true,
    ]
];

?>
<div class="giiant-crud tp-part-list-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <div class="clearfix crud-navigation" style="display: none;">
        <div class="pull-left">
            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']) ?>
        </div>

        <div class="pull-right">

                        
            <?= 
            \yii\bootstrap\ButtonDropdown::widget(
            [
            'id' => 'giiant-relations',
            'encodeLabel' => false,
            'label' => '<span class="glyphicon glyphicon-paperclip"></span> ' . 'Relations',
            'dropdown' => [
            'options' => [
            'class' => 'dropdown-menu-right'
            ],
            'encodeLabels' => false,
            'items' => [

]
            ],
            'options' => [
            'class' => 'btn-default'
            ]
            ]
            );
            ?>
        </div>
    </div>

    <!-- <hr /> -->
    <?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumn,
        'containerOptions' => ['style' => 'overflow: auto'],
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        'pjax' => true,
        'toolbar' =>  [
            ['content' => 
                Html::a('<i class="glyphicon glyphicon-import"></i>', ['import'], ['data-pjax' => 0, 'class' => 'btn btn-success', 'title' => Yii::t('app', 'Import Data')])
            ],
            '{export}',
            '{toggleData}',
        ],
        'export' => [
            'fontAwesome' => true
        ],
        'panel' => [
            'type' => 'info',
            'footer' => false,
        ],
    ]);
    ?>
    <div class="table-responsive" style="display: none;">
        <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'pager' => [
        'class' => yii\widgets\LinkPager::className(),
        'firstPageLabel' => 'First',
        'lastPageLabel' => 'Last',
        ],
                    'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
        'headerRowOptions' => ['class'=>'x'],
        'columns' => [
                [
            'class' => 'yii\grid\ActionColumn',
            'template' => $actionColumnTemplateString,
            'buttons' => [
                'view' => function ($url, $model, $key) {
                    $options = [
                        'title' => Yii::t('yii', 'View'),
                        'aria-label' => Yii::t('yii', 'View'),
                        'data-pjax' => '0',
                    ];
                    return Html::a('<span class="glyphicon glyphicon-file"></span>', $url, $options);
                }
            ],
            'urlCreator' => function($action, $model, $key, $index) {
                // using the column name as key, not mapping to 'id' like the standard generator
                $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
                $params[0] = \Yii::$app->controller->id ? \Yii::$app->controller->id . '/' . $action : $action;
                return Url::toRoute($params);
            },
            'contentOptions' => ['nowrap'=>'nowrap']
        ],
			'rev_no',
			'present_qty',
			'qty',
			/*'transportation_cost',*/
			/*'present_due_date',*/
			/*'last_modified',*/
			/*'dcn_no',*/
			/*'direct_po_trf',*/
			/*'delivery_conf_etd',*/
			/*'delivery_conf_eta',*/
			/*'act_delivery_etd',*/
			/*'act_delivery_eta',*/
			/*'transport_by',*/
			/*'part_type',*/
			/*'part_status',*/
			/*'caf_no',*/
			/*'purch_status',*/
			/*'pc_status',*/
			/*'pe_confirm',*/
			/*'status',*/
			/*'qa_judgement',*/
			/*'qa_remark',*/
			/*'invoice',*/
			/*'last_modified_by',*/
        ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


