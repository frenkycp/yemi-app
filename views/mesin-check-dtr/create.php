<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\MesinCheckDtr $model
*/

$this->title = Yii::t('app', 'Mesin Check Dtr');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mesin Check Dtrs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud mesin-check-dtr-create">

    <h1>
        <?= Yii::t('app', 'Mesin Check Dtr') ?>
        <small>
                        <?= $model->master_id ?>
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
