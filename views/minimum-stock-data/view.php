<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var app\models\MinimumStock $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('models', 'Minimum Stock');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Minimum Stocks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->ID_ITEM_LOC, 'url' => ['view', 'ID_ITEM_LOC' => $model->ID_ITEM_LOC]];
$this->params['breadcrumbs'][] = 'View';
?>
<div class="giiant-crud minimum-stock-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('models', 'Minimum Stock') ?>
        <small>
            <?= Html::encode($model->ID_ITEM_LOC) ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?= Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . 'Edit',
            [ 'update', 'ID_ITEM_LOC' => $model->ID_ITEM_LOC],
            ['class' => 'btn btn-info']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . 'Copy',
            ['create', 'ID_ITEM_LOC' => $model->ID_ITEM_LOC, 'MinimumStock'=>$copyParams],
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

    <?php $this->beginBlock('app\models\MinimumStock'); ?>

    
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            'ID_ITEM_LOC',
        'LOC',
        'ITEM',
        'ITEM_EQ_DESC_01',
        'ITEM_EQ_UM',
        'LOC_DESC',
        'PIC',
        'PIC_DESC',
        'DEP',
        'DEP_DESC',
        'HIGH_RISK',
        'CATEGORY',
        'USER_ID',
        'USER_DESC',
        'MACHINE',
        'MACHINE_NAME',
        'MIN_STOCK_QTY',
        'LAST_UPDATE',
    ],
    ]); ?>

    
    <hr/>

    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . 'Delete', ['delete', 'ID_ITEM_LOC' => $model->ID_ITEM_LOC],
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
    'label'   => '<b class=""># '.Html::encode($model->ID_ITEM_LOC).'</b>',
    'content' => $this->blocks['app\models\MinimumStock'],
    'active'  => true,
],
 ]
                 ]
    );
    ?>
</div>
