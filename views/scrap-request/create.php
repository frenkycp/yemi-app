<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\TraceItemScrap $model
*/

$this->title = Yii::t('models', 'Trace Item Scrap');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Trace Item Scraps'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud trace-item-scrap-create">

    <h1>
                <?= Html::encode($model->SERIAL_NO) ?>
        <small>
            <?= Yii::t('models', 'Trace Item Scrap') ?>
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
