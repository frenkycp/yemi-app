<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\ShippingMonthlySummary $model
*/

$this->title = Yii::t('models', 'Shipping Monthly Summary');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Shipping Monthly Summaries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud shipping-monthly-summary-create">

    <h1>
        <?= Yii::t('models', 'Shipping Monthly Summary') ?>
        <small>
                        <?= Html::encode($model->period) ?>
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
