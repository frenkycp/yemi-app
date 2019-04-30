<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\WipLimitQty $model
*/

$this->title = Yii::t('models', 'Wip Limit Qty');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Wip Limit Qties'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud wip-limit-qty-create">

    <h1>
        <?= Yii::t('models', 'Wip Limit Qty') ?>
        <small>
                        <?= Html::encode($model->child_analyst) ?>
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
