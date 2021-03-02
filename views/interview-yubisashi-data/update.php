<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\EmpInterviewYubisashi $model
*/

$this->title = Yii::t('models', 'Update Data');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Update Data'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->ID, 'url' => ['view', 'ID' => $model->ID]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud emp-interview-yubisashi-update">

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
