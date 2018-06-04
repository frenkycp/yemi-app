<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\MpInOut $model
*/

$this->title = Yii::t('models', 'Mp In Out');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Mp In Out'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->MP_ID, 'url' => ['view', 'MP_ID' => $model->MP_ID]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud mp-in-out-update">

    <h1>
        <?= Yii::t('models', 'Mp In Out') ?>
        <small>
                        <?= $model->MP_ID ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . 'View', ['view', 'MP_ID' => $model->MP_ID], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
