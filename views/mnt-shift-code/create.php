<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\MntShiftCode $model
*/

$this->title = Yii::t('models', 'Mnt Shift Code');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Mnt Shift Codes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud mnt-shift-code-create">

    <h1>
        <?= Yii::t('models', 'Mnt Shift Code') ?>
        <small>
                        <?= $model->id ?>
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
