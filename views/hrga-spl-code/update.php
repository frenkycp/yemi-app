<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\SplCode $model
*/

$this->title = Yii::t('models', 'Spl Code');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Spl Code'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->KODE_LEMBUR, 'url' => ['view', 'KODE_LEMBUR' => $model->KODE_LEMBUR]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud spl-code-update">

    <h1>
        <?= Yii::t('models', 'Spl Code') ?>
        <small>
                        <?= Html::encode($model->KODE_LEMBUR) ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . 'View', ['view', 'KODE_LEMBUR' => $model->KODE_LEMBUR], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
