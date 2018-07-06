<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

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
    $actionColumnTemplateString = "{view} {update} {delete}";
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';
?>
<div class="giiant-crud visual-picking-list-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <h1>
        <?= Yii::t('models', 'Visual Picking Lists') ?>
        <small>
            List
        </small>
    </h1>
    <div class="clearfix crud-navigation">
        <div class="pull-left">
            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']) ?>
        </div>

        <div class="pull-right">

                        
            <?= 
            \yii\bootstrap\ButtonDropdown::widget(
            [
            'id' => 'giiant-relations',
            'encodeLabel' => false,
            'label' => '<span class="glyphicon glyphicon-paperclip"></span> ' . 'Relations',
            'dropdown' => [
            'options' => [
            'class' => 'dropdown-menu-right'
            ],
            'encodeLabels' => false,
            'items' => [

]
            ],
            'options' => [
            'class' => 'btn-default'
            ]
            ]
            );
            ?>
        </div>
    </div>

    <hr />

    <div class="table-responsive">
        <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'pager' => [
        'class' => yii\widgets\LinkPager::className(),
        'firstPageLabel' => 'First',
        'lastPageLabel' => 'Last',
        ],
                    'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
        'headerRowOptions' => ['class'=>'x'],
        'columns' => [
                [
            'class' => 'yii\grid\ActionColumn',
            'template' => $actionColumnTemplateString,
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
			'set_list_no',
			'parent',
			'parent_desc',
			'parent_um',
			'analyst',
			'analyst_desc',
			'create_user_id',
			/*'create_user_desc',*/
			/*'confirm_user_id',*/
			/*'confirm_user_desc',*/
			/*'start_user_id',*/
			/*'start_user_desc',*/
			/*'completed_user_id',*/
			/*'completed_user_desc',*/
			/*'hand_over_user_id',*/
			/*'hand_over_user_desc',*/
			/*'stage_desc',*/
			/*'condition_desc',*/
			/*'stat',*/
			/*'catatan',*/
			/*'pts_stat',*/
			/*'set_list_type',*/
			/*'id_01',*/
			/*'id_01_desc',*/
			/*'id_02',*/
			/*'id_02_desc',*/
			/*'id_03',*/
			/*'id_03_desc',*/
			/*'id_04',*/
			/*'id_04_desc',*/
			/*'id_05',*/
			/*'id_05_desc',*/
			/*'id_06',*/
			/*'id_06_desc',*/
			/*'id_07',*/
			/*'id_07_desc',*/
			/*'id_08',*/
			/*'id_08_desc',*/
			/*'id_09',*/
			/*'id_09_desc',*/
			/*'id_10',*/
			/*'id_10_desc',*/
			/*'id_update',*/
			/*'id_update_desc',*/
			/*'sudah_cetak',*/
			/*'id_prioty',*/
			/*'id_prioty_desc',*/
			/*'id_hc',*/
			/*'id_hc_desc',*/
			/*'id_hc_stat',*/
			/*'id_hc_open',*/
			/*'id_hc_open_desc',*/
			/*'id_hc_open_stat',*/
			/*'pts_note',*/
			/*'show',*/
			/*'back_up_period',*/
			/*'back_up',*/
			/*'req_date',*/
			/*'req_date_original',*/
			/*'create_date',*/
			/*'confirm_date',*/
			/*'start_date',*/
			/*'completed_date',*/
			/*'hand_over_date',*/
			/*'id_update_date',*/
			/*'id_prioty_date',*/
			/*'id_hc_date',*/
			/*'id_hc_open_date',*/
			/*'closing_date',*/
			/*'plan_qty',*/
			/*'progress_pct',*/
			/*'pick_lt',*/
			/*'part_count',*/
			/*'part_count_fix',*/
			/*'man_power',*/
			/*'priority',*/
			/*'stage_id',*/
			/*'pts_part',*/
			/*'delay_days',*/
			/*'slip_count',*/
			/*'slip_open',*/
			/*'slip_close',*/
        ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


