<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\MesinCheckResult $model
*/

$this->title = Yii::t('models', 'Mesin Check Result');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Mesin Check Results'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud mesin-check-result-create">

    <h1>
        <?= Yii::t('models', 'Mesin Check Result') ?>
        <small>
                        <?= $model->urutan ?>
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
