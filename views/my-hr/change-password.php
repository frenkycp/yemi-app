<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dmstr\widgets\Alert;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\LoginForm */

$this->title = 'Change Password';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control'],
    //'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];
?>

<section class="login-block">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <?php $form = ActiveForm::begin([
                    'id' => 'login-form', 
                    'enableClientValidation' => true,
                    'errorSummaryCssClass' => 'error-summary alert alert-danger',
                    'options' => [
                        'class' => 'md-float-material form-material'
                    ],
                ]); ?>
                <div style="margin: 20px auto 0 auto; max-width: 450px;">
                    <?= Alert::widget() ?>
                </div>
                <div class="auth-box card">
                    <div class="card-block">
                        <div class="row m-b-20">
                            <div class="col-md-12">
                                <h3 class="text-center">Change Password</h3>
                            </div>
                        </div>
                        <?= $form
                        ->field($model, 'username')
                        //->label(false)
                        ->textInput(['placeholder' => 'Your NIK', 'readonly' => true]) ?>

                        <?= $form
                        ->field($model, 'password1', $fieldOptions1)
                        //->label(false)
                        ->passwordInput(['placeholder' => 'Your New Password']) ?>

                        <?= $form
                        ->field($model, 'password2')
                        //->label(false)
                        ->passwordInput(['placeholder' => 'Retype Your New Password']) ?>
                        <div class="row m-t-30">
                            <div class="col-md-6">
                                <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-danger btn-block']) ?>
                            </div>
                            <div class="col-md-6">
                                <?= Html::submitButton('Submit', ['class' => 'btn btn-success btn-block btn-flat', 'name' => 'login-button']) ?>
                            </div>
                            
                        </div>
                        <div class="row m-t-30">
                            
                        </div>
                        
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</section>