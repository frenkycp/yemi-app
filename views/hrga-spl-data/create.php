<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\SplHdr $model
*/

$this->title = Yii::t('models', 'Spl Hdr');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Spl Hdrs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud spl-hdr-create">

    <h1>
        <?= Yii::t('models', 'Spl Hdr') ?>
        <small>
                        <?= $model->SPL_HDR_ID ?>
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
