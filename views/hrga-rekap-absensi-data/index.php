<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\HrgaAttendanceDataSearch $searchModel
*/

$this->title = 'Data Rekap Absensi';
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
        'contentOptions' => ['nowrap'=>'nowrap'],
        'hidden' => Yii::$app->user->identity->role->id == 1 ? false : true,
    ],*/
    [
        'attribute' => 'PERIOD',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '90px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'SECTION',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'NIK',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '90px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'NAMA_KARYAWAN',
        'vAlign' => 'middle',
        'width' => '200px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'GRADE',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '70px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'ALPHA',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'IJIN',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'SAKIT',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'CUTI',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'CUTI_KHUSUS',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
    ],
    /*[
        'attribute' => 'CUTI_KHUSUS_IJIN',
        'encodeLabel' => false,
        'label' => 'Cuti Khusus<br/>Ijin',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
    ],*/
    [
        'attribute' => 'DISIPLIN',
        'label' => 'Tunjangan Disiplin',
        'value' => function($model){
            if ($model->DISIPLIN == 0) {
                return '<span class="text-red">TIDAK DAPAT</span>';
            }
            return '<span class="text-green">DAPAT</span>';
        },
        'format' => 'raw',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filter' => [
            1 => 'DAPAT',
            0 => 'TIDAK DAPAT'
        ],
        //'hiddenFromExport' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'SHIFT2',
        'label' => 'Shift II',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'SHIFT3',
        'label' => 'Shift III',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'SHIFT4',
        'label' => 'Shift IV',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
    ],
    /*[
        'attribute' => 'DISIPLIN',
        'value' => function($model){
            if ($model->DISIPLIN == 0) {
                return 'TIDAK DISIPLIN';
            }
            return 'DISIPLIN';
        },
        'format' => 'raw',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'hidden' => true
    ],*/
];
?>
<div class="giiant-crud absensi-tbl-index">

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
            //'pjax' => false, // pjax is set to always true for this demo
            'toolbar' =>  [
                ['content' => 
                    Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success'])
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
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


