<?php

use yii\helpers\Html;
use yii\helpers\Url;
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
            'style' => 'text-align: center;'
        ],
        'width' => '120px',
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
            /*return Html::img('http://172.17.144.5:81/product_image/' . $model->ITEM . '.jpg', [
                'width' => '20px',
                'height' => '20px',
                'alt' => ''
            ]);*/
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
    ],
    [
        'attribute' => 'RACK',
        'label' => 'Rak',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'MACHINE',
        'label' => 'ID Mesin',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
        'width' => '110px',
    ],
    [
        'attribute' => 'MACHINE_NAME',
        'label' => 'Nama Mesin',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
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
        'width' => '60px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
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
    <div class="table-responsive">
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
            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
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


