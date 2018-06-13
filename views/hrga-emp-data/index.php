<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\MpInOutSearch $searchModel
*/

$this->title = Yii::t('models', 'Employee Data');
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
        /*[
    'class' => 'yii\grid\ActionColumn',
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
        'attribute' => 'PERIOD',
        'width' => '80px',
        'hAlign' => 'center',
        'vAlign' => 'middle'
    ],
    [
        'attribute' => 'TANGGAL',
        'value' => function($model){
            return date('Y-m-d', strtotime($model->TANGGAL));
        },
        'width' => '100px',
        'hAlign' => 'center',
        'vAlign' => 'middle'
    ],
    [
        'attribute' => 'NIK',
        'width' => '80px',
        'hAlign' => 'center',
        'vAlign' => 'middle'
    ],
    [
        'attribute' => 'NAMA_KARYAWAN',
        'width' => '180px',
        //'hAlign' => 'center',
        'vAlign' => 'middle'
    ],
    [
        'attribute' => 'JABATAN_SR_GROUP',
        'value' => function($model){
            return substr($model->JABATAN_SR_GROUP, strpos($model->JABATAN_SR_GROUP, "-") + 1);
        },
        'filter' => $jabatan_arr,
        'label' => 'Jabatan',
        'width' => '150px',
        //'hAlign' => 'center',
        'vAlign' => 'middle'
    ],
    [
        'attribute' => 'JENIS_KELAMIN',
        'encodeLabel' => false,
        'label' => 'Jenis</br>Kelamin',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '50px'
    ],
    [
        'attribute' => 'DEPARTEMEN',
        'width' => '180px',
        //'hAlign' => 'center',
        'vAlign' => 'middle'
    ],
    [
        'attribute' => 'SECTION',
        'width' => '100px',
        //'hAlign' => 'center',
        'vAlign' => 'middle'
    ],
    [
        'attribute' => 'PKWT',
        'value' => function($model){
            return substr($model->PKWT, strpos($model->PKWT, "-") + 1);
        },
        'width' => '130px',
        'hAlign' => 'center',
        'vAlign' => 'middle'
    ],
    [
        'attribute' => 'KONTRAK_KE',
        'label' => 'Kontrak</br>ke',
        'encodeLabel' => false,
        'width' => '50px',
        'hAlign' => 'center',
        'vAlign' => 'middle'
    ],
    [
        'attribute' => 'KONTRAK_START',
        'width' => '100px',
        'value' => function($model){
            return $model->KONTRAK_START != null ? date('Y-m-d', strtotime($model->KONTRAK_START)) : '-';
        },
        'hAlign' => 'center',
        'vAlign' => 'middle'
    ],
    [
        'attribute' => 'KONTRAK_END',
        'width' => '100px',
        'value' => function($model){
            return $model->KONTRAK_END != null ? date('Y-m-d', strtotime($model->KONTRAK_END)) : '-';
        },
        'hAlign' => 'center',
        'vAlign' => 'middle'
    ],
];
?>
<div class="giiant-crud mp-in-out-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <h1 style="display: none;">
        <?= Yii::t('models', 'Mp In Outs') ?>
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

    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $columns,
            'hover' => true,
            //'condensed' => true,
            'striped' => true,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            //'pjax' => true, // pjax is set to always true for this demo
            'toolbar' =>  [
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
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


