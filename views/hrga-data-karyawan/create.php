<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\Karyawan $model
*/

$this->title = Yii::t('models', 'Karyawan');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Karyawans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud karyawan-create">

    <h1>
        <?= Yii::t('models', 'Karyawan') ?>
        <small>
                        <?= Html::encode($model->NIK) ?>
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
