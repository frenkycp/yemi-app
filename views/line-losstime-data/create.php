<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\SernoLosstime $model
*/

$this->title = Yii::t('models', 'Serno Losstime');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Serno Losstimes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud serno-losstime-create">

    <h1>
        <?= Yii::t('models', 'Serno Losstime') ?>
        <small>
                        <?= Html::encode($model->pk) ?>
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
