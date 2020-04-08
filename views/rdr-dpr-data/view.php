<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var app\models\RdrDprData $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('models', 'Rdr Dpr Data');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Rdr Dpr Datas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->material_document_number, 'url' => ['view', 'material_document_number' => $model->material_document_number]];
$this->params['breadcrumbs'][] = 'View';
?>
<div class="giiant-crud rdr-dpr-data-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('models', 'Rdr Dpr Data') ?>
        <small>
            <?= Html::encode($model->material_document_number) ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?= Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . 'Edit',
            [ 'update', 'material_document_number' => $model->material_document_number],
            ['class' => 'btn btn-info']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . 'Copy',
            ['create', 'material_document_number' => $model->material_document_number, 'RdrDprData'=>$copyParams],
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

    <?php $this->beginBlock('app\models\RdrDprData'); ?>

    
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            'material_document_number',
        'rcv_date',
        'user_issue_date',
        'purc_approve_date',
        'user_close_date',
        'do_inv_qty',
        'act_rcv_qty',
        'discrepancy_qty',
        'standard_price',
        'standard_amount',
        'purc_approve_remark',
        'material_document_number_barcode',
        'pic',
        'division',
        'NOTE',
        'user_desc',
        'korlap_desc',
        'korlap_confirm_date',
        'purc_approve_desc',
        'user_close_desc',
        'period',
        'vendor_code',
        'material',
        'vendor_name',
        'inv_no',
        'description',
        'rdr_dpr',
        'category',
        'normal_urgent',
        'um',
        'user_id',
        'korlap',
        'purc_approve',
        'user_close',
        'discrepancy_treatment',
        'payment_treatment',
        'close_open',
    ],
    ]); ?>

    
    <hr/>

    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . 'Delete', ['delete', 'material_document_number' => $model->material_document_number],
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
    'label'   => '<b class=""># '.Html::encode($model->material_document_number).'</b>',
    'content' => $this->blocks['app\models\RdrDprData'],
    'active'  => true,
],
 ]
                 ]
    );
    ?>
</div>
