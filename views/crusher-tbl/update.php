<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\CrusherTbl $model
*/

$this->title = Yii::t('models', 'Crusher Data Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Crusher Tbl'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->trans_id, 'url' => ['view', 'trans_id' => $model->trans_id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud crusher-tbl-update">

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
