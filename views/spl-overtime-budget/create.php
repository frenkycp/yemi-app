<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\SplOvertimeBudget $model
*/

$this->title = Yii::t('models', 'Spl Overtime Budget');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Spl Overtime Budgets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud spl-overtime-budget-create">

    <h1>
        <?= Yii::t('models', 'Spl Overtime Budget') ?>
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
