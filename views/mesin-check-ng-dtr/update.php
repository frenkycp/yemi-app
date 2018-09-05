<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\MesinCheckNgDtr $model
*/

$this->title = Yii::t('models', 'Update Machine Status');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Mesin Check Ng Dtr'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->SEQ, 'url' => ['view', 'SEQ' => $model->SEQ]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud mesin-check-ng-dtr-update">

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
