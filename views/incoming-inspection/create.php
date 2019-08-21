<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\SapPoRcv $model
*/

$this->title = Yii::t('models', 'Sap Po Rcv');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Sap Po Rcvs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud sap-po-rcv-create">

    <h1>
        <?= Yii::t('models', 'Sap Po Rcv') ?>
        <small>
                        <?= Html::encode($model->material_document_number) ?>
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
