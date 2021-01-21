<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\PabxLogSearch $searchModel
*/

$this->title = [
    'page_title' => 'Serno NG Data Table <span class="japanesse text-green"></span>',
    'tab_title' => 'Serno NG Data Table',
    'breadcrumbs_title' => 'Serno NG Data Table'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');

$this->registerCss("
    .btn-block {margin: 3px;}
");

$this->registerJs("$(function() {
   $('.popup_img').click(function(e) {
        e.preventDefault();
        $('#serno_img').modal('show').find('.modal-content').html('<div class=\"text-center\">" . Html::img('@web/loading-01.gif', ['alt'=>'some', 'class'=>'thing']) . "</div>').load($(this).attr('href'));
   });
});");

$gridColumns = [
    [
        'class' => 'kartik\grid\ActionColumn',
        //'hidden' => !$is_clinic ? true : false,
        'template' => '{update-image}',
        'buttons' => [
            'update-image' => function($url, $model, $key){
                $url = ['update-image', 'detail_id' => $model->detail_id, 'serial_no' => $model->serial_no];
                $options = [
                    'title' => 'Update Image',
                    'data-pjax' => '0',
                ];
                return Html::a('<span class="fa fa-image"></span>', $url, $options);
            }
        ],
        'urlCreator' => function($action, $model, $key, $index) {
            // using the column name as key, not mapping to 'id' like the standard generator
            $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
            $params[0] = \Yii::$app->controller->id ? \Yii::$app->controller->id . '/' . $action : $action;
            return Url::toRoute($params);
        },
        'contentOptions' => ['nowrap'=>'nowrap', 'style' => 'min-width: 100px;']
    ],
    [
        'attribute' => 'document_no',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;',
        ],
    ],
    [
        'attribute' => 'period',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;',
        ],
    ],
    [
        'attribute' => 'post_date',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;',
        ],
    ],
    [
        'attribute' => 'serial_no',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;',
        ],
    ],
    [
        'attribute' => 'img_before',
        'value' => function($model){
            if ($model->img_before != null) {
                //return Html::img('@web/uploads/NG_FA/thumbnail/' . $model->img_before);
                return Html::a(Html::img('@web/uploads/NG_FA/thumbnail/' . $model->img_before),
                    ['image-preview', 'before_after' => 'BEFORE', 'serial_no' => $model->serial_no, 'img_filename' => $model->img_before],
                    ['class' => 'popup_img', 'data-pjax' => '0',]
                );
            } else {
                return '-';
            }
        },
        'format' => 'html',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'mergeHeader' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;',
        ],
    ],
    [
        'attribute' => 'img_after',
        'value' => function($model){
            if ($model->img_after != null) {
                //return Html::img('@web/uploads/NG_FA/thumbnail/' . $model->img_after);
                return Html::a(Html::img('@web/uploads/NG_FA/thumbnail/' . $model->img_after),
                    ['image-preview', 'before_after' => 'AFTER', 'serial_no' => $model->serial_no, 'img_filename' => $model->img_after],
                    ['class' => 'popup_img', 'data-pjax' => '0',]
                );
            } else {
                return '-';
            }
        },
        'format' => 'html',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'mergeHeader' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;',
        ],
    ],
    [
        'attribute' => 'gmc_no',
        'label' => 'GMC',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;',
        ],
    ],
    [
        'attribute' => 'gmc_desc',
        'label' => 'Model Name',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;',
        ],
    ],
    [
        'attribute' => 'gmc_line',
        'label' => 'Line',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;',
        ],
    ],
    /*[
        'attribute' => 'ng_category_id',
        'label' => 'NG Category',
        'value' => function($model){
            return $model->ng_category_desc . ' - ' . $model->ng_category_detail;
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;',
        ],
    ],*/
    [
        'attribute' => 'ng_category_desc',
        'label' => 'NG Category',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;',
        ],
    ],
    [
        'attribute' => 'ng_category_detail',
        'label' => 'NG Category Detail',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;',
        ],
    ],
    [
        'attribute' => 'ng_detail',
        'label' => 'NG Remark',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;',
        ],
    ],
    [
        'attribute' => 'repair_id',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;',
        ],
    ],
    [
        'attribute' => 'repair_name',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;',
        ],
    ],
];
?>
<div class="giiant-crud prod-ng-detail-serno-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <div class="">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $gridColumns,
            'hover' => true,
            //'condensed' => true,
            'striped' => true,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto; font-size: 12px;'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'toolbar' => [
                '{export}',
                '{toggleData}',
            ],
            // set export properties
            'export' => [
                'fontAwesome' => true
            ],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => 'Last Update : ' . date('Y-m-d H:i:s')
                //'footer' => false,
            ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


<?php
yii\bootstrap\Modal::begin([
    'id' =>'serno_img',
    'header' => '<h3>Machine Image</h3>',
    'size' => 'modal-lg',
]);
yii\bootstrap\Modal::end();