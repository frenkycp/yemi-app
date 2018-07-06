<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\SplHdr $model
*/

$this->title = Yii::t('models', 'Spl Hdr');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Spl Hdr'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->SPL_HDR_ID, 'url' => ['view', 'SPL_HDR_ID' => $model->SPL_HDR_ID]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud spl-hdr-update">

    <h1>
        <?= Yii::t('models', 'Spl Hdr') ?>
        <small>
                        <?= $model->SPL_HDR_ID ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . 'View', ['view', 'SPL_HDR_ID' => $model->SPL_HDR_ID], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
