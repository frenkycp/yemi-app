<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var app\models\MesinCheckResult $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('models', 'Mesin Check Result');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Mesin Check Results'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->urutan, 'url' => ['view', 'urutan' => $model->urutan]];
$this->params['breadcrumbs'][] = 'View';
?>
<div class="giiant-crud mesin-check-result-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('models', 'Mesin Check Result') ?>
        <small>
            <?= $model->urutan ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?= Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . 'Edit',
            [ 'update', 'urutan' => $model->urutan],
            ['class' => 'btn btn-info']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . 'Copy',
            ['create', 'urutan' => $model->urutan, 'MesinCheckResult'=>$copyParams],
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

    <?php $this->beginBlock('app\models\MesinCheckResult'); ?>

    
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            'location',
        'area',
        'mesin_id',
        'mesin_nama',
        'mesin_no',
        'mesin_bagian',
        'mesin_bagian_ket',
        'mesin_status',
        'mesin_catatan',
        'mesin_periode',
        'user_id',
        'user_desc',
        'mesin_last_update',
        'hasil_ok',
        'hasil_ng',
        'total_cek',
    ],
    ]); ?>

    
    <hr/>

    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . 'Delete', ['delete', 'urutan' => $model->urutan],
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
    'label'   => '<b class=""># '.$model->urutan.'</b>',
    'content' => $this->blocks['app\models\MesinCheckResult'],
    'active'  => true,
],
 ]
                 ]
    );
    ?>
</div>
