<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\VisualPickingListSearch $searchModel
*/

$this->title = Yii::t('models', 'Visual Picking Lists');
$this->params['breadcrumbs'][] = $this->title;

if (isset($actionColumnTemplates)) {
$actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']);
	if (Yii::$app->user->identity->role->id == 1) {
		$actionColumnTemplateString = "{view} {update} {delete}";
	} else {
		$actionColumnTemplateString = "{delete}";
	}
    
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';

$gridColumns = [
	[
        'class' => 'kartik\grid\ActionColumn',
        'template' => $actionColumnTemplateString,
        'buttons' => [
            'view' => function ($url, $model, $key) {
                $options = [
                    'title' => Yii::t('cruds', 'View'),
                    'aria-label' => Yii::t('cruds', 'View'),
                    'data-pjax' => '0',
                ];
                return Html::a('<span class="glyphicon glyphicon-file"></span>', $url, $options);
            },
            'delete' => function ($url, $model, $key) {
                $options = [
                    'title' => Yii::t('cruds', 'Delete'),
                    'aria-label' => Yii::t('cruds', 'Delete'),
                    'data-pjax' => '0',
                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                ];
                return $model->stage_desc == 'DRAFT' ? Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options) : '';
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
        'attribute' => 'set_list_no',
        'label' => 'Setlist No',
        'vAlign' => 'middle',
        'hAlign' => 'center'
    ],
    [
        'attribute' => 'parent',
        'label' => 'Parent',
        'vAlign' => 'middle',
        'hAlign' => 'center'
    ],
    [
        'attribute' => 'parent_desc',
        'label' => 'Parent Desc',
        'vAlign' => 'middle',
        //'hAlign' => 'center'
    ],
    [
        'attribute' => 'analyst_desc',
        'label' => 'Location',
        'vAlign' => 'middle',
        'hAlign' => 'center'
    ],
    [
        'attribute' => 'req_date',
        'value' => function($model){
        	return $model->req_date == null ? '-' : date('Y-m-d', strtotime($model->req_date));
        },
        'label' => 'Req. Date',
        'vAlign' => 'middle',
        'hAlign' => 'center'
    ],
    [
        'attribute' => 'plan_qty',
        'encodeLabel' => false,
        'label' => 'Plan<br/>qty',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '70px'
    ],
    [
        'attribute' => 'part_count',
        'encodeLabel' => false,
        'label' => 'Part<br/>Count',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '70px'
    ],
    [
        'attribute' => 'man_power',
        'encodeLabel' => false,
        'label' => 'Man<br/>Power',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'width' => '70px'
    ],
    [
        'attribute' => 'start_date',
        'value' => function($model){
        	return $model->start_date == null ? '-' : date('Y-m-d', strtotime($model->start_date));
        },
        'vAlign' => 'middle',
        'hAlign' => 'center'
    ],
    [
        'attribute' => 'completed_date',
        'encodeLabel' => false,
        'label' => 'Completed<br/>Date',
        'value' => function($model){
        	return $model->completed_date == null ? '-' : date('Y-m-d', strtotime($model->completed_date));
        },
        'vAlign' => 'middle',
        'hAlign' => 'center'
    ],
    [
        'attribute' => 'stage_desc',
        'label' => 'Confirm',
        'vAlign' => 'middle',
        'contentOptions' => [
        	'style' => 'min-width: 150px;'
        ],
        'hAlign' => 'center',
        'filter' => ArrayHelper::map(app\models\VisualPickingList::find()->select('distinct(stage_desc)')->all(), 'stage_desc', 'stage_desc')
    ],
    [
        'attribute' => 'pts_note',
        'vAlign' => 'middle',
        'hAlign' => 'center'
    ],
];
?>
<div class="giiant-crud visual-picking-list-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $gridColumns,
            'hover' => true,
            //'condensed' => true,
            'striped' => true,
            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'pjax' => true, // pjax is set to always true for this demo
            'toolbar' =>  [
                /*['content' => 
                    Html::a('View Chart', $main_link, ['data-pjax' => 0, 'class' => 'btn btn-warning', 'title' => Yii::t('kvgrid', 'Show View Chart')])
                ],*/
                '{export}',
                '{toggleData}',
            ],
            // set export properties
            'export' => [
                'fontAwesome' => true
            ],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => $heading
            ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


