<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\ItemUnit $model
*/

$this->title = Yii::t('models', 'Update Item Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Item Unit'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud item-unit-update">

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
