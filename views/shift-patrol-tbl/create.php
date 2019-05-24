<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\ShiftPatrolTbl $model
*/

$this->title = Yii::t('models', 'Add Data');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Shift 2 Daily Patrol'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud shift-patrol-tbl-create">

    <?= $this->render('_form', [
    'model' => $model,
    'location_arr' => $location_arr,
    ]); ?>

</div>
