<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\KlinikObatLog $model
*/

$this->title = Yii::t('models', 'Klinik Obat Log');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Klinik Obat Logs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud klinik-obat-log-create">

    <h1>
                <?= Html::encode($model->id) ?>
        <small>
            <?= Yii::t('models', 'Klinik Obat Log') ?>
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
