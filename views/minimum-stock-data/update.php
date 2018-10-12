<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\MinimumStock $model
*/

$this->title = Yii::t('models', 'Minimum Stock');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Minimum Stock'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->ID_ITEM_LOC, 'url' => ['view', 'ID_ITEM_LOC' => $model->ID_ITEM_LOC]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud minimum-stock-update">

    <h1>
        <?= Yii::t('models', 'Minimum Stock') ?>
        <small>
                        <?= Html::encode($model->ID_ITEM_LOC) ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . 'View', ['view', 'ID_ITEM_LOC' => $model->ID_ITEM_LOC], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
