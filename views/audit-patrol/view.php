<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var app\models\AuditPatrolTbl $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('models', 'Audit Patrol Tbl');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models.plural', 'Audit Patrol Tbl'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->ID, 'url' => ['view', 'ID' => $model->ID]];
$this->params['breadcrumbs'][] = 'View';
?>
<div class="giiant-crud audit-patrol-tbl-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Html::encode($model->ID) ?>
        <small>
            <?= Yii::t('models', 'Audit Patrol Tbl') ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?php 
 echo Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . 'Edit',
            [ 'update', 'ID' => $model->ID],
            ['class' => 'btn btn-info'])
          ?>

            <?php 
 echo Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . 'Copy',
            ['create', 'ID' => $model->ID, 'AuditPatrolTbl'=>$copyParams],
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

    <?php $this->beginBlock('app\models\AuditPatrolTbl'); ?>

    
    <?php 
 echo DetailView::widget([
    'model' => $model,
    'attributes' => [
            'PATROL_DATE',
        'PATROL_DATETIME',
        'CATEGORY',
        'DESCRIPTION',
        'ACTION',
        'IMAGE_BEFORE',
        'IMAGE_AFTER',
        'PATROL_PERIOD',
        'LOC_ID',
        'LOC_DESC',
        'LOC_DETAIL',
        'TOPIC',
        'PIC_ID',
        'USER_ID',
        'AUDITOR',
        'AUDITEE',
        'PIC_NAME',
        'USER_NAME',
        'STATUS',
    ],
    ]);
  ?>

    
    <hr/>

    <?php 
 echo Html::a('<span class="glyphicon glyphicon-trash"></span> ' . 'Delete', ['delete', 'ID' => $model->ID],
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
    'label'   => '<b class=""># '.Html::encode($model->ID).'</b>',
    'content' => $this->blocks['app\models\AuditPatrolTbl'],
    'active'  => true,
],
 ]
                 ]
    );
    ?>
</div>
