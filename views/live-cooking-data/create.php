<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\LiveCookingRequest $model
*/

$this->title = Yii::t('models', 'Live Cooking Request (Add)');
//$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Live Cooking Requests (Add)'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud live-cooking-request-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
