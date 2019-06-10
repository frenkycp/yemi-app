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
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'DATE',
        'value' => function($model){
            return date('Y-m-d', strtotime($model->DATE));
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'DAY_STAT',
        'label' => 'Hari Kerja/Libur',
        'value' => function($model){
            $day_stat = '-';
            if ($model->DAY_STAT == 'L') {
                $day_stat = 'HARI LIBUR';
            } elseif ($model->DAY_STAT == 'HK') {
                $day_stat = 'HARI KERJA';
            }
            return $day_stat;
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filter' => [
            'HK' => 'HARI KERJA',
            'L' => 'HARI LIBUR'
        ],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px; min-width: 110px;'
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
        //'hAlign' => 'center',
    ],
    [
        'attribute' => 'SECTION',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filter' => ArrayHelper::map(app\models\CostCenter::find()->orderBy('CC_DESC')->all(), 'CC_DESC', 'CC_DESC'),
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 150px;'
        ],
    ],
    [
        'attribute' => 'SHIFT',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filter' => ArrayHelper::map(app\models\AbsensiTbl::find()
            ->select('DISTINCT(SHIFT)')
            ->where(['<>', 'SHIFT', ''])
            ->orderBy('SHIFT')->all(), 'SHIFT', 'SHIFT'),
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px; min-width: 70px;'
        ],
    ],
    [
        'attribute' => 'CATEGORY',
        'value' => function($model){
            if (in_array($model->CATEGORY, ['SHIFT-01', 'SHIFT-02', 'SHIFT-03'])) {
                return '-';
            }
            return $model->CATEGORY;
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '100px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
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
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'CHECK_IN',
        'value' => function($model){
            return $model->CHECK_IN == null ? '-' : date('Y-m-d H:i:s', strtotime($model->CHECK_IN));
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '100px',
    ],
    [
        'attribute' => 'CHECK_OUT',
        'value' => function($model){
            return $model->CHECK_OUT == null || $model->CHECK_OUT == $model->CHECK_IN ? '-' : date('Y-m-d H:i:s', strtotime($model->CHECK_OUT));
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '100px',
    ],
    /*[
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
            'pjax' => true, // pjax is set to always true for this demo
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


