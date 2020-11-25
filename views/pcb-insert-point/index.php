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
    'page_title' => 'PCB Insert Point Data <span class="japanesse light-green"></span>',
    'tab_title' => 'PCB Insert Point Data',
    'breadcrumbs_title' => 'PCB Insert Point Data'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("h1 .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }
    .disabled-link {color: DarkGrey; cursor: not-allowed;}");

$gridColumns = [
    [
        'class' => 'kartik\grid\ActionColumn',
        //'hidden' => !$is_clinic ? true : false,
        'template' => '{update}',
        'buttons' => [
            
        ],
        'urlCreator' => function($action, $model, $key, $index) {
            // using the column name as key, not mapping to 'id' like the standard generator
            $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
            $params[0] = \Yii::$app->controller->id ? \Yii::$app->controller->id . '/' . $action : $action;
            return Url::toRoute($params);
        },
        'contentOptions' => ['nowrap'=>'nowrap', 'style' => 'min-width: 100px;']
    ],
    [
        'attribute' => 'part_no',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'model_name',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'pcb',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'destination',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'bu',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filter' => ArrayHelper::map(app\models\PcbInsertPointData::find()->select('bu')->groupBy('bu')->orderBy('bu')->all(), 'bu', 'bu'),
    ],
    [
        'attribute' => 'smt_a',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'smt_b',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'smt',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'jv2',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'av131',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'rg131',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'ai',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'mi',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
    ],
    [
        'attribute' => 'total',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'mergeHeader' => true,
    ],
];

?>
<div class="giiant-crud pcb-insert-point-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $gridColumns,
            //'hover' => true,
            //'condensed' => true,
            'striped' => false,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto;'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'toolbar' =>  [
                Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'Add', ['create'], ['class' => 'btn btn-success']),
                '{export}',
                '{toggleData}',
            ],
            /*'rowOptions' => function($model){
                if ($model->Discontinue == 'Y') {
                    return ['class' => 'bg-danger'];
                }
            },*/
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


