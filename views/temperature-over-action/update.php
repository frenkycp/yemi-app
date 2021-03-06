<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\TemperatureOverAction $model
*/

$this->title = Yii::t('models', 'Temperature Over Action');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Temperature Over Action'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->ID, 'url' => ['view', 'ID' => $model->ID]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud temperature-over-action-update">

    <h1>
                <?= Html::encode($model->ID) ?>

        <small>
            <?= Yii::t('models', 'Temperature Over Action') ?>        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . 'View', ['view', 'ID' => $model->ID], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
