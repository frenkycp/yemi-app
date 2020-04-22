<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\web\View;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\WeeklyPlanSearch $searchModel
*/

//$this->title = 'Weekly Summary <span class="text-green">週次出荷（計画対実績）</span>';
$this->title = [
    'page_title' => 'Shipping Monthly Summary <span class="text-green"></span>',
    'tab_title' => 'Shipping Monthly Summary',
    'breadcrumbs_title' => 'Shipping Monthly Summary'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss(".disabled-link {color: DarkGrey; cursor: not-allowed;}");

date_default_timezone_set('Asia/Jakarta');

$columns = [
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{update}&nbsp;&nbsp;&nbsp;&nbsp;{sent-email}',
        'buttons' => [
            'update' => function ($url, $model, $key) {
                $options = [
                    'title' => Yii::t('cruds', 'Update'),
                    'aria-label' => Yii::t('cruds', 'Update'),
                    'data-pjax' => '0',
                ];
                if ($model->sent_email_datetime == null) {
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, $options);
                } else {
                    return '<i class="glyphicon glyphicon-pencil disabled-link"></i>';
                }
                
            }, 'sent-email' => function ($url, $model, $key) {
                $options = [
                    'title' => Yii::t('cruds', 'Send Email'),
                    'aria-label' => Yii::t('cruds', 'Send Email'),
                    'data-pjax' => '0',
                    'data-confirm' => 'Are you sure to send email for this period ?'
                ];
                return '<i class="fa fa-envelope disabled-link"></i>';
                if ($model->sent_email_datetime == null) {
                    return Html::a('<span class="fa fa-envelope"></span>', ['send-email', 'period' => $model->period], $options);
                } else {
                    $options['class'] = 'disabled';
                    return '<i class="fa fa-envelope disabled-link"></i>';
                }
                
            }
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
        'attribute' => 'period',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
    [
        'attribute' => 'final_product_so',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],[
        'attribute' => 'final_product_act',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ], [
        'attribute' => 'final_product_ratio',
        'value' => function($model){
            return $model->final_product_ratio . '%';
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ], [
        'attribute' => 'kd_so',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ], [
        'attribute' => 'kd_act',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ], [
        'attribute' => 'kd_ratio',
        'value' => function($model){
            return $model->kd_ratio . '%';
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center;'
        ],
    ],
];
?>
<div class="giiant-crud shipping-monthly-summary-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $columns,
            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'pjax' => true, // pjax is set to always true for this demo
            'showPageSummary' => true,
            'toolbar' => [
                Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']),
                '{export}',
                '{toggleData}',
            ],
            // set export properties
            'export' => [
                'fontAwesome' => true
            ],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => 'Last update : ' . date('d M Y H:i:s')
            ],
        ]); ?>

</div>


<?php \yii\widgets\Pjax::end() ?>


