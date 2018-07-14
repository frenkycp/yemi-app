<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var app\models\AbsensiTbl $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('models', 'Absensi Tbl');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Absensi Tbls'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->NIK_DATE_ID, 'url' => ['view', 'NIK_DATE_ID' => $model->NIK_DATE_ID]];
$this->params['breadcrumbs'][] = 'View';
?>
<div class="giiant-crud absensi-tbl-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('models', 'Absensi Tbl') ?>
        <small>
            <?= $model->NIK_DATE_ID ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?= Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . 'Edit',
            [ 'update', 'NIK_DATE_ID' => $model->NIK_DATE_ID],
            ['class' => 'btn btn-info']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . 'Copy',
            ['create', 'NIK_DATE_ID' => $model->NIK_DATE_ID, 'AbsensiTbl'=>$copyParams],
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

    <?php $this->beginBlock('app\models\AbsensiTbl'); ?>

    
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            'NIK_DATE_ID',
        'NO',
        'NIK',
        'CC_ID',
        'SECTION',
        'DIRECT_INDIRECT',
        'NAMA_KARYAWAN',
        'PERIOD',
        'NOTE',
        'DAY_STAT',
        'CATEGORY',
        'YEAR',
        'WEEK',
        'TOTAL_KARYAWAN',
        'KEHADIRAN',
        'BONUS',
        'DISIPLIN',
        'DATE',
    ],
    ]); ?>

    
    <hr/>

    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . 'Delete', ['delete', 'NIK_DATE_ID' => $model->NIK_DATE_ID],
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
    'label'   => '<b class=""># '.$model->NIK_DATE_ID.'</b>',
    'content' => $this->blocks['app\models\AbsensiTbl'],
    'active'  => true,
],
 ]
                 ]
    );
    ?>
</div>
