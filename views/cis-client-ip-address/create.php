<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\CisClientIpAddress $model
*/

$this->title = Yii::t('models', 'Cis Client Ip Address');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Cis Client Ip Addresses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud cis-client-ip-address-create">

    <h1>
        <?= Yii::t('models', 'Cis Client Ip Address') ?>
        <small>
                        <?= $model->id ?>
        </small>
    </h1>

    <div class="clearfix crud-navigation">
        <div class="pull-left">
            <?=             Html::a(
            'Cancel',
            \yii\helpers\Url::previous(),
            ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <hr />

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
