<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\ShipReservationDtr $model
*/

$this->title = Yii::t('models', 'Ship Reservation Dtr');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Ship Reservation Dtr'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->BL_NO, 'url' => ['view', 'BL_NO' => $model->BL_NO]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud ship-reservation-dtr-update">

    <h1>
        <?= Yii::t('models', 'Ship Reservation Dtr') ?>
        <small>
                        <?= Html::encode($model->BL_NO) ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . 'View', ['view', 'BL_NO' => $model->BL_NO], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
