<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\web\View;
/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\SkillMapDataSearch $searchModel
*/

$this->title = [
    'page_title' => 'RDR - DPR Waiting Approval (Purchasing) <span class="japanesse light-green"></span>',
    'tab_title' => 'RDR - DPR Waiting Approval (Purchasing)',
    'breadcrumbs_title' => 'RDR - DPR Waiting Approval (Purchasing)'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');

$script = "
    $('document').ready(function() {
        $('.btn-approve').click(function(){
        	$('#overlay').show();
    	});
    });
";
$this->registerJs($script, View::POS_HEAD );

$gridColumns = [
	[
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{approve}',
        'buttons' => [
            'approve' => function($url, $model, $key){
                $options = [
                    'data-pjax' => '0',
                    'id' => 'btn-report',
                    'value' => Url::to(['pch-approve','material_document_number' => $model->material_document_number]),
                    'title' => 'Purchasing Approve',
                    'class' => 'showModalButton btn btn-success btn-sm'
                ];
                return Html::a('Approve', '#', $options);
            },
        ],
    ],
    [
        'attribute' => 'material_document_number',
        'label' => 'Document No.',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'period',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'rcv_date',
        'value' => function($model){
        	if ($model->rcv_date != null) {
        		return date('Y-m-d', strtotime($model->rcv_date));
        	} else {
        		return '-';
        	}
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'material',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'description',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'vendor_code',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'vendor_name',
        'vAlign' => 'middle',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'do_inv_qty',
        'format' => ['decimal', 0],
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'act_rcv_qty',
        'format' => ['decimal', 0],
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'discrepancy_qty',
        'format' => ['decimal', 0],
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'category',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'normal_urgent',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
];

?>
<div class="giiant-crud skill-master-karyawan-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

	    <div class="box box-primary">
	    	<div class="box-body no-padding">
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
		                //'heading' => 'Last Update : ' . date('Y-m-d H:i:s')
		                //'footer' => false,
		            ],
		        ]); ?>
		    </div>
		    <div class="overlay" id="overlay" style="display: none;">
              	<i class="fa fa-refresh fa-spin"></i>
            </div>
	    </div>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


