<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\UserSupplement $model
*/

$this->title = Yii::t('models', 'User Supplement');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'User Supplements'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud user-supplement-create">

    <h1>
        <?= Yii::t('models', 'User Supplement') ?>
        <small>
                        <?= Html::encode($model->id_user) ?>
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
