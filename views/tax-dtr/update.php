<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\TaxDtr $model
*/

$this->title = Yii::t('models', 'Tax Dtr');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Tax Dtr'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->dtrid, 'url' => ['view', 'dtrid' => $model->dtrid]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud tax-dtr-update">

    <h1>
                <?= Html::encode($model->dtrid) ?>

        <small>
            <?= Yii::t('models', 'Tax Dtr') ?>        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . 'View', ['view', 'dtrid' => $model->dtrid], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
