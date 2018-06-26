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
    'page_title' => 'Final Inspection Data <span>(出荷管理検査データ)</span>',
    'tab_title' => 'Final Inspection Data (出荷管理検査データ)',
    'breadcrumbs_title' => 'Final Inspection Data (出荷管理検査データ)'
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

$this->registerCss("h1 span { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

$this->registerJs("$(function() {
   $('.popupModal').click(function(e) {
     e.preventDefault();
     $('#modal').modal('show').find('.modal-body').load($(this).attr('href'));
   });
   $('.ngModal').click(function(e) {
     e.preventDefault();
     $('#modal-ng').modal('show').find('.modal-body').load($(this).attr('href'));
   });
});");

$columns = [
    [
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
                    'proddate' => $model->proddate,
                    'plan' => $model->plan
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
    ],
    [
        'attribute' => 'proddate',
        'label' => 'Prod. Date',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 75px;'
        ],
        'width' => '150px',
    ],
    [
        'attribute' => 'gmc',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 75px;'
        ],
        'width' => '150px',
    ],
    [
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
                'plan' => $model->plan,
                'proddate' => $model->proddate,
            ])
            ->andWhere(['<>', 'qa_ng', ''])
            ->all();

            $url = ['get-ng-detail',
                'proddate' => $model->proddate,
                'plan' => $model->plan
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
    ],
    [
        'attribute' => 'qa_ok',
        'label' => 'Inspection',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
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


    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
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
                'header' => '<h3>Product Detail</h3>',
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


