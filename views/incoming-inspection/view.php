<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var app\models\SapPoRcv $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('models', 'Sap Po Rcv');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Sap Po Rcvs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->material_document_number, 'url' => ['view', 'material_document_number' => $model->material_document_number]];
$this->params['breadcrumbs'][] = 'View';
?>
<div class="giiant-crud sap-po-rcv-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('models', 'Sap Po Rcv') ?>
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
            ['create', 'material_document_number' => $model->material_document_number, 'SapPoRcv'=>$copyParams],
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

    <?php $this->beginBlock('app\models\SapPoRcv'); ?>

    
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            'local_import',
        'currency',
        'abc_indicator',
        'vendor_code',
        'vendor_name',
        'payment_terms',
        'freight_cond_type',
        'insurance_cond_type',
        'internal_exp_cond_type',
        'no',
        'material_document_number',
        'item_no',
        'inv_no',
        'po_id',
        'slip_no',
        'acct_assig_cat',
        'material',
        'description',
        'um',
        'pur_um',
        'direct_indirect',
        'nat_acc',
        'nat_acc_desc',
        'cost_center',
        'cost_center_desc',
        'purchasing_group',
        'vendor_country_code',
        'storage_location_po',
        'movement_type',
        'lt_po',
        'grt_po',
        'stock_type_po',
        'delivery_completed',
        'cust_doc_date',
        'doc_type',
        'cust_doc_no',
        'po_no',
        'po_line',
        'upload',
        'period',
        'fix_add',
        'voucher_no',
        'invoice_act',
        'kwitansi_act',
        'status',
        'bc_type',
        'bc_no',
        'sign',
        'asano_doc',
        'asano_invoice',
        'pic',
        'division',
        'sinkron',
        'Inspection_level',
        'Judgement',
        'Remark',
        'rate',
        'freight',
        'insurance',
        'internal_exp',
        'quantity',
        'quantity_pur_unit',
        'unit_price',
        'amount_rcv',
        'amount_ppn',
        'amount_wh',
        'amount_usd',
        'amount_freight',
        'amount_insurance',
        'amount_internal_exp',
        'amount_total_charges',
        'amount_total',
        'std_price',
        'std_amount',
        'order_quantity',
        'relied_delivery_qty',
        'price_act',
        'amount_act',
        'variance_act',
        'rcv_date',
        'order_date',
        'order_delivery_date',
        'relied_delivery_date',
        'bc_date',
        'upload_date',
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
    'content' => $this->blocks['app\models\SapPoRcv'],
    'active'  => true,
],
 ]
                 ]
    );
    ?>
</div>
