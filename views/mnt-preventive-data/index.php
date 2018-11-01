<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\MesinCheckDtrSearch $searchModel
*/

$this->title = [
    'page_title' => 'Preventive Data <span class="text-green">(予防データ)',
    'tab_title' => 'Preventive Data',
    'breadcrumbs_title' => 'Preventive Data'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("h1 span { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

if (isset($actionColumnTemplates)) {
$actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']);
    $actionColumnTemplateString = "{view} {update} {delete}";
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';

$this->registerJs("$(function() {
   $('.popupModal').click(function(e) {
        e.preventDefault();
        $('#modal').modal('show').find('.modal-body').html('<div class=\"text-center\">" . Html::img('@web/loading-01.gif', ['alt'=>'some', 'class'=>'thing']) . "</div>').load($(this).attr('href'));
   });
   $('.popup_machine_img').click(function(e) {
        e.preventDefault();
        $('#machine_info').modal('show').find('.modal-content').html('<div class=\"text-center\">" . Html::img('@web/loading-01.gif', ['alt'=>'some', 'class'=>'thing']) . "</div>').load($(this).attr('href'));
   });
});");

$grid_columns = [
    [
        'class' => 'kartik\grid\ActionColumn',
        //'template' => "{check_sheet} {history}",
        'template' => "{check_sheet} {upload_image}",
        'buttons' => [
            'view' => function ($url, $model, $key) {
                $options = [
                    'title' => Yii::t('cruds', 'View'),
                    'aria-label' => Yii::t('cruds', 'View'),
                    'data-pjax' => '0',
                ];
                return Html::a('<span class="glyphicon glyphicon-file"></span>', $url, $options);
            },
            'check_sheet' => function ($url, $model, $key) {
                $options = [
                    'title' => 'View Check Sheet',
                    'class' => 'popupModal',
                ];
                $url = ['get-check-sheet', 'mesin_id' => $model->mesin_id, 'mesin_periode' => $model->mesin_periode];
                return Html::a('<span class="glyphicon glyphicon-list-alt"></span>', $url, $options);
            },
            'upload_image' => function ($url, $model, $key) {
                $options = [
                    'title' => 'Upload Image',
                    'style' => 'padding-left: 10px;'
                ];
                $url = ['upload-image', 'mesin_id' => $model->mesin_id];

                $filename = $model->mesin_id . '.jpg';
                $path = \Yii::$app->basePath . '\\web\\uploads\\MNT_MACHINE\\' . $filename;
                if (file_exists($path)) {
                    return null;
                } else {
                    return Html::a('<span class="glyphicon glyphicon-upload"></span>', $url, $options);
                }
                
                
            },
            'history' => function ($url, $model, $key) {
                $options = [
                    'title' => 'View History',
                    'class' => 'popupHistory',
                ];
                $url = ['get-history', 'mesin_id' => $model->mesin_id, 'mesin_periode' => $model->mesin_periode];
                return Html::a('<span class="glyphicon glyphicon-time"></span>', $url, $options);
            },
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
        'attribute' => 'mesin_id',
        'label' => 'Machine ID',
        'value' => function($model){
            $filename = $model->mesin_id . '.jpg';
            $path = \Yii::$app->basePath . '\\web\\uploads\\MNT_MACHINE\\' . $filename;
            if (file_exists($path)) {
                return Html::a($model->mesin_id, ['get-image-preview', 'mesin_id' => $model->mesin_id, 'machine_desc' => $model->machine_desc], ['class' => 'popup_machine_img btn btn-info btn-xs', 'data-pjax' => '0',]);
            } else {
                return $model->mesin_id;
            }
        },
        'format' => 'html',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '110px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    /*[
        'attribute' => 'machine_img',
        'label' => 'Image',
        'value' => function($model){
            return Html::a(Html::img('@web/upload/MNT_MACHINE/' . $model->mesin_id . '.jpg', [
                'width' => '20px',
                'height' => '20px',
                'alt' => '-'
            ]), ['get-image-preview', 'urutan' => $model->mesin_id], ['class' => 'imageModal', 'data-pjax' => '0',]);
        },
        'format' => 'html',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '50px',
    ],*/
    [
        'attribute' => 'machine_desc',
        'label' => 'Description',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
        //'hAlign' => 'center'
    ],
    [
        'attribute' => 'location',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filter' => $loc_arr,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'area',
        'vAlign' => 'middle',
        'filter' => $area_arr,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'mesin_periode',
        'label' => 'Machine Period',
        'vAlign' => 'middle',
        'width' => '100px',
        'filter' => $machine_periode_arr,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'master_plan_maintenance',
        'label' => 'Master Plan',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'value' => function($model){
            return $model->master_plan_maintenance == null ? '-' : date('d-M-Y', strtotime($model->master_plan_maintenance));
        },
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'count_close',
        'label' => 'Status',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'value' => function($model){
            return $model->count_close == 0 ? 'OPEN' : 'CLOSE';
        },
        'filter' => [
            0 => 'OPEN',
            1 => 'CLOSE'
        ],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ]
];
?>
<div class="giiant-crud mesin-check-dtr-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php //\yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <h1 style="display: none;">
        <?= Yii::t('app', 'Mesin Check Dtrs') ?>
        <small>
            List
        </small>
    </h1>
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

    <!--<hr />-->

    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $grid_columns,
            'hover' => true,
            //'condensed' => true,
            'striped' => true,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto; font-size: 12px;'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            //'pjax' => false, // pjax is set to always true for this demo
            'toolbar' =>  [
                ['content' => 
                    Html::a('View Chart', ['/masterplan-report/index'], ['data-pjax' => 0, 'class' => 'btn btn-warning', 'title' => Yii::t('kvgrid', 'Back to Chart')])
                ],
                '{export}',
                '{toggleData}',
            ],
            // set export properties
            'export' => [
                'fontAwesome' => true
            ],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => $heading,
                //'footer' => false,
            ],
        ]); ?>

        <?php
            yii\bootstrap\Modal::begin([
                'id' =>'modal',
                'header' => '<h3>Check Sheet</h3>',
                'size' => 'modal-lg',
            ]);
            yii\bootstrap\Modal::end();

            yii\bootstrap\Modal::begin([
                'id' =>'machine_info',
                'header' => '<h3>Machine Image</h3>',
                //'size' => 'modal-lg',
            ]);
            yii\bootstrap\Modal::end();
        ?>
    </div>

</div>


<?php //\yii\widgets\Pjax::end() ?>


