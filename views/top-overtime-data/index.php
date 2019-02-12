<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;

$this->title = [
    'page_title' => 'OT Management by NIK <span class="japanesse text-green">(社員別残業管理）</span>',
    'tab_title' => 'OT Management by NIK',
    'breadcrumbs_title' => 'OT Management by NIK'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }
");

date_default_timezone_set('Asia/Jakarta');

$gridColumns = [
    [
        'class' => 'kartik\grid\SerialColumn',
        'contentOptions' => ['class' => 'kartik-sheet-style'],
        'width' => '36px',
        'header' => '',
        'headerOptions' => ['class' => 'kartik-sheet-style']
    ],
    [
        'attribute' => 'PERIOD',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'CC_GROUP',
        'label' => 'Department',
        'vAlign' => 'middle',
        //'hAlign' => 'center',
        'filter' => ArrayHelper::map(app\models\CostCenter::find()->select('CC_GROUP')->groupBy('CC_GROUP')->orderBy('CC_GROUP')->all(), 'CC_GROUP', 'CC_GROUP'),
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'CC_DESC',
        'label' => 'Section',
        'vAlign' => 'middle',
        //'hAlign' => 'center',
        'filter' => ArrayHelper::map(app\models\CostCenter::find()->select('CC_DESC')->groupBy('CC_DESC')->orderBy('CC_DESC')->all(), 'CC_DESC', 'CC_DESC'),
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'NIK',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'format' => 'html',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'NAMA_KARYAWAN',
        'label' => 'Name',
        'vAlign' => 'middle',
        //'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'GRADE',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filter' => \Yii::$app->params['grade_arr'],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 80px;'
        ],
    ],
    [
        'attribute' => 'NILAI_LEMBUR_ACTUAL',
        'label' => 'Overtime Total',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 80px;'
        ],
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        //'template' => "{check_sheet} {history}",
        'template' => "{view_period}",
        'buttons' => [
            'view_period' => function ($url, $model, $key) {
                $options = [
                    'title' => 'View Monthly Overtime (in a year)',
                ];
                $url = ['/emp-overtime-monthly/index', 'year' => substr($model->PERIOD, 0, 4), 'nik' => $model->NIK];
                return Html::a('<span class="glyphicon glyphicon-calendar"></span>', $url, $options);
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
];
?>
<div class="giiant-crud gojek-order-tbl-index">

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
                'heading' => 'Last Update : ' . date('Y-m-d H:i:s')
                //'footer' => false,
            ],
        ]); ?>
    </div>

</div>