<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\ShipCustomer $model
*/

$this->title = Yii::t('app', 'Ship Customer');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ship Customers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud ship-customer-create">

    <h1>
        <?= Yii::t('app', 'Ship Customer') ?>
        <small>
                        <?= $model->id ?>
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
