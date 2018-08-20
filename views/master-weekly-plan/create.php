<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\WeeklyPlan $model
*/

$this->title = Yii::t('models', 'Weekly Plan');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Weekly Plans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud weekly-plan-create">

    <h1>
        <?= Yii::t('models', 'Weekly Plan') ?>
        <small>
                        <?= $model->id ?>
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
