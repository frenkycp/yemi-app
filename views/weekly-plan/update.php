<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\WeeklyPlan $model
*/

$this->title = Yii::t('app', 'Weekly Plan');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Weekly Plan'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud weekly-plan-update">

    <h1>
        <?= Yii::t('app', 'Weekly Plan') ?>
        <small>
                        <?= $model->id ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . 'View', ['view', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
