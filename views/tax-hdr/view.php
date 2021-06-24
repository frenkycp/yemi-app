<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var app\models\TaxHdr $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('models', 'Tax Hdr');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models.plural', 'Tax Hdr'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->no_seri, 'url' => ['view', 'no_seri' => $model->no_seri]];
$this->params['breadcrumbs'][] = 'View';
?>
<div class="giiant-crud tax-hdr-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Html::encode($model->no_seri) ?>
        <small>
            <?= Yii::t('models', 'Tax Hdr') ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?php 
 echo Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . 'Edit',
            [ 'update', 'no_seri' => $model->no_seri],
            ['class' => 'btn btn-info'])
          ?>

            <?php 
 echo Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . 'Copy',
            ['create', 'no_seri' => $model->no_seri, 'TaxHdr'=>$copyParams],
            ['class' => 'btn btn-success'])
          ?>

            <?php 
 echo Html::a(
            '<span class="glyphicon glyphicon-plus"></span> ' . 'New',
            ['create'],
            ['class' => 'btn btn-success'])
          ?>
        </div>

        <div class="pull-right">
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> '
            . 'Full list', ['index'], ['class'=>'btn btn-default']) ?>
        </div>

    </div>

    <hr/>

    <?php $this->beginBlock('app\models\TaxHdr'); ?>

    
    <?php 
 echo DetailView::widget([
    'model' => $model,
    'attributes' => [
            'no_seri',
        'tanggalFaktur',
        'last_updated',
        'jumlahDpp',
        'jumlahPpn',
        'jumlahPpnBm',
        'no_seri_val',
        'kdJenisTransaksi',
        'fgPengganti',
        'nomorFaktur',
        'npwpPenjual',
        'namaPenjual',
        'alamatPenjual',
        'npwpLawanTransaksi',
        'namaLawanTransaksi',
        'alamatLawanTransaksi',
        'statusApproval',
        'statusFaktur',
        'referensi',
        'period',
        'status_upload',
    ],
    ]);
  ?>

    
    <hr/>

    <?php 
 echo Html::a('<span class="glyphicon glyphicon-trash"></span> ' . 'Delete', ['delete', 'no_seri' => $model->no_seri],
    [
    'class' => 'btn btn-danger',
    'data-confirm' => '' . 'Are you sure to delete this item?' . '',
    'data-method' => 'post',
    ]);
  ?>
    <?php $this->endBlock(); ?>


    
    <?php 
        echo Tabs::widget(
                 [
                     'id' => 'relation-tabs',
                     'encodeLabels' => false,
                     'items' => [
 [
    'label'   => '<b class=""># '.Html::encode($model->no_seri).'</b>',
    'content' => $this->blocks['app\models\TaxHdr'],
    'active'  => true,
],
 ]
                 ]
    );
    ?>
</div>
