<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\HrgaSplDataSearch $searchModel
*/

$this->title = Yii::t('models', 'SPL Monthly Report');
$this->params['breadcrumbs'][] = $this->title;

if (isset($actionColumnTemplates)) {
$actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']);
    $actionColumnTemplateString = "{view} {update} {delete}";
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';

$grid_columns = [
    [
        'attribute' => 'PERIOD',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 70px; font-size:12px;'
        ],
    ],
    [
        'attribute' => 'DEPARTEMEN',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
        'filter' => ArrayHelper::map(app\models\SplViewReport03::find()->select('DISTINCT(DEPARTEMEN)')->where('DEPARTEMEN IS NOT NULL')->orderBy('DEPARTEMEN ASC')->all(), 'DEPARTEMEN', 'DEPARTEMEN'),
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 200px; font-size:12px;'
        ],
    ],
    [
        'attribute' => 'SECTION',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
        'filter' => ArrayHelper::map(app\models\SplViewReport03::find()->select('DISTINCT(SECTION)')->where('SECTION IS NOT NULL')->orderBy('SECTION ASC')->all(), 'SECTION', 'SECTION'),
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 180px; font-size:12px;'
        ],
    ],
    /*[
        'attribute' => 'SUB_SECTION',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
        'contentOptions' => [
            'style' => 'min-width: 180px;'
        ],
    ],*/
    [
        'attribute' => 'NIK',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 80px; font-size:12px;'
        ],
    ],
    [
        'attribute' => 'NAMA_KARYAWAN',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; min-width: 180px; font-size:12px;'
        ],
    ],
    [
        'attribute' => 'P01',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->P01 == 0 ? '' : $model->P01;
        }
    ],
    [
        'attribute' => 'P02',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->P02 == 0 ? '' : $model->P02;
        }
    ],
    [
        'attribute' => 'P03',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->P03 == 0 ? '' : $model->P03;
        }
    ],
    [
        'attribute' => 'P04',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->P04 == 0 ? '' : $model->P04;
        }
    ],
    [
        'attribute' => 'P05',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->P05 == 0 ? '' : $model->P05;
        }
    ],
    [
        'attribute' => 'P06',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->P06 == 0 ? '' : $model->P06;
        }
    ],
    [
        'attribute' => 'P07',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->P07 == 0 ? '' : $model->P07;
        }
    ],
    [
        'attribute' => 'P08',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->P08 == 0 ? '' : $model->P08;
        }
    ],
    [
        'attribute' => 'P09',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->P09 == 0 ? '' : $model->P09;
        }
    ],
    [
        'attribute' => 'P10',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->P10 == 0 ? '' : $model->P10;
        }
    ],
    [
        'attribute' => 'P11',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->P11 == 0 ? '' : $model->P11;
        }
    ],
    [
        'attribute' => 'P12',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->P12 == 0 ? '' : $model->P12;
        }
    ],
    [
        'attribute' => 'P13',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->P13 == 0 ? '' : $model->P13;
        }
    ],
    [
        'attribute' => 'P14',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->P14 == 0 ? '' : $model->P14;
        }
    ],
    [
        'attribute' => 'P15',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->P15 == 0 ? '' : $model->P15;
        }
    ],
    [
        'attribute' => 'P16',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->P16 == 0 ? '' : $model->P16;
        }
    ],
    [
        'attribute' => 'P17',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->P17 == 0 ? '' : $model->P17;
        }
    ],
    [
        'attribute' => 'P18',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->P18 == 0 ? '' : $model->P18;
        }
    ],
    [
        'attribute' => 'P19',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->P19 == 0 ? '' : $model->P19;
        }
    ],
    [
        'attribute' => 'P20',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->P20 == 0 ? '' : $model->P20;
        }
    ],
    [
        'attribute' => 'P21',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->P21 == 0 ? '' : $model->P21;
        }
    ],
    [
        'attribute' => 'P22',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->P22 == 0 ? '' : $model->P22;
        }
    ],
    [
        'attribute' => 'P23',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->P23 == 0 ? '' : $model->P23;
        }
    ],
    [
        'attribute' => 'P24',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->P24 == 0 ? '' : $model->P24;
        }
    ],
    [
        'attribute' => 'P25',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->P25 == 0 ? '' : $model->P25;
        }
    ],
    [
        'attribute' => 'P26',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->P26 == 0 ? '' : $model->P26;
        }
    ],
    [
        'attribute' => 'P27',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->P27 == 0 ? '' : $model->P27;
        }
    ],
    [
        'attribute' => 'P28',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->P28 == 0 ? '' : $model->P28;
        }
    ],
    [
        'attribute' => 'P29',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->P29 == 0 ? '' : $model->P29;
        }
    ],
    [
        'attribute' => 'P30',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->P30 == 0 ? '' : $model->P30;
        }
    ],
    [
        'attribute' => 'P31',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->P31 == 0 ? '' : $model->P31;
        }
    ],
    [
        'attribute' => 'A01',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->A01 == 0 ? '' : $model->A01;
        }
    ],
    [
        'attribute' => 'A02',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->A02 == 0 ? '' : $model->A02;
        }
    ],
    [
        'attribute' => 'A03',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->A03 == 0 ? '' : $model->A03;
        }
    ],
    [
        'attribute' => 'A04',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->A04 == 0 ? '' : $model->A04;
        }
    ],
    [
        'attribute' => 'A05',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->A05 == 0 ? '' : $model->A05;
        }
    ],
    [
        'attribute' => 'A06',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->A06 == 0 ? '' : $model->A06;
        }
    ],
    [
        'attribute' => 'A07',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->A07 == 0 ? '' : $model->A07;
        }
    ],
    [
        'attribute' => 'A08',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->A08 == 0 ? '' : $model->A08;
        }
    ],
    [
        'attribute' => 'A09',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->A09 == 0 ? '' : $model->A09;
        }
    ],
    [
        'attribute' => 'A10',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->A10 == 0 ? '' : $model->A10;
        }
    ],
    [
        'attribute' => 'A11',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->A11 == 0 ? '' : $model->A11;
        }
    ],
    [
        'attribute' => 'A12',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->A12 == 0 ? '' : $model->A12;
        }
    ],
    [
        'attribute' => 'A13',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->A13 == 0 ? '' : $model->A13;
        }
    ],
    [
        'attribute' => 'A14',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->A14 == 0 ? '' : $model->A14;
        }
    ],
    [
        'attribute' => 'A15',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->A15 == 0 ? '' : $model->A15;
        }
    ],
    [
        'attribute' => 'A16',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->A16 == 0 ? '' : $model->A16;
        }
    ],
    [
        'attribute' => 'A17',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->A17 == 0 ? '' : $model->A17;
        }
    ],
    [
        'attribute' => 'A18',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->A18 == 0 ? '' : $model->A18;
        }
    ],
    [
        'attribute' => 'A19',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->A19 == 0 ? '' : $model->A19;
        }
    ],
    [
        'attribute' => 'A20',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->A20 == 0 ? '' : $model->A20;
        }
    ],
    [
        'attribute' => 'A21',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->A21 == 0 ? '' : $model->A21;
        }
    ],
    [
        'attribute' => 'A22',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->A22 == 0 ? '' : $model->A22;
        }
    ],
    [
        'attribute' => 'A23',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->A23 == 0 ? '' : $model->A23;
        }
    ],
    [
        'attribute' => 'A24',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->A24 == 0 ? '' : $model->A24;
        }
    ],
    [
        'attribute' => 'A25',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->A25 == 0 ? '' : $model->A25;
        }
    ],
    [
        'attribute' => 'A26',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->A26 == 0 ? '' : $model->A26;
        }
    ],
    [
        'attribute' => 'A27',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->A27 == 0 ? '' : $model->A27;
        }
    ],
    [
        'attribute' => 'A28',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->A28 == 0 ? '' : $model->A28;
        }
    ],
    [
        'attribute' => 'A29',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->A29 == 0 ? '' : $model->A29;
        }
    ],
    [
        'attribute' => 'A30',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->A30 == 0 ? '' : $model->A30;
        }
    ],
    [
        'attribute' => 'A31',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->A31 == 0 ? '' : $model->A31;
        }
    ],
];
?>
<div class="giiant-crud spl-hdr-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <div class="">
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
            'pjax' => true, // pjax is set to always true for this demo
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


