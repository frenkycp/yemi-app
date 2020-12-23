<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\ProdNgDetailSerno $model
*/

$this->title = Yii::t('models', 'Prod Ng Detail Serno');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Prod Ng Detail Serno'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->SEQ, 'url' => ['view', 'SEQ' => $model->SEQ]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud prod-ng-detail-serno-update">

    <h1>
        <?= Yii::t('models', 'Prod Ng Detail Serno') ?>
        <small>
                        <?= Html::encode($model->SEQ) ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . 'View', ['view', 'SEQ' => $model->SEQ], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
