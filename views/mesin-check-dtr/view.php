<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var app\models\MesinCheckDtr $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('app', 'Mesin Check Dtr');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mesin Check Dtrs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->master_id, 'url' => ['view', 'master_id' => $model->master_id]];
$this->params['breadcrumbs'][] = 'View';
?>
<div class="giiant-crud mesin-check-dtr-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('app', 'Mesin Check Dtr') ?>
        <small>
            <?= $model->master_id ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?= Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . 'Edit',
            [ 'update', 'master_id' => $model->master_id],
            ['class' => 'btn btn-info']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . 'Copy',
            ['create', 'master_id' => $model->master_id, 'MesinCheckDtr'=>$copyParams],
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

    <?php $this->beginBlock('app\models\MesinCheckDtr'); ?>

    
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            'master_id',
        'mesin_id',
        'machine_desc',
        'location',
        'area',
        'mesin_periode',
        'r01',
        'r02',
        'r03',
        'r04',
        'r05',
        'r06',
        'r07',
        'r08',
        'r09',
        'r10',
        'r11',
        'r12',
        'r13',
        'r14',
        'r15',
        'r16',
        'r17',
        'r18',
        'r19',
        'r20',
        'r21',
        'r22',
        'r23',
        'r24',
        'r25',
        'r26',
        'r27',
        'r28',
        'r29',
        'r30',
        'r31',
        'r32',
        'r33',
        'r34',
        'r35',
        'r36',
        'r37',
        'r38',
        'r39',
        'r40',
        'r41',
        'r42',
        'r43',
        'r44',
        'r45',
        'r46',
        'r47',
        'r48',
        'r49',
        'r50',
        'b01',
        'b02',
        'b03',
        'b04',
        'b05',
        'b06',
        'b07',
        'b08',
        'b09',
        'b10',
        'b11',
        'b12',
        'b13',
        'b14',
        'b15',
        'b16',
        'b17',
        'b18',
        'b19',
        'b20',
        'b21',
        'b22',
        'b23',
        'b24',
        'b25',
        'b26',
        'b27',
        'b28',
        'b29',
        'b30',
        'b31',
        'b32',
        'b33',
        'b34',
        'b35',
        'b36',
        'b37',
        'b38',
        'b39',
        'b40',
        'b41',
        'b42',
        'b43',
        'b44',
        'b45',
        'b46',
        'b47',
        'b48',
        'b49',
        'b50',
        'd01',
        'd02',
        'd03',
        'd04',
        'd05',
        'd06',
        'd07',
        'd08',
        'd09',
        'd10',
        'd11',
        'd12',
        'd13',
        'd14',
        'd15',
        'd16',
        'd17',
        'd18',
        'd19',
        'd20',
        'd21',
        'd22',
        'd23',
        'd24',
        'd25',
        'd26',
        'd27',
        'd28',
        'd29',
        'd30',
        'd31',
        'd32',
        'd33',
        'd34',
        'd35',
        'd36',
        'd37',
        'd38',
        'd39',
        'd40',
        'd41',
        'd42',
        'd43',
        'd44',
        'd45',
        'd46',
        'd47',
        'd48',
        'd49',
        'd50',
        's01',
        's02',
        's03',
        's04',
        's05',
        's06',
        's07',
        's08',
        's09',
        's10',
        's11',
        's12',
        's13',
        's14',
        's15',
        's16',
        's17',
        's18',
        's19',
        's20',
        's21',
        's22',
        's23',
        's24',
        's25',
        's26',
        's27',
        's28',
        's29',
        's30',
        's31',
        's32',
        's33',
        's34',
        's35',
        's36',
        's37',
        's38',
        's39',
        's40',
        's41',
        's42',
        's43',
        's44',
        's45',
        's46',
        's47',
        's48',
        's49',
        's50',
        'c01',
        'c02',
        'c03',
        'c04',
        'c05',
        'c06',
        'c07',
        'c08',
        'c09',
        'c10',
        'c11',
        'c12',
        'c13',
        'c14',
        'c15',
        'c16',
        'c17',
        'c18',
        'c19',
        'c20',
        'c21',
        'c22',
        'c23',
        'c24',
        'c25',
        'c26',
        'c27',
        'c28',
        'c29',
        'c30',
        'c31',
        'c32',
        'c33',
        'c34',
        'c35',
        'c36',
        'c37',
        'c38',
        'c39',
        'c40',
        'c41',
        'c42',
        'c43',
        'c44',
        'c45',
        'c46',
        'c47',
        'c48',
        'c49',
        'c50',
        'user_id',
        'user_desc',
        'master_plan_maintenance',
        'mesin_last_update',
        'mesin_next_schedule',
        'sisa_waktu',
        'count_list',
        'count_update',
    ],
    ]); ?>

    
    <hr/>

    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . 'Delete', ['delete', 'master_id' => $model->master_id],
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
    'label'   => '<b class=""># '.$model->master_id.'</b>',
    'content' => $this->blocks['app\models\MesinCheckDtr'],
    'active'  => true,
],
 ]
                 ]
    );
    ?>
</div>
