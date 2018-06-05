<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PlanReceiving */

$this->title = 'Create Plan Receiving';
$this->params['breadcrumbs'][] = ['label' => 'Plan Receivings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plan-receiving-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
