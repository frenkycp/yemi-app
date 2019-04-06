<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\web\View;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\ClinicDataSearch $searchModel
*/

$this->title = [
    'page_title' => 'Data Klinik <span class="japanesse text-green"></span>',
    'tab_title' => 'Data Klinik',
    'breadcrumbs_title' => 'Data Klinik'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }
");

date_default_timezone_set('Asia/Jakarta');

$script = <<< JS
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout("refreshPage();", 300000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
JS;

$this->registerJs($script, View::POS_END);

$this->registerJs("$(function() {
   $('.btn_checkout').click(function(e) {
     e.preventDefault();
     $('#common-modal').modal('show');
   });
});");

$clinic_role_id = [1, 31];
if (in_array(\Yii::$app->user->identity->role_id, $clinic_role_id)) {
    $is_clinic = true;
    $toolbar = [
        Html::button('<span class="glyphicon glyphicon-log-out"></span> ' . 'Cek Out', [
            'value' => Url::to(['check-out']),
            'title' => 'Cek Out Klinik',
            'class' => 'showModalButton btn btn-warning',
            'id' => 'btn_checkout'
        ]),
        Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'Tambah', ['create'], ['class' => 'btn btn-success']),
        '{export}',
        '{toggleData}',
    ];
} else {
    $is_clinic = false;
    $toolbar = [
        '{export}',
        '{toggleData}',
    ];
}

$gridColumns = [
    [
        'class' => 'kartik\grid\ActionColumn',
        //'hidden' => !$is_clinic ? true : false,
        'template' => '{update} {delete}',
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
        'attribute' => 'input_date',
        'label' => 'Tanggal',
        'value' => function($model){
            return date('Y-m-d', strtotime($model->pk));
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; width: 85px;'
        ],
    ],
    [
        'attribute' => 'nik',
        'label' => 'NIK',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; width: 70px;'
        ],
    ],
    [
        'attribute' => 'nama',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px; min-width: 150px;'
        ],
    ],
    [
        'attribute' => 'dept',
        'label' => 'Departemen',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px; min-width: 150px;'
        ],
    ],
    [
        'attribute' => 'opsi',
        'value' => function($model){
            if ($model->opsi == 1) {
                return 'PERIKSA';
            } elseif ($model->opsi == 2) {
                return 'ISTIRAHAT SAKIT';
            } else {
                return 'LAKSTASI';
            }
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filter' => [
            1 => 'PERIKSA',
            2 => 'ISTIRAHAT SAKIT',
            3 => 'LAKSTASI',
        ],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 100px;'
        ],
    ],
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'masuk',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
        'editableOptions'=> [
            'inputType'=>\kartik\editable\Editable::INPUT_TIME,
            'options' => [
                'pluginOptions' => [
                    'showSeconds' => true,
                    'showMeridian' => false,
                    'minuteStep' => 1,
                    'secondStep' => 5,
                ]
            ]
        ],
        //'hiddenFromExport' => true,
        //'hidden' => !$is_clinic ? true : false,
    ],
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'keluar',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
        'editableOptions'=> [
            'inputType'=>\kartik\editable\Editable::INPUT_TIME,
            'options' => [
                'pluginOptions' => [
                    'showSeconds' => true,
                    'showMeridian' => false,
                    'minuteStep' => 1,
                    'secondStep' => 5,
                ]
            ]
        ],
        //'hiddenFromExport' => true,
        //'hidden' => !$is_clinic ? true : false,
    ],
    [
        'attribute' => 'masuk',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; width: 70px;'
        ],
        //'hidden' => $is_clinic ? true : false,
    ],
    [
        'attribute' => 'keluar',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; width: 70px;'
        ],
        //'hidden' => $is_clinic ? true : false,
    ],
    [
        'attribute' => 'confirm',
        'label' => 'Konfirmasi Manager',
        'value' => function($model){
            if ($model->confirm == 1) {
                return '<span class="text-green">SUDAH</span>';
            } else {
                return '<span class="text-red">BELUM</span>';
            }
        },
        'format' => 'html',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filter' => [
            0 => 'BELUM',
            1 => 'SUDAH'
        ],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'handleby',
        'value' => function($model){
            return strtoupper($model->handleby);
        },
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'anamnesa',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px; min-width: 100px;'
        ],
    ],
    [
        'attribute' => 'root_cause',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px; min-width: 100px;'
        ],
    ],
    [
        'attribute' => 'diagnosa',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px; min-width: 100px;'
        ],
    ],
    [
        'attribute' => 'obat1',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px; min-width: 100px;'
        ],
    ],
    [
        'attribute' => 'obat2',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px; min-width: 100px;'
        ],
    ],
    [
        'attribute' => 'obat3',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px; min-width: 100px;'
        ],
    ],
    [
        'attribute' => 'obat4',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px; min-width: 100px;'
        ],
    ],
    [
        'attribute' => 'obat5',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'font-size: 12px; min-width: 100px;'
        ],
    ],
];

if (!$is_clinic) {
    unset($gridColumns[0]);
    unset($gridColumns[6]);
    unset($gridColumns[7]);
} else {
    unset($gridColumns[8]);
    unset($gridColumns[9]);
}

?>
<div class="row" style="<?= !$is_clinic ? 'display: none;' : ''; ?>">
    <div class="col-md-12">
        <div class="pull-left">
            <?php
            $data_handle = app\models\KlinikHandle::find()->all();
            foreach ($data_handle as $key => $value) {
                if ($value->pk == 'doctor') {
                    $nama = 'Dokter';
                } elseif ($value->pk == 'nurse') {
                    $nama = 'Perawat';
                }
                if ($value->status == 1) {
                    $available = 'Ada';
                    $bg = ' bg-green';
                } elseif ($value->status == 0) {
                    $available = 'Tidak Ada';
                    $bg = ' bg-red';
                }
                echo Html::a('<span class="badge' . $bg . '">' . $available . '</span><i class="fa fa-user"></i> ' . $nama, ['change-status', 'pk' => $value->pk], ['class' => 'btn btn-app']);
                echo "&nbsp;";
            }
            ?>
        </div>
    </div>
</div>

<div class="giiant-crud klinik-input-index">

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
            'toolbar' => $toolbar,
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


<?php \yii\widgets\Pjax::end() ?>


