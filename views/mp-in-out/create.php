<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\MpInOut $model
*/

$this->title = Yii::t('models', 'Mp In Out');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Mp In Outs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud mp-in-out-create">

    <h1>
        <?= Yii::t('models', 'Mp In Out') ?>
        <small>
                        <?= $model->MP_ID ?>
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
