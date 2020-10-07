<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\ShipReservationDtr $model
*/

$this->title = Yii::t('models', 'Update Data');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Ship Reservation Dtr'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->BL_NO, 'url' => ['view', 'BL_NO' => $model->BL_NO]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud ship-reservation-dtr-update">

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
