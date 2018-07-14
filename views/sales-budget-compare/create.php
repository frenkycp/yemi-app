<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\SalesBudgetCompare $model
*/

$this->title = Yii::t('models', 'Sales Budget Compare');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Sales Budget Compares'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud sales-budget-compare-create">

    <h1>
        <?= Yii::t('models', 'Sales Budget Compare') ?>
        <small>
                        <?= $model->ITEM_INDEX ?>
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
