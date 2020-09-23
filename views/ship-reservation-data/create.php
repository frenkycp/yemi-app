<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\ShipReservationDtr $model
*/

$this->title = Yii::t('models', 'Ship Reservation New Data');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Ship Reservation'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud ship-reservation-dtr-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
