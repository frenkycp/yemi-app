<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\MesinCheckNg $model
*/

$this->title = Yii::t('app', 'Mesin Check Ng');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mesin Check Ngs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud mesin-check-ng-create">

    <h1>
        <?= Yii::t('app', 'Mesin Check Ng') ?>
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
