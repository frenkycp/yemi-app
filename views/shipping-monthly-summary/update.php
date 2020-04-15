<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\ShippingMonthlySummary $model
*/

$this->title = Yii::t('models', 'Shipping Monthly Summary');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Shipping Monthly Summary'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->period, 'url' => ['view', 'period' => $model->period]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud shipping-monthly-summary-update">

    <h1>
        <?= Yii::t('models', 'Shipping Monthly Summary') ?>
        <small>
                        <?= Html::encode($model->period) ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . 'View', ['view', 'period' => $model->period], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
