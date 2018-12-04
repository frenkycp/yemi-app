<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\RfidGate $model
*/

$this->title = Yii::t('models', 'RFID Gate Update Data');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Rfid Gate'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->gate, 'url' => ['view', 'gate' => $model->gate]];
$this->params['breadcrumbs'][] = 'Edit';
?>

<?php echo $this->render('_form', [
    'model' => $model,
]); ?>

    
