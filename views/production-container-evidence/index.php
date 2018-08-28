<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\ProductionContainerEvidenceSearch $searchModel
*/

$this->title = [
    'page_title' => 'Container Evidence Data <span class="japanesse text-green"></span>',
    'tab_title' => 'Container Evidence Data',
    'breadcrumbs_title' => 'Container Evidence Data'
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

$columns = [
    [
        'attribute' => 'etd',
        'label' => 'Export Date',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'cntr',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'so',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'dst',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'invo',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'cont',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'm3',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'evidence_file',
        'label' => 'Evidence File',
        'value' => function($model){
            $filename = $model->cntr . '.pdf';
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
    ],
];
?>
<div class="giiant-crud serno-output-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    
    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'hover' => true,
            'pjax' => true, // pjax is set to always true for this demo
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
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


