<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var app\models\VisualPickingList $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('models', 'Visual Picking List');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Visual Picking Lists'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->seq_no, 'url' => ['view', 'seq_no' => $model->seq_no]];
$this->params['breadcrumbs'][] = 'View';
?>
<div class="giiant-crud visual-picking-list-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('models', 'Visual Picking List') ?>
        <small>
            <?= $model->seq_no ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?= Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . 'Edit',
            [ 'update', 'seq_no' => $model->seq_no],
            ['class' => 'btn btn-info']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . 'Copy',
            ['create', 'seq_no' => $model->seq_no, 'VisualPickingList'=>$copyParams],
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

    <?php $this->beginBlock('app\models\VisualPickingList'); ?>

    
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            'set_list_no',
        'parent',
        'parent_desc',
        'parent_um',
        'analyst',
        'analyst_desc',
        'create_user_id',
        'create_user_desc',
        'confirm_user_id',
        'confirm_user_desc',
        'start_user_id',
        'start_user_desc',
        'completed_user_id',
        'completed_user_desc',
        'hand_over_user_id',
        'hand_over_user_desc',
        'stage_desc',
        'condition_desc',
        'stat',
        'catatan',
        'pts_stat',
        'set_list_type',
        'id_01',
        'id_01_desc',
        'id_02',
        'id_02_desc',
        'id_03',
        'id_03_desc',
        'id_04',
        'id_04_desc',
        'id_05',
        'id_05_desc',
        'id_06',
        'id_06_desc',
        'id_07',
        'id_07_desc',
        'id_08',
        'id_08_desc',
        'id_09',
        'id_09_desc',
        'id_10',
        'id_10_desc',
        'id_update',
        'id_update_desc',
        'sudah_cetak',
        'id_prioty',
        'id_prioty_desc',
        'id_hc',
        'id_hc_desc',
        'id_hc_stat',
        'id_hc_open',
        'id_hc_open_desc',
        'id_hc_open_stat',
        'pts_note',
        'show',
        'back_up_period',
        'back_up',
        'req_date',
        'req_date_original',
        'create_date',
        'confirm_date',
        'start_date',
        'completed_date',
        'hand_over_date',
        'id_update_date',
        'id_prioty_date',
        'id_hc_date',
        'id_hc_open_date',
        'closing_date',
        'plan_qty',
        'progress_pct',
        'pick_lt',
        'part_count',
        'part_count_fix',
        'man_power',
        'priority',
        'stage_id',
        'pts_part',
        'delay_days',
        'slip_count',
        'slip_open',
        'slip_close',
    ],
    ]); ?>

    
    <hr/>

    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . 'Delete', ['delete', 'seq_no' => $model->seq_no],
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
    'label'   => '<b class=""># '.$model->seq_no.'</b>',
    'content' => $this->blocks['app\models\VisualPickingList'],
    'active'  => true,
],
 ]
                 ]
    );
    ?>
</div>
