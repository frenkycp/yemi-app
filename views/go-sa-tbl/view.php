<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var app\models\GoSaTbl $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('models', 'Go Sa Tbl');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Go Sa Tbls'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->ID, 'url' => ['view', 'ID' => $model->ID]];
$this->params['breadcrumbs'][] = 'View';
?>
<div class="giiant-crud go-sa-tbl-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('models', 'Go Sa Tbl') ?>
        <small>
            <?= Html::encode($model->ID) ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?= Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . 'Edit',
            [ 'update', 'ID' => $model->ID],
            ['class' => 'btn btn-info']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . 'Copy',
            ['create', 'ID' => $model->ID, 'GoSaTbl'=>$copyParams],
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

    <?php $this->beginBlock('app\models\GoSaTbl'); ?>

    
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            'REQUESTOR_NIK',
        'REQUESTOR_NAME',
        'REMARK:ntext',
        'START_TIME',
        'END_TIME',
        'TOTAL_MP',
        'FLAG',
        'LT',
    ],
    ]); ?>

    
    <hr/>

    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . 'Delete', ['delete', 'ID' => $model->ID],
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
    'label'   => '<b class=""># '.Html::encode($model->ID).'</b>',
    'content' => $this->blocks['app\models\GoSaTbl'],
    'active'  => true,
],
 ]
                 ]
    );
    ?>
</div>
