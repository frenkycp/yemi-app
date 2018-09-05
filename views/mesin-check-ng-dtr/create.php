<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\MesinCheckNgDtr $model
*/

$this->title = Yii::t('models', 'Add Machine Status');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Mesin Check Ng Dtrs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud mesin-check-ng-dtr-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
