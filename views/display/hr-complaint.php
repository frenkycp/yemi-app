<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\web\View;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\HrComplaintSearch $searchModel
*/

$this->title = [
    'page_title' => 'Question & Answer (HR) <span class="japanesse light-green">労務管理問い合わせ</span> <span class="pull-right-container"><small class="label pull-right bg-yellow">' . $total_waiting . '</small></span>',
    'tab_title' => 'Question & Answer (HR)',
    'breadcrumbs_title' => 'Question & Answer (HR)'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    .form-control {font-size: 30px; height: 52px;}
    .content-header {color: white;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    .box-header .box-title, .control-label{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .active a {background-color: #3c8dbc !important; font-size: 18px; color: white !important;}
");

$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 180000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";
$this->registerJs($script, View::POS_HEAD );

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
        'class' => 'kartik\grid\EnumColumn',
        'attribute' => 'whatsapp',
        'label' => 'Sent<br/>Using',
        'enum' => [
            'Y' => Html::img('@web/uploads/ICON/wa_001.png', ['alt' => 'No Image Found', 'width' => '40px', 'title' => 'WhatsApp']),
            'N' => Html::img('@web/uploads/ICON/pc_001.png', ['alt' => 'No Image Found', 'width' => '40px', 'title' => 'PC']),
         ],
        'encodeLabel' => false,
        'format' => 'html',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '80px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; '
        ],
    ],
    [
        'attribute' => 'input_datetime',
        'label' => 'Question<br/>Datetime',
        'encodeLabel' => false,
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '80px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; '
        ],
    ],
    [
        'attribute' => 'response_datetime',
        'label' => 'Answered<br/>Datetime',
        'encodeLabel' => false,
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '80px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; '
        ],
    ],
    [
        'attribute' => 'nik',
        'label' => 'NIK',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '90px;',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; '
        ],
    ],
    [
        'attribute' => 'emp_name',
        'label' => 'Name',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => ''
        ],
    ],
    [
        'attribute' => 'section',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => ''
        ],
    ],
    [
        'attribute' => 'status',
        'value' => function($model){
            if ($model->status == 0) {
                return '<span class="label label-warning">WAITING</span>';
            } elseif($model->status == 1) {
                return '<span class="label label-success">ANSWERED</span>';
            }
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'format' => 'html',
        'width' => '120px;',
        'filter' => [
            0 => 'WAITING',
            1 => 'ANSWERED'
        ],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => ''
        ],
    ],
    [
        'attribute' => 'remark',
        'label' => 'Question',
        'vAlign' => 'middle',
        'format' => 'ntext',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => ''
        ],
    ],
    [
        'attribute' => 'response',
        'label' => 'Answer',
        'vAlign' => 'middle',
        'format' => 'ntext',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => ''
        ],
    ]
];
?>
<div class="giiant-crud hr-complaint-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    
    <div class="">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'columns' => $grid_columns,
            'hover' => true,
            //'showPageSummary' => true,
            'condensed' => true,
            'striped' => true,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto; font-size: 14px; font-weight: bold;'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'pjax' => true, // pjax is set to always true for this demo
            'toolbar' =>  false,
            // set export properties
            'export' => [
                'fontAwesome' => true
            ],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => false,
                'footer' => false,
            ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


