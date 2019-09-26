<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\HrComplaintSearch $searchModel
*/

$this->title = 'My Facility';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss("h1 .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }
    .disabled-link {color: DarkGrey; cursor: not-allowed;}");

$this->registerJs("$(function() {
   $('#btn-upload-facility').click(function(e) {
     e.preventDefault();
     $('#common-modal').modal('show');
   });
});");

$gridColumns = [
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{upload_facility}',
        'buttons' => [
            'view' => function ($url, $model, $key) {
                $options = [
                    'title' => Yii::t('cruds', 'View'),
                    'aria-label' => Yii::t('cruds', 'View'),
                    'data-pjax' => '0',
                ];
                return Html::a('<span class="glyphicon glyphicon-file"></span>', $url, $options);
            }, 'upload_facility' => function($url, $model, $key){
                $options = [
                    'data-pjax' => '0',
                    'id' => 'btn-upload-facility',
                    'value' => Url::to(['upload-facility-img','id' => $model->id]),
                    'title' => 'Upload Image',
                    'class' => 'showModalButton'
                ];
                if ($model->img_filename == null) {
                    return Html::a('<i class="fa fa-fw fa-upload"></i>', '#', $options);
                } else {
                    return '<i class="fa fa-fw fa-upload disabled-link"></i>';
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
        'attribute' => 'img_filename',
        'label' => 'Pict.',
        'encodeLabel' => false,
        'value' => function($model){
            if ($model->img_filename != null) {
                return Html::a('<i class="fa fa-fw fa-photo"></i>', Url::base(true) .'/uploads/MY FACILITY/' . $model->img_filename, ['target' => '_blank', 'data-pjax' => 0]);
            } else {
                return '-';
            }
        },
        'format' => 'raw',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'mergeHeader' => true,
        //'width' => '100px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'min-width: 70px; font-size: 12px; text-align: center;',
        ],
    ],
    [
        'attribute' => 'remark_category',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'label' => '(+/-)',
        'filter' => [
            1 => 'POSITIF',
            0 => 'NEGATIF'
        ],
        'value' => function($model){
            if ($model->remark_category == 1) {
                //return Html::img('@web/uploads/ICON/icons8-thumbs-up-64.png', ['style' => 'height: 25px;']);
                return '<span style="font-size: 16px;" class="glyphicon glyphicon-thumbs-up text-green"></span>';
            } else {
                //return Html::img('@web/uploads/ICON/icons8-thumbs-down-64.png', ['style' => 'height: 25px;']);
                return '<span style="font-size: 16px;" class="glyphicon glyphicon-thumbs-down text-red"></span>';
            }
        },
        'format' => 'raw',
        'width' => '70px;',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'period',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '90px;',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'input_datetime',
        'label' => 'Question<br/>Datetime',
        'encodeLabel' => false,
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '80px',
        'value' => function($model){
            if ($model->input_datetime == null) {
                return '-';
            } else {
                return date('Y-m-d H:i', strtotime($model->input_datetime));
            }
        },
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'remark',
        'label' => 'Question',
        'vAlign' => 'middle',
        'format' => 'ntext',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'response',
        'label' => 'Answer',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'response_datetime',
        'label' => 'Answered<br/>Datetime',
        'encodeLabel' => false,
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '80px',
        'value' => function($model){
            if ($model->response_datetime == null) {
                return '-';
            } else {
                return date('Y-m-d H:i', strtotime($model->response_datetime));
            }
        },
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
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
            'style' => 'font-size: 12px;'
        ],
    ],
]
?>

<div class="giiant-crud hr-complaint-index">

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
            //'showPageSummary' => true,
            //'condensed' => true,
            'striped' => true,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto; font-size: 12px;'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'pjax' => false, // pjax is set to always true for this demo
            'toolbar' =>  [
                [
                    'content' => Html::a('New', ['my-hr/create-facility'], ['data-pjax' => 0, 'class' => 'btn btn-success pull-left'])
                ],
                [
                    'content' => Html::a('Back', ['my-hr/index'], ['data-pjax' => 0, 'class' => 'btn btn-warning'])
                ],
                //'{export}',
                '{toggleData}',
            ],
            // set export properties
            'export' => [
                'fontAwesome' => true
            ],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'before' => '<b><em>* Menu ini khusus digunakan jika ada kritik/saran/pujian terkait fasilitas perusahaan. Akan lebih baik jika disertai foto.</em></b><br/>
                <em><span class="text-red">* Untuk keluhan mengenai absensi, lembur dan yang berkaitan dengan data karyawan, gunakan menu "Question & Answer with HR"</span></em>',
                'heading' => ''
            ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>