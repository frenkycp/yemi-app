<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\AbsensiTbl $model
*/

$this->title = Yii::t('models', 'Absensi Tbl');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Absensi Tbls'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud absensi-tbl-create">

    <h1>
        <?= Yii::t('models', 'Absensi Tbl') ?>
        <small>
                        <?= $model->NIK_DATE_ID ?>
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
