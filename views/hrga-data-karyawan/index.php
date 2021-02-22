<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\HrgaDataKaryawanSearch $searchModel
*/

$this->title = 'Data Karyawan';
$this->params['breadcrumbs'][] = $this->title;

if (isset($actionColumnTemplates)) {
$actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']);
    $actionColumnTemplateString = "{view} {update} {delete}";
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';

$this->registerJs("$(function() {
   $('.popup_img').click(function(e) {
        e.preventDefault();
        $('#emp_photo').modal('show').find('.modal-content').html('<div class=\"text-center\">" . Html::img('@web/loading-01.gif', ['alt'=>'some', 'class'=>'thing']) . "</div>').load($(this).attr('href'));
   });
});");

$gridColumns = [
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{update} {upload_image}',
        'buttons' => [
            'view' => function ($url, $model, $key) {
                $options = [
                    'title' => Yii::t('cruds', 'View'),
                    'aria-label' => Yii::t('cruds', 'View'),
                    'data-pjax' => '0',
                ];
                return Html::a('<span class="glyphicon glyphicon-file"></span>', $url, $options);
            },
            'upload_image' => function ($url, $model, $key) {
                $options = [
                    'title' => 'Upload Image',
                    'style' => 'padding-left: 10px;'
                ];
                $url = ['upload-image', 'NIK' => $model->NIK, 'NAMA_KARYAWAN' => $model->NAMA_KARYAWAN];

                return Html::a('<span class="glyphicon glyphicon-upload"></span>', $url, $options);
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
    [
        'attribute' => 'NIK',
        'label' => 'NIK',
        'value' => function($model){
            $filename = $model->NIK . '.jpg';
            $path = \Yii::$app->basePath . '\\web\\uploads\\yemi_employee_img\\' . $filename;
            if (file_exists($path)) {
                return Html::a($model->NIK, ['get-image-preview', 'NIK' => $model->NIK, 'NAMA_KARYAWAN' => $model->NAMA_KARYAWAN], ['class' => 'popup_img btn btn-warning btn-xs', 'data-pjax' => '0',]);
            } else {
                return $model->NIK;
            }
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'format' => 'html',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'NIK_SUN_FISH',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'AKTIF',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'NAMA_KARYAWAN',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'CC_ID',
        'label' => 'CC ID',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filter' => $cost_center_dropdown,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'DEPARTEMEN',
        'vAlign' => 'middle',
        //'hAlign' => 'center',
        'filter' => $departemen_dropdown,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'SECTION',
        'vAlign' => 'middle',
        //'hAlign' => 'center',
        'filter' => $section_dropdown,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'SUB_SECTION',
        'vAlign' => 'middle',
        //'hAlign' => 'center',
        'filter' => $sub_section_dropdown,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'cuti',
        'value' => function($model){
            $rekap_cuti_arr = app\models\CutiRekapView02::find()
            ->where([
                'TAHUN' => date('Y'),
                'NIK' => $model->NIK,
            ])
            ->all();

            $using_cuti = 0;
            $kuota_cuti = 0;
            foreach ($rekap_cuti_arr as $rekap_cuti) {
                if ($rekap_cuti->TYPE == '01-KUOTA') {
                    $kuota_cuti += $rekap_cuti->JUMLAH_CUTI;
                } else {
                    $using_cuti += $rekap_cuti->JUMLAH_CUTI;
                }
            }
            $sisa_cuti = $kuota_cuti + $using_cuti;
            if ($sisa_cuti < 0) {
                $sisa_cuti = 0;
            }

            return '<span class="badge bg-light-blue">' . $sisa_cuti . '/' . $kuota_cuti . '</span>';
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'format' => 'html',
        'filter' => $sub_section_dropdown,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'STATUS_KARYAWAN',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filter' => $status_karyawan_dropdown,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'KONTRAK_KE',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filter' => [
            1 => 1,
            2 => 2
        ],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'kontrak_start',
        'value' => function($model){
            $value = '-';
            if ($model->KONTRAK_KE == 1) {
                if ($model->K1_START == null) {
                    $value = '-';
                } else {
                    $value = date('Y-m-d', strtotime($model->K1_START));
                }
                
            } elseif ($model->KONTRAK_KE == 2) {
                $value = $model->K2_START == null ? '-' : date('Y-m-d', strtotime($model->K2_START));
            }
            return $value;
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'kontrak_end',
        'value' => function($model){
            $value = '-';
            if ($model->KONTRAK_KE == 1) {
                $value = $model->K1_END == null ? '-' : date('Y-m-d', strtotime($model->K1_END));
            } elseif ($model->KONTRAK_KE == 2) {
                $value = $model->K2_END == null ? '-' : date('Y-m-d', strtotime($model->K2_END));
            }
            return $value;
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
];
?>
<div class="giiant-crud karyawan-index">

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
            ],
        ]); ?>
    </div>

</div>
<?php
yii\bootstrap\Modal::begin([
    'id' =>'emp_photo',
    'header' => '<h3>Machine Image</h3>',
    //'size' => 'modal-lg',
]);
yii\bootstrap\Modal::end();

yii\bootstrap\Modal::begin([
    'id' =>'modal-resign',
    'header' => '<h3>Resign Input Form</h3>',
]);
yii\bootstrap\Modal::end();
?>


<?php \yii\widgets\Pjax::end() ?>


