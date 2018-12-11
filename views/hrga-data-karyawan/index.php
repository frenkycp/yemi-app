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

$gridColumns = [
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{update}',
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
    ],
    [
        'attribute' => 'NIK',
        'label' => 'NIK',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
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
    /*'JENIS_KELAMIN',
    'STATUS_PERKAWINAN',
    'ALAMAT',
    'ALAMAT_SEMENTARA',
    'TELP',
    'NPWP',*/
    /*'KTP',*/
    /*'BPJS_KESEHATAN',*/
    /*'BPJS_KETENAGAKERJAAN',*/
    /*'STATUS_KARYAWAN',*/
    /*'CC_ID',*/
    /*'JABATAN_SR',*/
    /*'JABATAN_SR_GROUP',*/
    /*'GRADE',*/
    /*'DIRECT_INDIRECT',*/
    /*'JENIS_PEKERJAAN',*/
    /*'SERIKAT_PEKERJA',*/
    /*'ACTIVE_STAT',*/
    /*'PASSWORD',*/
    /*'TGL_LAHIR',*/
    /*'TGL_MASUK_YEMI',*/
    /*'K1_START',*/
    /*'K1_END',*/
    /*'K2_START',*/
    /*'K2_END',*/
    /*'SKILL',*/
    /*'KONTRAK_KE',*/
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


<?php \yii\widgets\Pjax::end() ?>


