<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\MesinCheckResult $model
*/

$this->title = Yii::t('models', 'Mesin Check Result');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Mesin Check Result'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->urutan, 'url' => ['view', 'urutan' => $model->urutan]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud mesin-check-result-update">

    <h1>
        <?= Yii::t('models', 'Mesin Check Result') ?>
        <small>
                        <?= $model->urutan ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . 'View', ['view', 'urutan' => $model->urutan], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
