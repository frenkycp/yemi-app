<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\TraceItemDtr $model
*/

$this->title = Yii::t('models', 'Trace Item Dtr');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Trace Item Dtrs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud trace-item-dtr-create">

    <h1>
                <?= Html::encode($model->SERIAL_NO) ?>
        <small>
            <?= Yii::t('models', 'Trace Item Dtr') ?>
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
