<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var app\models\Karyawan $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('models', 'Karyawan');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Karyawans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->NIK, 'url' => ['view', 'NIK' => $model->NIK]];
$this->params['breadcrumbs'][] = 'View';
?>
<div class="giiant-crud karyawan-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('models', 'Karyawan') ?>
        <small>
            <?= Html::encode($model->NIK) ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?= Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . 'Edit',
            [ 'update', 'NIK' => $model->NIK],
            ['class' => 'btn btn-info']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . 'Copy',
            ['create', 'NIK' => $model->NIK, 'Karyawan'=>$copyParams],
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

    <?php $this->beginBlock('app\models\Karyawan'); ?>

    
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            'NIK',
        'NAMA_KARYAWAN',
        'JENIS_KELAMIN',
        'STATUS_PERKAWINAN',
        'ALAMAT',
        'ALAMAT_SEMENTARA',
        'TELP',
        'NPWP',
        'KTP',
        'BPJS_KESEHATAN',
        'BPJS_KETENAGAKERJAAN',
        'STATUS_KARYAWAN',
        'CC_ID',
        'DEPARTEMEN',
        'SECTION',
        'SUB_SECTION',
        'JABATAN_SR',
        'JABATAN_SR_GROUP',
        'GRADE',
        'DIRECT_INDIRECT',
        'JENIS_PEKERJAAN',
        'SERIKAT_PEKERJA',
        'ACTIVE_STAT',
        'PASSWORD',
        'TGL_LAHIR',
        'TGL_MASUK_YEMI',
        'K1_START',
        'K1_END',
        'K2_START',
        'K2_END',
        'SKILL',
        'KONTRAK_KE',
    ],
    ]); ?>

    
    <hr/>

    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . 'Delete', ['delete', 'NIK' => $model->NIK],
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
    'label'   => '<b class=""># '.Html::encode($model->NIK).'</b>',
    'content' => $this->blocks['app\models\Karyawan'],
    'active'  => true,
],
 ]
                 ]
    );
    ?>
</div>
