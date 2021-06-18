<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\ShipLiner $model
*/

$this->title = Yii::t('models', 'Ship Liner');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Ship Liners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud ship-liner-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
