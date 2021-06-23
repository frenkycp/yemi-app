<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\TemperatureOverAction $model
*/

$this->title = Yii::t('models', 'Temperature Over Action');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Temperature Over Actions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud temperature-over-action-create">

    <h1>
                <?= Html::encode($model->ID) ?>
        <small>
            <?= Yii::t('models', 'Temperature Over Action') ?>
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
