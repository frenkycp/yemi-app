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
    'page_title' => null,
    'tab_title' => 'RDR - DPR Waiting Approval (KORLAP)',
    'breadcrumbs_title' => 'RDR - DPR Waiting Approval (KORLAP)'
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
        'template' => '{approve} {pch_approve} {close}',
        'buttons' => [
            'approve' => function ($url, $model, $key) {
                $options = [
                    'title' => Yii::t('cruds', 'Approve'),
                    'data-pjax' => '0',
                    'class' => 'btn btn-info btn-xs btn-approve btn-block'
                ];
                if ($model->korlap != null) {
                    return '<button class="btn btn-xs btn-info btn-block disabled" title="Aprroved...">KORLAP APPROVE</button>';
                }
                return Html::a('KORLAP APPROVE', Url::to(['korlap-approve', 'material_document_number' => $model->material_document_number]), $options);
            },
            'pch_approve' => function($url, $model, $key){
                $options = [
                    'data-pjax' => '0',
                    'id' => 'btn-report',
                    'value' => Url::to(['pch-approve','material_document_number' => $model->material_document_number]),
                    'title' => 'Purchasing Approve',
                    'class' => 'showModalButton btn btn-primary btn-xs btn-block'
                ];
                if ($model->purc_approve != null) {
                    return '<button class="btn btn-xs btn-primary btn-block disabled" title="Aprroved...">PURCH. APPROVE</button>';
                }
                if ($model->korlap == null) {
                    return '<button class="btn btn-xs btn-primary btn-block disabled" title="Waiting Korlap Approval...">PURCH. APPROVE</button>';
                }
                return Html::a('PURCH. APPROVE', '#', $options);
            },
            'close' => function ($url, $model, $key) {
                $options = [
                    'title' => Yii::t('cruds', 'Close'),
                    'data-pjax' => '0',
                    'data-confirm' => 'Are you sure to close this report ?',
                    'class' => 'btn btn-success btn-xs btn-block'
                ];
                if ($model->close_open  == 'C') {
                    return '<button class="btn btn-xs btn-success btn-block disabled" title="CLOSED...">CLOSE</button>';
                }
                return Html::a('CLOSE', Url::to(['close', 'material_document_number' => $model->material_document_number]), $options);
            },
        ],
        'urlCreator' => function($action, $model, $key, $index) {
            // using the column name as key, not mapping to 'id' like the standard generator
            $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
            $params[0] = \Yii::$app->controller->id ? \Yii::$app->controller->id . '/' . $action : $action;
            return Url::toRoute($params);
        },
        'contentOptions' => ['nowrap'=>'nowrap'],
        'vAlign' => 'middle',
        'width' => '60px',
        //'hidden' => in_array(Yii::$app->user->identity->username, ['admin', 'prd']) ? false : true,
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
        'attribute' => 'material_document_number',
        'label' => 'Doc. No.',
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
    [
        'attribute' => 'user_issue_date',
        'label' => 'Issue Date',
        'value' => function($model){
            return date('Y-m-d H:i:s', strtotime($model->user_issue_date));
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'user_id',
        'label' => 'Issued By (NIK)',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'filterInputOptions' => [
            'class' => 'form-control',
            'style' => 'text-align: center; font-size: 12px;'
        ],
    ],
    [
        'attribute' => 'user_desc',
        'label' => 'Issued By (Name)',
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
        echo $this->render('approval_data_search', ['model' =>$searchModel]);
    ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

	    <div class="box box-primary">
	    	<div class="box-body no-padding">
		        <?= GridView::widget([
		            'dataProvider' => $dataProvider,
		            //'filterModel' => $searchModel,
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


