<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var app\models\SplHdr $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('models', 'Spl Hdr');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Spl Hdrs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->SPL_HDR_ID, 'url' => ['view', 'SPL_HDR_ID' => $model->SPL_HDR_ID]];
$this->params['breadcrumbs'][] = 'View';
?>
<div class="giiant-crud spl-hdr-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('models', 'Spl Hdr') ?>
        <small>
            <?= $model->SPL_HDR_ID ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?= Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . 'Edit',
            [ 'update', 'SPL_HDR_ID' => $model->SPL_HDR_ID],
            ['class' => 'btn btn-info']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . 'Copy',
            ['create', 'SPL_HDR_ID' => $model->SPL_HDR_ID, 'SplHdr'=>$copyParams],
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

    <?php $this->beginBlock('app\models\SplHdr'); ?>

    
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            'SPL_HDR_ID',
        'SPL_BARCODE',
        'TGL_LEMBUR',
        'JENIS_LEMBUR',
        'CC_ID',
        'CC_GROUP',
        'CC_DESC',
        'USER_ID',
        'USER_DESC',
        'USER_DOC_RCV',
        'USER_DESC_DOC_RCV',
        'URAIAN_UMUM',
        'STAT',
        'USER_LAST_UPDATE',
        'DOC_RCV_DATE',
        'DOC_VALIDATION_DATE',
    ],
    ]); ?>

    
    <hr/>

    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . 'Delete', ['delete', 'SPL_HDR_ID' => $model->SPL_HDR_ID],
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
    'label'   => '<b class=""># '.$model->SPL_HDR_ID.'</b>',
    'content' => $this->blocks['app\models\SplHdr'],
    'active'  => true,
],
 ]
                 ]
    );
    ?>
</div>
