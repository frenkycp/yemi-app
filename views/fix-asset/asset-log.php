<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\FixAssetDataSearch $searchModel
*/

/**
 * This is the base-model class for table "db_owner.ASSET_TBL".
 *
 * @property string $asset_id
 * @property string $qr
 * @property string $ip_address
 * @property string $computer_name
 * @property string $jenis
 * @property string $manufacture
 * @property string $manufacture_desc
 * @property string $cpu_desc
 * @property string $ram_desc
 * @property string $rom_desc
 * @property string $os_desc
 * @property string $fixed_asst_account
 * @property string $asset_category
 * @property string $purchase_date
 * @property integer $report_type
 * @property string $LAST_UPDATE
 * @property string $network
 * @property string $display
 * @property string $camera
 * @property string $battery
 * @property string $note
 * @property string $location
 * @property string $area
 * @property string $project
 * @property string $cur
 * @property double $price
 * @property double $price_usd
 * @property string $manager_name
 * @property string $department_pic
 * @property string $cost_centre
 * @property string $department_name
 * @property string $section_name
 * @property string $nik
 * @property string $NAMA_KARYAWAN
 * @property string $primary_picture
 * @property string $FINANCE_ASSET
 * @property double $qty
 * @property double $AtCost
 * @property string $Discontinue
 * @property string $DateDisc
 * @property string $status
 * @property string $label
 * @property string $aliasModel
 */

$this->title = [
    'page_title' => 'Fixed Asset History Data Table <span class="japanesse light-green"></span>',
    'tab_title' => 'Fixed Asset History Data Table',
    'breadcrumbs_title' => 'Fixed Asset History Data Table'
];

date_default_timezone_set('Asia/Jakarta');
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
");

if (isset($actionColumnTemplates)) {
$actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']);
    $actionColumnTemplateString = "{view} {update} {delete}";
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';



$this->registerJs("$(document).ready(function() {
    $('.imageModal').click(function(e) {
        e.preventDefault();
        $('#image-modal').modal('show').find('.modal-body').load($(this).attr('href'));
    });
});");

