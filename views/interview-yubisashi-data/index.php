<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\InterviewYubisashiDataSearch $searchModel
*/

$this->title = [
    'page_title' => 'Interview Yubisashi Data <span class="japanesse text-green"></span>',
    'tab_title' => 'Interview Yubisashi Data',
    'breadcrumbs_title' => 'Interview Yubisashi Data'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$columns = [
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{update}',
        'buttons' => [
            'scrap' => function($url, $model, $key){
                $url = ['scrap', 'SERIAL_NO' => $model->SERIAL_NO];
                $options = [
                    'title' => 'Request Scrap',
                    'data-pjax' => '0',
                    //'data-confirm' => 'Are you sure to scrap this item?',
                ];
                if ($model->SCRAP_REQUEST_STATUS != 0) {
                    return '<button class="btn btn-danger disabled" title="Scrap request has been made..."><span class="fa fa-trash"></span></button>';
                }
                return Html::a('<button class="btn btn-danger"><span class="fa fa-trash"></span></button>', $url, $options);
            },
            
        ],
        'urlCreator' => function($action, $model, $key, $index) {
            $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
            $params[0] = \Yii::$app->controller->id ? \Yii::$app->controller->id . '/' . $action : $action;
            return Url::toRoute($params);
        },
        'contentOptions' => ['nowrap'=>'nowrap', 'style' => 'min-width: 70px;']
    ],
    [
        'attribute' => 'FISCAL_YEAR',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'EMP_ID',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'EMP_NAME',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'DEPARTMENT',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'YAMAHA_DIAMOND',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return \Yii::$app->params['interview_yubisashi_value_arr'][$model->YAMAHA_DIAMOND];
        },
        'format' => 'html',
        'filter' => \Yii::$app->params['interview_yubisashi_value_arr'],
        'contentOptions' => [
            'style' => 'min-width: 100px;'
        ],
    ],
    [
        'attribute' => 'K3',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return \Yii::$app->params['interview_yubisashi_value_arr'][$model->K3];
        },
        'format' => 'html',
        'filter' => \Yii::$app->params['interview_yubisashi_value_arr'],
        'contentOptions' => [
            'style' => 'min-width: 100px;'
        ],
    ],
    [
        'attribute' => 'SLOGAN_KUALITAS',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return \Yii::$app->params['interview_yubisashi_value_arr'][$model->SLOGAN_KUALITAS];
        },
        'format' => 'html',
        'filter' => \Yii::$app->params['interview_yubisashi_value_arr'],
        'contentOptions' => [
            'style' => 'min-width: 100px;'
        ],
    ],
    [
        'attribute' => 'KESELAMATAN_LALU_LINTAS',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return \Yii::$app->params['interview_yubisashi_value_arr'][$model->KESELAMATAN_LALU_LINTAS];
        },
        'format' => 'html',
        'filter' => \Yii::$app->params['interview_yubisashi_value_arr'],
        'contentOptions' => [
            'style' => 'min-width: 100px;'
        ],
    ],
    [
        'attribute' => 'KOMITMENT_BERKENDARA',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return \Yii::$app->params['interview_yubisashi_value_arr'][$model->KOMITMENT_BERKENDARA];
        },
        'format' => 'html',
        'filter' => \Yii::$app->params['interview_yubisashi_value_arr'],
        'contentOptions' => [
            'style' => 'min-width: 100px;'
        ],
    ],
    [
        'attribute' => 'BUDAYA_KERJA',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function($model){
            return \Yii::$app->params['interview_yubisashi_value_arr'][$model->BUDAYA_KERJA];
        },
        'format' => 'html',
        'filter' => \Yii::$app->params['interview_yubisashi_value_arr'],
        'contentOptions' => [
            'style' => 'min-width: 100px;'
        ],
    ],
    [
        'attribute' => 'LAST_UPDATE',
        'value' => function($model){
            if ($model->LAST_UPDATE == null) {
                return '-';
            } else {
                return date('Y-m-d H:i:s');
            }
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
];
?>
<div class="giiant-crud emp-interview-yubisashi-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    
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
            'containerOptions' => ['style' => 'overflow: auto;'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            //'pjax' => false, // pjax is set to always true for this demo
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
                //'footer' => false,
            ],
        ]); 
        ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


