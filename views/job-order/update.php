<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\JobOrder $model
*/
    
$this->title = Yii::t('app', 'Job Order') . " " . $model->JOB_ORDER_NO . ', ' . 'Edit';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Job Order'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->JOB_ORDER_NO, 'url' => ['view', 'JOB_ORDER_NO' => $model->JOB_ORDER_NO]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud job-order-update">

    <h1>
        <?= Yii::t('app', 'Job Order') ?>
        <small>
                        <?= $model->JOB_ORDER_NO ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . 'View', ['view', 'JOB_ORDER_NO' => $model->JOB_ORDER_NO], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
