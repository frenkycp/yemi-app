<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\MinimumStock $model
*/

$this->title = Yii::t('models', 'Minimum Stock');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Minimum Stocks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud minimum-stock-create">

    <h1>
        <?= Yii::t('models', 'Minimum Stock') ?>
        <small>
                        <?= Html::encode($model->ID_ITEM_LOC) ?>
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
