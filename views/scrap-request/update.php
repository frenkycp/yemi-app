<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\TraceItemScrap $model
*/

$this->title = Yii::t('models', 'Trace Item Scrap');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Trace Item Scrap'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->SERIAL_NO, 'url' => ['view', 'SERIAL_NO' => $model->SERIAL_NO]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud trace-item-scrap-update">

    <h1>
                <?= Html::encode($model->SERIAL_NO) ?>

        <small>
            <?= Yii::t('models', 'Trace Item Scrap') ?>        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . 'View', ['view', 'SERIAL_NO' => $model->SERIAL_NO], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
