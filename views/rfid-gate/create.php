<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\RfidGate $model
*/

$this->title = Yii::t('models', 'Rfid Gate');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Rfid Gates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud rfid-gate-create">

    <h1>
        <?= Yii::t('models', 'Rfid Gate') ?>
        <small>
                        <?= Html::encode($model->gate) ?>
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
