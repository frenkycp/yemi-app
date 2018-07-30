<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\MntShiftSch $model
*/

$this->title = Yii::t('models', 'Update Schedule');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Update Schedule'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud mnt-shift-sch-update">

    <h1 style="display: none;">
        <?= Yii::t('models', 'Mnt Shift Sch') ?>
        <small>
                        <?= $model->id ?>
        </small>
    </h1>

    <div class="crud-navigation" style="display: none;">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . 'View', ['view', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
    </div>

    <!--<hr />-->

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
