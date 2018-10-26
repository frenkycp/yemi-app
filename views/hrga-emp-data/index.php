<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
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
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 70px; font-size: 12px; text-align: center;',
        ],
    ],
    [
        'attribute' => 'TANGGAL',
        'value' => function($model){
            return date('Y-m-d', strtotime($model->TANGGAL));
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 90px; font-size: 12px; text-align: center;',
        ],
    ],
    [
        'attribute' => 'NIK',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 70px; font-size: 12px; text-align: center;',
        ],
    ],
    [
        'attribute' => 'NAMA_KARYAWAN',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width:120px; font-size: 12px;',
        ],
    ],
    [
        'attribute' => 'GRADE',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 40px; font-size: 12px; text-align: center;',
        ],
    ],
    [
        'attribute' => 'JABATAN_SR_GROUP',
        'value' => function($model){
            return substr($model->JABATAN_SR_GROUP, strpos($model->JABATAN_SR_GROUP, "-") + 1);
        },
        'filter' => $jabatan_arr,
        'label' => 'Grup Jabatan SR',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width:120px; font-size: 12px; text-align: center;',
        ],
    ],
    [
        'attribute' => 'JABATAN_SR',
        'label' => 'Jabatan SR',
        'filter' => ArrayHelper::map(app\models\EmpData::find()->select('DISTINCT(JABATAN_SR)')->where('JABATAN_SR IS NOT NULL')->all(), 'JABATAN_SR', 'JABATAN_SR'),
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 120px; font-size: 12px; text-align: center;',
        ],
    ],
    [
        'attribute' => 'JENIS_KELAMIN',
        'encodeLabel' => false,
        'label' => 'JK',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 40px; font-size: 12px; text-align: center;',
        ],
    ],
    [
        'attribute' => 'DEPARTEMEN',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 120px; font-size: 12px; text-align: center;',
        ],
    ],
    [
        'attribute' => 'SECTION',
        'width' => '100px',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 100px; font-size: 12px; text-align: center;',
        ],
    ],
    [
        'attribute' => 'PKWT',
        'value' => function($model){
            return substr($model->PKWT, strpos($model->PKWT, "-") + 1);
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 70px; font-size: 12px; text-align: center;',
        ],
    ],
    [
        'attribute' => 'KONTRAK_KE',
        'label' => 'Kontrak</br>ke',
        'encodeLabel' => false,
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 50px; font-size: 12px; text-align: center;',
        ],
    ],
    [
        'attribute' => 'KONTRAK_START',
        'value' => function($model){
            return $model->KONTRAK_START != null ? date('Y-m-d', strtotime($model->KONTRAK_START)) : '-';
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 70px; font-size: 12px; text-align: center;',
        ],
    ],
    [
        'attribute' => 'KONTRAK_END',
        'value' => function($model){
            return $model->KONTRAK_END != null ? date('Y-m-d', strtotime($model->KONTRAK_END)) : '-';
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 120px; font-size: 12px; text-align: center;',
        ],
    ],
];
?>
<div class="giiant-crud mp-in-out-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <div class="">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $columns,
            'hover' => true,
            //'condensed' => true,
            'striped' => true,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto; font-size: 12px;'], // only set when $responsive = false
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


