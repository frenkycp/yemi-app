<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\AssetStockTakeSchedule $model
*/

$this->title = Yii::t('models', 'Create Schedule');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Create Schedules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud asset-stock-take-schedule-create">
    
    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
