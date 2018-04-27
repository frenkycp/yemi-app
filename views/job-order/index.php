<?php

//use yii\helpers\Html;

use yii\helpers\Url;
//use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use kartik\helpers\Html;
/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\JobOrderSearch $searchModel
*/

$this->title = Yii::t('app', 'Job Orders Data Table');
$this->params['breadcrumbs'][] = $this->title;

if (isset($actionColumnTemplates)) {
$actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']);
    $actionColumnTemplateString = "{view} {update} {delete}";
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';

$gridColumns = [
    [
        'class' => 'kartik\grid\ActionColumn',
        'width'=>'100px',
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
    [
        'attribute' => 'JOB_ORDER_NO',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width'=>'100px',
    ],
    [
        'attribute' => 'SCH_DATE',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'format' => ['date', 'php:d-M-Y'],
    ],
    //'JOB_ORDER_BARCODE',
    //'LOC',
    [
        'attribute' => 'LOC_DESC',
        'label' => 'Location',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width'=>'100px',
    ],
    //'LINE',
    //'NIK',
    [
        'attribute' => 'NAMA_KARYAWAN',
        'label' => 'PIC',
        'vAlign' => 'middle',
        'width'=>'150px',
    ],
    /*'SMT_SHIFT',*/
    /*'KELOMPOK',*/
    [
        'attribute' => 'ITEM',
        'label' => 'Part No',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width'=>'100px',
    ],
    [
        'attribute' => 'ITEM_DESC',
        'label' => 'Part Name',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
        'width'=>'200px',
    ],
    /*'UM',*/
    [
        'attribute' => 'MODEL',
        'label' => 'Model',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
        'width'=>'200px',
    ],
    'DESTINATION',
    /*'USER_ID',*/
    /*'USER_DESC',*/
    /*'STAGE',*/
    /*'STATUS',*/
    /*'JOB_ORDER_LOT_NO',*/
    /*'USER_ID_START',*/
    /*'USER_DESC_START',*/
    /*'USER_ID_PAUSE',*/
    /*'USER_DESC_PAUSE',*/
    /*'USER_ID_CONTINUED',*/
    /*'USER_DESC_CONTINUED',*/
    /*'USER_ID_ENDED',*/
    /*'USER_DESC_ENDED',*/
    /*'NOTE',*/
    /*'NOTE2',*/
    /*'CONFORWARD',*/
    /*'CONFORWARD_PRINT',*/
    
    /*'START_DATE',*/
    /*'PAUSE_DATE',*/
    /*'CONTINUED_DATE',*/
    /*'END_DATE',*/
    /*'LAST_UPDATE',*/
    /*'MAN_POWER',*/
    /*'LOT_QTY',*/
    /*'ORDER_QTY',*/
    /*'COMMIT_QTY',*/
    /*'OPEN_QTY',*/
    /*'STD_TIME_VAR',*/
    /*'STD_TIME',*/
    /*'INSERT_POINT_VAR',*/
    /*'INSERT_POINT',*/
    /*'LOST_TIME',*/
    /*'DANDORI',*/
];
        
$fullExportMenu = ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    'target' => ExportMenu::TARGET_SELF,
    'fontAwesome' => true,
    'pjaxContainerId' => 'kv-pjax-container',
    'dropdownOptions' => [
        'label' => 'Full',
        'class' => 'btn btn-default',
        'itemsBefore' => [
            '<li class="dropdown-header">Export All Data</li>',
        ],
    ],
]);

?>
<div class="giiant-crud job-order-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <!--<h1>
        <?= '';//Yii::t('app', 'Job Orders') ?>
        <small>
            List
        </small>
    </h1> -->
    <div class="clearfix crud-navigation">
        <div class="pull-left">
            <?= ''; //Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']) ?>
        </div>

        <div class="pull-right">

                        
            <?= '';
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
    
    <br/>
    
    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'hover' => true,
            'panel' => [
                'type' => 'warning',
                'heading' => '<i class="glyphicon glyphicon-book"></i>  Job Orders Data Table',
                //'footer' => false,
                //'before' => false,
                'after' => false,
            ],
            'pager' => [
                'class' => yii\widgets\LinkPager::className(),
                'firstPageLabel' => 'First',
                'lastPageLabel' => 'Last',
            ],
            'columns' => $gridColumns,
            'toolbar' => [
                '{export}',
                //'{toggleData}',
                $fullExportMenu,
            ],
            'export' => [
                'label' => 'Page',
                'target' => '_self',
                'fontAwesome'=>true,
            ],
            
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


