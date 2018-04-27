<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var app\models\TpPartList $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('app', 'Tp Part List');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tp Part Lists'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->tp_part_list_id, 'url' => ['view', 'tp_part_list_id' => $model->tp_part_list_id]];
$this->params['breadcrumbs'][] = 'View';
?>
<div class="giiant-crud tp-part-list-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('app', 'Tp Part List') ?>
        <small>
            <?= $model->tp_part_list_id ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?= Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . 'Edit',
            [ 'update', 'tp_part_list_id' => $model->tp_part_list_id],
            ['class' => 'btn btn-info']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . 'Copy',
            ['create', 'tp_part_list_id' => $model->tp_part_list_id, 'TpPartList'=>$copyParams],
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

    <?php $this->beginBlock('app\models\TpPartList'); ?>

    
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            'rev_no',
        'total_product',
        'total_assy',
        'total_spare_part',
        'total_requirement',
        'present_qty',
        'qty',
        'transportation_cost',
        'present_due_date',
        'last_modified',
        'speaker_model',
        'present_po',
        'dcn_no',
        'direct_po_trf',
        'delivery_conf_etd',
        'delivery_conf_eta',
        'act_delivery_etd',
        'act_delivery_eta',
        'transport_by',
        'part_no',
        'part_type',
        'part_status',
        'caf_no',
        'purch_status',
        'pc_status',
        'pe_confirm',
        'status',
        'qa_judgement',
        'qa_remark',
        'part_name',
        'pc_remarks',
        'invoice',
        'last_modified_by',
    ],
    ]); ?>

    
    <hr/>

    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . 'Delete', ['delete', 'tp_part_list_id' => $model->tp_part_list_id],
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
    'label'   => '<b class=""># '.$model->tp_part_list_id.'</b>',
    'content' => $this->blocks['app\models\TpPartList'],
    'active'  => true,
],
 ]
                 ]
    );
    ?>
</div>
