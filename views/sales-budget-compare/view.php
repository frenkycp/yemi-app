<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var app\models\SalesBudgetCompare $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('models', 'Sales Budget Compare');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Sales Budget Compares'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->ITEM_INDEX, 'url' => ['view', 'ITEM_INDEX' => $model->ITEM_INDEX]];
$this->params['breadcrumbs'][] = 'View';
?>
<div class="giiant-crud sales-budget-compare-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('models', 'Sales Budget Compare') ?>
        <small>
            <?= $model->ITEM_INDEX ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?= Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . 'Edit',
            [ 'update', 'ITEM_INDEX' => $model->ITEM_INDEX],
            ['class' => 'btn btn-info']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . 'Copy',
            ['create', 'ITEM_INDEX' => $model->ITEM_INDEX, 'SalesBudgetCompare'=>$copyParams],
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

    <?php $this->beginBlock('app\models\SalesBudgetCompare'); ?>

    
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            'ITEM_INDEX',
        'ITEM',
        'DESC',
        'NO',
        'MODEL',
        'MODEL_GROUP',
        'BU',
        'TYPE',
        'FISCAL',
        'PERIOD',
        'QTY_BGT',
        'AMOUNT_BGT',
        'QTY_ACT_FOR',
        'AMOUNT_ACT_FOR',
        'QTY_BALANCE',
        'AMOUNT_BALANCE',
    ],
    ]); ?>

    
    <hr/>

    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . 'Delete', ['delete', 'ITEM_INDEX' => $model->ITEM_INDEX],
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
    'label'   => '<b class=""># '.$model->ITEM_INDEX.'</b>',
    'content' => $this->blocks['app\models\SalesBudgetCompare'],
    'active'  => true,
],
 ]
                 ]
    );
    ?>
</div>
