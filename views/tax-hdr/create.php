<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\TaxHdr $model
*/

$this->title = Yii::t('models', 'Tax Hdr');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Tax Hdrs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud tax-hdr-create">

    <h1>
                <?= Html::encode($model->no_seri) ?>
        <small>
            <?= Yii::t('models', 'Tax Hdr') ?>
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
