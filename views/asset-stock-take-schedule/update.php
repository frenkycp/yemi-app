<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\AssetStockTakeSchedule $model
*/

$this->title = Yii::t('models', 'Asset Stock Take Schedule');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Asset Stock Take Schedule'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->schedule_id, 'url' => ['view', 'schedule_id' => $model->schedule_id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud asset-stock-take-schedule-update">

    <h1>
        <?= Yii::t('models', 'Asset Stock Take Schedule') ?>
        <small>
                        <?= Html::encode($model->schedule_id) ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . 'View', ['view', 'schedule_id' => $model->schedule_id], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
