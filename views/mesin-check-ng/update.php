<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\MesinCheckNg $model
*/

$this->title = Yii::t('app', 'Mesin Check Ng');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mesin Check Ng'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->urutan, 'url' => ['view', 'urutan' => $model->urutan]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud mesin-check-ng-update">

    <h1>
        <?= Yii::t('app', 'Mesin Check Ng') ?>
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
