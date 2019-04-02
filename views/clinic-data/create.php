<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\KlinikInput $model
*/

$this->title = Yii::t('models', 'Input Data Klinik');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Klinik Inputs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud klinik-input-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
