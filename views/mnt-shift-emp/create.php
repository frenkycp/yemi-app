<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\MntShiftEmp $model
*/

$this->title = Yii::t('models', 'Mnt Shift Emp');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Mnt Shift Emps'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud mnt-shift-emp-create">

    <h1>
        <?= Yii::t('models', 'Mnt Shift Emp') ?>
        <small>
                        <?= $model->name ?>
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
