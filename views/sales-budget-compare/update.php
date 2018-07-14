<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\SalesBudgetCompare $model
*/

$this->title = Yii::t('models', 'Sales Budget Compare');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Sales Budget Compare'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->ITEM_INDEX, 'url' => ['view', 'ITEM_INDEX' => $model->ITEM_INDEX]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud sales-budget-compare-update">

    <h1>
        <?= Yii::t('models', 'Sales Budget Compare') ?>
        <small>
                        <?= $model->ITEM_INDEX ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . 'View', ['view', 'ITEM_INDEX' => $model->ITEM_INDEX], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
