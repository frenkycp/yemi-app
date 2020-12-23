<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\ProdNgDetailSerno $model
*/

$this->title = Yii::t('models', 'Prod Ng Detail Serno');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Prod Ng Detail Sernos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud prod-ng-detail-serno-create">

    <h1>
        <?= Yii::t('models', 'Prod Ng Detail Serno') ?>
        <small>
                        <?= Html::encode($model->SEQ) ?>
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
