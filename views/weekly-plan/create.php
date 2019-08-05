<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\WeeklyPlan $model
*/

$this->title = Yii::t('app', 'Weekly Summary Input Data');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Weekly Summary Input Data'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud weekly-plan-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
