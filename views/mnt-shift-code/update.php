<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\MntShiftCode $model
*/

$this->title = Yii::t('models', 'Mnt Shift Code');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Mnt Shift Code'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud mnt-shift-code-update">

    <h1>
        <?= Yii::t('models', 'Mnt Shift Code') ?>
        <small>
                        <?= $model->id ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . 'View', ['view', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
