<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\SupplierBilling $model
*/

$this->title = Yii::t('models', 'Supplier Billing');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Supplier Billing'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->no, 'url' => ['view', 'no' => $model->no]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud supplier-billing-update">

    <h1>
                <?= Html::encode($model->no) ?>

        <small>
            <?= Yii::t('models', 'Supplier Billing') ?>        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . 'View', ['view', 'no' => $model->no], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
