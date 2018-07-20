<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PlanReceiving */

$this->title = 'Create Plan Receiving';
$this->params['breadcrumbs'][] = ['label' => 'Plan Receivings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plan-receiving-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
