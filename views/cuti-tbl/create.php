<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\CutiTbl $model
*/

$this->title = Yii::t('models', 'Cuti Tbl');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Cuti Tbls'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud cuti-tbl-create">

    <h1>
        <?= Yii::t('models', 'Cuti Tbl') ?>
        <small>
                        <?= Html::encode($model->CUTI_ID) ?>
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
