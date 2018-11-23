<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var app\models\SernoSlipLog $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('models', 'Serno Slip Log');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Serno Slip Logs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->pk, 'url' => ['view', 'pk' => $model->pk]];
$this->params['breadcrumbs'][] = 'View';
?>
<div class="giiant-crud serno-slip-log-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('models', 'Serno Slip Log') ?>
        <small>
            <?= Html::encode($model->pk) ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?= Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . 'Edit',
            [ 'update', 'pk' => $model->pk],
            ['class' => 'btn btn-info']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . 'Copy',
            ['create', 'pk' => $model->pk, 'SernoSlipLog'=>$copyParams],
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

    <?php $this->beginBlock('app\models\SernoSlipLog'); ?>

    
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            'pk',
        'start',
        'end',
        'arrival_time',
        'line',
        'nik',
    ],
    ]); ?>

    
    <hr/>

    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . 'Delete', ['delete', 'pk' => $model->pk],
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
    'label'   => '<b class=""># '.Html::encode($model->pk).'</b>',
    'content' => $this->blocks['app\models\SernoSlipLog'],
    'active'  => true,
],
 ]
                 ]
    );
    ?>
</div>
