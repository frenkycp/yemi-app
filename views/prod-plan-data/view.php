<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var app\models\WipEffTbl $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('models', 'Wip Eff Tbl');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Wip Eff Tbls'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->lot_id, 'url' => ['view', 'lot_id' => $model->lot_id]];
$this->params['breadcrumbs'][] = 'View';
?>
<div class="giiant-crud wip-eff-tbl-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('models', 'Wip Eff Tbl') ?>
        <small>
            <?= Html::encode($model->lot_id) ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?= Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . 'Edit',
            [ 'update', 'lot_id' => $model->lot_id],
            ['class' => 'btn btn-info']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . 'Copy',
            ['create', 'lot_id' => $model->lot_id, 'WipEffTbl'=>$copyParams],
            ['class' => 'btn btn-success']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-plus"></span> ' . 'New',
            ['create'],
            ['class' => 'btn btn-success']) ?>
        </div>

        <div class="pull-right">
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> '
            . 'Full list', ['index'], ['class'=>'btn btn-default']) ?>
        </div>

    </div>

    <hr/>

    <?php $this->beginBlock('app\models\WipEffTbl'); ?>

    
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            'lot_id',
        'child_analyst',
        'child_analyst_desc',
        'LINE',
        'SMT_SHIFT',
        'KELOMPOK',
        'slip_id_01',
        'child_01',
        'child_desc_01',
        'slip_id_02',
        'child_02',
        'child_desc_02',
        'slip_id_03',
        'child_03',
        'child_desc_03',
        'slip_id_04',
        'child_04',
        'child_desc_04',
        'slip_id_05',
        'child_05',
        'child_desc_05',
        'slip_id_06',
        'child_06',
        'child_desc_06',
        'slip_id_07',
        'child_07',
        'child_desc_07',
        'slip_id_08',
        'child_08',
        'child_desc_08',
        'slip_id_09',
        'child_09',
        'child_desc_09',
        'slip_id_10',
        'child_10',
        'child_desc_10',
        'child_all',
        'child_desc_all',
        'period',
        'USER_ID',
        'USER_DESC',
        'note01',
        'note02',
        'note03',
        'note04',
        'note05',
        'note06',
        'note07',
        'note08',
        'note09',
        'note10',
        'note11',
        'note12',
        'note13',
        'note14',
        'note15',
        'note16',
        'note17',
        'note18',
        'period_original',
        'plan_item',
        'plan_stats',
        'plan_run',
        'act_qty_01',
        'std_time_01',
        'act_qty_02',
        'std_time_02',
        'act_qty_03',
        'std_time_03',
        'act_qty_04',
        'std_time_04',
        'act_qty_05',
        'std_time_05',
        'act_qty_06',
        'std_time_06',
        'act_qty_07',
        'std_time_07',
        'act_qty_08',
        'std_time_08',
        'act_qty_09',
        'std_time_09',
        'act_qty_10',
        'std_time_10',
        'qty_all',
        'std_all',
        'lt_gross',
        'lt_loss',
        'lt_nett',
        'lt_std',
        'efisiensi_gross',
        'efisiensi',
        'long01',
        'long02',
        'long03',
        'long04',
        'long05',
        'long06',
        'long07',
        'long08',
        'long09',
        'long10',
        'long11',
        'long12',
        'long13',
        'long14',
        'long15',
        'long16',
        'long17',
        'long18',
        'long_total',
        'break_time',
        'nozzle_maintenance',
        'change_schedule',
        'air_pressure_problem',
        'power_failure',
        'part_shortage',
        'set_up_1st_time_running_tp',
        'part_arrangement_dcn',
        'meeting',
        'dandori',
        'porgram_error',
        'm_c_problem',
        'feeder_problem',
        'quality_problem',
        'pcb_transfer_problem',
        'profile_problem',
        'pick_up_error',
        'other',
        'plan_qty',
        'plan_balance',
        'slip_count',
        'start_date',
        'end_date',
        'post_date',
        'LAST_UPDATE',
        'post_date_original',
        'plan_date',
    ],
    ]); ?>

    
    <hr/>

    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . 'Delete', ['delete', 'lot_id' => $model->lot_id],
    [
    'class' => 'btn btn-danger',
    'data-confirm' => '' . 'Are you sure to delete this item?' . '',
    'data-method' => 'post',
    ]); ?>
    <?php $this->endBlock(); ?>


    
    <?= Tabs::widget(
                 [
                     'id' => 'relation-tabs',
                     'encodeLabels' => false,
                     'items' => [
 [
    'label'   => '<b class=""># '.Html::encode($model->lot_id).'</b>',
    'content' => $this->blocks['app\models\WipEffTbl'],
    'active'  => true,
],
 ]
                 ]
    );
    ?>
</div>
