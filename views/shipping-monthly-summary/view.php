<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var app\models\ShippingMonthlySummary $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('models', 'Shipping Monthly Summary');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Shipping Monthly Summaries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->period, 'url' => ['view', 'period' => $model->period]];
$this->params['breadcrumbs'][] = 'View';
?>
<div class="giiant-crud shipping-monthly-summary-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('models', 'Shipping Monthly Summary') ?>
        <small>
            <?= Html::encode($model->period) ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?= Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . 'Edit',
            [ 'update', 'period' => $model->period],
            ['class' => 'btn btn-info']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . 'Copy',
            ['create', 'period' => $model->period, 'ShippingMonthlySummary'=>$copyParams],
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

    <?php $this->beginBlock('app\models\ShippingMonthlySummary'); ?>

    
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            'period',
        'final_product_so',
        'final_product_act',
        'final_product_ratio',
        'kd_so',
        'kd_act',
        'kd_ratio',
        'sent_email_datetime:email',
    ],
    ]); ?>

    
    <hr/>

    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . 'Delete', ['delete', 'period' => $model->period],
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
    'label'   => '<b class=""># '.Html::encode($model->period).'</b>',
    'content' => $this->blocks['app\models\ShippingMonthlySummary'],
    'active'  => true,
],
 ]
                 ]
    );
    ?>
</div>
