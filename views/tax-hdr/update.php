<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\TaxHdr $model
*/

$this->title = Yii::t('models', 'Tax Hdr');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Tax Hdr'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->no_seri, 'url' => ['view', 'no_seri' => $model->no_seri]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud tax-hdr-update">

    <h1>
                <?= Html::encode($model->no_seri) ?>

        <small>
            <?= Yii::t('models', 'Tax Hdr') ?>        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . 'View', ['view', 'no_seri' => $model->no_seri], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
