<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\HrgaAttendanceDataSearch $searchModel
*/

$this->title = Yii::t('models', 'Attendance Data');
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
    ],
    [
        'attribute' => 'PERIOD',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'DATE',
        'value' => function($model){
            return date('Y-m-d', strtotime($model->DATE));
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'NIK',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'NAMA_KARYAWAN',
        'vAlign' => 'middle',
        'width' => '200px',
        //'hAlign' => 'center',
    ],
    [
        'attribute' => 'SECTION',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'SHIFT',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filter' => ArrayHelper::map(app\models\AbsensiTbl::find()->select('DISTINCT(SHIFT)')->orderBy('SHIFT')->all(), 'SHIFT', 'SHIFT'),
    ],
    [
        'attribute' => 'CATEGORY',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '100px',
    ],
    [
        'attribute' => 'KEHADIRAN',
        'value' => function($model){
            if ($model->KEHADIRAN == 0) {
                return '<i class="fa fa-fw fa-close text-red"></i>';
            }
            return '<i class="fa fa-fw fa-check text-green"></i>';
        },
        'format' => 'raw',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '100px',
        'filter' => [
            0 => 'Absen',
            1 => 'Hadir',
        ],
    ],
    [
        'attribute' => 'BONUS',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '100px',
    ],
    [
        'attribute' => 'DISIPLIN',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '100px',
    ],
    //'NIK_DATE_ID',
    //'NO',
    /*'PERIOD',*/
    /*'NOTE',*/
    /*'DAY_STAT',*/
    /*'CATEGORY',*/
    /*'YEAR',*/
    /*'WEEK',*/
    /*'TOTAL_KARYAWAN',*/
    /*'KEHADIRAN',*/
    /*'BONUS',*/
    /*'DISIPLIN',*/
    /*'DATE',*/
];
?>
<div class="giiant-crud absensi-tbl-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $gridColumns,
            'hover' => true,
            //'condensed' => true,
            'striped' => true,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
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


