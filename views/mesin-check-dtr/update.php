<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\MesinCheckDtr $model
*/

$this->title = Yii::t('app', 'Mesin Check Dtr');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mesin Check Dtr'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->master_id, 'url' => ['view', 'master_id' => $model->master_id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud mesin-check-dtr-update">

    <h1>
        <?= Yii::t('app', 'Mesin Check Dtr') ?>
        <small>
                        <?= $model->master_id ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . 'View', ['view', 'master_id' => $model->master_id], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
