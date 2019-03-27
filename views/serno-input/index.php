<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\SernoInputSearch $searchModel
*/

$this->title = [
    'page_title' => 'Final Product Tracer <span class="japanesse text-green">(完成品トレーサ）</span>',
    'tab_title' => 'Final Product Tracer',
    'breadcrumbs_title' => 'Final Product Tracer'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss(".japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

if (isset($actionColumnTemplates)) {
$actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']);
    $actionColumnTemplateString = "{view} {update} {delete}";
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';

date_default_timezone_set('Asia/Jakarta');

$grid_columns = [
    /*[
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
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
        'contentOptions' => [
            'style' => 'min-width: 100px;'
        ],
    ],
    [
        'attribute' => 'waktu',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
        'contentOptions' => [
            'style' => 'min-width: 100px;'
        ],
    ],
    [
        'attribute' => 'flo',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'line',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '80px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'gmc',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'speaker_model',
        'label' => 'Description',
        'value' => 'partName',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'contentOptions' => [
            'style' => 'min-width: 150px;'
        ],
    ],
    [
        'attribute' => 'sernum',
        'label' => 'Serial Number',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'vms',
        'label' => 'VMS Date',
        'value' => function($model){
            if ($model->plan == '') {
                return 'Maedaoshi ' . $model->adv;
            } else {
                return $model->sernoOutput->vms;
            }
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'contentOptions' => [
            'style' => 'min-width:100px;'
        ],
    ],
    [
        'attribute' => 'etd_ship',
        'value' => 'sernoOutput.etd',
        'label' => 'ETD YEMI',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'contentOptions' => [
            'style' => 'min-width:100px;'
        ],
    ],
    [
        'attribute' => 'port',
        'value' => 'sernoOutput.dst',
        'label' => 'Port',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'contentOptions' => [
            'style' => 'min-width:100px;'
        ],
    ],
    [
        'attribute' => 'status',
        'label' => 'Status',
        'width' => '90px',
        'value' => function($model){
            $val = '';
            if ($model->qa_ng == '' && $model->qa_ok == '') {
                $val = 'Open';
                $btn_class = 'btn btn-xs btn-info';
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
                }
            }
            return $val;
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filter' => [
            'OK' => 'OK',
            'LOT OUT' => 'Lot Out',
            'REPAIR' => 'Repair'
        ],
    ],
    [
        'attribute' => 'invoice',
        'value' => 'sernoOutput.invo',
        'label' => 'Invoice',
        'vAlign' => 'middle',
        'width' => '80px',
        'contentOptions' => [
            'style' => 'min-width: 120px;'
        ],
    ],
    [
        'attribute' => 'loct',
        'value' => function($model){
            $location = '';
            if ($model->loct == 0) {
                $location = 'Production Floor';
            } elseif ($model->loct == 1) {
                $location = 'InTransit Area';
            } elseif ($model->loct == 2) {
                $location = 'Finish Good WH';
            }
            return $location;
        },
        'label' => 'Location',
        'vAlign' => 'middle',
        'width' => '80px',
        'contentOptions' => [
            'style' => 'min-width: 120px;'
        ],
    ],
    [
        'attribute' => 'so',
        'value' => 'sernoOutput.so',
        'label' => 'SO',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '80px',
        'contentOptions' => [
            'style' => 'min-width: 120px;'
        ],
    ],
    [
        'attribute' => 'pdf_file',
        'label' => 'Evidence File',
        'value' => function($model){
            $filename = $model->sernoOutput->cntr . '.pdf';
            $path = \Yii::$app->basePath . '\\..\\mis7\\fg\\' . $filename;
            $link = '-';
            if (file_exists($path)) {
                $link = Html::a($filename, 'http://172.17.144.6:99/fg/' . $filename, ['target' => '_blank']);
            }
            return $link;
        },
        'format' => 'raw',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'mergeHeader' => true,
        'hiddenFromExport' => true,
    ],
    [
        'attribute' => 'qa_ng',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'qa_ng_date',
        'label' => 'Inspection Date',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    
    /*[
        'attribute' => 'qa_ok_date',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'pdf_file',
        'label' => 'PDF File',
        'value' => function($model){
            $filename = str_replace('-', '', $model->qa_ng_date) . $model->gmc . '.pdf';
            $link = Html::a($filename, 'http://172.17.144.6:99/qa/' . $filename, ['target' => '_blank']);
            return $model->qa_ng != '' ? $link : '';
        },
        'format' => 'raw',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],*/
];
?>
<div class="box box-success box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">Search Form</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        <?php
        echo $this->render('_search', [
            'model' =>$searchModel,
            'data_gmc' => $data_gmc,
            'data_flo' => $data_flo,
            'data_invoice' => $data_invoice,
        ]);
        ?>
    </div>
</div>
<div class="giiant-crud serno-input-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <div class="">
        <?= !\Yii::$app->request->get() ? '' : GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'columns' => $grid_columns,
            'hover' => true,
            //'condensed' => true,
            'striped' => true,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'pager' => [
                    'firstPageLabel'=>'First',   // Set the label for the "first" page button
                    'lastPageLabel'=>'Last',    // Set the label for the "last" page button
            ],
            'containerOptions' => ['style' => 'overflow: auto; font-size: 12px;'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'pjax' => true, // pjax is set to always true for this demo
            'toolbar' =>  [
                /*['content' => 
                    Html::a('View Chart', ['/production-monthly-inspection/index'], ['data-pjax' => 0, 'class' => 'btn btn-warning', 'title' => Yii::t('kvgrid', 'View Chart')])
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
                'heading' => 'Last Update : ' . date('d-M-Y H:i') . ' WIB',
                //'footer' => false,
            ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


