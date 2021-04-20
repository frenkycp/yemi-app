<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var app\models\InjMoldingTbl $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('models', 'Inj Molding Tbl');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models.plural', 'Inj Molding Tbl'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->MOLDING_ID, 'url' => ['view', 'MOLDING_ID' => $model->MOLDING_ID]];
$this->params['breadcrumbs'][] = 'View';
?>
<div class="giiant-crud inj-molding-tbl-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Html::encode($model->MOLDING_ID) ?>
        <small>
            <?= Yii::t('models', 'Inj Molding Tbl') ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?php 
 echo Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . 'Edit',
            [ 'update', 'MOLDING_ID' => $model->MOLDING_ID],
            ['class' => 'btn btn-info'])
          ?>

            <?php 
 echo Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . 'Copy',
            ['create', 'MOLDING_ID' => $model->MOLDING_ID, 'InjMoldingTbl'=>$copyParams],
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

    <?php $this->beginBlock('app\models\InjMoldingTbl'); ?>

    
    <?php 
 echo DetailView::widget([
    'model' => $model,
    'attributes' => [
            'MOLDING_ID',
        'TOTAL_COUNT',
        'TARGET_COUNT',
        'MOLDING_STATUS',
        'LAST_UPDATE',
        'MACHINE_ID',
        'MOLDING_NAME',
        'MACHINE_DESC',
    ],
    ]);
  ?>

    
    <hr/>

    <?php 
 echo Html::a('<span class="glyphicon glyphicon-trash"></span> ' . 'Delete', ['delete', 'MOLDING_ID' => $model->MOLDING_ID],
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
    'label'   => '<b class=""># '.Html::encode($model->MOLDING_ID).'</b>',
    'content' => $this->blocks['app\models\InjMoldingTbl'],
    'active'  => true,
],
 ]
                 ]
    );
    ?>
</div>
