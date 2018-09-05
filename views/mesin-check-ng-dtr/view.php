<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var app\models\MesinCheckNgDtr $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('models', 'Mesin Check Ng Dtr');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Mesin Check Ng Dtrs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->SEQ, 'url' => ['view', 'SEQ' => $model->SEQ]];
$this->params['breadcrumbs'][] = 'View';
?>
<div class="giiant-crud mesin-check-ng-dtr-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('models', 'Mesin Check Ng Dtr') ?>
        <small>
            <?= $model->SEQ ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?= Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . 'Edit',
            [ 'update', 'SEQ' => $model->SEQ],
            ['class' => 'btn btn-info']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . 'Copy',
            ['create', 'SEQ' => $model->SEQ, 'MesinCheckNgDtr'=>$copyParams],
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

    <?php $this->beginBlock('app\models\MesinCheckNgDtr'); ?>

    
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            'urutan',
        'color_stat',
        'down_time:datetime',
        'stat_last_update',
        'stat_description',
    ],
    ]); ?>

    
    <hr/>

    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . 'Delete', ['delete', 'SEQ' => $model->SEQ],
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
    'label'   => '<b class=""># '.$model->SEQ.'</b>',
    'content' => $this->blocks['app\models\MesinCheckNgDtr'],
    'active'  => true,
],
 ]
                 ]
    );
    ?>
</div>
