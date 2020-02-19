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
    'page_title' => 'Fixed Asset Data Table <span class="japanesse light-green"></span>',
    'tab_title' => 'Fixed Asset Data Table',
    'breadcrumbs_title' => 'Fixed Asset Data Table'
];
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

$gridColumns = [
    [
        'class' => 'kartik\grid\ActionColumn',
        //'hidden' => !$is_clinic ? true : false,
        'template' => '{stock-take}',
        'buttons' => [
            'view' => function ($url, $model, $key) {
                $options = [
                    'title' => Yii::t('cruds', 'View'),
                    'aria-label' => Yii::t('cruds', 'View'),
                    'data-pjax' => '0',
                ];
                return Html::a('<span class="glyphicon glyphicon-file"></span>', $url, $options);
            }, 'stock-take' => function($url, $model, $key){
                $url = ['stock-take', 'asset_id' => $model->asset_id];
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
        'attribute' => 'asset_id',
        'label' => 'Fixed Asset ID',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 70px;'
        ],
    ],
    [
        'attribute' => 'computer_name',
        'label' => 'Fixed Asset Description',
        'vAlign' => 'middle',
        //'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 70px;'
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
            'style' => 'text-align: center; font-size: 12px; min-width: 70px;'
        ],
    ],
    [
        'attribute' => 'cost_centre',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filter' => ArrayHelper::map(app\models\CostCenter::find()->all(), 'CC_ID', 'CC_ID'),
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 70px;'
        ],
    ],
    // [
    //     'attribute' => 'department_name',
    //     'label' => 'Department',
    //     'vAlign' => 'middle',
    //     'filter' => ArrayHelper::map(app\models\AssetTbl::find()->select('department_name')->where(['FINANCE_ASSET' => 'Y'])->andWhere('department_name IS NOT NULL')->groupBy('department_name')->orderBy('department_name')->all(), 'department_name', 'department_name'),
    //     'filterInputOptions' => [
    //         'class' => 'form-control',
    //         'style' => 'text-align: center; font-size: 12px; min-width: 70px;'
    //     ],
    // ],
    [
        'attribute' => 'section_name',
        'label' => 'Section',
        'vAlign' => 'middle',
        'filter' => ArrayHelper::map(app\models\AssetTbl::find()->select('section_name')->where(['FINANCE_ASSET' => 'Y'])->andWhere('section_name IS NOT NULL')->groupBy('section_name')->orderBy('section_name')->all(), 'section_name', 'section_name'),
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 70px;'
        ],
    ],
    [
        'attribute' => 'purchase_date',
        'label' => 'Acquisition Date',
        'format' => ['date', 'php:Y-m-d'],
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 70px;'
        ],
    ],
    [
        'attribute' => 'qty',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 70px;'
        ],
    ],
    /*[
        'attribute' => 'loc_type',
        'label' => 'Type (I/O)',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filter' => [
            'I' => 'I',
            'O' => 'O',
        ],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 70px;'
        ],
    ],*/
    [
        'attribute' => 'LOC',
        'label' => 'Loc. ID',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 70px;'
        ],
    ],
    [
        'attribute' => 'location',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 70px;'
        ],
    ],
    // [
    //     'attribute' => 'area',
    //     'vAlign' => 'middle',
    //     'hAlign' => 'center',
    //     'filterInputOptions' => [
    //         'class' => 'form-control',
    //         'style' => 'text-align: center; font-size: 12px; min-width: 70px;'
    //     ],
    // ],
    [
        'attribute' => 'Discontinue',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filter' => [
            'Y' => 'Y',
            'N' => 'N',
        ],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 70px;'
        ],
    ],
    [
        'attribute' => 'status',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filter' => \Yii::$app->params['fixed_asset_status'],
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 70px;'
        ],
    ],
    [
        'attribute' => 'label',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px; min-width: 70px;'
        ],
    ],
];
?>
<div class="giiant-crud asset-tbl-index">

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
            'toolbar' =>  [
                //Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'Add', ['create'], ['class' => 'btn btn-success']),
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
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


