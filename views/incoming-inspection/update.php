<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\SapPoRcv $model
*/

$this->title = Yii::t('models', 'Sap Po Rcv');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Sap Po Rcv'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->material_document_number, 'url' => ['view', 'material_document_number' => $model->material_document_number]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud sap-po-rcv-update">

    <h1>
        <?= Yii::t('models', 'Sap Po Rcv') ?>
        <small>
                        <?= Html::encode($model->material_document_number) ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . 'View', ['view', 'material_document_number' => $model->material_document_number], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
