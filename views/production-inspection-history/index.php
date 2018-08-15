<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\ProductionInspectionHistorySearch $searchModel
*/

$this->title = 'Inspection History';
$this->params['breadcrumbs'][] = $this->title;

if (isset($actionColumnTemplates)) {
$actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']);
    $actionColumnTemplateString = "{view} {update} {delete}";
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';

$columns = [
    [
        'class' => 'kartik\grid\SerialColumn',
        'contentOptions' => ['class' => 'kartik-sheet-style'],
        'width' => '36px',
        'header' => '',
        'headerOptions' => ['class' => 'kartik-sheet-style']
    ],
    [
        'attribute' => 'proddate',
        'label' => 'Prod. Date',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
        'width' => '120px',
        'value' => function($model){
            return date('d-M-Y', strtotime($model->proddate));
        },
    ],
    [
        'attribute' => 'qa_ng_date',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'label' => 'Inspection Date',
        'width' => '120px',
        'value' => function($model){
            return date('d-M-Y', strtotime($model->qa_ng_date));
        },
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
            //return Html::a($val, $url, $options);
            return '<span class="' . $btn_class . '">' . $val . '</span>';
        },
        'format' => 'raw',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filter' => [
            'OK' => 'OK',
            'LOT OUT' => 'Lot Out',
            'REPAIR' => 'Repair'
        ],
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
            'style' => 'text-align: center;'
        ],
    ],
];
?>
<div class="giiant-crud serno-input-index">

    <?php
            //echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'pjax' => true,
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
                    '<form action="' . Url::to(['production-inspection-history/index']) . '" method="get"><input type="text" name="ProductionInspectionHistorySearch[qa_ng]" class="form-control" placeholder="Search Remark..." value="' . $searchModel['qa_ng'] . '" size="35"></input></form>'
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
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


