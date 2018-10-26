<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\MntMinimumStockSearch $searchModel
*/

$this->title = [
    'page_title' => 'Data Sparepart Maintenance <span class="text-green japanesse"></span>',
    'tab_title' => 'Data Sparepart Maintenance',
    'breadcrumbs_title' => 'Data Sparepart Maintenance'
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

$grid_column = [
    [
        'attribute' => 'ITEM',
        'label' => 'Kode Item',
        /*'value' => function($model){
            return Html::a($model->ITEM, ['get-image-preview', 'urutan' => $model->ITEM], ['class' => 'imageModal', 'data-pjax' => '0',]);
        },
        'format' => 'raw',*/
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'image',
        'label' => 'Foto',
        'value' => function($model){
            return Html::a(Html::img('http://172.17.144.5:81/product_image/' . $model->ITEM . '.jpg', [
                'width' => '20px',
                'height' => '20px',
                'alt' => '-'
            ]), ['get-image-preview', 'urutan' => $model->ITEM], ['class' => 'imageModal', 'data-pjax' => '0',]);
        },
        'format' => 'html',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '50px',
    ],
    [
        'attribute' => 'ITEM_EQ_DESC_01',
        'label' => 'Deskripsi',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px; min-width: 120px;'
        ],
    ],
    [
        'attribute' => 'RACK',
        'label' => 'Rak',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'MACHINE',
        'label' => 'ID Mesin',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 60px;'
        ],
    ],
    [
        'attribute' => 'MACHINE_NAME',
        'label' => 'Nama Mesin',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 100px;'
        ],
    ],
    [
        'attribute' => 'CATEGORY',
        'label' => 'Kategori',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'hidden' => true,
    ],
    [
        'attribute' => 'ITEM_EQ_UM',
        'label' => 'UM',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 20px;'
        ],
    ],
    [
        'attribute' => 'MIN_STOCK_QTY',
        'encodeLabel' => false,
        'label' => 'Minimum<br/>Qty',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '80px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'ONHAND',
        'encodeLabel' => false,
        'label' => 'Onhand<br/>Qty',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '80px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'ONHAND_STATUS',
        'label' => 'Status',
        'value' => function($model){
            $label_class = '';
            if ($model->ONHAND_STATUS == 1) {
                $label_class = 'label-danger';
            } elseif ($model->ONHAND_STATUS == 2) {
                $label_class = 'label-warning';
            } elseif ($model->ONHAND_STATUS == 3) {
                $label_class = 'label-success';
            }
            return '<span class="label ' . $label_class . '">' . $model->ONHAND_STATUS_DESC . '</span>';
        },
        'format' => 'raw',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 80px;'
        ],
        'filter' => ArrayHelper::map(app\models\MinimumStockView03::find()->select('ONHAND_STATUS, ONHAND_STATUS_DESC')->groupBy('ONHAND_STATUS, ONHAND_STATUS_DESC')->orderBy('ONHAND_STATUS_DESC')->all(), 'ONHAND_STATUS', 'ONHAND_STATUS_DESC'),
    ],
    [
        'attribute' => 'POST_DATE',
        'value' => function($model){
            return $model->POST_DATE !== null ? date('Y-m-d', strtotime($model->POST_DATE)) : '-';
        },
        'label' => 'Last<br/>Purchase Date',
        'encodeLabel' => false,
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'UNIT_PRICE',
        'label' => 'Last Price',
        'value' => function($model){
            return number_format($model->UNIT_PRICE);
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'CURR',
        'label' => 'Currency',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
];

$this->registerJs("$(function() {
   $('.imageModal').click(function(e) {
     e.preventDefault();
     $('#image-modal').modal('show').find('.modal-body').load($(this).attr('href'));
   });
});");
?>

<?php //\yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

<div class="giiant-crud minimum-stock-index">
    <div class="">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $grid_column,
            'hover' => true,
            //'showPageSummary' => true,
            //'condensed' => true,
            'striped' => true,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto; font-size: 12px;'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            //'pjax' => false, // pjax is set to always true for this demo
            'toolbar' =>  [
                /*['content' => 
                    Html::a('View Chart', $main_link, ['data-pjax' => 0, 'class' => 'btn btn-warning', 'title' => Yii::t('kvgrid', 'Show View Chart')])
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
            ],
        ]); 

        yii\bootstrap\Modal::begin([
            'id' =>'image-modal',
            //'header' => '',
            //'size' => 'modal-lg',
        ]);
        yii\bootstrap\Modal::end();
        ?>
    </div>

</div>


<?php //\yii\widgets\Pjax::end() ?>


