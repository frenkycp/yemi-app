<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\AbsensiTbl $model
*/

$this->title = Yii::t('models', 'Absensi Tbl');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Absensi Tbl'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->NIK_DATE_ID, 'url' => ['view', 'NIK_DATE_ID' => $model->NIK_DATE_ID]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud absensi-tbl-update">

    <h1>
        <?= Yii::t('models', 'Absensi Tbl') ?>
        <small>
                        <?= $model->NIK_DATE_ID ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . 'View', ['view', 'NIK_DATE_ID' => $model->NIK_DATE_ID], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
