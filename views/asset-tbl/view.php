<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var app\models\AssetTbl $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('models', 'Asset Tbl');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Asset Tbls'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->asset_id, 'url' => ['view', 'asset_id' => $model->asset_id]];
$this->params['breadcrumbs'][] = 'View';
?>
<div class="giiant-crud asset-tbl-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('models', 'Asset Tbl') ?>
        <small>
            <?= Html::encode($model->asset_id) ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?= Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . 'Edit',
            [ 'update', 'asset_id' => $model->asset_id],
            ['class' => 'btn btn-info']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . 'Copy',
            ['create', 'asset_id' => $model->asset_id, 'AssetTbl'=>$copyParams],
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

    <?php $this->beginBlock('app\models\AssetTbl'); ?>

    
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            'asset_id',
        'qr',
        'ip_address',
        'computer_name',
        'jenis',
        'manufacture',
        'manufacture_desc',
        'cpu_desc',
        'ram_desc',
        'rom_desc',
        'os_desc',
        'nik',
        'NAMA_KARYAWAN',
        'fixed_asst_account',
        'network',
        'display',
        'camera',
        'battery',
        'note',
        'location',
        'area',
        'department_pic',
        'purchase_date',
        'LAST_UPDATE',
        'report_type',
    ],
    ]); ?>

    
    <hr/>

    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . 'Delete', ['delete', 'asset_id' => $model->asset_id],
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
    'label'   => '<b class=""># '.Html::encode($model->asset_id).'</b>',
    'content' => $this->blocks['app\models\AssetTbl'],
    'active'  => true,
],
 ]
                 ]
    );
    ?>
</div>
