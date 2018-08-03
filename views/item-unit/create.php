<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\ItemUnit $model
*/

$this->title = Yii::t('models', 'Create Item Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Item Units'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud item-unit-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
