<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\TaxDtr $model
*/

$this->title = Yii::t('models', 'Tax Dtr');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Tax Dtrs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud tax-dtr-create">

    <h1>
                <?= Html::encode($model->dtrid) ?>
        <small>
            <?= Yii::t('models', 'Tax Dtr') ?>
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
