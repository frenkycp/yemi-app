<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var app\models\JobOrder $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('app', 'Job Order');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Job Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->JOB_ORDER_NO, 'url' => ['view', 'JOB_ORDER_NO' => $model->JOB_ORDER_NO]];
$this->params['breadcrumbs'][] = 'View';
?>
<div class="giiant-crud job-order-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('app', 'Job Order') ?>
        <small>
            <?= $model->JOB_ORDER_NO ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?= Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . 'Edit',
            [ 'update', 'JOB_ORDER_NO' => $model->JOB_ORDER_NO],
            ['class' => 'btn btn-info']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . 'Copy',
            ['create', 'JOB_ORDER_NO' => $model->JOB_ORDER_NO, 'JobOrder'=>$copyParams],
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

    <hr />

    <?php $this->beginBlock('app\models\JobOrder'); ?>

    
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            'JOB_ORDER_NO',
        'JOB_ORDER_BARCODE',
        'LOC',
        'LOC_DESC',
        'LINE',
        'NIK',
        'NAMA_KARYAWAN',
        'SMT_SHIFT',
        'KELOMPOK',
        'ITEM',
        'ITEM_DESC',
        'UM',
        'MODEL',
        'DESTINATION',
        'USER_ID',
        'USER_DESC',
        'STAGE',
        'STATUS',
        'JOB_ORDER_LOT_NO',
        'USER_ID_START',
        'USER_DESC_START',
        'USER_ID_PAUSE',
        'USER_DESC_PAUSE',
        'USER_ID_CONTINUED',
        'USER_DESC_CONTINUED',
        'USER_ID_ENDED',
        'USER_DESC_ENDED',
        'NOTE',
        'NOTE2',
        'CONFORWARD',
        'CONFORWARD_PRINT',
        'SCH_DATE',
        'START_DATE',
        'PAUSE_DATE',
        'CONTINUED_DATE',
        'END_DATE',
        'LAST_UPDATE',
        'MAN_POWER',
        'LOT_QTY',
        'ORDER_QTY',
        'COMMIT_QTY',
        'OPEN_QTY',
        'STD_TIME_VAR',
        'STD_TIME',
        'INSERT_POINT_VAR',
        'INSERT_POINT',
        'LOST_TIME',
        'DANDORI',
    ],
    ]); ?>

    
    <hr/>

    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . 'Delete', ['delete', 'JOB_ORDER_NO' => $model->JOB_ORDER_NO],
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
    'label'   => '<b class=""># '.$model->JOB_ORDER_NO.'</b>',
    'content' => $this->blocks['app\models\JobOrder'],
    'active'  => true,
],
 ]
                 ]
    );
    ?>
</div>
