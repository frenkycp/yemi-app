<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var app\models\SplCode $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('models', 'Spl Code');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Spl Codes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->KODE_LEMBUR, 'url' => ['view', 'KODE_LEMBUR' => $model->KODE_LEMBUR]];
$this->params['breadcrumbs'][] = 'View';
?>
<div class="giiant-crud spl-code-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('models', 'Spl Code') ?>
        <small>
            <?= Html::encode($model->KODE_LEMBUR) ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?= Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . 'Edit',
            [ 'update', 'KODE_LEMBUR' => $model->KODE_LEMBUR],
            ['class' => 'btn btn-info']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . 'Copy',
            ['create', 'KODE_LEMBUR' => $model->KODE_LEMBUR, 'SplCode'=>$copyParams],
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

    <?php $this->beginBlock('app\models\SplCode'); ?>

    
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            'KODE_LEMBUR',
        'JENIS_LEMBUR',
        'START_LEMBUR_PLAN',
        'END_LEMBUR_PLAN',
        'NILAI_LEMBUR_PLAN',
    ],
    ]); ?>

    
    <hr/>

    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . 'Delete', ['delete', 'KODE_LEMBUR' => $model->KODE_LEMBUR],
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
    'label'   => '<b class=""># '.Html::encode($model->KODE_LEMBUR).'</b>',
    'content' => $this->blocks['app\models\SplCode'],
    'active'  => true,
],
 ]
                 ]
    );
    ?>
</div>
