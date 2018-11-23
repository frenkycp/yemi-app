<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\SernoSlipLog $model
*/

$this->title = Yii::t('models', 'Serno Slip Log');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Serno Slip Logs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud serno-slip-log-create">

    <h1>
        <?= Yii::t('models', 'Serno Slip Log') ?>
        <small>
                        <?= Html::encode($model->pk) ?>
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
