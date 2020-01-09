<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\ProdAttendanceMpPlan $model
*/

$this->title = Yii::t('models', 'Prod Attendance Mp Plan');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Prod Attendance Mp Plan'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud prod-attendance-mp-plan-update">

    <h1>
        <?= Yii::t('models', 'Prod Attendance Mp Plan') ?>
        <small>
                        <?= Html::encode($model->name) ?>
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
