<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\ProductionInspectionSearch $searchModel
*/

$this->title = [
    'page_title' => 'Final Inspection Data <span class="japanesse text-green">(出荷管理検査データ)</span>',
    'tab_title' => 'Final Inspection Data',
    'breadcrumbs_title' => 'Final Inspection Data'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

if (isset($actionColumnTemplates)) {
$actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']);
    $actionColumnTemplateString = "{view} {update} {delete}";
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';

$this->registerCss("h1 .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

$this->registerJs("$(function() {
   $('.popupModal').click(function(e) {
     e.preventDefault();
     $('#modal').modal('show').find('.modal-body').html('<div class=\"text-center\">" . Html::img('@web/loading-01.gif', ['alt'=>'some', 'class'=>'thing']) . "</div>').load($(this).attr('href'));
   });
   $('.ngModal').click(function(e) {
     e.preventDefault();
     $('#modal-ng').modal('show').find('.modal-body').html('<div class=\"text-center\">" . Html::img('@web/loading-01.gif', ['alt'=>'some', 'class'=>'thing']) . "</div>').load($(this).attr('href'));
   });
});");

$columns = [
    /*[
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{view_serno}',
        'buttons' => [
            'view' => function ($url, $model, $key) {
                $options = [
                    'title' => Yii::t('cruds', 'View'),
                    'aria-label' => Yii::t('cruds', 'View'),
                    'data-pjax' => '0',
                ];
                return Html::a('<span class="glyphicon glyphicon-file"></span>', $url, $options);
            },
            'view_serno' => function ($url, $model, $key) {
                $url = ['get-product-serno',
                    'ng_date' => $model->qa_ng_date,
                    'gmc' => $model->gmc
                ];
                $options = [
                    'class' => 'popupModal',
                    'data-pjax' => '0',
                ];
                return Html::a('<span class="glyphicon glyphicon-info-sign"></span>', $url, $options);
            }
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
        'attribute' => 'proddate',
        'label' => 'Prod. Date',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
        'width' => '120px',
    ],
    [
        'attribute' => 'line',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '100px',
    ],
    [
        'attribute' => 'flo',
        'label' => 'FLO No.',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
        'width' => '110px',
    ],
    [
        'attribute' => 'gmc',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
        'width' => '100px',
    ],
    [
        'attribute' => 'partName',
        'label' => 'Description',
        'vAlign' => 'middle',
        'contentOptions' => [
            'style' => 'min-width: 150px;'
        ],
    ],
    [
        'attribute' => 'package',
        //'label' => 'Description',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'contentOptions' => [
            'style' => 'min-width: 100px;'
        ],
    ],
    [
        'attribute' => 'total',
        'label' => 'Qty',
        'value' => function($model){
            /*$url = ['get-product-serno',
                'flo' => $model->flo,
            ];
            $options = [
                'class' => 'popupModal btn btn-primary btn-xs',
                'data-pjax' => '0',
            ];*/
            return '<span><b>' . $model->total . '</b></span>';
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '50px',
        'format' => 'raw',
    ],
    [
        'attribute' => 'status',
        'label' => 'Status',
        'width' => '110px',
        'value' => function($model){
            $val = '';
            $btn_class = '';
            if ($model->qa_ng == '' && $model->qa_ok == '') {
                $val = 'Open';
                $btn_class = 'btn btn-xs btn-default';
            } elseif ($model->qa_ng == '' && $model->qa_ok == 'OK') {
                $val = 'OK';
                $btn_class = 'btn btn-xs btn-success';
            } elseif ($model->qa_ng != '') {
                if ($model->qa_result == 2) {
                    $val = 'Repair';
                    $btn_class = 'btn btn-xs btn-warning';
                } else {
                    $val = 'Lot Out';
                    $btn_class = 'btn btn-xs btn-danger';
                    if ($model->qa_result == 1) {
                        $btn_class = 'btn btn-xs btn-info';
                    }
                }
            }
            $url = ['get-product-serno',
                'flo' => $model->flo,
                'status' => $val
            ];
            $options = [
                'class' => 'popupModal ' . $btn_class,
                'data-pjax' => '0',
            ];
            return Html::a($val, $url, $options);
            return '<span class="' . $btn_class . '">' . $val . '</span>';
        },
        'format' => 'raw',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filter' => [
            'OPEN' => 'OPEN',
            'OK' => 'OK',
            'LOT OUT' => 'Lot Out',
            'REPAIR' => 'Repair'
        ],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'loct',
        'label' => 'Location',
        'value' => function($model){
            $string = '';
            if ($model->loct == 1) {
                $string = 'FA Output';
            } elseif ($model->loct == 2) {
                $string = 'Finish Good WH';
            } elseif ($model->loct == 3) {
                $string = 'Export';
            }
            return $string;
        },
        'filter' => [
            1 => 'FA Output',
            2 => 'Finish Good WH',
            3 => 'Export',
        ],
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'loct_time',
        'label' => 'Time',
        'value' => function($model){
            if ($model->loct_time == '0000-00-00 00:00:00') {
                return '-';
            } else {
                return $model->loct_time;
            }
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '120px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'qa_ng_date',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'label' => 'Inspection Date',
        'width' => '120px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'qa_ng',
        'value' => function($model){
            return strtoupper($model->qa_ng);
        },
        'vAlign' => 'middle',
        'label' => 'Lot Out Remark'
    ],
    [
        'attribute' => 'pdf_file',
        'label' => 'PDF File',
        'value' => function($model){

            if ($model->qa_ng != '') {
                if ($model->qa_result == 2) {
                    $filename = str_replace('-', '', $model->qa_ng_date) . $model->flo . '.pdf';
                } else {
                    $filename = str_replace('-', '', $model->qa_ng_date) . $model->gmc . '.pdf';
                }
                $path = \Yii::$app->basePath . '\\..\\mis7\\qa\\' . $filename;
                $link = Html::a($filename, 'http://172.17.144.6:99/qa/' . $filename, ['target' => '_blank']);
                
                if (file_exists($path)) {
                    
                    return $link;
                } else {
                    return "File not found...";
                }
            } else {
                return '';
            }
            
            //return $model->qa_ng != '' ? $link : '';
        },
        'format' => 'raw',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    /*[
        'attribute' => 'partName',
        'label' => 'Description',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'destination',
        'value' => 'sernoOutput.dst',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'etd_ship',
        'value' => 'sernoOutput.ship',
        'label' => 'ETD Ship',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 75px;'
        ],
        'width' => '150px',
    ],
    [
        'attribute' => 'qa_ng',
        'label' => 'NG',
        'value' => function($model){
            $ng_data = app\models\SernoInput::find()
            ->where([
                'proddate' => $model->proddate,
                'gmc' => $model->gmc
            ])
            ->andWhere(['<>', 'qa_ng', ''])
            ->all();

            $url = ['get-ng-detail',
                'proddate' => $model->proddate,
                'gmc' => $model->gmc
            ];

            $options = [
                'class' => 'btn btn-warning btn-xs ngModal',
                'data-pjax' => '0',
            ];

            $link = Html::a(count($ng_data) . ' pcs', $url, $options);

            if (count($ng_data) > 0) {
                return $link;
            }
            return '';
        },
        'format' => 'raw',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],*/
    /*[
        'attribute' => 'qa_ok',
        'label' => 'Inspection',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],*/
];
?>
<div class="giiant-crud serno-input-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <!--<h1>
        <?= Yii::t('models', 'Serno Inputs') ?>
        <small>
            List
        </small>
    </h1>-->

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
            [
                'url' => ['serno-output/index'],
                'label' => '<i class="glyphicon glyphicon-arrow-left"></i> ' . Yii::t('models', 'Serno Output'),
            ],
                    
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


    <div class="">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'containerOptions' => ['style' => 'overflow: auto; font-size: 12px;'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'hover' => true,
            'panel' => [
                'type' => 'info',
                //'heading' => '<i class="glyphicon glyphicon-book"></i>  Job Orders Data Table',
                //'footer' => false,
                //'before' => false,
                'after' => false,
            ],
            'pager' => [
                'class' => yii\widgets\LinkPager::className(),
                'firstPageLabel' => 'First',
                'lastPageLabel' => 'Last',
            ],
            'columns' => $columns,
            'toolbar' => [
                ['content' => 
                    Html::a('View Chart', ['/production-monthly-inspection/index'], ['data-pjax' => 0, 'class' => 'btn btn-warning', 'title' => Yii::t('kvgrid', 'View Chart')])
                ],
                '{export}',
                '{toggleData}',
                //$fullExportMenu,
            ],
            'export' => [
                'label' => 'Page',
                'target' => '_self',
                'fontAwesome'=>true,
            ],
            
        ]); ?>
        <?php
            yii\bootstrap\Modal::begin([
                'id' =>'modal',
                'header' => '<h3>Detail Info</h3>',
                //'size' => 'modal-lg',
            ]);
            yii\bootstrap\Modal::end();
            yii\bootstrap\Modal::begin([
                'id' =>'modal-ng',
                'header' => '<h3>NG Detail</h3>',
                'size' => 'modal-lg',
            ]);
            yii\bootstrap\Modal::end();
        ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