$gridColumns = [
    [
        'class' => 'kartik\grid\ActionColumn',
        //'hidden' => !$is_clinic ? true : false,
        'template' => '{stock-take}',
        'buttons' => [
            'stock-take' => function($url, $model, $key){
                $session = \Yii::$app->session;
                if ($model->schedule_status == 'C' && $model->user_id != $session['fix_asset_user'] && $model->user_id != $session['fix_asset_nik']) {
                    return '';
                }
                $url = ['stock-take', 'asset_id' => $model->asset_id, 'trans_id' => $model->trans_id];
                $options = [
                    'title' => 'Stock Take',
                    'data-pjax' => '0',
                ];
                return Html::a('<span class="fa fa-cubes"></span>', $url, $options);
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
        'attribute' => 'asset_image',
        'label' => 'Image',
        'value' => function($model){
            $tmp_file1 = \Yii::$app->basePath . '\\web\\uploads\\ASSET_IMG\\' . $model->schedule_id . '\\' . $model->asset_id . '.jpg';
            $tmp_file2 = \Yii::$app->basePath . '\\web\\uploads\\ASSET_IMG\\' . $model->asset_id . '.jpg';
            if (file_exists($tmp_file1)) {
                $filepath = \Yii::getAlias("@web/uploads/ASSET_IMG/") . $model->schedule_id . '/' . $model->asset_id . '.jpg';
            } elseif (file_exists($tmp_file2)) {
                $filepath = \Yii::getAlias("@web/uploads/ASSET_IMG/") . $model->asset_id . '.jpg';
            } else {
                $filepath = \Yii::getAlias("@web/uploads/image-not-available.png");
            }
            return Html::img($filepath, [
                'height' => '50px',
                'alt' => '-'
            ]);
            /*return Html::a(Html::img($filepath, [
                'height' => '50px',
                'alt' => '-'
            ]), ['get-image-preview', 'asset_id' => $model->asset_id, 'schedule_id' => $model->schedule_id], ['class' => 'imageModal', 'data-pjax' => '0',]);*/
        },
        'format' => 'html',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'asset_id',
        'label' => 'Asset ID',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 10px; min-width: 70px;'
        ],
    ],
    [
        'attribute' => 'computer_name',
        'label' => 'Asset Name',
        'vAlign' => 'middle',
        //'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 10px; min-width: 70px;'
        ],
    ],
    [
        'attribute' => 'jenis',
        'label' => 'Type',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filter' => $dropdown_type,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 10px; min-width: 70px;'
        ],
    ],
    [
        'attribute' => 'cost_centre',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filter' => ArrayHelper::map(app\models\CostCenter::find()->all(), 'CC_ID', 'CC_ID'),
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 10px; min-width: 70px;'
        ],
    ],
    // [
    //     'attribute' => 'department_name',
    //     'label' => 'Department',
    //     'vAlign' => 'middle',
    //     'filter' => ArrayHelper::map(app\models\AssetTbl::find()->select('department_name')->where(['FINANCE_ASSET' => 'Y'])->andWhere('department_name IS NOT NULL')->groupBy('department_name')->orderBy('department_name')->all(), 'department_name', 'department_name'),
    //     'filterInputOptions' => [
    //         'class' => 'form-control',
    //         'style' => 'text-align: center; font-size: 10px; min-width: 70px;'
    //     ],
    // ],
    [
        'attribute' => 'CC_DESC',
        'label' => 'Section',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 10px; min-width: 70px;'
        ],
    ],
    [
        'attribute' => 'purchase_date',
        'label' => 'Acquisition Date',
        'value' => function($model){
            if ($model->purchase_date == null) {
                return '-';
            } else {
                return date('Y-m-d', strtotime($model->purchase_date));
            }
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 10px; min-width: 70px;'
        ],
    ],
    [
        'attribute' => 'qty',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 10px; min-width: 70px;'
        ],
    ],
    [
        'attribute' => 'schedule_status',
        'label' => 'Closing Status',
        'value' => function($model){
            if ($model->schedule_status == 'O') {
                return 'OPEN';
            }
            if ($model->schedule_status == 'C') {
                return 'CLOSE';
            }
            return '???';
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filter' => [
            'O' => 'OPEN',
            'C' => 'CLOSE',
        ],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 10px; min-width: 70px;'
        ],
    ],
    [
        'attribute' => 'posting_date',
        'label' => 'Date',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 10px; min-width: 70px;'
        ],
    ],
    [
        'attribute' => 'status',
        'label' => 'Asset Status',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 10px; min-width: 70px;'
        ],
    ],
    [
        'attribute' => 'propose_scrap',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filter' => [
            'Y' => 'Y',
            'N' => 'N',
        ],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 10px; min-width: 70px;'
        ],
    ],
    [
        'attribute' => 'label',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 10px; min-width: 70px;'
        ],
    ],
    // [
    //     'attribute' => 'NBV',
    //     'vAlign' => 'middle',
    //     'hAlign' => 'center',
    //     'filterInputOptions' => [
    //         'class' => 'form-control',
    //         'style' => 'text-align: center; font-size: 10px; min-width: 70px;'
    //     ],
    // ],
    [
        'attribute' => 'note',
        'label' => 'Remark',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 10px; min-width: 70px;'
        ],
    ],
    [
        'attribute' => 'from_loc',
        'label' => 'Source Location',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 10px; min-width: 70px;'
        ],
    ],
    [
        'attribute' => 'to_loc',
        'label' => 'Destination Location',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 10px; min-width: 70px;'
        ],
    ],
    [
        'attribute' => 'user_id',
        'label' => 'NIK',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 10px; min-width: 70px;'
        ],
    ],
    [
        'attribute' => 'user_desc',
        'label' => 'Name',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 10px; min-width: 70px;'
        ],
    ],
    /*[
        'attribute' => 'signature',
        'value' => function($model){
            $dept_sign = \Yii::$app->params['department_signature'];
            if ($model->schedule_status == 'O') {
                return '';
            } else {
                if ($model->cost_centre == null) {
                    $filepath = \Yii::getAlias("@web/uploads/image-not-available.png");
                } else {
                    $filepath = \Yii::getAlias("@web/uploads/TTD/") . $dept_sign[$model->cost_centre];
                }
                return Html::img($filepath, [
                    'height' => '50px',
                    'alt' => '-'
                ]);
            }
        },
        'format' => 'html',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],*/
];
?>
<div class="giiant-crud asset-tbl-index">

    <?php
             echo $this->render('log_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <div class="">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'columns' => $gridColumns,
            'hover' => true,
            //'condensed' => true,
            'striped' => true,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto; font-size: 10px;'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'toolbar' =>  [
                //Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'Add', ['create'], ['class' => 'btn btn-success']),
                '{export}',
                '{toggleData}',
            ],
            'rowOptions' => function($model){
                if ($model->schedule_status == 'O') {
                    return ['class' => 'danger'];
                } else {
                    return ['class' => 'success'];
                }
            },
            // set export properties
            'export' => [
                'fontAwesome' => true
            ],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                //'footer' => false,
            ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


<?php
yii\bootstrap\Modal::begin([
    'id' =>'image-modal',
    //'header' => '',
    'size' => 'modal-lg',
]);
yii\bootstrap\Modal::end();
?>