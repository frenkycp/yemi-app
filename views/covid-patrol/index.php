<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use kartik\export\ExportMenu;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\CutiTblSearch $searchModel
*/

$this->title = [
    'page_title' => 'Covid Patrol Data <span class="japanesse text-green"></span>',
    'tab_title' => 'Covid Patrol Data',
    'breadcrumbs_title' => 'Covid Patrol Data'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
    .btn-block {
        margin: 3px 0px;
    }
    .img-before-after {
        display: block;
        width: 100%;
    }
");

$tmp_patrol_category = \Yii::$app->params['covid_patrol_category'];
$tmp_patrol_loc = \Yii::$app->params['covid_patrol_loc'];
asort($tmp_patrol_loc);

$gridColumns = [
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{update} {action} {delete_data}',
        'buttons' => [
            'update' => function($url, $model, $key){
                $url = ['update', 'ID' => $model->ID];
                $options = [
                    'title' => 'Edit',
                    'data-pjax' => '0',
                ];
                return Html::a('<button class="btn btn-success btn-sm btn-block"><i class="fa fa-edit"></i> EDIT</span></button>', $url, $options);
            },
            'action' => function($url, $model, $key){
                $url = ['solve', 'ID' => $model->ID];
                $options = [
                    'title' => 'Action',
                    'data-pjax' => '0',
                ];
                return Html::a('<button class="btn btn-warning btn-sm btn-block"><i class="fa fa-thumbs-o-up"></i> ACTION</span></button>', $url, $options);
            },
            'delete_data' => function($url, $model, $key){
                $options = [
                    'data-pjax' => '0',
                    'value' => Url::to(['delete-data', 'ID' => $model->ID]),
                    'title' => 'Delete Patrol Data',
                    'class' => 'showModalButton'
                ];
                
                return Html::a('<button class="btn btn-danger btn-sm btn-block"><i class="fa fa-remove"></i> DELETE</span></button>', '#', $options);
            },
            'view' => function ($url, $model, $key) {
                $options = [
                    'title' => Yii::t('cruds', 'View'),
                    'aria-label' => Yii::t('cruds', 'View'),
                    'data-pjax' => '0',
                ];
                return Html::a('<span class="glyphicon glyphicon-file"></span>', $url, $options);
            }
        ],
        'contentOptions' => ['nowrap'=>'nowrap', 'style' => 'width: 100px;']
    ],
    /*[
        'attribute' => 'CATEGORY',
        'value' => function($model){
            return \Yii::$app->params['audit_patrol_category'][$model->CATEGORY];
        },
        'label' => 'Patrol Type',
        'filter' => \Yii::$app->params['audit_patrol_category'],
        //'hAlign' => 'center',
        'vAlign' => 'middle',
    ],*/
    [
        'attribute' => 'ID',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'TOPIC',
        'label' => 'Patrol Category',
        'filter' => $tmp_patrol_category,
        //'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'PATROL_DATE',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    /*[
        'attribute' => 'LOC_ID',
        'value' => 'LOC_DESC',
        'label' => 'Location',
        'filter' => \Yii::$app->params['wip_location_arr'],
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],*/
    [
        'attribute' => 'LOC_DETAIL',
        'label' => 'Location',
        'filter' => $tmp_patrol_loc,
        //'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'AUDITOR',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'PIC_NAME',
        'label' => 'PIC',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'STATUS',
        'value' => function($model){
            if ($model->STATUS == 'O') {
                return '<span class="text-red">OPEN</span>';
            } else {
                return '<span class="text-green">CLOSE</span>';
            }
        },
        'format' => 'html',
        'filter' => [
            'O' => 'OPEN',
            'C' => 'CLOSE',
        ],
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    /*[
        'attribute' => 'TOPIC',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],*/
    [
        'attribute' => 'DESCRIPTION',
        //'hAlign' => 'center',
        'vAlign' => 'middle',
        'contentOptions' => [
            'style' => 'min-width: 100px;'
        ],
    ],
    [
        'attribute' => 'ACTION',
        /*'value' => function($model){
            $return_val = $model->ACTION;
            if ($model->IMAGE_AFTER_1 != null) {
                $return_val .= '<br/>' . Html::img('@web/uploads/AUDIT_PATROL/' . $model->IMAGE_AFTER_1, ['width'=>'250']);
            }
            return $return_val;
        },
        'mergeHeader' => true,*/
        'format' => 'html',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'contentOptions' => [
            'style' => 'min-width: 100px;'
        ],
    ],
    [
        'attribute' => 'IMAGE_BEFORE_1',
        'value' => function($model){
            if ($model->IMAGE_BEFORE_1 != null) {
                return Html::img('http://10.110.52.5:86/uploads/COVID_PATROL/' . $model->IMAGE_BEFORE_1, ['width'=>'170px', 'alt' => 'No Image Found...', 'class' => 'img-before-after']);
            }
        },
        'width' => '170px',
        'mergeHeader' => true,
        'format' => 'html',
        'label' => 'Image Before',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    
    [
        'attribute' => 'IMAGE_AFTER_1',
        'value' => function($model){
            if ($model->IMAGE_AFTER_1 != null) {
                return Html::img('http://10.110.52.5:86/uploads/COVID_PATROL/' . $model->IMAGE_AFTER_1, ['width'=>'170px', 'alt' => 'No Image Found...', 'class' => 'img-before-after']);
            }
        },
        'width' => '170px',
        'mergeHeader' => true,
        'format' => 'html',
        'label' => 'Image After',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],

];
?>
<div class="giiant-crud audit-patrol-tbl-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

<?php
/*echo ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
        'onRenderDataCell' => function(PhpOffice\PhpSpreadsheet\Cell\Cell $cell, $content, $model, $key, $index, kartik\export\ExportMenu $widget) {
            $column = $cell->getColumn();
            $columnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($column) - 1;
            $path = \Yii::$app->basePath . '\\web\\uploads\\COVID_PATROL\\' . $model->IMAGE_BEFORE_1;
            $value = ($model->IMAGE_BEFORE_1);
            if(file_exists($path)) {   // change the condition as you prefer
                $firstRow = 2;  // skip header row
                $imageName = "Image name";      // Add a name
                $imageDescription = "Image description";    // Add a description
                $padding = 5;
                $imageWidth = 60;   // Image width
                $imageHeight = 60;  // Image height
                $cellID = $column . ($index + $firstRow);   // Get cell identifier
                $worksheet = $cell->getWorksheet();
                $worksheet->getRowDimension($index + $firstRow)->setRowHeight($imageHeight + ($padding * 2));
                //$worksheet->getColumnDimension($column)->setAutoSize(false);
                //$worksheet->getColumnDimension($column)->setWidth($imageWidth + ($padding * 2));
                $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $drawing->setName($imageName);
                $drawing->setDescription($imageDescription);
                $drawing->setPath($value); // put your path and image here
                $drawing->setCoordinates($cellID);
                //$drawing->setOffsetX(200);
                $drawing->setWidth($imageWidth);
                $drawing->setHeight($imageHeight);
                //$drawing->setWidthAndHeight($imageWidth, $imageHeight);
                $drawing->setWorksheet($worksheet);

            }
        },
        'dropdownOptions' => [
            'label' => 'Export All',
            'class' => 'btn btn-secondary'
        ]
    ]) . "<hr>\n";*/
?>

    <div class="">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $gridColumns,
            //'hover' => true,
            //'condensed' => true,
            'striped' => false,
            'pager' => [
                'firstPageLabel' => 'First',
                'lastPageLabel'  => 'Last'
            ],
            'showPageSummary' => true,
            //'floatHeader'=>true,
            //'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'containerOptions' => ['style' => 'overflow: auto;'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'pjax' => true, // pjax is set to always true for this demo
            'toolbar' =>  [
                Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'Add', ['create'], ['class' => 'btn btn-success']),
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


