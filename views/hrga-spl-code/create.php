<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\SplCode $model
*/

$this->title = Yii::t('models', 'Spl Code');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Spl Codes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud spl-code-create">

    <h1>
        <?= Yii::t('models', 'Spl Code') ?>
        <small>
                        <?= Html::encode($model->KODE_LEMBUR) ?>
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
