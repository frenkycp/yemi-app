<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\KlinikInput $model
*/

$this->title = Yii::t('models', 'Edit NG Information (SMT)');
//$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Klinik Input'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => (string)$model->pk, 'url' => ['view', 'pk' => $model->pk]];
//$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud klinik-input-update">

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
