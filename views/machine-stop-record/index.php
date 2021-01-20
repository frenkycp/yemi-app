<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\MachineStopRecord;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\PabxLogSearch $searchModel
*/

$this->title = [
    'page_title' => 'Machine Stop Data Record <span class="japanesse text-green"></span>',
    'tab_title' => 'Machine Stop Data Record',
    'breadcrumbs_title' => 'Machine Stop Data Record'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');

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
        'attribute' => 'PERIOD',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '90px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;',
        ],
    ],
    [
        'attribute' => 'POST_DATE',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '120px',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;',
        ],
    ],
    [
        'attribute' => 'MESIN_ID',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;',
        ],
    ],
    [
        'attribute' => 'MESIN_DESC',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;',
        ],
    ],
    [
        'attribute' => 'START_TIME',
        'value' => function($model){
            if ($model->START_TIME != null) {
                return date('Y-m-d H:i', strtotime($model->START_TIME));
            } else {
                return '-';
            }
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'mergeHeader' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;',
        ],
    ],
    [
        'attribute' => 'START_BY_NAME',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;',
        ],
    ],
    [
        'attribute' => 'REMARK',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;',
        ],
    ],
    [
        'attribute' => 'END_TIME',
        'value' => function($model){
            if ($model->END_TIME != null) {
                return date('Y-m-d H:i', strtotime($model->END_TIME));
            } else {
                return '-';
            }
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'mergeHeader' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;',
        ],
    ],
    [
        'attribute' => 'END_BY_NAME',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;',
        ],
    ],
    [
        'attribute' => 'TOTAL_DOWNTIME',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'mergeHeader' => true,
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;',
        ],
    ],
];
?>
<div class="giiant-crud machine-stop-record-index">

    <div class="box box-solid box-danger">
        <div class="box-header">
            <h3 class="box-title">Machine STOP!</h3>
        </div>
        <div class="box-body">
            <?= Html::a('Click Here to add new data', ['create'], ['class' => 'btn btn-default']); ?><br/><br/>
            <?php
            $tmp_stop = MachineStopRecord::find()->where(['STATUS' => 0])->orderBy('START_TIME')->all();
            if (count($tmp_stop) == 0) {
                echo '<marquee behavior="alternate" scrollamount="10"><span style="font-size: 30px" class="text-green">ALL ARE RUNNING WELL ...</span></marquee>';
            } else {
                ?>
                <table class="table table-responsive table-bordered table-striped" style="font-size: 20px;">
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Machine ID</th>
                        <th class="">Machine Name</th>
                        <th class="text-center">Start Time</th>
                        <th class="text-center">Action</th>
                    </tr>
                    <?php
                    $no = 0;
                    foreach ($tmp_stop as $key => $value): 
                        $no++;
                        ?>
                        <tr>
                            <td class="text-center"><?= $no; ?></td>
                            <td class="text-center"><?= $value->MESIN_ID; ?></td>
                            <td class=""><?= $value->MESIN_DESC; ?></td>
                            <td class="text-center"><?= date('Y-m-d H:i', strtotime($value->START_TIME)); ?></td>
                            <td class="text-center" width="100px"><?= Html::a('END', ['end-time', 'ID' => $value->ID], ['class' => 'btn btn-block btn-primary btn-sm']); ?></td>
                        </tr>
                    <?php endforeach ?>
                </table>
            <?php }
            ?>
        </div>
    </div>
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
            'toolbar' => [
                '{export}',
                '{toggleData}',
            ],
            // set export properties
            'export' => [
                'fontAwesome' => true
            ],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => 'Data Table'
                //'footer' => false,
            ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


