<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\GojekOrderTbl $model
*/

$this->title = Yii::t('models', 'Gojek Order Tbl');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Gojek Order Tbls'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud gojek-order-tbl-create">

    <h1>
        <?= Yii::t('models', 'Gojek Order Tbl') ?>
        <small>
                        <?= Html::encode($model->id) ?>
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
