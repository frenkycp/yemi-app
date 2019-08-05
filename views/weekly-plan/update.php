<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\WeeklyPlan $model
*/

$this->title = Yii::t('app', 'Weekly Summary Update Data');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Weekly Summary Update Data'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud weekly-plan-update">

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
