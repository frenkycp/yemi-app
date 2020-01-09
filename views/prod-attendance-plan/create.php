<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\ProdAttendanceMpPlan $model
*/

$this->title = Yii::t('models', 'Prod Attendance Mp Plan');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Prod Attendance Mp Plans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud prod-attendance-mp-plan-create">

    <h1>
        <?= Yii::t('models', 'Prod Attendance Mp Plan') ?>
        <small>
                        <?= Html::encode($model->name) ?>
        </small>
    </h1>

    <div class="clearfix crud-navigation">
        <div class="pull-left">
            <?=             Html::a(
            'Cancel',
            \yii\helpers\Url::previous(),
            ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <hr />

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
